<?php

namespace AppBundle\Services;

use Exception;
use Memcached;
use RuntimeException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use InvalidArgumentException;

class MemcachedService
{
    private $log;
    private $memcached;
    
    /**
     * Inicializar la conexión con Memcached
     * 
     * @param array $addServers
     * @param object $log
     * @param bool $debug
     * @throws Exception
     */
    public function __construct($addServers, $log) 
    {                
        $this->log = $log;
        
        $this->dsn = var_export($addServers, true);
        
        try
        {            
            if(!class_exists('Memcached'))
            {
                throw new NotFoundHttpException('No existe la clase: Memcached', 900);
            }
            
            $this->memcached = new Memcached();
            
            if(!is_array($addServers) || !is_array(current($addServers)))
            {
                throw new InvalidArgumentException('La configuracion de servidores de Memcached no es correcta');
            }
            
            $this->memcached->addServers($addServers);
        }
        catch (Exception $e) 
        {
            $this->catchException($e);
        }
    }
    
    
    /**
     * Envoltura de los metodos de Memcached a través de sobrecarga de métodos
     * 
     * @param string $name
     * @param arrray $arguments
     * @return boolean
     * @throws \Exception
     */
    public function __call($name, $arguments)
    {        
        try
        {
            if(!method_exists($this->memcached, $name))
            {
                throw new NotFoundHttpException('No existe el metodo: ' . $name);
            }
            
            $resultado = call_user_func_array(array($this->memcached, $name), $arguments);
        }
        catch (Exception $e) 
        {
            $resultado = $this->catchException($e);
        }
        
        return $resultado;
    }
    
    /**
     * Enviar al log el error y levantar la excepcion
     * 
     * @param object $e Exception
     * @throws Exception
     */
    protected function catchException(Exception $e)
    {
        $this->log->err('DSN: '.$this->dsn. '| CLASS: '.get_class($e). '| CODE: '.$e->getCode() . '| MSG: '. $e->getMessage());
        
        if($e instanceof NotFoundHttpException && $e->getCode() == 900)
        {
            //Evitar parar la ejecucion por no existir Memcached
            return false;
        }
        
        throw new RuntimeException($e->getMessage(), $e->getCode(), $e);
    }
}
