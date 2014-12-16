<?php

namespace AppBundle\Listeners;

use Doctrine\ORM\Event\LifecycleEventArgs;
use AppBundle\Entity\Albumes;
use AppBundle\Entity\Artistas;
use AppBundle\Services\MemcachedService;

class MemcachedListener
{
    private $memcached;
    
    public function __construct(MemcachedService $memcached)
    {
        $this->memcached = $memcached;
    }
    
    /**
     * Al persistir un Album o Artista, enviamos los datos a memcached
     * 
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $args
     */
    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        //$entityManager = $args->getEntityManager();

        if($entity instanceof Albumes) 
        {
            $artistasAlbum = array();
            foreach ($entity->getArtistas() as $artista)
            {
                $artistasAlbum[] = array('nombre' => $artista->getNombre(), 'rol' => $artista->getRol());
            }
            
            $infoAlbum = array(
                'titulo' => $entity->getTitulo(),
                'fechaPublicacion' => $entity->getFechaPublicacion()->format('Y-m-d'),
                'artistas' => $artistasAlbum
            );
            
            $this->memcached->set('album_'.$entity->getId(), $infoAlbum);
        }
        
        if($entity instanceof Artistas)
        {
            $albumesArtista = array();
            foreach ($entity->getAlbumes() as $album)
            {
                $albumesArtista[] = array('titulo' => $album->getTitulo(), 'fecha_publicacion' => $album->getFechaPublicacion());
            }
            
            $infoArtista = array(
                'nombre' => $entity->getNombre(),
                'rol' => $entity->getRol(),
                'albumes' => $albumesArtista
            );
            
            $this->memcached->set('artista_'.$entity->getId(), $infoArtista);
        }
    }
}
