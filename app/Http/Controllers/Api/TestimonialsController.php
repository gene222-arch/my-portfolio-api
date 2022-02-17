<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Testimonial\DestroyRequest;
use App\Http\Requests\Testimonial\StoreUpdateRequest;
use App\Models\Testimonial;
use Symfony\Component\HttpFoundation\Response;

class TestimonialsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return $this->success(
            'OK',
            Testimonial::all()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Testimonial\StoreUpdateRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreUpdateRequest $request)
    {
        return $this->success(
            'Testimonial created successfully.',
            Testimonial::create($request->validated()),
            Response::HTTP_CREATED
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Testimonial  $testimonial
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Testimonial $testimonial)
    {
        return $this->success('OK', $testimonial);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Testimonial\StoreUpdateRequest  $request
     * @param  \App\Models\Testimonial  $testimonial
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(StoreUpdateRequest $request, Testimonial $testimonial)
    {
        return $this->success(
            'Testimonial created successfully.',
            $testimonial->update($request->validated())
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Http\Requests\Testimonial\DestroyRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(DestroyRequest $request)
    {
        Testimonial::whereIn('id', $request->testimonial_ids)->delete();

        return $this->success('Testimonial/s deleted successfully.');
    }
}
