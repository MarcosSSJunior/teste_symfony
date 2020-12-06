<?php

namespace App\Controller;

use JsonSchema\Validator as JsonSchemaValidator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class BaseController
{
    const MESSAGE_LIST_OK = 'Data returned succesfully!';
    const MESSAGE_CREATE_OK = 'Entity created sucessfully!';
    const MESSAGE_UPDATE_OK = 'Entity updated sucessfully!';
    const MESSAGE_DELETE_OK = 'Entity removed succesfully!';

    /**
     * @var Request $request
     * @var string|null $schema
     * 
     * @return null|array
     */
    public function buildData(Request $request, string $schema = null): ?array
    {
        if ($schema !== null) {
            $validator = new JsonSchemaValidator();
            $data = json_decode($request->getContent());
            $validator->validate($data, json_decode(file_get_contents('../resource/schema/' . $schema . '.json')));
            if (!$validator->isValid()) {
                die(json_encode($validator->getErrors()));
            }
        }
        return json_decode($request->getContent(), true);
    }

    public function buildResponse(array $data, string $message = null, int $statusCode = Response::HTTP_OK)
    {
        $message = $message ?? self::MESSAGE_LIST_OK;

        return new JsonResponse(
            [
                'message' => $message,
                'data' => $data
            ],
            $statusCode,
            [
                'Content-Type' => 'application/json'
            ]
        );
    }
}
