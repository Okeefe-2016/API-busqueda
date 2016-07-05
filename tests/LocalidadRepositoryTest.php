<?php

use App\Models\Localidad;
use App\Repositories\LocalidadRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LocalidadRepositoryTest extends TestCase
{
    use MakeLocalidadTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var LocalidadRepository
     */
    protected $localidadRepo;

    public function setUp()
    {
        parent::setUp();
        $this->localidadRepo = App::make(LocalidadRepository::class);
    }

    /**
     * @test create
     */
    /*public function testCreateLocalidad()
    {
        $localidad = $this->fakeLocalidadData();
        $createdLocalidad = $this->localidadRepo->create($localidad);
        $createdLocalidad = $createdLocalidad->toArray();
        $this->assertArrayHasKey('id', $createdLocalidad);
        $this->assertNotNull($createdLocalidad['id'], 'Created Localidad must have id specified');
        $this->assertNotNull(Localidad::find($createdLocalidad['id']), 'Localidad with given id must be in DB');
        $this->assertModelData($localidad, $createdLocalidad);
    }*/

    /**
     * @test read
     */
    public function testReadLocalidad()
    {
        $localidad = $this->makeLocalidad();
        $dbLocalidad = $this->localidadRepo->find($localidad->id);
        $dbLocalidad = $dbLocalidad->toArray();
        $this->assertModelData($localidad->toArray(), $dbLocalidad);
    }

    /**
     * @test update
     */
    /*public function testUpdateLocalidad()
    {
        $localidad = $this->makeLocalidad();
        $fakeLocalidad = $this->fakeLocalidadData();
        $updatedLocalidad = $this->localidadRepo->update($fakeLocalidad, $localidad->id);
        $this->assertModelData($fakeLocalidad, $updatedLocalidad->toArray());
        $dbLocalidad = $this->localidadRepo->find($localidad->id);
        $this->assertModelData($fakeLocalidad, $dbLocalidad->toArray());
    }*/

    /**
     * @test delete
     */
    /*public function testDeleteLocalidad()
    {
        $localidad = $this->makeLocalidad();
        $resp = $this->localidadRepo->delete($localidad->id);
        $this->assertTrue($resp);
        $this->assertNull(Localidad::find($localidad->id), 'Localidad should not exist in DB');
    }*/
}
