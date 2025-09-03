<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Issue;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentAjaxTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_comment_via_ajax(): void
    {
        $project = Project::factory()->create();
        $issue = Issue::factory()->create(['project_id' => $project->id]);

        $response = $this->postJson(route('issues.comments.store', $issue), [
            'author_name' => 'John Doe',
            'body' => 'This is a test comment.',
        ]);

        $response->assertStatus(201);
        $response->assertJson([
            'success' => true,
            'message' => 'Comment added successfully.',
        ]);

        $this->assertDatabaseHas('comments', [
            'issue_id' => $issue->id,
            'author_name' => 'John Doe',
            'body' => 'This is a test comment.',
        ]);
    }

    public function test_comment_validation_via_ajax(): void
    {
        $project = Project::factory()->create();
        $issue = Issue::factory()->create(['project_id' => $project->id]);

        $response = $this->postJson(route('issues.comments.store', $issue), [
            'author_name' => '',
            'body' => '',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['author_name', 'body']);
    }

    public function test_can_load_comments_via_ajax(): void
    {
        $project = Project::factory()->create();
        $issue = Issue::factory()->create(['project_id' => $project->id]);
        $comment = Comment::factory()->create(['issue_id' => $issue->id]);

        $response = $this->getJson(route('issues.comments.index', $issue));

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);
        $response->assertJsonStructure([
            'html',
            'pagination' => [
                'current_page',
                'last_page',
                'has_more',
            ],
        ]);
    }
}