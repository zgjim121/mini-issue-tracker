@extends('layouts.app')

@section('content')
<div class="mb-6">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-900">{{ $issue->title }}</h1>
        <div class="flex space-x-3">
            <a href="{{ route('issues.edit', $issue) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Edit
            </a>
            <form action="{{ route('issues.destroy', $issue) }}" method="POST" class="inline" 
                  onsubmit="return confirm('Are you sure you want to delete this issue?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                    Delete
                </button>
            </form>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2">

        <div class="bg-white shadow-sm rounded-lg p-6 mb-6">
            <div class="mb-4">
                <h3 class="text-lg font-medium text-gray-900 mb-2">Description</h3>
                <p class="text-gray-700 whitespace-pre-wrap">{{ $issue->description }}</p>
            </div>
            
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <span class="font-medium text-gray-500">Project:</span>
                    <a href="{{ route('projects.show', $issue->project) }}" class="text-blue-600 hover:text-blue-800">
                        {{ $issue->project->name }}
                    </a>
                </div>
                <div>
                    <span class="font-medium text-gray-500">Status:</span>
                    <span class="status-{{ $issue->status }}">{{ ucfirst(str_replace('_', ' ', $issue->status)) }}</span>
                </div>
                <div>
                    <span class="font-medium text-gray-500">Priority:</span>
                    <span class="priority-{{ $issue->priority }}">{{ ucfirst($issue->priority) }}</span>
                </div>
                @if($issue->due_date)
                    <div>
                        <span class="font-medium text-gray-500">Due Date:</span>
                        {{ $issue->due_date->format('M j, Y') }}
                    </div>
                @endif
            </div>
        </div>

        <div class="bg-white shadow-sm rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Comments</h3>

            <form id="comment-form" class="mb-6">
                @csrf
                <div class="mb-4">
                    <label for="author_name" class="block text-sm font-medium text-gray-700">Your Name *</label>
                    <input type="text" name="author_name" id="author_name" required
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <div id="author_name_error" class="mt-1 text-sm text-red-600 hidden"></div>
                </div>
                
                <div class="mb-4">
                    <label for="body" class="block text-sm font-medium text-gray-700">Comment *</label>
                    <textarea name="body" id="body" rows="3" required
                              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                    <div id="body_error" class="mt-1 text-sm text-red-600 hidden"></div>
                </div>
                
                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    Add Comment
                </button>
            </form>

            <div id="comments-container">
                @foreach($issue->comments as $comment)
                    @include('issues.partials.comment-item', ['comment' => $comment])
                @endforeach
            </div>

            @if($issue->comments->count() >= 10)
                <div class="text-center mt-4">
                    <button id="load-more-comments" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded"
                            data-page="2">
                        Load More Comments
                    </button>
                </div>
            @endif
        </div>
    </div>

    <div class="lg:col-span-1">
        <div class="bg-white shadow-sm rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Tags</h3>
            <div class="mb-4">
                <div id="current-tags">
                    @foreach($issue->tags as $tag)
                        @include('issues.partials.tag-chip', ['tag' => $tag, 'removable' => true])
                    @endforeach
                </div>
                @if($issue->tags->isEmpty())
                    <p class="text-gray-500 text-sm">No tags attached.</p>
                @endif
            </div>

            @if($availableTags->isNotEmpty())
                <form id="tag-form" class="space-y-3">
                    @csrf
                    <div>
                        <label for="tag_id" class="block text-sm font-medium text-gray-700">Add Tag</label>
                        <select name="tag_id" id="tag_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">Select a tag</option>
                            @foreach($availableTags as $tag)
                                <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                            @endforeach
                        </select>
                        <div id="tag_error" class="mt-1 text-sm text-red-600 hidden"></div>
                    </div>
                    <button type="submit" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Attach Tag
                    </button>
                </form>
            @else
                <p class="text-gray-500 text-sm">All available tags are already attached.</p>
            @endif
        </div>
    </div>
</div>

<script>
    window.currentIssueId = {{ $issue->id }};
</script>
@endsection
