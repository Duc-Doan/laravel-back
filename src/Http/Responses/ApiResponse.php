<?php
namespace Laravel\Back\Http\Responses;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

abstract class ApiResponse extends BaseResponse
{
    /**
     * Convert data to JSON response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getResponse(): JsonResponse
    {
        // Check empty content
        if (is_null($this->data)) {
            return $this->getDefaultResponse();
        }

        // Get data type
        if (is_object($this->data)) {
            $class = get_class($this->data);
        } else {
            $class = gettype($this->data);
        }

        // Handler output data
        switch (true) {
            case $class instanceof \Throwable:
                $responseData = $this->data->getMessage();
                break;
            default:
                $responseData = $this->data;
        }

        // Attach and response
        return $this->attach($responseData);
    }

    /**
     * Response Json with attach
     *
     * @param $content
     * @return \Illuminate\Http\JsonResponse
     */
    protected function attach($content): JsonResponse
    {
        // Get attach header
        method_exists($this, 'attachHeader') && is_array($headerOptions = $this->attachHeader());

        // Get attach options
        method_exists($this, 'attachOption') && is_array($option = $this->attachOption());

        // Return json response
        return response()->json($content, Response::HTTP_OK, $headerOptions ?? [], $option ?? 0);
    }

    /**
     * Response default
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function getDefaultResponse(): JsonResponse
    {
        return response()->json('');
    }
}
