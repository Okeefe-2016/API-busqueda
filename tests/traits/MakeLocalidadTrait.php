<?php

use Faker\Factory as Faker;
use App\Models\Localidad;
use App\Repositories\LocalidadRepository;

trait MakeLocalidadTrait
{
    /**
     * Create fake instance of Localidad and save it in database
     *
     * @param array $localidadFields
     * @return Localidad
     */
    public function makeLocalidad($localidadFields = [])
    {
        /** @var LocalidadRepository $localidadRepo */
        $localidadRepo = App::make(LocalidadRepository::class);
        $theme = $this->fakeLocalidadData($localidadFields);
        return $localidadRepo->create($theme);
    }

    /**
     * Get fake instance of Localidad
     *
     * @param array $localidadFields
     * @return Localidad
     */
    public function fakeLocalidad($localidadFields = [])
    {
        return new Localidad($this->fakeLocalidadData($localidadFields));
    }

    /**
     * Get fake data of Localidad
     *
     * @param array $postFields
     * @return array
     */
    public function fakeLocalidadData($localidadFields = [])
    {
        $fake = Faker::create();

        return array_merge([
        ], $localidadFields);
    }
}
