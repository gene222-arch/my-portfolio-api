<?php
namespace App\Services;

use App\Models\PageReport;
use App\Models\Testimonial;
use Illuminate\Support\Facades\DB;

class TestimonialService
{
    public function deleteMultiple(array $ids)
    {
        try {
            DB::transaction(function () use ($ids)
            {
                Testimonial::whereIn('id', $ids)->delete();

                PageReport::query()
                    ->first()
                    ->decrement('testimonials', count($ids));
            });
        } catch (\Throwable $th) {
            return $th->getMessage();
        }

        return true;
    }
}