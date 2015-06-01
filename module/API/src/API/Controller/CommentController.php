<?php

namespace API\Controller;

use API\Service\CommentService;
use Zend\File\Transfer\Adapter\Http;
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
            $comment = $this->commentService->addComment($data);

            $files = $this->getRequest()->getFiles()->toArray();

            $httpAdapter = new Http();
            $httpAdapter->setDestination('/srv/apps/dreamBeach/data/pics');
            $httpAdapter->addFilter('rename', array(
                    'target'    => '/srv/apps/dreamBeach/data/pics/' . $comment['id'] . '.jpg',
                    'overwrite' => false
                )
            );

            if (!$httpAdapter->receive($files['file']['name'])) {
                throw new \RuntimeException(sprintf('Error saving the image: %s',implode(',', $httpAdapter->getErrors())));
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
