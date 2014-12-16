<?php

namespace AppBundle\Exceptions;

/**
 * @author Salvador Mendez <salva@sgmendez.com>
 */
class NoResultException extends \Exception
{
    public function __construct($message, $code = 0, $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

?>
