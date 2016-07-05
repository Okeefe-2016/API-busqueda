<?php

use Faker\Factory as Faker;
use App\Models\Pais;
use App\Repositories\PaisRepository;

trait MakePaisTrait
{
    /**
     * Create fake instance of Pais and save it in database
     *
     * @param array $paisFields
     * @return Pais
     */
    public function makePais($paisFields = [])
    {
        /** @var PaisRepository $paisRepo */
        $paisRepo = App::make(PaisRepository::class);
        $theme = $this->fakePaisData($paisFields);
        return $paisRepo->create($theme);
    }

    /**
     * Get fake instance of Pais
     *
     * @param array $paisFields
     * @return Pais
     */
    public function fakePais($paisFields = [])
    {
        return new Pais($this->fakePaisData($paisFields));
    }

    /**
     * Get fake data of Pais
     *
     * @param array $paisFields
     * @return array
     * @internal param array $postFields
     */
    public function fakePaisData($paisFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            
        ], $paisFields);
    }
}
