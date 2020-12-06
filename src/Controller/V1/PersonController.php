<?php

namespace App\Controller\V1;

use App\Controller\BaseController;
use App\Service\V1\PersonService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PersonController extends BaseController
{
    /**
     * @var PersonService
     */
    private $service;

    public function __construct(PersonService $personService)
    {
        $this->service = $personService;
    }

    /**
     * @Route(
     *      "/persons/{id}", 
     *      name="show_persons_v1", 
     *      methods={"GET"}, 
     *      requirements={"id": "\d+"}
     * )
     * 
     * @return JsonResponse
     */
    public function show(int $id)
    {
        $data = $this->service->show($id);

        return $this->buildResponse($data);
    }

    /**
     * @Route(
     *      "/persons/list", 
     *      name="list_persons_v1", 
     *      methods={"GET"}
     * )
     * 
     * @return JsonResponse
     */
    public function list(Request $request): JsonResponse
    {
        $page = $request->attributes->get('page', 0);
        $size = $request->attributes->get('size', 3);
        $data = $this->service->list($page, $size);

        return $this->buildResponse($data);
    }

    /**
     * @Route(
     *      "/persons", 
     *      name="create_persons_v1", 
     *      methods={"POST"}
     * )
     * 
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        $data = $this->service->create($this->buildData($request, 'V1/create_persons'));

        return $this->buildResponse($data, parent::MESSAGE_CREATE_OK);
    }

    /**
     * @Route(
     *      "/persons/{id}", 
     *      name="update_persons_v1", 
     *      methods={"PUT"}
     * )
     * 
     * @return JsonResponse
     */
    public function update(int $id, Request $request): JsonResponse
    {
        $data = $this->service->update($id, $this->buildData($request));

        return $this->buildResponse($data, parent::MESSAGE_UPDATE_OK);
    }

    /**
     * @Route(
     *      "/persons/{id}", 
     *      name="delete_persons_v1", 
     *      methods={"DELETE"}
     * )
     * 
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        $this->service->delete($id);

        return $this->buildResponse([], parent::MESSAGE_DELETE_OK);
    }
}
