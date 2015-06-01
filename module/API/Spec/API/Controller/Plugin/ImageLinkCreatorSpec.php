<?php

namespace Spec\API\Controller\Plugin;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ImageLinkCreatorSpec extends ObjectBehavior
{

    function it_implements_interface()
    {
        $this->shouldHaveType('Zend\Mvc\Controller\Plugin\AbstractPlugin');
    }

    function it_add_to_comment_response_item_a_link_to_the_related_image()
    {
        $commentData = array(
          array(
              'id'=>1,
              'name'=>'Gigi',
              'last_name' => 'Lanzo'
          )
        );

        $expectedResult = array(
            array(
                'id'=>1,
                'name'=>'Gigi',
                'last_name' => 'Lanzo',
                'image' => 'http://localhost/image/comment/1.jpg'
            )
        );


        $this->addCommentImageLink($commentData)->shouldBeEqualTo($expectedResult);
    }

}
