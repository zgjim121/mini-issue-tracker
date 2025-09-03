<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Issue;
use App\Models\Project;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        $tags = Tag::factory(10)->create([
            'name' => function () {
                static $tagNames = ['bug', 'feature', 'enhancement', 'documentation', 'testing', 'urgent', 'backend', 'frontend', 'database', 'security'];
                static $index = 0;
                return $tagNames[$index++] ?? 'tag-' . ($index - 10);
            }
        ]);

        Project::factory(5)->create()->each(function ($project) use ($tags) {
            $issues = Issue::factory(rand(5, 15))->create([
                'project_id' => $project->id
            ]);

            $issues->each(function ($issue) use ($tags) {

                $randomTags = $tags->random(rand(0, 3));
                $issue->tags()->attach($randomTags);

                Comment::factory(rand(2, 8))->create([
                    'issue_id' => $issue->id
                ]);
            });
        });
    }
}