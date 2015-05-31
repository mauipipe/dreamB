<?php

namespace API\Controller;

use API\Service\BeachService;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class BeachController extends AbstractRestfulController
{

    private $beachService;

    public function __construct(BeachService $beachService)
    {
        $this->beachService = $beachService;
    }

    /**
     * Create a new resource
     *
     * @param  mixed $data
     * @return mixed
     */
    public function create($data)
    {
        $responseBody = array();
        $response = $this->getResponse();

        try {
            $this->beachService->addBeach($data);
            $response->setStatusCode(201);
        } catch (\Exception $e) {
            $response->setStatusCode(500);
            $responseBody['error'] = $e->getMessage();
        }

        return new JsonModel($responseBody);
    }


    public function getList()
    {
        $responseBody = array();
        $response = $this->getResponse();

        try {
            $responseBody = $this->beachService->getBeaches();
        } catch (\Exception $e) {
            $response->setStatusCode(500);
            $responseBody['error'] = $e->getMessage();
        }

        return new JsonModel($responseBody);
    }

}
