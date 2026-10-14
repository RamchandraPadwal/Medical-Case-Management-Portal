<?php

namespace Tests\Feature;

use App\Models\MedicalCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CaseManagementTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->create(['role' => User::ROLE_ADMIN]);
    }

    private function viewer(): User
    {
        return User::factory()->create(['role' => User::ROLE_VIEWER]);
    }

    private function payload(array $overrides = []): array
    {
        return array_merge([
            'case_number' => 'CASE-9001',
            'patient_reference' => 'PT-000001',
            'surgeon_name' => 'Dr. Demo',
            'implant_type' => 'Knee implant',
            'status' => 'Draft',
            'priority' => 'Medium',
            'surgery_date' => '2027-01-15',
        ], $overrides);
    }

    // 1
    public function test_valid_login_succeeds(): void
    {
        $user = User::factory()->create(); // factory password is "password"

        $response = $this->post('/login', ['email' => $user->email, 'password' => 'password']);

        $this->assertAuthenticatedAs($user);
        $response->assertRedirect(route('dashboard', absolute: false));
    }

    // 2
    public function test_invalid_login_is_rejected(): void
    {
        $user = User::factory()->create();

        $response = $this->from('/login')->post('/login', ['email' => $user->email, 'password' => 'wrong-password']);

        $this->assertGuest();
        $response->assertSessionHasErrors('email');
    }

    // 3
    public function test_guest_cannot_open_case_pages_or_api(): void
    {
        $this->get('/cases')->assertRedirect('/login');
        $this->get('/dashboard')->assertRedirect('/login');

        $this->getJson('/api/cases')->assertStatus(401)->assertJson(['success' => false]);
        $this->postJson('/api/cases', $this->payload())->assertStatus(401);
    }

    // 4
    public function test_admin_can_create_a_case(): void
    {
        $admin = $this->admin();

        $response = $this->actingAs($admin)->post('/cases', $this->payload());

        $case = MedicalCase::where('case_number', 'CASE-9001')->first();
        $this->assertNotNull($case);
        $this->assertSame($admin->id, $case->created_by);
        $response->assertRedirect(route('cases.show', $case, absolute: false));
    }

    public function test_admin_can_create_a_case_through_the_api(): void
    {
        Sanctum::actingAs($this->admin());

        $this->postJson('/api/cases', $this->payload())
            ->assertStatus(201)
            ->assertJson(['success' => true, 'data' => ['case_number' => 'CASE-9001']]);
    }

    // 5
    public function test_duplicate_case_number_fails_with_422(): void
    {
        $admin = $this->admin();
        MedicalCase::factory()->create(['case_number' => 'CASE-9001', 'created_by' => $admin->id]);
        Sanctum::actingAs($admin);

        $this->postJson('/api/cases', $this->payload())
            ->assertStatus(422)
            ->assertJsonValidationErrors('case_number', 'errors')
            ->assertJson(['success' => false]);
    }

    public function test_editing_a_case_can_keep_its_own_case_number(): void
    {
        $admin = $this->admin();
        $case = MedicalCase::factory()->create(['case_number' => 'CASE-9001', 'created_by' => $admin->id]);
        Sanctum::actingAs($admin);

        $this->putJson("/api/cases/{$case->id}", $this->payload(['status' => 'Approved']))
            ->assertStatus(200);

        $this->assertSame('Approved', $case->fresh()->status);
    }

    // 6
    public function test_viewer_cannot_delete_a_case(): void
    {
        $admin = $this->admin();
        $case = MedicalCase::factory()->create(['created_by' => $admin->id]);

        $this->actingAs($this->viewer())->delete("/cases/{$case->id}")->assertForbidden();

        Sanctum::actingAs($this->viewer());
        $this->deleteJson("/api/cases/{$case->id}")->assertStatus(403);

        $this->assertDatabaseHas('cases', ['id' => $case->id]);
    }

    public function test_admin_can_delete_a_case(): void
    {
        $admin = $this->admin();
        $case = MedicalCase::factory()->create(['created_by' => $admin->id]);

        $this->actingAs($admin)->delete("/cases/{$case->id}")->assertRedirect(route('cases.index', absolute: false));

        $this->assertDatabaseMissing('cases', ['id' => $case->id]);
    }

    public function test_api_returns_404_for_missing_case(): void
    {
        Sanctum::actingAs($this->viewer());

        $this->getJson('/api/cases/999999')->assertStatus(404)->assertJson(['success' => false]);
    }
}
