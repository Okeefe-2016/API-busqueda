<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PropiedadesApiTest extends TestCase
{
    use MakePropiedadesTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreatePropiedades()
    {
        $propiedades = $this->fakePropiedadesData();
        $this->json('POST', '/api/v1/propiedades', $propiedades);

        $this->assertApiResponse($propiedades);
    }

    /**
     * @test
     */
    public function testReadPropiedades()
    {
        $propiedades = $this->makePropiedades();
        $this->json('GET', '/api/v1/propiedades/'.$propiedades->id);

        $this->assertApiResponse($propiedades->toArray());
    }

    /**
     * @test
     */
    public function testUpdatePropiedades()
    {
        $propiedades = $this->makePropiedades();
        $editedPropiedades = $this->fakePropiedadesData();

        $this->json('PUT', '/api/v1/propiedades/'.$propiedades->id, $editedPropiedades);

        $this->assertApiResponse($editedPropiedades);
    }

    /**
     * @test
     */
    public function testDeletePropiedades()
    {
        $propiedades = $this->makePropiedades();
        $this->json('DELETE', '/api/v1/propiedades/'.$propiedades->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/propiedades/'.$propiedades->id);

        $this->assertResponseStatus(404);
    }
}
