<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PaisApiTest extends TestCase
{
    use MakePaisTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    /*public function testCreatePais()
    {
        $pais = $this->fakePaisData();
        $this->json('POST', '/api/v1/pais', $pais);

        $this->assertApiResponse($pais);
    }*/

    /**
     * @test
     */
    public function testReadPais()
    {
        $pais = $this->makePais();

        $this->json('GET', '/api/v1/pais/'. $pais->id_pais);

        $this->assertApiResponse($pais->toArray());
    }

    /**
     * @test
     */
   /* public function testUpdatePais()
    {
        $pais = $this->makePais();
        $editedPais = $this->fakePaisData();

        $this->json('PUT', '/api/v1/pais/'.$pais->id, $editedPais);

        $this->assertApiResponse($editedPais);
    }*/

    /**
     * @test
     */
    /*public function testDeletePais()
    {
        $pais = $this->makePais();
        $this->json('DELETE', '/api/v1/pais/'.$pais->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/pais/'.$pais->id);

        $this->assertResponseStatus(404);
    }*/
}
