<?php

namespace App\Repositories;

use App\Models\UbicacionPropiedad;
use App\Transformers\SearchTransformer;
use Prettus\Repository\Eloquent\BaseRepository;

class UbicacionPropiedadRepository extends BaseRepository
{
    /**
     * @var UbicacionPropiedad
     */
    protected $ubicacionPropiedad;

    /**
     * @var SearchTransformer
     */
    protected $searchTranformer;

    /**
     * UbicacionPropiedadRepository constructor.
     * @param UbicacionPropiedad $ubicacionPropiedad
     * @param SearchTransformer $searchTranformer
     * @param PropiedadRepository $propiedadRepository
     */
    public function __construct(UbicacionPropiedad $ubicacionPropiedad,
                                SearchTransformer $searchTranformer, PropiedadRepository $propiedadRepository)
    {
        $this->propiedadRepository = $propiedadRepository;
        $this->ubicacionPropiedad = $ubicacionPropiedad;
        $this->searchService = $searchTranformer;
    }

    /**
     * Return properties with parent/children
     *
     * ubications
     * @param $request
     * @return mixed
     */
    public function getParentWithChildsQuery($request, $params)
    {
        $keyword = $request->ubicacion;

        $query = "
                SELECT  
                  t0.nombre_ubicacion AS pais, 
                  t1.nombre_ubicacion AS zona_padre, 
                  t2.nombre_ubicacion AS localidad,
                  t3.nombre_ubicacion AS subzona, 
                  t4.nombre_ubicacion AS zona_emprendimiento,
                  #if (t4.id_ubica is not null, t4.id_ubica, t3.id_ubica) AS idZona,
                  t3.id_ubica AS idZona,
                  if(t4.nombre_ubicacion is not null, 
                  	CONCAT(t0.nombre_ubicacion,', ',t1.nombre_ubicacion,',', t2.nombre_ubicacion, ',', t3.nombre_ubicacion, ', ', t4.nombre_ubicacion) ,
                  	CONCAT(t0.nombre_ubicacion,', ',t1.nombre_ubicacion,',', t2.nombre_ubicacion, ',', t3.nombre_ubicacion)
                  ) AS valor
                FROM ubicacionpropiedad AS t0
                LEFT JOIN ubicacionpropiedad AS t1 ON t1.id_padre = t0.id_ubica
                LEFT JOIN ubicacionpropiedad AS t2 ON t2.id_padre = t1.id_ubica
                LEFT JOIN ubicacionpropiedad AS t3 ON t3.id_padre = t2.id_ubica 
                LEFT JOIN ubicacionpropiedad AS t4 ON t4.id_padre = t3.id_ubica
                WHERE t2.nombre_ubicacion != t3.nombre_ubicacion
                HAVING idZona = $keyword";

        $ubications = $this->ubicacionPropiedad->hydrateRaw($query);

        $ubications = $this->searchUbicacionPropiedad($ubications, $request, $params);

        return $ubications;
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
        $searchValues = $this->propiedadRepository->setDefaultsValues($request);

        $ubicacion = $ubications->first();

        $properties = $this->getPropertiesData($ubicacion, $searchValues, $params, $request);

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
     * @param $params
     * @return mixed
     * @internal param PropiedadRepository $propiedadRepository
     * @internal param $type
     * @internal param $operation
     */
    private function getPropertiesData($element, $searchValues, $params, $request)
    {
        $properties = $this->propiedadRepository->byPropertiesSpec($element, $searchValues, $params, $request);

        return $properties;
    }

    /**
     * Get ubication by id
     *
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getById($id)
    {
        $query = "
                SELECT  
                  t0.nombre_ubicacion AS pais, 
                  t1.nombre_ubicacion AS zona_padre, 
                  t2.nombre_ubicacion AS localidad,
                  t3.nombre_ubicacion AS subzona, 
                  t4.nombre_ubicacion AS zona_emprendimiento,
                  #if (t4.id_ubica is not null, t4.id_ubica, t3.id_ubica) AS idZona,
                  t3.id_ubica AS idZona,
                  if(t4.nombre_ubicacion is not null, 
                  	CONCAT(t0.nombre_ubicacion,', ',t1.nombre_ubicacion,',', t2.nombre_ubicacion, ',', t3.nombre_ubicacion, ', ', t4.nombre_ubicacion) ,
                  	CONCAT(t0.nombre_ubicacion,', ',t1.nombre_ubicacion,',', t2.nombre_ubicacion, ',', t3.nombre_ubicacion)
                  ) AS valor
                FROM ubicacionpropiedad AS t0
                LEFT JOIN ubicacionpropiedad AS t1 ON t1.id_padre = t0.id_ubica
                LEFT JOIN ubicacionpropiedad AS t2 ON t2.id_padre = t1.id_ubica
                LEFT JOIN ubicacionpropiedad AS t3 ON t3.id_padre = t2.id_ubica 
                LEFT JOIN ubicacionpropiedad AS t4 ON t4.id_padre = t3.id_ubica
                WHERE t2.nombre_ubicacion != t3.nombre_ubicacion AND t3.id_ubica = $id";

        $ubications = $this->ubicacionPropiedad->hydrateRaw($query);

        return $ubications;
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        // TODO: Implement model() method.
    }
}