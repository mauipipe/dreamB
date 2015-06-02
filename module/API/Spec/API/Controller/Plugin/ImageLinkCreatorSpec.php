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

    function it_add_to_a_comment_a_link_to_a_valid_related_image()
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
                'image' => 'http://dream-beach.local/image/comment/1.jpg'
            )
        );


        $this->addCommentImageLink($commentData)->shouldBeEqualTo($expectedResult);
    }

    function it_add_to_a_comment_a_link_to_a_invalid_related_image()
    {
        $commentData = array(
            array(
                'id'=>3,
                'name'=>'Gigi',
                'last_name' => 'Lanzo'
            )
        );

        $expectedResult = array(
            array(
                'id'=>3,
                'name'=>'Gigi',
                'last_name' => 'Lanzo',
                'image' => 'http://dream-beach.local/image/comment/placeholder.jpg'
            )
        );


        $this->addCommentImageLink($commentData)->shouldBeEqualTo($expectedResult);
    }

}
