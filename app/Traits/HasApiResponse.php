<?php

namespace App\Traits;

use Symfony\Component\HttpFoundation\Response;

Trait HasApiResponse
{
    /**
     * Success Response
     */
    public function success(
        ?string $message = null,
        $data = null,
        int $code = Response::HTTP_OK
    ): \Illuminate\Http\JsonResponse
	{
        return self::jsonResponse($code, $data, $message, "success");
	}


    /**
     * Error Response
     */
	public function error($message = null, int $code = Response::HTTP_UNPROCESSABLE_ENTITY): \Illuminate\Http\JsonResponse
	{
        return self::jsonResponse($code, null, $message, "error");
    }


    /**
     * No Content Response
     */
    public function noContent(string $message = "No Content"): \Illuminate\Http\JsonResponse
	{
        return self::jsonResponse(Response::HTTP_NO_CONTENT, null, $message, 'no content');
	}


    private static function jsonResponse(
        int $code,
        $data = null,
        $message = null,
        string $status
    ): \Illuminate\Http\JsonResponse
    {
        $body = [
            'data' => $data,
            'message' => $message,
            'status' => $status,
            'status_message' => Response::$statusTexts[$code]
        ];

        return response()->json($body, $code);
    }
}
