<?php

namespace API\Controller;

use API\Service\BeachService;
use Zend\View\Model\JsonModel;

class BeachController extends AbstractBaseRestController
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
            $requestParamsResult = $this->processRequestParams($data);
            if($requestParamsResult instanceof JsonModel){
                return $requestParamsResult;
            }
            $beach = $this->beachService->addBeach($data);
            $responseBody['entity'] = $beach;
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
