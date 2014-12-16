<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ArtistasControllerTest extends WebTestCase
{    
    public function testAddArtista()
    {
        $client = static::createClient();
        
        $client->request('POST', '/artist/add/', array('nombre' => 'Artista de Prueba', 'rol' => 'voz'));
        $response = $client->getResponse();
        
        $res = json_decode($client->getResponse()->getContent(), true);
        
        if(!empty($res['id']))
        {
            $GLOBALS['idArtistaTest'] = $res['id'];
        }
        
        $this->assertEquals(201, $response->getStatusCode(), $response->getContent());
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'), 'JSON no valido');
    }
    
    public function testGetArtista()
    {
        global $idArtistaTest;
        
        $client = static::createClient();
        
        $client->request('GET', '/artist/get/'.$idArtistaTest.'/');
        $response = $client->getResponse();
                
        $this->assertEquals(200, $response->getStatusCode(), $response->getContent());
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'), 'JSON no valido');
    }
    
    public function testUpdateArtista()
    {
        global $idArtistaTest;
        
        $client = static::createClient();
        
        $client->request('PUT', '/artist/update/'.$idArtistaTest.'/', array('rol' => 'bajo'));
        $response = $client->getResponse();
        
        $this->assertEquals(200, $response->getStatusCode(), $response->getContent());
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'), 'JSON no valido');
    }
    
    public function testSetAlbum()
    {
        global $idArtistaTest;
        
        $client = static::createClient();
        
        $client->request('PUT', '/artist/setalbum/'.$idArtistaTest.'/', array('albumId' => '1'));
        $response = $client->getResponse();
        
        $this->assertEquals(200, $response->getStatusCode(), $response->getContent());
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'), 'JSON no valido');
    }
    
    public function testGetAllArtistas()
    {
        $client = static::createClient();
        
        $client->request('GET', '/artist/all/');
        $response = $client->getResponse();
        
        $res = json_decode($client->getResponse()->getContent(), true);
        
        $this->assertEquals(200, $response->getStatusCode(), $response->getContent());
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'), 'JSON no valido');
        $this->assertTrue(key_exists('count', $res), 'No aparece un contador en el listado de albumes');
    }
    
    public function testDeleteArtista()
    {
        global $idArtistaTest;
        
        $client = static::createClient();
        
        $client->request('DELETE', '/artist/delete/'.$idArtistaTest.'/');
        $response = $client->getResponse();
        
        $this->assertEquals(200, $response->getStatusCode(), $response->getContent());
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'), 'JSON no valido');
    }
}
