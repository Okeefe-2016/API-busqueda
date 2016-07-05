<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class LocalidadApiTest extends TestCase
{
    use MakeLocalidadTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    /*public function testCreateLocalidad()
    {
        $localidadData = $this->fakeLocalidadData();
        $this->json('POST', '/api/v1/localid_locaads', $localidadData);

        $this->assertApiResponse($localidadData);
    }*/

    /**
     * @test
     */
    public function testReadLocalidad()
    {
        $localidadData = $this->makeLocalidad();
        $this->json('GET', '/api/v1/localidades/'.$localidadData->id_loca);

        $this->assertApiResponse($localidadData->toArray());
    }

    /**
     * @test
     */
    /*public function testUpdateLocalidad()
    {
        $localidadData = $this->makeLocalidad();
        $editedLocalid_locaad = $this->fakeLocalidadData();

        $this->json('PUT', '/api/v1/localid_locaads/'.$localidadData->id_loca, $editedLocalid_locaad);

        $this->assertApiResponse($editedLocalid_locaad);
    }*/

    /**
     * @test
     */
    /*public function testDeleteLocalidadData()
    {
        $localidadData = $this->makeLocalidad();
        $this->json('DELETE', '/api/v1/localid_locaads/'.$localidadData->id_loca);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/localid_locaads/'.$localidadData->id_loca);

        $this->assertResponseStatus(404);
    }*/
}
