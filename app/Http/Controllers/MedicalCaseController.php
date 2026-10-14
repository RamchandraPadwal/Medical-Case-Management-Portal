<?php

namespace App\Http\Controllers;

use App\Http\Requests\MedicalCaseRequest;
use App\Models\MedicalCase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class MedicalCaseController extends Controller
{
    public function index(Request $request)
    {
        Gate::authorize('viewAny', MedicalCase::class);

        $search = trim((string) $request->query('search', ''));
        $status = $request->query('status');
        $priority = $request->query('priority');

        $cases = MedicalCase::query()
            ->with('creator')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('case_number', 'like', "%{$search}%")
                      ->orWhere('surgeon_name', 'like', "%{$search}%");
                });
            })
            ->when(in_array($status, MedicalCase::STATUSES, true), fn ($q) => $q->where('status', $status))
            ->when(in_array($priority, MedicalCase::PRIORITIES, true), fn ($q) => $q->where('priority', $priority))
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        return view('cases.index', compact('cases', 'search', 'status', 'priority'));
    }

    public function create()
    {
        Gate::authorize('create', MedicalCase::class);

        return view('cases.create', ['case' => new MedicalCase(['status' => 'Draft', 'priority' => 'Medium'])]);
    }

    public function store(MedicalCaseRequest $request)
    {
        $case = new MedicalCase($request->validated());
        $case->created_by = $request->user()->id; // set from the logged-in user, never from the form
        $case->save();

        return redirect()->route('cases.show', $case)->with('success', 'Case created.');
    }

    public function show(MedicalCase $case)
    {
        Gate::authorize('view', $case);

        return view('cases.show', ['case' => $case->load('creator')]);
    }

    public function edit(MedicalCase $case)
    {
        Gate::authorize('update', $case);

        return view('cases.edit', compact('case'));
    }

    public function update(MedicalCaseRequest $request, MedicalCase $case)
    {
        $case->update($request->validated());

        return redirect()->route('cases.show', $case)->with('success', 'Case updated.');
    }

    public function destroy(MedicalCase $case)
    {
        // Server-side check: hiding the button is not enough.
        Gate::authorize('delete', $case);

        $case->delete();

        return redirect()->route('cases.index')->with('success', 'Case deleted.');
    }
}
