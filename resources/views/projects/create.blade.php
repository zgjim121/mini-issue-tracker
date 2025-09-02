@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Create New Project</h1>
    <form action="{{ route('projects.store')}}" method="POST" class="bg-white shadow-sm rounded-lg p-6">
        @csrf

        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
            <input class="mt-1 block w-full border-gray-500 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" type="text" name="name" required id="name" value="{{ old('name') }}">
            @error('name')
                <p class="mt-1 text-red-600 text-sm">{{ $message}}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700" for="description">Description</label>
            <textarea clas="mt-1 block w-full border-gray-500 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" name="description" id="description" rows="5">{{ old('description') }}</textarea>
            @error('description')
                <p class="mt-1 text-red-600 text-sm">{{ $message}}</p>
            @enderror
        </div>


        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700" for="start_date">Start Date</label>
                <input type="date" name="start_date" id="start_date" value="{{ old('start_date')}}" required
                class="mt-1 block w-full border-gray-500 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @error('start_date')
                    <p class="mt-1 text-red-600 text-sm">{{$message}}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700" for="deadline">Deadline</label>
                <input type="date" name="deadline" id="deadline" value="{{ old('deadline')}}"
                class="mt-1 block w-full border-gray-500 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @error('deadline')
                    <p class="mt-1 text-red-600 text-sm">{{$message}}</p>
                @enderror
            </div>
        </div>

        <div class="flex justify-end space-x-3">
            <a class="bg-gray-200 hover:bg-gray-400 text-gray-700 font-bold py-2 px-4 rounded" href="{{route('projects.index')}}">Cancel</a>
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Create Project</button>
        </div>
    </form>
</div>

@endsection