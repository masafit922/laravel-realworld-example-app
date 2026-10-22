<?php

namespace App\Exceptions;

use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

/**
 * Renders every exception as JSON for api clients, since this is an api only backend.
 *
 * Registered in bootstrap/app.php. The framework has already converted
 * exceptions such as ModelNotFoundException into HTTP exceptions at this point.
 */
class ApiExceptionRenderer
{
    /**
     * Render the exception, or return null to fall back to the default renderer.
     *
     * @param  \Throwable  $exception
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse|null
     */
    public function __invoke(Throwable $exception, Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            return $this->getJsonResponse($exception);
        }

        return null;
    }

    /**
     * Get the json response for the exception.
     *
     * @param  \Throwable  $exception
     * @return \Illuminate\Http\JsonResponse
     */
    protected function getJsonResponse(Throwable $exception): JsonResponse
    {
        $debugEnabled = config('app.debug');

        /*
         * Handle validation errors thrown using ValidationException.
         */
        if ($exception instanceof ValidationException) {

            $validationErrors = $exception->validator->errors()->getMessages();

            /*
             * Laravel validation error format example
             * "attribute" => [
             *      "The attribute failed validation."
             * ]
             *
             * What we need as per the api spec
             * "attribute" => [
             * 	    "failed validation."
             * ]
             */

            $validationErrors = array_map(function ($error) {
                return array_map(function ($message) {
                    return remove_words($message, 2);
                }, $error);
            }, $validationErrors);

            return response()->json(['errors' => $validationErrors], 422);
        }

        /*
         * Handle database errors thrown using QueryException.
         * Prevent sensitive information from leaking in the error message.
         */
        if ($exception instanceof QueryException) {
            if ($debugEnabled) {
                $message = $exception->getMessage();
            } else {
                $message = 'Internal Server Error';
            }
        }

        $statusCode = $this->getStatusCode($exception);

        if (! isset($message) && ! ($message = $exception->getMessage())) {
            $message = sprintf('%d %s', $statusCode, Response::$statusTexts[$statusCode]);
        }

        $errors = [
            'message' => $message,
            'status_code' => $statusCode,
        ];

        if ($debugEnabled) {
            $errors['exception'] = get_class($exception);
            $errors['trace'] = explode("\n", $exception->getTraceAsString());
        }

        return response()->json(['errors' => $errors], $statusCode);
    }

    /**
     * Get the status code from the exception.
     *
     * @param  \Throwable  $exception
     * @return int
     */
    protected function getStatusCode(Throwable $exception): int
    {
        return $exception instanceof HttpExceptionInterface ? $exception->getStatusCode() : 500;
    }
}
