<?php

use Faker\Factory as Faker;
use App\Models\Propiedades;
use App\Repositories\PropiedadesRepository;

trait MakePropiedadesTrait
{
    /**
     * Create fake instance of Propiedades and save it in database
     *
     * @param array $propiedadesFields
     * @return Propiedades
     */
    public function makePropiedades($propiedadesFields = [])
    {
        /** @var PropiedadesRepository $propiedadesRepo */
        $propiedadesRepo = App::make(PropiedadesRepository::class);
        $theme = $this->fakePropiedadesData($propiedadesFields);
        return $propiedadesRepo->create($theme);
    }

    /**
     * Get fake instance of Propiedades
     *
     * @param array $propiedadesFields
     * @return Propiedades
     */
    public function fakePropiedades($propiedadesFields = [])
    {
        return new Propiedades($this->fakePropiedadesData($propiedadesFields));
    }

    /**
     * Get fake data of Propiedades
     *
     * @param array $postFields
     * @return array
     */
    public function fakePropiedadesData($propiedadesFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $propiedadesFields);
    }
}
