@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Tags</h1>
</div>

<!-- Create Tag Form -->
<div class="bg-white shadow-sm rounded-lg p-6 mb-6">
    <h2 class="text-lg font-medium text-gray-900 mb-4">Create New Tag</h2>
    @include('tags._form')
</div>

<!-- Tags List -->
<div class="bg-white shadow overflow-hidden sm:rounded-md">
    @if($tags->count() > 0)
        <ul class="divide-y divide-gray-200">
            @foreach($tags as $tag)
                <li class="px-4 py-4 sm:px-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            @include('issues.partials.tag-chip', ['tag' => $tag, 'removable' => false])
                            @if($tag->color)
                                <span class="ml-2 text-sm text-gray-500">({{ $tag->color }})</span>
                            @endif
                        </div>
                        <div class="flex items-center">
                            <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded">
                                {{ $tag->issues_count }} issues
                            </span>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    @else
        <div class="text-center py-12">
            <p class="text-gray-500">No tags yet.</p>
        </div>
    @endif
</div>
@endsection