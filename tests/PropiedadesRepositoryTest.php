<?php

use App\Models\Propiedades;
use App\Repositories\PropiedadesRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PropiedadesRepositoryTest extends TestCase
{
    use MakePropiedadesTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var PropiedadesRepository
     */
    protected $propiedadesRepo;

    public function setUp()
    {
        parent::setUp();
        $this->propiedadesRepo = App::make(PropiedadesRepository::class);
    }

    /**
     * @test create
     */
    public function testCreatePropiedades()
    {
        $propiedades = $this->fakePropiedadesData();
        $createdPropiedades = $this->propiedadesRepo->create($propiedades);
        $createdPropiedades = $createdPropiedades->toArray();
        $this->assertArrayHasKey('id', $createdPropiedades);
        $this->assertNotNull($createdPropiedades['id'], 'Created Propiedades must have id specified');
        $this->assertNotNull(Propiedades::find($createdPropiedades['id']), 'Propiedades with given id must be in DB');
        $this->assertModelData($propiedades, $createdPropiedades);
    }

    /**
     * @test read
     */
    public function testReadPropiedades()
    {
        $propiedades = $this->makePropiedades();
        $dbPropiedades = $this->propiedadesRepo->find($propiedades->id);
        $dbPropiedades = $dbPropiedades->toArray();
        $this->assertModelData($propiedades->toArray(), $dbPropiedades);
    }

    /**
     * @test update
     */
    public function testUpdatePropiedades()
    {
        $propiedades = $this->makePropiedades();
        $fakePropiedades = $this->fakePropiedadesData();
        $updatedPropiedades = $this->propiedadesRepo->update($fakePropiedades, $propiedades->id);
        $this->assertModelData($fakePropiedades, $updatedPropiedades->toArray());
        $dbPropiedades = $this->propiedadesRepo->find($propiedades->id);
        $this->assertModelData($fakePropiedades, $dbPropiedades->toArray());
    }

    /**
     * @test delete
     */
    public function testDeletePropiedades()
    {
        $propiedades = $this->makePropiedades();
        $resp = $this->propiedadesRepo->delete($propiedades->id);
        $this->assertTrue($resp);
        $this->assertNull(Propiedades::find($propiedades->id), 'Propiedades should not exist in DB');
    }
}
