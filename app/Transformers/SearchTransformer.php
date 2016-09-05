<?php

namespace App\Transformers;

use App\Repositories\PropiedadRepository;

class SearchTransformer
{
    /**
     * @var PropiedadRepository
     */
    protected $propiedadRepository;

    public function __construct(PropiedadRepository $propiedadRepository)
    {
        $this->propiedadRepository = $propiedadRepository;
    }

    /**
     * Search property and ubications
     *
     * @param $ubications
     * @param $request
     * @return static
     */
    public function searchUbicacionPropiedad($ubications, $request, $params)
    {
        $searchValues = $this->setDefaultsValues($request);

            $ubicacion = $ubications->first();

            $properties = $this->getPropertiesData($ubicacion, $searchValues, $params);

            $props = [
                'ubicacion' => $ubicacion->valor,
                'propiedades' => $properties
            ];

            return $props;

    }

    /**
     * Get properties based given params
     *
     * @param $element
     * @param $searchValues
     * @return mixed
     * @internal param $type
     * @internal param $operation
     */
    private function getPropertiesData($element, $searchValues, $params)
    {
        $properties = $this->propiedadRepository->byPropertiesSpec($element, $searchValues, $params);

        return $properties;
    }

    /**
     * Get from configurations default values
     *
     * @param $request
     * @return array
     */
    private function setDefaultsValues($request)
    {
        $searchValues = [];

        $configKeys = array_keys(config('apiDefaults'));

        foreach ($configKeys as $item) {
            $searchValues[$item] = !$request->{$item} ? config("apiDefaults.{$item}") : $request->{$item};


            if ($searchValues[$item] === true) {
                $searchValues[$item] = '< 100';
            }

            if (is_array($searchValues[$item])) {
                $searchValues[$item] =  config("apiDefaults.{$item}.options");
            }
        }

        return $searchValues;
    }
}