<?php

namespace Tests\Feature;

use App\Models\Issue;
use App\Models\Project;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IssueTagTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_attach_tag_to_issue(): void
    {
        $project = Project::factory()->create();
        $issue = Issue::factory()->create(['project_id' => $project->id]);
        $tag = Tag::factory()->create();

        $response = $this->postJson(route('issues.tags.store', $issue), [
            'tag_id' => $tag->id,
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'Tag attached successfully.',
        ]);

        $this->assertDatabaseHas('issue_tag', [
            'issue_id' => $issue->id,
            'tag_id' => $tag->id,
        ]);
    }

    public function test_can_detach_tag_from_issue(): void
    {
        $project = Project::factory()->create();
        $issue = Issue::factory()->create(['project_id' => $project->id]);
        $tag = Tag::factory()->create();
        
        $issue->tags()->attach($tag);

        $response = $this->deleteJson(route('issues.tags.destroy', [$issue, $tag]));

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'Tag detached successfully.',
        ]);

        $this->assertDatabaseMissing('issue_tag', [
            'issue_id' => $issue->id,
            'tag_id' => $tag->id,
        ]);
    }

    public function test_cannot_attach_duplicate_tag(): void
    {
        $project = Project::factory()->create();
        $issue = Issue::factory()->create(['project_id' => $project->id]);
        $tag = Tag::factory()->create();
        
        $issue->tags()->attach($tag);

        $response = $this->postJson(route('issues.tags.store', $issue), [
            'tag_id' => $tag->id,
        ]);

        $response->assertStatus(409);
        $response->assertJson([
            'success' => false,
            'message' => 'Tag is already attached to this issue.',
        ]);
    }
}