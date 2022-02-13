<?php
namespace App\Services;

use App\Models\Project;
use Illuminate\Support\Facades\DB;

class ProjectService
{
    public function create(
        string $imageUrl,
        string $title,
        string $description,
        ?string $clientFeedback = null,
        array $subImageUrls
    ): Project|string
    {
        try {
            $project = DB::transaction(function () use ($imageUrl, $title, $description, $clientFeedback, $subImageUrls)
            {
                $subImageUrls = array_map(fn ($subImageUrl) => ['image_url' => $subImageUrl], $subImageUrls);

                $proj = Project::create([
                    'image_url' => $imageUrl,
                    'title' => $title,
                    'description' => $description,
                    'client_feedback' => $clientFeedback
                ]);

                $proj->subImages()->createMany($subImageUrls);

                return $proj;
            });
        } catch (\Throwable $th) {
            return $th->getMessage();
        }

        return $project;
    }

    public function update(
        Project $project,
        string $imageUrl,
        string $title,
        string $description,
        ?string $clientFeedback = null,
        array $subImageUrls
    ): Project|string
    {
        try {
            DB::transaction(function () use ($project, $imageUrl, $title, $description, $clientFeedback, $subImageUrls)
            {
                $subImageUrls = array_map(fn ($subImageUrl) => ['image_url' => $subImageUrl], $subImageUrls);

                $project->update([
                    'image_url' => $imageUrl,
                    'title' => $title,
                    'description' => $description,
                    'client_feedback' => $clientFeedback
                ]);

                $project->subImages()->delete();
                $project->subImages()->createMany($subImageUrls);
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

                $projects->map->subImages()->delete();
                $projects->delete();
            });
        } catch (\Throwable $th) {
            return $th->getMessage();
        }

        return true;
    }
}
