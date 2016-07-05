<?php

use App\Models\Caracteristica;
use App\Repositories\CaracteristicaRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CaracteristicaRepositoryTest extends TestCase
{
    use MakeCaracteristicaTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var CaracteristicaRepository
     */
    protected $caracteristicaRepo;

    public function setUp()
    {
        parent::setUp();
        $this->caracteristicaRepo = App::make(CaracteristicaRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateCaracteristica()
    {
        $caracteristica = $this->fakeCaracteristicaData();
        $createdCaracteristica = $this->caracteristicaRepo->create($caracteristica);
        $createdCaracteristica = $createdCaracteristica->toArray();
        $this->assertArrayHasKey('id', $createdCaracteristica);
        $this->assertNotNull($createdCaracteristica['id_carac'], 'Created Caracteristica must have id specified');
        $this->assertNotNull(Caracteristica::find($createdCaracteristica['id_carac']), 'Caracteristica with given id must be in DB');
        $this->assertModelData($caracteristica, $createdCaracteristica);
    }

    /**
     * @test read
     */
    public function testReadCaracteristica()
    {
        $caracteristica = $this->makeCaracteristica();
        $dbCaracteristica = $this->caracteristicaRepo->find($caracteristica->id_carac);
        $dbCaracteristica = $dbCaracteristica->toArray();
        $this->assertModelData($caracteristica->toArray(), $dbCaracteristica);
    }

    /**
     * @test update
     */
    public function testUpdateCaracteristica()
    {
        $caracteristica = $this->makeCaracteristica();
        $fakeCaracteristica = $this->fakeCaracteristicaData();
        $updatedCaracteristica = $this->caracteristicaRepo->update($fakeCaracteristica, $caracteristica->id_carac);
        $this->assertModelData($fakeCaracteristica, $updatedCaracteristica->toArray());
        $dbCaracteristica = $this->caracteristicaRepo->find($caracteristica->id_carac);
        $this->assertModelData($fakeCaracteristica, $dbCaracteristica->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteCaracteristica()
    {
        $caracteristica = $this->makeCaracteristica();
        $resp = $this->caracteristicaRepo->delete($caracteristica->id_carac);
        $this->assertTrue($resp);
        $this->assertNull(Caracteristica::find($caracteristica->id_carac), 'Caracteristica should not exist in DB');
    }
}
