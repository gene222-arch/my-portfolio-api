<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\DestroyRequest;
use App\Http\Requests\Project\StoreRequest;
use App\Http\Requests\Project\UpdateRequest;
use App\Models\Project;
use App\Services\ProjectService;
use Illuminate\Http\Request;
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
        $projects = Project::with('images')->get();

        return $this->success('OK', $projects);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Project\StoreRequest  $request
     * @param  \App\Services\ProjectService  $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreRequest $request, ProjectService $service)
    {
        $result = $service->create(
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
     * @param  \App\Services\ProjectService  $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request, Project $project, ProjectService $service)
    {
        $result = $service->update(
            $project,
            $request->image_url,
            $request->websiteUrl,
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
     * @param  \App\Services\ProjectService  $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(DestroyRequest $request, ProjectService $service)
    {
        $result = $service->destroy($request->project_ids);

        return gettype($result) === 'string'
            ? $this->error($result)
            : $this->success('Project/s deleted successfully.');
    }
}
