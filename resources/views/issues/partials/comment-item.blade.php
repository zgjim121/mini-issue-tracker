@if(isset($comments))
    @foreach($comments as $comment)
        <div class="border-b border-gray-200 pb-4 mb-4 last:border-b-0 last:pb-0 last:mb-0">
            <div class="flex justify-between items-start">
                <div class="flex-1">
                    <h4 class="text-sm font-medium text-gray-900">{{ $comment->author_name }}</h4>
                    <p class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</p>
                </div>
            </div>
            <p class="text-gray-700 mt-2 whitespace-pre-wrap">{{ $comment->body }}</p>
        </div>
    @endforeach
@else
    <div class="border-b border-gray-200 pb-4 mb-4 last:border-b-0 last:pb-0 last:mb-0">
        <div class="flex justify-between items-start">
            <div class="flex-1">
                <h4 class="text-sm font-medium text-gray-900">{{ $comment->author_name }}</h4>
                <p class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</p>
            </div>
        </div>
        <p class="text-gray-700 mt-2 whitespace-pre-wrap">{{ $comment->body }}</p>
    </div>
@endif