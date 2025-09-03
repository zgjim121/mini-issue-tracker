<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\ProjectRequest;

class ProjectController extends Controller
{
    public function index(): View
    {
        $projects = Project::withCount('issues')->latest()->get();

        return view('projects.index', compact('projects'));
    }

    public function create(): View
    {
        return view('projects.create');
    }

    public function store(ProjectRequest $request): RedirectResponse
    {
        $project = Project::create($request->validated());

        return redirect()->route('projects.show', $project)
        ->with('success', 'Project created successfully');
    }

    public function show(Project $project): View
    {
        $project->load('issues.tags');

        return view('projects.show', compact('project'));
    }

    public function edit(Project $project): View
    {
        return view('projects.edit', compact('project'));
    }

    public function update(ProjectRequest $request, Project $project): RedirectResponse
    {
        $project->update($request->validated());

        return redirect()->route('projects.show', $project)
        ->with('success', 'Project updated successfully');
    }
    
    public function destroy(Project $project): RedirectResponse
    {
        $project->delete();

        return redirect()->route('projects.index')
        ->with('success', 'Project deleted successfully');
    }
}
