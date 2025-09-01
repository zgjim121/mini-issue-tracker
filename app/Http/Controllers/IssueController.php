<?php

namespace App\Http\Controllers;

use App\Http\Requests\IssueRequest;
use App\Models\Issue;
use App\Models\Project;
use App\Models\Tag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class IssueController extends Controller
{
    public function index(Request $request): View
    {
        $query = Issue::with(['project', 'tags']);

        if ($request->filled('status')) {
            $query->status($request->status);
        }

        if ($request->filled('priority')) {
            $query->priority($request->priority);
        }

        if ($request->filled('tag')) {
            $query->withTag($request->tag);
        }

        $issues = $query->latest()->paginate(15);
        $projects = Project::orderBy('name')->get();
        $tags = Tag::orderBy('name')->get();

        return view('issues.index', compact('issues', 'projects', 'tags'));
    }

    public function create(): View
    {
        $projects = Project::orderBy('name')->get();
        
        return view('issues.create', compact('projects'));
    }

    public function store(IssueRequest $request): RedirectResponse
    {
        $issue = Issue::create($request->validated());

        return redirect()->route('issues.show', $issue)
            ->with('success', 'Issue created successfully.');
    }

    public function show(Issue $issue): View
    {
        $issue->load(['project', 'tags', 'comments' => function ($query) {
            $query->latest();
        }]);

        $availableTags = Tag::whereNotIn('id', $issue->tags->pluck('id'))->orderBy('name')->get();

        return view('issues.show', compact('issue', 'availableTags'));
    }

    public function edit(Issue $issue): View
    {
        $projects = Project::orderBy('name')->get();
        
        return view('issues.edit', compact('issue', 'projects'));
    }

    public function update(IssueRequest $request, Issue $issue): RedirectResponse
    {
        $issue->update($request->validated());

        return redirect()->route('issues.show', $issue)
            ->with('success', 'Issue updated successfully.');
    }

    public function destroy(Issue $issue): RedirectResponse
    {
        $issue->delete();

        return redirect()->route('issues.index')
            ->with('success', 'Issue deleted successfully.');
    }
}
