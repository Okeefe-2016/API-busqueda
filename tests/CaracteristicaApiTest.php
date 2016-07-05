<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;


class CaracteristicaApiTest extends TestCase
{
    use MakeCaracteristicaTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    /*public function testCreateCaracteristica()
    {
        $caracteristica = $this->fakeCaracteristicaData();
        $this->json('POST', '/api/v1/caracteristicas', $caracteristica);

        $this->assertApiResponse($caracteristica);
    }*/

    /**
     * @test
     */
    public function testReadCaracteristica()
    {
        $caracteristica = $this->makeCaracteristica();
        
        $this->json('GET', '/api/v1/caracteristicas/'.$caracteristica->id_carac);

        $this->assertApiResponse($caracteristica->toArray());
    }

    /**
     * @test
     */
    /*public function testUpdateCaracteristica()
    {
        $caracteristica = $this->makeCaracteristica();
        $editedCaracteristica = $this->fakeCaracteristicaData();

        $this->json('PUT', '/api/v1/caracteristicas/'.$caracteristica->id, $editedCaracteristica);

        $this->assertApiResponse($editedCaracteristica);
    }*/

    /**
     * @test
     */
    /*public function testDeleteCaracteristica()
    {
        $caracteristica = $this->makeCaracteristica();
        $this->json('DELETE', '/api/v1/caracteristicas/'.$caracteristica->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/caracteristicas/'.$caracteristica->id);

        $this->assertResponseStatus(404);
    }*/
}
