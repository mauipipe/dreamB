<?php
/**
 * Created by David Contavalli <david.contavalli@gmail.com>
 */

namespace API\Service\Strategy;


use API\Entity\Beach;
use API\Entity\City;
use Zend\Stdlib\Hydrator\Strategy\StrategyInterface;

class DateTimeStrategy implements StrategyInterface
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
        return $value->format('Y-m-d h:m:s');
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