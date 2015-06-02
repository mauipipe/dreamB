<?php
/**
 * Created by David Contavalli <david.contavalli@gmail.com>
 */

namespace API\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;



class ImageLinkCreator extends AbstractPlugin {

    const PLACEHOLDER_JPG = 'placeholder.jpg';

    const DEFAULT_HOST = 'dream-beach.local';

    public function addCommentImageLink(array $comments)
    {
        $hostName = str_replace('api.','',$this->getHostname());
        $imageRootPath = $hostName . "/image/comment/";

        $result = array_map(function($item) use ($imageRootPath){
            $imageName = $item['id'] . '.jpg';

            $imageInfo = @getimagesize($imageRootPath . $item['id'] . '.jpg');
            if(false === $imageInfo){
                $imageName = self::PLACEHOLDER_JPG;
            }

            $item['image'] = $imageRootPath . $imageName;
            return $item;
        },$comments);

        return $result;
    }


    private function getHostname()
    {
        $I_controller = $this->getController();
        $host = self::DEFAULT_HOST;
        if(isset($I_controller)){
            $I_request = $I_controller->getRequest();
            $I_uri = $I_request->getUri();
            $host = $I_uri->getHost();
        }

        return "http://" . $host;
    }

}