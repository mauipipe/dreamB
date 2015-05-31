<?php

namespace API\Controller;

use API\Service\CityService;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class CityController extends AbstractRestfulController
{

    private  $cityService;

    public function __construct(CityService $cityService)
    {
        $this->cityService = $cityService;
    }

    public function getList()
    {

        $responseBody = array();
        $response = $this->getResponse();

        try {
            $responseBody = $this->cityService->getCities();
        } catch (\Exception $e) {
            $response->setStatusCode(500);
            $responseBody['error'] = $e->getMessage();
        }

        return new JsonModel($responseBody);
    }
}
