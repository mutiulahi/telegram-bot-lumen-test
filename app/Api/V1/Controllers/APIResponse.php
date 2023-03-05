<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class APIResponse extends Controller
{
    /**
     * Return success response
     */
    public static function success(String $message, $data = null)
    {
        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $data,
        ], 200);
    }

    /**
     * Return error response
     */
    public static function error(String $message, int $code)
    {
        return response()->json([
            'status' => false,
            'message' => $message,
        ], $code);
    }

    /**
     * Return 404 Error response
     */
    public static function notFound()
    {
        return response()->json([
            'status' => false,
            'message' => 'Resource not found',
        ], 404);
    }

    /**
     * return unauthenticated error
     */
    public static function unauthenticated()
    {
        return response()->json([
            'status' => false,
            'message' => 'You are not authenticated',
        ], 401);
    }

    /**
     * Return authorization error
     */
    public static function unauthorized()
    {
        return response()->json([
            'status' => false,
            'message' => 'You are not allowed to access this resource',
        ], 403);
    }

    /**
     * Indicates a server error
     */
    public static function serverError()
    {
        return response()->json([
            'status' => false,
            'message' => 'A server error occured',
        ], 500);
    }
}
