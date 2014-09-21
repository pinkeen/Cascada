<?php

namespace Pinkeen\CascadaBundle\Crud\Exception;
use Exception;

/**
 * Throws an exception when a method which is optional is not implemented but needed because certain functionality
 * is used at runtime.
 */
class MethodNotImplemented extends \RuntimeException
{
    /**
     * @param object $object
     * @param string $methodName
     * @param string|null $explanation
     * @param \Exception $previous
     */
    public function __construct($object, $methodName, $explanation = null, \Exception $previous = null)
    {
        $message = sprintf("Method '%s::%s' not implemented but called");

        if(null !== $explanation) {
            $message .= ': ' . $explanation;
        }

        $message .= '.';

        parent::__construct($message, 0, $previous);
    }

} 