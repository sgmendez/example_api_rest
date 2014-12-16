<?php

namespace AppBundle\Services;

use AppBundle\Exceptions\NoResultException;
use AppBundle\Exceptions\InvalidParameterException;

/**
 * Metodos de validacion
 *
 * @author Salvador Mendez <salva@sgmendez.com>
 */
class ValidateService
{
    /**
     * Comprobar que existe el parametro
     * 
     * @param type $results
     * @return type
     * @throws NoResultException
     */
    public function checkNoResults($results)
    {
        if(!$results)
        {
            throw new NoResultException('El objeto solicitado no existe');
        }
        
        return $results;
    }
    
    /**
     * Comprobar que el parametro no es nulo
     * 
     * @param type $param
     * @param type $key
     * @return type
     * @throws InvalidParameterException
     */
    public function checkParameterNotNull($param, $key)
    {
        if(is_null($param))
        {
            throw new InvalidParameterException('El parametro ['.$key.'] es obligatorio');
        }
        
        return $param;
    }
}

?>
