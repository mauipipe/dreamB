<?php

namespace API\Controller;

use API\Service\CommentService;
use Application\Service\ImageService;
use Zend\File\Transfer\Adapter\Http;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class CommentController extends AbstractRestfulController
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
            $comment = $this->commentService->addComment($data);

            $files = $this->getRequest()->getFiles()->toArray();

            $this->imageService->rename($comment['id']);
            if (!$this->imageService->isReceived($files['file']['name'])) {
                throw new \RuntimeException('Error saving the image');
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
