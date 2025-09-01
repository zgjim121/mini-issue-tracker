@extends('layouts.app')

@section('content')
<div>
    <h1>Projects</h1>
    <a href="">New Project</a>
</div>

<div>
    @if($projects->count() > 0)
    <ul>
        @foreach($projects as $project)
        <li>
            <a href="{{ route('projects.show', $project) }}">
                <div>
                    <div>
                        <h3>{{ $project->name}}</h3>
                        <p>{{ Str::limit($project->description, 100) }}</p>
                        <div>
                            <span>Start: {{ $project->start_date->format('M j, Y')}}</span>
                            @if($project->deadline)
                                <span>Deadline: {{ $project->deadline->format('M j, Y')}}</span>
                            @endif
                        </div>
                    </div>
                    <div>
                        <span>{{ $project->issues_count }} issues</span>
                    </div>
                </div>
            </a>
        </li>
        @endforeach
    </ul>
    @else
    <p>No Projects Found. <a href="{{ route('projects.create') }}">Create Your First Project</a>.</p>
    @endif
</div>
@endsection