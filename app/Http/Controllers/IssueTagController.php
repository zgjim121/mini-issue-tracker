<?php

namespace App\Http\Controllers;

use App\Models\Issue;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class IssueTagController extends Controller
{
    public function store(Request $request, Issue $issue): JsonResponse
    {
        $request->validate([
            'tag_id' => 'required|exists:tags,id',
        ]);

        $tag = Tag::findOrFail($request->tag_id);

        if (!$issue->tags->contains($tag->id)) {
            $issue->tags()->attach($tag->id);
            
            return response()->json([
                'success' => true,
                'message' => 'Tag attached successfully.',
                'tag' => $tag,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Tag is already attached to this issue.',
        ], 409);
    }

    public function destroy(Issue $issue, Tag $tag): JsonResponse
    {
        if ($issue->tags->contains($tag->id)) {
            $issue->tags()->detach($tag->id);
            
            return response()->json([
                'success' => true,
                'message' => 'Tag detached successfully.',
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Tag is not attached to this issue.',
        ], 404);
    }
}
