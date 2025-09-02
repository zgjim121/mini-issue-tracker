<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Mini Issue Tracker</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .tag-chip {
            display: inline-block;
            padding: 0.25rem 0.5rem;
            background: #e5e7eb;
            border-radius: 0.375rem;
            font-size: 0.75rem;
            margin: 0.125rem;
        }
        .status-open { color: #059669; }
        .status-in_progress { color: #d97706; }
        .status-closed { color: #dc2626; }
        .priority-low { color: #6b7280; }
        .priority-medium { color: #d97706; }
        .priority-high { color: #dc2626; }
    </style>
</head>
<body class="bg-gray-100">
    <nav class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center space-x-8">
                    <a href="{{ route('projects.index') }}" class="text-xl font-semibold text-gray-900">
                        Mini Issue Tracker
                    </a>
                    <div class="flex space-x-4">
                        <a href="{{ route('projects.index') }}" class="text-gray-700 hover:text-gray-900">Projects</a>
                        <a href="{{ route('issues.index') }}" class="text-gray-700 hover:text-gray-900">Issues</a>
                        <a href="{{ route('tags.index') }}" class="text-gray-700 hover:text-gray-900">Tags</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

    <script src="/js/issue-tags.js"></script>
    <script src="/js/comments.js"></script>
</body>
</html>
