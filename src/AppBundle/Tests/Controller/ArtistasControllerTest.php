<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ArtistasControllerTest extends WebTestCase
{
    const ROUTEARTISTA = '/artist/';
    
    public function testAddArtistaErrorNombre()
    {
        $client = static::createClient();
        
        $client->request('POST', self::ROUTEARTISTA, array('rol' => 'voz'));
        $response = $client->getResponse();
        
        $this->assertEquals(400, $response->getStatusCode(), $response->getContent());
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'), 'JSON no valido');
    }
    
    public function testAddArtistaErrorRol()
    {
        $client = static::createClient();
        
        $client->request('POST', self::ROUTEARTISTA, array('nombre' => 'Artista de Prueba'));
        $response = $client->getResponse();
        
        $this->assertEquals(400, $response->getStatusCode(), $response->getContent());
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'), 'JSON no valido');
    }
    
    public function testAddArtista()
    {
        $client = static::createClient();
        
        $client->request('POST', self::ROUTEARTISTA, array('nombre' => 'Artista de Prueba', 'rol' => 'voz'));
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
        
        $client->request('GET', self::ROUTEARTISTA.$idArtistaTest.'/');
        $response = $client->getResponse();
                
        $this->assertEquals(200, $response->getStatusCode(), $response->getContent());
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'), 'JSON no valido');
    }
    
    public function testGetAlbumNoExiste()
    {
        $client = static::createClient();
        
        $client->request('GET', self::ROUTEARTISTA.'No_existe_9999999999/');
        $response = $client->getResponse();
                
        $this->assertEquals(404, $response->getStatusCode(), $response->getContent());
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'), 'JSON no valido');
    }
    
    public function testUpdateArtistaRol()
    {
        global $idArtistaTest;
        
        $client = static::createClient();
        
        $client->request('PUT', self::ROUTEARTISTA.$idArtistaTest.'/', array('rol' => 'bajo'));
        $response = $client->getResponse();
        
        $this->assertEquals(200, $response->getStatusCode(), $response->getContent());
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'), 'JSON no valido');
    }
    
    public function testUpdateArtistaNombre()
    {
        global $idArtistaTest;
        
        $client = static::createClient();
        
        $client->request('PUT', self::ROUTEARTISTA.$idArtistaTest.'/', array('nombre' => 'Artista modificado'));
        $response = $client->getResponse();
        
        $this->assertEquals(200, $response->getStatusCode(), $response->getContent());
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'), 'JSON no valido');
    }
    
    public function testUpdateArtistaErrorId()
    {        
        $client = static::createClient();
        
        $client->request('PUT', self::ROUTEARTISTA.'No_existe_999999/', array('nombre' => 'Artista modificado'));
        $response = $client->getResponse();
        
        $this->assertEquals(404, $response->getStatusCode(), $response->getContent());
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'), 'JSON no valido');
    }
    
    public function testSetAlbum()
    {
        global $idArtistaTest;
        
        $client = static::createClient();
        
        $client->request('PUT', self::ROUTEARTISTA.'album/'.$idArtistaTest.'/', array('albumId' => '1'));
        $response = $client->getResponse();
        
        $this->assertEquals(200, $response->getStatusCode(), $response->getContent());
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'), 'JSON no valido');
    }
    
    public function testGetAllArtistas()
    {
        $client = static::createClient();
        
        $client->request('GET', self::ROUTEARTISTA);
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
        
        $client->request('DELETE', self::ROUTEARTISTA.$idArtistaTest.'/');
        $response = $client->getResponse();
        
        $this->assertEquals(200, $response->getStatusCode(), $response->getContent());
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'), 'JSON no valido');
    }
}
