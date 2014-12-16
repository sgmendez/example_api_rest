<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AlbumesControllerTest extends WebTestCase
{    
    public function testAddAlbum()
    {
        $client = static::createClient();
        
        $client->request('POST', '/album/add/', array('titulo' => 'Album de Prueba', 'fechaPublicacion' => '2014-10-02'));
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
        
        $client->request('GET', '/album/get/'.$idAlbumTest.'/');
        $response = $client->getResponse();
                
        $this->assertEquals(200, $response->getStatusCode(), $response->getContent());
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'), 'JSON no valido');
    }
    
    public function testUpdateAlbum()
    {
        global $idAlbumTest;
        
        $client = static::createClient();
        
        $client->request('PUT', '/album/update/'.$idAlbumTest.'/', array('titulo' => 'Album Modificado'));        
        $response = $client->getResponse();
        
        $this->assertEquals(200, $response->getStatusCode(), $response->getContent());
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'), 'JSON no valido');
    }
    
    public function testSetArtista()
    {
        global $idAlbumTest;
        
        $client = static::createClient();
        
        $client->request('PUT', '/album/setartista/'.$idAlbumTest.'/', array('artistaId' => '3'));
        $response = $client->getResponse();
        
        $this->assertEquals(200, $response->getStatusCode(), $response->getContent());
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'), 'JSON no valido');
    }
    
    public function testDeleteAlbum()
    {
        global $idAlbumTest;
        
        $client = static::createClient();
        
        $client->request('DELETE', '/album/delete/'.$idAlbumTest.'/');
        $response = $client->getResponse();
        
        $this->assertEquals(200, $response->getStatusCode(), $response->getContent());
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'), 'JSON no valido');
    }
}
