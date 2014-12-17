<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AlbumesControllerTest extends WebTestCase
{
    const ROUTEALBUM = '/album/';

    public function testAddAlbumErrorTitulo()
    {
        $client = static::createClient();
        
        $client->request('POST', self::ROUTEALBUM, array('fechaPublicacion' => '2014-10-02'));
        $response = $client->getResponse();
        
        $this->assertEquals(400, $response->getStatusCode(), $response->getContent());
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'), 'JSON no valido');
    }
    
    public function testAddAlbumErrorFecha()
    {
        $client = static::createClient();
        
        $client->request('POST', self::ROUTEALBUM, array('titulo' => 'Album de Prueba'));
        $response = $client->getResponse();
        
        $this->assertEquals(400, $response->getStatusCode(), $response->getContent());
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'), 'JSON no valido');
    }
    
    public function testAddAlbum()
    {
        $client = static::createClient();
        
        $client->request('POST', self::ROUTEALBUM, array('titulo' => 'Album de Prueba', 'fechaPublicacion' => '2014-10-02'));
        $response = $client->getResponse();
        
        $res = json_decode($client->getResponse()->getContent(), true);
        
        if(!empty($res['id']))
        {
            $GLOBALS['idAlbumTest'] = $res['id'];
        }
        
        $this->assertEquals(201, $response->getStatusCode(), $response->getContent());
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'), 'JSON no valido');
    }
    
    public function testGetAlbum()
    {
        global $idAlbumTest;
        
        $client = static::createClient();
        
        $client->request('GET', self::ROUTEALBUM.$idAlbumTest.'/');
        $response = $client->getResponse();
                
        $this->assertEquals(200, $response->getStatusCode(), $response->getContent());
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'), 'JSON no valido');
    }
    
    public function testGetAlbumNoExiste()
    {
        $client = static::createClient();
        
        $client->request('GET', self::ROUTEALBUM.'No_existe_9999999999/');
        $response = $client->getResponse();
                
        $this->assertEquals(404, $response->getStatusCode(), $response->getContent());
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'), 'JSON no valido');
    }
    
    public function testUpdateAlbumTitulo()
    {
        global $idAlbumTest;
        
        $client = static::createClient();
        
        $client->request('PUT', self::ROUTEALBUM.$idAlbumTest.'/', array('titulo' => 'Album Modificado'));        
        $response = $client->getResponse();
        
        $this->assertEquals(200, $response->getStatusCode(), $response->getContent());
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'), 'JSON no valido');
    }
    
    public function testUpdateAlbumFecha()
    {
        global $idAlbumTest;
        
        $client = static::createClient();
        
        $client->request('PUT', self::ROUTEALBUM.$idAlbumTest.'/', array('fechaPublicacion' => '2014-07-01'));        
        $response = $client->getResponse();
        
        $this->assertEquals(200, $response->getStatusCode(), $response->getContent());
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'), 'JSON no valido');
    }
    
    public function testUpdateAlbumError()
    {
        $client = static::createClient();
        
        $client->request('PUT', self::ROUTEALBUM.'No_existe_9999999/', array('fechaPublicacion' => '2014-07-01'));        
        $response = $client->getResponse();
        
        $this->assertEquals(404, $response->getStatusCode(), $response->getContent());
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'), 'JSON no valido');
    }
    
    public function testSetArtista()
    {
        global $idAlbumTest;
        
        $client = static::createClient();
        
        $client->request('PUT', self::ROUTEALBUM.'artista/'.$idAlbumTest.'/', array('artistaId' => '3'));
        $response = $client->getResponse();
        
        $this->assertEquals(200, $response->getStatusCode(), $response->getContent());
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'), 'JSON no valido');
    }
    
    public function testGetAllAlbums()
    {
        $client = static::createClient();
        
        $client->request('GET', self::ROUTEALBUM);
        $response = $client->getResponse();
        
        $res = json_decode($client->getResponse()->getContent(), true);
        
        $this->assertEquals(200, $response->getStatusCode(), $response->getContent());
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'), 'JSON no valido');
        $this->assertTrue(key_exists('count', $res), 'No aparece un contador en el listado de albumes');
    }
    
    public function testDeleteAlbum()
    {
        global $idAlbumTest;
        
        $client = static::createClient();
        
        $client->request('DELETE', self::ROUTEALBUM.$idAlbumTest.'/');
        $response = $client->getResponse();
        
        $this->assertEquals(200, $response->getStatusCode(), $response->getContent());
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'), 'JSON no valido');
    }
}