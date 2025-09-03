<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentStoreRequest;
use App\Models\Comment;
use App\Models\Issue;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index(Request $request, Issue $issue): JsonResponse
    {
        $comments = $issue->comments()
            ->latest()
            ->paginate(10, ['*'], 'page', $request->get('page', 1));

        $html = view('issues.partials.comment-item', compact('comments'))->render();

        return response()->json([
            'success' => true,
            'html' => $html,
            'pagination' => [
                'current_page' => $comments->currentPage(),
                'last_page' => $comments->lastPage(),
                'has_more' => $comments->hasMorePages(),
            ],
        ]);
    }

    public function store(CommentStoreRequest $request, Issue $issue): JsonResponse
    {
        $comment = $issue->comments()->create($request->validated());

        $html = view('issues.partials.comment-item', ['comment' => $comment])->render();

        return response()->json([
            'success' => true,
            'message' => 'Comment added successfully.',
            'html' => $html,
        ], 201);
    }
}