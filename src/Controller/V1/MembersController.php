<?php

namespace App\Controller\V1;

use App\Controller\BaseController;
use App\Service\V1\MembersService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MembersController extends BaseController
{
    /**
     * @var MembersService
     */
    private $service;

    public function __construct(MembersService $membersService)
    {
        $this->service = $membersService;
    }

    /**
     * @Route(
     *      "/projects/{projectId}/members", 
     *      name="show_project_members_v1", 
     *      methods={"GET"}, 
     *      requirements={"projectId": "\d+"}
     * )
     * 
     * @return JsonResponse
     */
    public function listByProjects(int $projectId)
    {
        $data = $this->service->listByProjects($projectId);

        return $this->buildResponse($data);
    }

    /**
     * @Route(
     *      "/projects/{projectId}/members", 
     *      name="create_members_v1", 
     *      methods={"POST"}, 
     *      requirements={"projectId": "\d+"}
     * )
     * 
     * @return JsonResponse
     */
    public function create(int $projectId, Request $request): JsonResponse
    {
        $data = $this->service->createProject($projectId, $this->buildData($request));

        return $this->buildResponse($data, parent::MESSAGE_CREATE_OK);
    }

    /**
     * @Route(
     *      "/projects/{projectId}/members/{personId}", 
     *      name="delete_members_v1", 
     *      methods={"DELETE"},
     *      requirements={
     *          "projectId": "\d+",
     *          "personId": "\d+"
     *      }
     * )
     * 
     * @return JsonResponse
     */
    public function delete(int $projectId, int $personId): JsonResponse
    {
        $this->service->deleteProject($projectId, $personId);

        return $this->buildResponse([], parent::MESSAGE_DELETE_OK);
    }
}