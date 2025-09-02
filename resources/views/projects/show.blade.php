@extends('layouts.app')

@section('content')
<div class="mb-6">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-900">{{ $project->name }}</h1>
        <div class="flex space-x-3">
            <a href="{{ route('projects.edit', $project) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Edit
            </a>
            <form action="{{ route('projects.destroy', $project) }}" method="POST" class="inline" 
                  onsubmit="return confirm('Are you sure you want to delete this project?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                    Delete
                </button>
            </form>
        </div>
    </div>
    
    <div class="mt-4 bg-white shadow-sm rounded-lg p-6">
        <p class="text-gray-700 mb-4">{{ $project->description }}</p>
        <div class="flex items-center text-sm text-gray-500">
            <span>Start: {{ $project->start_date->format('M j, Y') }}</span>
            @if($project->deadline)
                <span class="ml-4">Deadline: {{ $project->deadline->format('M j, Y') }}</span>
            @endif
        </div>
    </div>
</div>

<div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-semibold text-gray-900">Issues ({{ $project->issues->count() }})</h2>
    <a href="{{ route('issues.create', ['project_id' => $project->id]) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
        New Issue
    </a>
</div>

<div class="bg-white shadow overflow-hidden sm:rounded-md">
    @if($project->issues->count() > 0)
        <ul class="divide-y divide-gray-200">
            @foreach($project->issues as $issue)
                @include('issues.partials.issue-row', ['issue' => $issue])
            @endforeach
        </ul>
    @else
        <div class="text-center py-12">
            <p class="text-gray-500">No issues yet. <a href="{{ route('issues.create', ['project_id' => $project->id]) }}" class="text-green-500">Create the first issue</a>.</p>
        </div>
    @endif
</div>
@endsection