<?php

use App\Models\Pais;
use App\Repositories\PaisRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PaisRepositoryTest extends TestCase
{
    use MakePaisTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var PaisRepository
     */
    protected $paisRepo;

    public function setUp()
    {
        parent::setUp();
        $this->paisRepo = App::make(PaisRepository::class);
    }

    /**
     * @test create
     */
    public function testCreatePais()
    {
        $pais = $this->fakePaisData();
        $createdPais = $this->paisRepo->create($pais);
        $createdPais = $createdPais->toArray();
        $this->assertArrayHasKey('id', $createdPais);
        $this->assertNotNull($createdPais['id'], 'Created Pais must have id specified');
        $this->assertNotNull(Pais::find($createdPais['id']), 'Pais with given id must be in DB');
        $this->assertModelData($pais, $createdPais);
    }

    /**
     * @test read
     */
    public function testReadPais()
    {
        $pais = $this->makePais();
        $dbPais = $this->paisRepo->find($pais->id_pais);
        $dbPais = $dbPais->toArray();
        $this->assertModelData($pais->toArray(), $dbPais);
    }

    /**
     * @test update
     */
    public function testUpdatePais()
    {
        $pais = $this->makePais();
        $fakePais = $this->fakePaisData();
        $updatedPais = $this->paisRepo->update($fakePais, $pais->id);
        $this->assertModelData($fakePais, $updatedPais->toArray());
        $dbPais = $this->paisRepo->find($pais->id);
        $this->assertModelData($fakePais, $dbPais->toArray());
    }

    /**
     * @test delete
     */
    public function testDeletePais()
    {
        $pais = $this->makePais();
        $resp = $this->paisRepo->delete($pais->id);
        $this->assertTrue($resp);
        $this->assertNull(Pais::find($pais->id), 'Pais should not exist in DB');
    }
}
