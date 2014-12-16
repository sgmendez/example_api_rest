<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Artistas;
use \Symfony\Component\HttpFoundation\JsonResponse;

class ArtistasController extends Controller
{
    /**
     * Obtener un listado de artistas registrados
     * 
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getAllArtistasAction()
    {
        $em = $this->getDoctrine()->getManager();
        
        $artistas = $this->checkNoResults($em->getRepository('AppBundle:Artistas')->findAll());
        
        $infoArtista = array('count' => count($artistas));
        foreach($artistas as $artista)
        {            
            $infoArtista[] = $this->getInfoArtista($artista);
        }
        
        return new JsonResponse($infoArtista, 200);
    }
    
    /**
     * Obtener un artista por id
     * 
     * @param type $id
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getArtistaAction($id)
    {
        $memcached = $this->get('memcached');
        $infoArtista = $memcached->get('artista_'.$id);
        
        if(!$infoArtista)
        {
            $em = $this->getDoctrine()->getManager();
            $artista = $this->checkNoResults($em->getRepository('AppBundle:Artistas')->findOneById($id));

            $infoArtista = $this->getInfoArtista($artista);
            
            $memcached->set('artista_'.$id, $infoArtista);
        }
        
        return new JsonResponse($infoArtista, 200);
    }
    
    /**
     * Agregar un artista
     * 
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function addArtistaAction(Request $request)
    {
        $keyNombre = 'nombre';
        $nombre = $this->checkParameter($request->request->get($keyNombre, null), $keyNombre);
        
        $keyRol = 'rol';
        $rol = $this->checkParameter($request->request->get($keyRol, null), $keyRol);
        
        $artista = new Artistas();
        
        $artista->setNombre($nombre);
        $artista->setRol($rol);
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($artista);
        $em->flush();
        
        return new JsonResponse(array('message' => 'Artista creado correctamente', 'id' => $artista->getId()), 201);
    }

    /**
     * Actualizar un artista
     * 
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param type $id
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function updateArtistaAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $artista = $this->checkNoResults($em->getRepository('AppBundle:Artistas')->findOneById($id));
        
        $nombre = $request->request->get('nombre', null);
        $rol = $request->request->get('rol', null);
        
        if(!is_null($nombre)) $artista->setNombre($nombre);
        if(!is_null($rol)) $artista->setRol($rol);
        
        $em->persist($artista);
        $em->flush();
        
        return new JsonResponse(array('message' => 'Artista actualizado'), 200);
    }
    
    /**
     * Borrar un artista
     * 
     * @param type $id
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function deleteArtistaAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        
        $artista = $this->checkNoResults($em->getRepository('AppBundle:Artistas')->findOneById($id));
        
        $em->remove($artista);
        $em->flush();
        
        return new JsonResponse(array('message' => 'Artista borrado'), 200);
    }
    
    /**
     * Agregar un album a un artista
     * 
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param type $idArtista
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function setAlbumArtistaAction(Request $request, $idArtista)
    {
        $keyRequest = 'albumId';
        $albumId = $this->checkParameter($request->request->get($keyRequest, null), $keyRequest);
        
        $em = $this->getDoctrine()->getManager();
        
        $album = $this->checkNoResults($em->getRepository('AppBundle:Albumes')->findOneById($albumId));
        $artista = $this->checkNoResults($em->getRepository('AppBundle:Artistas')->findOneById($idArtista));
        
        $artista->addAlbume($album);
        
        $em->persist($artista);
        $em->flush();
        
        return new JsonResponse(array('message' => 'Artista actualizado'), 200);
    }

    /**
     * Obtener un array con los albumes del artista
     * 
     * @param object $albumes
     * @return array
     */
    private function getAlbumesArtista($albumes)
    {
        $albumesArtista = array();
        foreach ($albumes as $album)
        {
            $albumesArtista[] = array('titulo' => $album->getTitulo(), 'fecha_publicacion' => $album->getFechaPublicacion()->format('Y-m-d'));
        }
        
        return $albumesArtista;
    }
    
    /**
     * Formatear la información de salida del artista
     * 
     * @param \AppBundle\Entity\Artistas $artista
     * @return array
     */
    private function getInfoArtista($artista)
    {
        $infoArtista = array(
            'nombre' => $artista->getNombre(),
            'rol' => $artista->getRol(),
            'fecha_creacion' => $artista->getCreateAt()->format('Y-m-d'),
            'albumes' => $this->getAlbumesArtista($artista->getAlbumes())
        );
        
        return $infoArtista;
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
