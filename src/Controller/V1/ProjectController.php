<?php

namespace App\Controller\V1;

use App\Controller\BaseController;
use App\Service\V1\ProjectService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProjectController extends BaseController
{
    /**
     * @var ProjectService
     */
    private $service;

    public function __construct(ProjectService $projectservice)
    {
        $this->service = $projectservice;
    }

    /**
     * @Route(
     *      "/projects/{id}", 
     *      name="show_projects_v1", 
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
     *      "/projects/list", 
     *      name="list_projects_v1", 
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
     *      "/projects", 
     *      name="create_projects_v1", 
     *      methods={"POST"}
     * )
     * 
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        $data = $this->service->create($this->buildData($request));

        return $this->buildResponse($data, parent::MESSAGE_CREATE_OK);
    }

    /**
     * @Route(
     *      "/projects/{id}", 
     *      name="update_projects_v1", 
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
     *      "/projects/{id}", 
     *      name="delete_projects_v1", 
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
