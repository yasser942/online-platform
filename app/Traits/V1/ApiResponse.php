<?php

namespace App\Traits\V1;

trait ApiResponse
{
    /**
     * Return a successful API response.
     *
     * @param mixed $data
     * @param string $message
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    protected function successResponse($data = null, string $message = 'Operation successful', int $statusCode = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }

    /**
     * Return an error API response.
     *
     * @param string $message
     * @param mixed $errors
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    protected function errorResponse(string $message = 'Operation failed', $errors = null, int $statusCode = 400)
    {
        $response = [
            'success' => false,
            'message' => $message,
        ];

        if (!is_null($errors)) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $statusCode);
    }

    /**
     * Return a not found API response.
     *
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    protected function notFoundResponse(string $message = 'Resource not found')
    {
        return $this->errorResponse($message, null, 404);
    }

    /**
     * Return an unauthorized API response.
     *
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    protected function unauthorizedResponse(string $message = 'Unauthorized')
    {
        return $this->errorResponse($message, null, 401);
    }

    /**
     * Return a validation error API response.
     *
     * @param mixed $errors
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    protected function validationErrorResponse($errors, string $message = 'Validation failed')
    {
        return $this->errorResponse($message, $errors, 422);
    }
}
