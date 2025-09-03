<span class="tag-chip" @if($tag->color) style="background-color: {{ $tag->color }}; color: white;" @endif>
    {{ $tag->name }}
    @if($removable ?? false)
        <button type="button" class="ml-1 text-xs hover:text-red-600 remove-tag" data-tag-id="{{ $tag->id }}">
            ×
        </button>
    @endif
</span>