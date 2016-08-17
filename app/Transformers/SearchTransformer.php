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
    public function searchUbicacionPropiedad($ubications, $request)
    {
        $searchValues = $this->setDefaultsValues($request);

        $ubicationsProperties = $ubications->map(function ($element) use ($searchValues, $request) {

            $element->zona = trim($element->zona);
            $element->localidad = trim($element->localidad);
            $element->subzona = trim($element->subzona);

            $properties = $this->getPropertiesData($element, $searchValues);

            $props = [
                'valor' => $element->valor,
                'pais' => $element->pais,
                'zona_padre' => $element->zona_padre,
                'localidad' => $element->localidad,
                'subzona' => $element->subzona,
                'zona_hija' => $element->zona_emprendimiento,
                'id_zona' => $element->idZona,
                'cantidad' => count($properties),
            ];

            if ($request->mostrar_props == true) {
                $props['propiedades'] =  $properties;
            }

            return $props;
        });

        return $ubicationsProperties;
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
    private function getPropertiesData($element, $searchValues)
    {
        $properties = $this->propiedadRepository->byPropertiesSpec($element, $searchValues);

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