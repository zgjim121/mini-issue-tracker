<li>
    <a href="{{ route('issues.show', $issue) }}" class="block hover:bg-gray-50 px-4 py-4 sm:px-6">
        <div class="flex items-center justify-between">
            <div class="flex-1">
                <h3 class="text-lg font-medium text-indigo-600">{{ $issue->title }}</h3>
                <p class="text-sm text-gray-500 mt-1">{{ Str::limit($issue->description, 100) }}</p>
                <div class="mt-2 flex items-center space-x-4 text-sm text-gray-500">
                    <span>Project: {{ $issue->project->name }}</span>
                    <span class="status-{{ $issue->status }}">{{ ucfirst(str_replace('_', ' ', $issue->status)) }}</span>
                    <span class="priority-{{ $issue->priority }}">{{ ucfirst($issue->priority) }} Priority</span>
                    @if($issue->due_date)
                        <span>Due: {{ $issue->due_date->format('M j, Y') }}</span>
                    @endif
                </div>
                @if($issue->tags->isNotEmpty())
                    <div class="mt-2">
                        @foreach($issue->tags as $tag)
                            @include('issues.partials.tag-chip', ['tag' => $tag, 'removable' => false])
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </a>
</li>