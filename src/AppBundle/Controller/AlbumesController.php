<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Albumes;
use \Symfony\Component\HttpFoundation\JsonResponse;

class AlbumesController extends Controller
{
    /**
     * Obtener un listado de todos los albums registrados
     * 
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getAllAlbumsAction()
    {
        $em = $this->getDoctrine()->getManager();
        
        $albumes = $this->checkNoResults($em->getRepository('AppBundle:Albumes')->findAll());
        
        $infoAlbum = array('count' => count($albumes));
        foreach($albumes as $album)
        {
            $infoAlbum[] = $this->getInfoAlbum($album);
        }
        
        return new JsonResponse($infoAlbum, 200);
    }
    
    /**
     * Obtener un album por Id
     * 
     * @param type $id
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getAlbumAction($id)
    {
        $memcached = $this->get('memcached');
        $infoAlbum = $memcached->get('album_'.$id);
        
        if(!$infoAlbum)
        {
            $em = $this->getDoctrine()->getManager();
            $album = $this->checkNoResults($em->getRepository('AppBundle:Albumes')->findOneById($id));

            $infoAlbum = $this->getInfoAlbum($album);
            
            $memcached->set('album_'.$id, $infoAlbum);
        }
        
        return new JsonResponse($infoAlbum, 200);
    }
    
    /**
     * Agregar un album
     * 
     * Recibe por POST el titulo y la fecha de publicación (formato Y-m-d)
     * 
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function addAlbumAction(Request $request)
    {
        $keyTitulo = 'titulo';
        $titulo = $this->checkParameter($request->request->get($keyTitulo, null), $keyTitulo);
        
        $keyFechaPublicacion = 'fechaPublicacion';
        $fechaPublicacion = $this->checkParameter($request->request->get($keyFechaPublicacion, null), $keyFechaPublicacion);
        
        $album = new Albumes();
        
        $album->setTitulo($titulo);
        $album->setFechaPublicacion(new \DateTime($fechaPublicacion));
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($album);
        $em->flush();
        
        return new JsonResponse(array('success' => true, 'message' => 'Album creado correctamente', 'id' => $album->getId()), 201);
    }
    
    /**
     * Actualizar un album
     * 
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param type $id
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function updateAlbumAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $album = $this->checkNoResults($em->getRepository('AppBundle:Albumes')->findOneById($id));
        
        $titulo = $request->request->get('titulo', null);
        $fechaPublicacion = $request->request->get('fechaPublicacion', null);
        
        if(!is_null($titulo)) $album->setTitulo($titulo);
        if(!is_null($fechaPublicacion)) $album->setFechaPublicacion(new \DateTime($fechaPublicacion));
        
        $em->persist($album);
        $em->flush();
        
        return new JsonResponse(array('success' => true, 'message' => 'Album actualizado'), 200);
    }
    
    /**
     * Borrar un album
     * 
     * @param type $id
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function deleteAlbumAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        
        $album = $this->checkNoResults($em->getRepository('AppBundle:Albumes')->findOneById($id));
        
        $em->remove($album);
        $em->flush();
        
        return new JsonResponse(array('success' => true, 'message' => 'Album borrado'), 200);
    }
    
    /**
     * Asignar un artista a un album
     * 
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param type $idAlbum
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function setArtistaAlbumAction(Request $request, $idAlbum)
    {
        $keyArtistaId = 'artistaId';
        $artistaId = $this->checkParameter($request->request->get($keyArtistaId, null), $keyArtistaId);
        
        $em = $this->getDoctrine()->getManager();
        
        $album = $this->checkNoResults($em->getRepository('AppBundle:Albumes')->findOneById($idAlbum));
        
        $artista = $this->checkNoResults($em->getRepository('AppBundle:Artistas')->findOneById($artistaId));
        
        $album->addArtista($artista);
        
        $em->persist($artista);
        $em->flush();
        
        return new JsonResponse(array('success' => true, 'message' => 'Album actualizado'), 200);
    }
    
    /**
     * Obtener un array con los artistas del album
     * 
     * @param object $artistas
     * @return array
     */
    private function getArtistasAlbum($artistas)
    {
        $artistasAlbum = array();
        foreach ($artistas as $artista)
        {
            $artistasAlbum[] = array('nombre' => $artista->getNombre(), 'rol' => $artista->getRol());
        }
        
        return $artistasAlbum;
    }
    
    /**
     * Formatear la información de salida del album
     * 
     * @param \AppBundle\Entity\Albumes $album
     * @return array
     */
    private function getInfoAlbum($album)
    {        
        $infoAlbum = array(
            'titulo' => $album->getTitulo(),
            'fechaPublicacion' => $album->getFechaPublicacion()->format('Y-m-d'),
            'fechaCreacion' => $album->getCreateAt()->format('Y-m-d'),
            'artistas' => $this->getArtistasAlbum($album->getArtistas())
        );
        
        return $infoAlbum;
    }
    
    /**
     * Comprobar que existe el parametro
     * 
     * @param type $results
     * @return type
     * @throws NoResultException
     */
    private function checkNoResults($results)
    {
        $validate = $this->get('validate');
        return $validate->checkNoResults($results);
    }
    
    /**
     * Comprobar que el parametro no es nulo
     * 
     * @param type $param
     * @param type $key
     * @return type
     * @throws InvalidParameterException
     */
    private function checkParameter($param, $key)
    {
        $validate = $this->get('validate');
        return $validate->checkParameterNotNull($param, $key);
    }
}
