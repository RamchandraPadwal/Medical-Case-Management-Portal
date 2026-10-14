<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\MedicalCaseRequest;
use App\Models\MedicalCase;
use App\Support\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class MedicalCaseController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->query('search', ''));
        $status = $request->query('status');

        $cases = MedicalCase::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('case_number', 'like', "%{$search}%")
                      ->orWhere('surgeon_name', 'like', "%{$search}%");
                });
            })
            ->when(in_array($status, MedicalCase::STATUSES, true), fn ($q) => $q->where('status', $status))
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        return ApiResponse::success($cases->items(), 'Cases retrieved.', 200, [
            'meta' => [
                'current_page' => $cases->currentPage(),
                'last_page' => $cases->lastPage(),
                'per_page' => $cases->perPage(),
                'total' => $cases->total(),
            ],
        ]);
    }

    public function store(MedicalCaseRequest $request)
    {
        $case = new MedicalCase($request->validated());
        $case->created_by = $request->user()->id;
        $case->save();

        return ApiResponse::success($case, 'Case created.', 201);
    }

    public function show(int $id)
    {
        $case = MedicalCase::find($id);

        if (! $case) {
            return ApiResponse::error('Case not found.', 404);
        }

        return ApiResponse::success($case->load('creator:id,name'), 'Case retrieved.');
    }

    public function update(MedicalCaseRequest $request, int $id)
    {
        $case = MedicalCase::find($id);

        if (! $case) {
            return ApiResponse::error('Case not found.', 404);
        }

        $case->update($request->validated());

        return ApiResponse::success($case, 'Case updated.');
    }

    public function destroy(int $id)
    {
        $case = MedicalCase::find($id);

        if (! $case) {
            return ApiResponse::error('Case not found.', 404);
        }

        if (Gate::denies('delete', $case)) {
            return ApiResponse::error('You are not allowed to delete cases.', 403);
        }

        $case->delete();

        return ApiResponse::success(null, 'Case deleted.');
    }
}
