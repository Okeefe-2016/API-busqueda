<?php

namespace App\Repositories;

use App\Models\UbicacionPropiedad;
use App\Transformers\SearchTransformer;

clASs UbicacionPropiedadRepository
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
     */
    public function __construct(UbicacionPropiedad $ubicacionPropiedad, SearchTransformer $searchTranformer)
    {
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
    public function getParentWithChildsQuery($request)
    {
        $keyword = "%$request->q%";

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
                WHERE t2.nombre_ubicacion != t3.nombre_ubicacion AND t0.id_padre  = 0
                HAVING valor LIKE '$keyword'";

        $ubications = $this->ubicacionPropiedad->hydrateRaw($query);

        $ubications = $this->searchService->searchUbicacionPropiedad($ubications, $request);

        return $ubications;
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
                WHERE t2.nombre_ubicacion != t3.nombre_ubicacion AND t0.id_padre  = 0 AND t3.id_ubica = $id";

        $ubications = $this->ubicacionPropiedad->hydrateRaw($query);

        return $ubications;
    }
}