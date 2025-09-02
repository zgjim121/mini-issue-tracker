@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Issues</h1>
    <a href="{{ route('issues.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
        New Issue
    </a>
</div>

<!-- Filters -->
<div class="bg-white shadow-sm rounded-lg p-6 mb-6">
    <form method="GET" action="{{ route('issues.index') }}" class="flex flex-wrap gap-4 items-end">
        <div>
            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
            <select name="status" id="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">All statuses</option>
                <option value="open" {{ request('status') === 'open' ? 'selected' : '' }}>Open</option>
                <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                <option value="closed" {{ request('status') === 'closed' ? 'selected' : '' }}>Closed</option>
            </select>
        </div>
        
        <div>
            <label for="priority" class="block text-sm font-medium text-gray-700">Priority</label>
            <select name="priority" id="priority" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">All priorities</option>
                <option value="low" {{ request('priority') === 'low' ? 'selected' : '' }}>Low</option>
                <option value="medium" {{ request('priority') === 'medium' ? 'selected' : '' }}>Medium</option>
                <option value="high" {{ request('priority') === 'high' ? 'selected' : '' }}>High</option>
            </select>
        </div>
        
        <div>
            <label for="tag" class="block text-sm font-medium text-gray-700">Tag</label>
            <select name="tag" id="tag" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">All tags</option>
                @foreach($tags as $tag)
                    <option value="{{ $tag->id }}" {{ request('tag') == $tag->id ? 'selected' : '' }}>
                        {{ $tag->name }}
                    </option>
                @endforeach
            </select>
        </div>
        
        <div>
            <button type="submit" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Filter
            </button>
            <a href="{{ route('issues.index') }}" class="ml-2 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                Clear
            </a>
        </div>
    </form>
</div>

<div class="bg-white shadow overflow-hidden sm:rounded-md">
    @if($issues->count() > 0)
        <ul class="divide-y divide-gray-200">
            @foreach($issues as $issue)
                @include('issues.partials.issue-row', ['issue' => $issue])
            @endforeach
        </ul>
        
        <div class="px-4 py-3 border-t">
            {{ $issues->appends(request()->query())->links() }}
        </div>
    @else
        <div class="text-center py-12">
            <p class="text-gray-500">No issues found. <a href="{{ route('issues.create') }}" class="text-blue-500">Create your first issue</a>.</p>
        </div>
    @endif
</div>
@endsection