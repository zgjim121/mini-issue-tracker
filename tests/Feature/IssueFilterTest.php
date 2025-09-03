<?php

namespace Tests\Feature;

use App\Models\Issue;
use App\Models\Project;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IssueFilterTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_filter_issues_by_status(): void
    {
        $project = Project::factory()->create();
        $openIssue = Issue::factory()->create(['project_id' => $project->id, 'status' => 'open']);
        $closedIssue = Issue::factory()->create(['project_id' => $project->id, 'status' => 'closed']);

        $response = $this->get(route('issues.index', ['status' => 'open']));

        $response->assertStatus(200);
        $response->assertSee($openIssue->title);
        $response->assertDontSee($closedIssue->title);
    }

    public function test_can_filter_issues_by_priority(): void
    {
        $project = Project::factory()->create();
        $highIssue = Issue::factory()->create(['project_id' => $project->id, 'priority' => 'high']);
        $lowIssue = Issue::factory()->create(['project_id' => $project->id, 'priority' => 'low']);

        $response = $this->get(route('issues.index', ['priority' => 'high']));

        $response->assertStatus(200);
        $response->assertSee($highIssue->title);
        $response->assertDontSee($lowIssue->title);
    }

    public function test_can_filter_issues_by_tag(): void
    {
        $project = Project::factory()->create();
        $tag = Tag::factory()->create(['name' => 'urgent']);
        
        $taggedIssue = Issue::factory()->create(['project_id' => $project->id]);
        $untaggedIssue = Issue::factory()->create(['project_id' => $project->id]);
        
        $taggedIssue->tags()->attach($tag);

        $response = $this->get(route('issues.index', ['tag' => $tag->id]));

        $response->assertStatus(200);
        $response->assertSee($taggedIssue->title);
        $response->assertDontSee($untaggedIssue->title);
    }
}