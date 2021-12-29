<?php

namespace App\Shared\Infrastructure\Symfony\Response;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class ResponseBuilder
{
    private NormalizerInterface $normalizer;
    private FormattedResponse $response;

    public function __construct(NormalizerInterface $normalizer)
    {
        $this->normalizer = $normalizer;
    }

    public function custom(int $responseCode): self
    {
        $this->response = new FormattedResponse();

        $this->response->code = $responseCode;
        $this->response->message = Response::$statusTexts[$responseCode];

        return $this;
    }

    public function withNormalizedModel(object $model): self
    {
        $normalized = $this->normalizer->normalize($model);
        $this->response->data = $normalized;

        return $this;
    }

    public function addHeader(string $key, string $value): self
    {
        $this->response->headers[$key] = $value;

        return $this;
    }

    public function addBodyValue(string $key, mixed $value): self
    {
        $this->response->data[$key] = $value;

        return $this;
    }

    public function withDetails(string|null $details): self
    {
        $this->response->details = $details;

        return $this;
    }

    public function getRawResponse(): FormattedResponse
    {
        return $this->response;
    }

    public function getJsonResponse(): JsonResponse
    {
        $headers = $this->response->headers ?? [];

        $content = [
            'code'=>$this->response->code,
            'message'=>$this->response->message,
        ];

        if($this->response->details !== null){
            $content['details'] = $this->response->details;
        }

        if($this->response->data !== null && $this->response->data !== []){
            $content['data'] = $this->response->data;
        }


        return new JsonResponse($content, $this->response->code, $headers);
    }
}
