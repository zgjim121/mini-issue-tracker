@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Projects</h1>
    <a href="{{ route('projects.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
        New Project
    </a>
</div>

<div class="bg-white shadow overflow-hidden sm:rounded-md">
    @if($projects->count() > 0)
        <ul class="divide-y divide-gray-200">
            @foreach($projects as $project)
                <li>
                    <a href="{{ route('projects.show', $project) }}" class="block hover:bg-gray-50 px-4 py-4 sm:px-6">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <h3 class="text-lg font-medium text-indigo-600">{{ $project->name }}</h3>
                                <p class="text-sm text-gray-500 mt-1">{{ Str::limit($project->description, 100) }}</p>
                                <div class="mt-2 flex items-center text-sm text-gray-500">
                                    <span>Start: {{ $project->start_date->format('M j, Y') }}</span>
                                    @if($project->deadline)
                                        <span class="ml-4">Deadline: {{ $project->deadline->format('M j, Y') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="flex items-center">
                                <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded">
                                    {{ $project->issues_count }} issues
                                </span>
                            </div>
                        </div>
                    </a>
                </li>
            @endforeach
        </ul>
    @else
        <div class="text-center py-12">
            <p class="text-gray-500">No projects yet. <a href="{{ route('projects.create') }}" class="text-blue-500">Create your first project</a>.</p>
        </div>
    @endif
</div>
@endsection