<?php

use Illuminate\Http\JsonResponse;

function successResponseJson(mixed $data, string $msg, int $status = 200): JsonResponse
{
    if ($data instanceof \Illuminate\Pagination\LengthAwarePaginator) {
        $pagination = formatPaginator($data);
        $formatted_data = $data->toArray();
        return response()->json([
            'success' => true,
            'status' => $status,
            'message' => $msg,
            'data' => $formatted_data['data'],
            'pagination' => $pagination
        ], $status);
    } else {
        return response()->json([
            'success' => true,
            'status' => $status,
            'message' => $msg,
            'data' => $data
        ], $status);
    }
}

function formatPaginator(\Illuminate\Pagination\LengthAwarePaginator $data): mixed
{
    $data = $data->toArray();
    unset($data['data']);
    return $data;
}
