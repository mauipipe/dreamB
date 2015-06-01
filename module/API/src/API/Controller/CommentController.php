<?php

namespace API\Controller;

use API\Service\CommentService;
use Application\Service\ImageService;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class CommentController extends AbstractBaseRestController
{

    private $commentService;
    private $imageService;

    public function __construct(CommentService $commentService, ImageService $imageService)
    {
        $this->commentService = $commentService;
        $this->imageService = $imageService;
    }

    public function create($data)
    {

        $responseBody = array();
        $response = $this->getResponse();
        try {

            $requestParamsResult = $this->processRequestParams($data);
            if($requestParamsResult instanceof JsonModel){
                return $requestParamsResult;
            }

            $comment = $this->commentService->addComment($data);

            $files = $this->getRequest()->getFiles()->toArray();
            $this->imageService->rename($comment['id']);
            if (!$this->imageService->isReceived($files['file']['name'])) {
                throw new \ImageNotFoundException('The image is not saved');
            }

            $formattedComment = $this->imageLinkCreator()->addCommentImageLink(array($comment));
            $responseBody['entity'] = $formattedComment[0];
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

        $params = $this->getRequest()->getQuery();
        $requestParamsResult = $this->processRequestParams($params->toArray(),true);
        if($requestParamsResult instanceof JsonModel){
            return $requestParamsResult;
        }

        try {
            $comments = $this->commentService->getComments($params);
            $responseBody = $this->imageLinkCreator()->addCommentImageLink($comments);
        } catch (\Exception $e) {
            $response->setStatusCode(500);
            $responseBody['error'] = $e->getMessage();
        }

        return new JsonModel($responseBody);
    }

}
