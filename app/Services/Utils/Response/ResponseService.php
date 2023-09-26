<?php

namespace App\Services\Utils\Response;

use Illuminate\Http\Response;

class ResponseService implements ResponseServiceInterface
{

    public function resolveResponse($message, $data)
    {
        return response()->json(
            [
                "message" => $message,
                "data" => $data,
            ],
            200);
    }

    public function rejectResponse($message, $data)
    {
        return response()->json(
            [
                "message" => $message,
                "data" => $data,
            ],
            500);
    }

    // list response 200 status
    public function successResponse($model, $data)
    {
        $message = __('message.fetch_success', ['name' => $model]);

        return response()->json(
            [
                "message" => $message,
                "data" => $data
            ],
            200
        );
    }

    // created response 201 status
    public function storeResponse($model, $data)
    {
        $message = __('message.create_success', ['name' => $model]);

        return response()->json(
            [
                "message" => $message,
                "data" => $data
            ],
            201
        );
    }

    // accepted response 202
    public function updateResponse($model, $data)
    {
        $message = __('message.update_success', ['name' => $model]);

        return response()->json(
            [
                "message" => $message,
                "data" => $data
            ],
            202
        );
    }

    // accepted response 200
    public function deleteResponse($model, $data)
    {
        $message = __('message.delete_success', ['name' => $model]);

        return response()->json(
            [
                "message" => $message,
                "data" => $data
            ],
            200
        );
    }
}
