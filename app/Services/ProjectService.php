<?php
namespace App\Services;

use App\Models\Project;
use Illuminate\Support\Facades\DB;

class ProjectService
{
    public function create(
        string $imageUrl,
        string $websiteUrl,
        string $title,
        string $description,
        ?string $clientFeedback = null,
        array $subImageUrls
    ): Project|string
    {
        try {
            $project = DB::transaction(function () use ($imageUrl, $websiteUrl, $title, $description, $clientFeedback, $subImageUrls)
            {
                $subImageUrls = array_map(fn ($subImageUrl) => ['image_url' => $subImageUrl], $subImageUrls);

                $proj = Project::create([
                    'image_url' => $imageUrl,
                    'website_url' => $websiteUrl,
                    'title' => $title,
                    'description' => $description,
                    'client_feedback' => $clientFeedback
                ]);

                $proj->images()->createMany($subImageUrls);

                return Project::with('images')->find($proj->id);
            });
        } catch (\Throwable $th) {
            return $th->getMessage();
        }

        return $project;
    }

    public function update(
        Project $project,
        string $websiteUrl,
        string $imageUrl,
        string $title,
        string $description,
        ?string $clientFeedback = null,
        array $subImageUrls
    ): bool|string
    {
        try {
            DB::transaction(function () use ($project, $imageUrl, $websiteUrl, $title, $description, $clientFeedback, $subImageUrls)
            {
                $subImageUrls = array_map(fn ($subImageUrl) => ['image_url' => $subImageUrl], $subImageUrls);

                $project->update([
                    'image_url' => $imageUrl,
                    'website_url', $websiteUrl,
                    'title' => $title,
                    'description' => $description,
                    'client_feedback' => $clientFeedback
                ]);

                $project->images()->delete();
                $project->images()->createMany($subImageUrls);
            });
        } catch (\Throwable $th) {
            return $th->getMessage();
        }

        return true;
    }

    public function destroy(array $projectIDs): bool|string
    {
        try {
            DB::transaction(function () use ($projectIDs)
            {
                $projects = Project::whereIn('id', $projectIDs)->get();

                $projects
                    ->map
                    ->images
                    ->collapse()
                    ->map
                    ->delete();
                    
                $projects->map->delete();
            });
        } catch (\Throwable $th) {
            return $th->getMessage();
        }

        return true;
    }
}
