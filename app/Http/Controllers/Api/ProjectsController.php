<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\DestroyRequest;
use App\Http\Requests\Project\StoreRequest;
use App\Http\Requests\Project\UpdateRequest;
use App\Http\Requests\Project\UploadImageRequest;
use App\Models\Project;
use App\Services\FileUploadService;
use App\Services\ProjectService;
use Symfony\Component\HttpFoundation\Response;

class ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $projects = Project::with('images')->orderByDesc('created_at')->get();

        return $this->success('OK', $projects);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Project\StoreRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreRequest $request)
    {
        $result = ProjectService::create(
            $request->image_url,
            $request->website_url,
            $request->title,
            $request->description,
            $request->client_feedback,
            $request->sub_image_urls
        );

        return gettype($result) === 'string'
            ? $this->error($result)
            : $this->success(
                'Project created successfully.',
                $result,
                Response::HTTP_CREATED
            );
    }

    public function uploadImage(UploadImageRequest $request, FileUploadService $service)
    {
        $url = $service->upload($request, 'image');

        return $this->success('OK', [
            'url' => $url
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $projectID
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $projectID)
    {
        return $this->success('OK', Project::with('images')->find($projectID));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Project\UpdateRequest  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request, Project $project)
    {
        $result = ProjectService::update(
            $project,
            $request->websiteUrl,
            $request->image_url,
            $request->title,
            $request->description,
            $request->client_feedback,
            $request->sub_image_urls
        );

        return gettype($result) === 'string'
            ? $this->error($result)
            : $this->success('Project updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Http\Requests\Project\DestroyRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(DestroyRequest $request)
    {
        $result = ProjectService::destroy($request->project_ids);

        return gettype($result) === 'string'
            ? $this->error($result)
            : $this->success('Project/s deleted successfully.');
    }
}
