<?php

namespace API\Controller;

use API\Service\CommentService;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class CommentController extends AbstractRestfulController
{

    private $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    public function create($data)
    {
        $responseBody = array();
        $response = $this->getResponse();

        try {
            $this->commentService->addComment($data);
            $response->setStatusCode(201);
        } catch (\Exception $e) {
            $response->setStatusCode(500);
            $responseBody['error'] = $e->getMessage();
        }

        return new JsonModel($responseBody);
    }

}
