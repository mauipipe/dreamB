<?php
/**
 * Created by David Contavalli <david.contavalli@gmail.com>
 */

namespace API\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class ImageLinkCreator extends AbstractPlugin {

    public function addCommentImageLink(array $comments)
    {
        $hostName = str_replace('api.','',$this->getHostname());
        $imageRootPath = $hostName . "/image/comment/";

        $result = array_map(function($item) use ($imageRootPath){
            $item['image'] = $imageRootPath . $item['id'] . '.jpg';
            return $item;
        },$comments);

        return $result;
    }


    private function getHostname()
    {
        $I_controller = $this->getController();
        $host = 'localhost';
        if(isset($I_controller)){
            $I_request = $I_controller->getRequest();
            $I_uri = $I_request->getUri();
            $host = $I_uri->getHost();
        }

        return "http://" . $host;
    }

}