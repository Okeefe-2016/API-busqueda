<?php

use App\Models\Domicilio;
use App\Repositories\DomicilioRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DomicilioRepositoryTest extends TestCase
{
    use MakeDomicilioTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var DomicilioRepository
     */
    protected $domicilioRepo;

    public function setUp()
    {
        parent::setUp();
        $this->domicilioRepo = App::make(DomicilioRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateDomicilio()
    {
        $domicilio = $this->fakeDomicilioData();
        $createdDomicilio = $this->domicilioRepo->create($domicilio);
        $createdDomicilio = $createdDomicilio->toArray();
        $this->assertArrayHasKey('id_dom', $createdDomicilio);
        $this->assertNotNull($createdDomicilio['id_dom'], 'Created Domicilio must have id_dom specified');
        $this->assertNotNull(Domicilio::find($createdDomicilio['id_dom']), 'Domicilio with given id_dom must be in DB');
        $this->assertModelData($domicilio, $createdDomicilio);
    }

    /**
     * @test read
     */
    public function testReadDomicilio()
    {
        $domicilio = $this->makeDomicilio();
        $dbDomicilio = $this->domicilioRepo->find($domicilio->id_dom_dom);
        $dbDomicilio = $dbDomicilio->toArray();
        $this->assertModelData($domicilio->toArray(), $dbDomicilio);
    }

    /**
     * @test update
     */
    public function testUpdateDomicilio()
    {
        $domicilio = $this->makeDomicilio();
        $fakeDomicilio = $this->fakeDomicilioData();
        $updatedDomicilio = $this->domicilioRepo->update($fakeDomicilio, $domicilio->id_dom);
        $this->assertModelData($fakeDomicilio, $updatedDomicilio->toArray());
        $dbDomicilio = $this->domicilioRepo->find($domicilio->id_dom);
        $this->assertModelData($fakeDomicilio, $dbDomicilio->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteDomicilio()
    {
        $domicilio = $this->makeDomicilio();
        $resp = $this->domicilioRepo->delete($domicilio->id_dom);
        $this->assertTrue($resp);
        $this->assertNull(Domicilio::find($domicilio->id_dom), 'Domicilio should not exist in DB');
    }
}
