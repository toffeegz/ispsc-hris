<?php

namespace App\Services\Utils\Response;

interface ResponseServiceInterface
{
    public function resolveResponse($message, $data);
    public function rejectResponse($message, $data);

    public function successResponse($message, $data);
    public function storeResponse($message, $data);
    public function updateResponse($message, $data);
    public function deleteResponse($message, $data);
}
