<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DomicilioApiTest extends TestCase
{
    use MakeDomicilioTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    /*public function testCreateDomicilio()
    {
        $domicilio = $this->fakeDomicilioData();
        $this->json('POST', '/api/v1/domicilios', $domicilio);

        $this->assertApiResponse($domicilio);
    }*/

    /**
     * @test
     */
    public function testReadDomicilio()
    {
        $domicilio = $this->makeDomicilio();
        $this->json('GET', '/api/v1/domicilios/'.$domicilio->id_dom);

        $this->assertApiResponse($domicilio->toArray());
    }

    /**
     * @test
     */
    /*public function testUpdateDomicilio()
    {
        $domicilio = $this->makeDomicilio();
        $editedDomicilio = $this->fakeDomicilioData();

        $this->json('PUT', '/api/v1/domicilios/'.$domicilio->id, $editedDomicilio);

        $this->assertApiResponse($editedDomicilio);
    }*/

    /**
     * @test
     */
    /*public function testDeleteDomicilio()
    {
        $domicilio = $this->makeDomicilio();
        $this->json('DELETE', '/api/v1/domicilios/'.$domicilio->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/domicilios/'.$domicilio->id);

        $this->assertResponseStatus(404);
    }*/
}
