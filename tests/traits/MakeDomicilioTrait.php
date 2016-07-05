<?php

use Faker\Factory as Faker;
use App\Models\Domicilio;
use App\Repositories\DomicilioRepository;

trait MakeDomicilioTrait
{
    /**
     * Create fake instance of Domicilio and save it in database
     *
     * @param array $domicilioFields
     * @return Domicilio
     */
    public function makeDomicilio($domicilioFields = [])
    {
        /** @var DomicilioRepository $domicilioRepo */
        $domicilioRepo = App::make(DomicilioRepository::class);
        $theme = $this->fakeDomicilioData($domicilioFields);
        return $domicilioRepo->create($theme);
    }

    /**
     * Get fake instance of Domicilio
     *
     * @param array $domicilioFields
     * @return Domicilio
     */
    public function fakeDomicilio($domicilioFields = [])
    {
        return new Domicilio($this->fakeDomicilioData($domicilioFields));
    }

    /**
     * Get fake data of Domicilio
     *
     * @param array $postFields
     * @return array
     */
    public function fakeDomicilioData($domicilioFields = [])
    {
        $fake = Faker::create();

        return array_merge([
        ], $domicilioFields);
    }
}
