<?php
/**
 * Created by David Contavalli <david.contavalli@gmail.com>
 */

namespace API\Service\Strategy;


use Zend\Stdlib\Hydrator\Strategy\StrategyInterface;

class CommentStrategy implements StrategyInterface
{

    /**
     * Converts the given value so that it can be extracted by the hydrator.
     *
     * @param mixed $value The original value.
     * @param object $object (optional) The original object for context.
     * @return mixed Returns the value that should be extracted.
     */
    public function extract($value)
    {
        $result = array();
        $result['id'] = $value->getId();
        $result['name'] = $value->getName();
        $result['city'] = $value->getCityName();

        return $result;
    }

    /**
     * Converts the given value so that it can be hydrated by the hydrator.
     *
     * @param mixed $value The original value.
     * @param array $data (optional) The original data for context.
     * @return mixed Returns the value that should be hydrated.
     */
    public function hydrate($value)
    {
        return $value;
    }
}