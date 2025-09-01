<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mini Issue Tracker</title>
</head>
<body>
    <nav>
        <div>
            <div>
                <div>
                    <a href="{{route('projects.index')}}">Mini Issue Tracker</a>
                    <div>
                        <a href="{{route('projects.index')}}">Projects</a>
                        <a href="{{route('issues.index')}}">Issues</a>
                        <a href="{{route('tags.index')}}">Tags</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <main>
        @if(session('success'))
            <div class="bg-green-500 text-white p-4 rounded-md">
                {{session('success')}}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-500 text-white p-4 rounded-md">
                {{session('error')}}
            </div>
        @endif

        @yield('content')
    </main>

    <script src="/js/issue-tags.js"></script>
    <script src="/js/comments.js"></script>
</body>