<?php

use Faker\Factory as Faker;
use App\Models\Caracteristica;
use App\Repositories\CaracteristicaRepository;

trait MakeCaracteristicaTrait
{
    /**
     * Create fake instance of Caracteristica and save it in database
     *
     * @param array $caracteristicaFields
     * @return Caracteristica
     */
    public function makeCaracteristica($caracteristicaFields = [])
    {
        /** @var CaracteristicaRepository $caracteristicaRepo */
        $caracteristicaRepo = App::make(CaracteristicaRepository::class);
        $theme = $this->fakeCaracteristicaData($caracteristicaFields);
        return $caracteristicaRepo->create($theme);
    }

    /**
     * Get fake instance of Caracteristica
     *
     * @param array $caracteristicaFields
     * @return Caracteristica
     */
    public function fakeCaracteristica($caracteristicaFields = [])
    {
        return new Caracteristica($this->fakeCaracteristicaData($caracteristicaFields));
    }

    /**
     * Get fake data of Caracteristica
     *
     * @param array $caracteristicaFields
     * @return array
     */
    public function fakeCaracteristicaData($caracteristicaFields = [])
    {
        $fake = Faker::create();

        return array_merge([
        ], $caracteristicaFields);
    }
}
