<?php

namespace App\Repositories;

use App\Models\UbicacionPropiedad;
use Illuminate\Http\Request;

class UbicacionRepository
{
    public function __construct(UbicacionPropiedad $ubicacion)
    {
        $this->ubicacion = $ubicacion;
    }

    public function getByParams(Request $request, $zona, $tipo, $operacion)
    {
        $ubicationQuery = $this->getUbicationQuery();

        if ($request->emp == ' is not null') {
            $nomedif = 'AND  prop.nomedif = t4.nombre_ubicacion';
        } else {
            $nomedif = ' ';
        }

        $query = "{$ubicationQuery} 
                 LEFT JOIN propiedad AS prop 
                  ON t3.id_ubica = prop.id_ubica  
                  AND prop.tipo_oper_id = $operacion AND prop.id_tipo_prop in($tipo) " . $nomedif . " 
                WHERE t0.nombre_ubicacion != t1.nombre_ubicacion
                  AND t4.nombre_ubicacion $request->emp
                GROUP BY idZona
                HAVING  valor LIKE '%$zona%'
                ORDER BY cantidad desc";


        $ubications = $this->ubicacion->hydrateRaw($query);
        \Log::info($ubications);
        return $ubications;
    }

    /**
     * @param $tipo
     * @param $operacion
     * @return string
     */
    public function getUbicationQuery()
    {
        $ubicationQuery = "SELECT  
                  t0.nombre_ubicacion AS pais, 
                  t1.nombre_ubicacion AS zona_padre,
                  t2.nombre_ubicacion AS localidad, 
                  t3.nombre_ubicacion AS subzona ,
                  t4.nombre_ubicacion AS zona_emprendimiento,
                  (CASE
                    WHEN t2.id_ubica is null THEN t1.id_ubica
                    WHEN t3.id_ubica is null THEN t2.id_ubica
                    WHEN t4.id_ubica is null THEN t3.id_ubica
                    WHEN  t3.nombre_ubicacion = t4.nombre_ubicacion THEN t3.id_ubica
                    ELSE t4.id_ubica
                   END) as idZona,
                  COUNT(prop.id_prop) as cantidad,
                  (CASE 
                    WHEN t2.nombre_ubicacion is null THEN CONCAT(t0.nombre_ubicacion,', ',t1.nombre_ubicacion)
                    WHEN t3.nombre_ubicacion is null THEN CONCAT(t0.nombre_ubicacion,', ',t1.nombre_ubicacion,',', t2.nombre_ubicacion)
                    WHEN t4.nombre_ubicacion is null THEN CONCAT(t0.nombre_ubicacion,', ',t1.nombre_ubicacion,',', t2.nombre_ubicacion, ',', t3.nombre_ubicacion)
                    ELSE CONCAT(t0.nombre_ubicacion,', ',t1.nombre_ubicacion,',', t2.nombre_ubicacion, ',', t3.nombre_ubicacion, ',', t4.nombre_ubicacion)
                  END) AS valor
                FROM ubicacionpropiedad AS t0
                LEFT JOIN ubicacionpropiedad AS t1 ON t1.id_padre = t0.id_ubica
                LEFT JOIN ubicacionpropiedad AS t2 ON t2.id_padre = t1.id_ubica 
                LEFT JOIN ubicacionpropiedad AS t3 ON t3.id_padre = t2.id_ubica 
                LEFT JOIN ubicacionpropiedad AS t4 ON t4.id_padre = t3.id_ubica";

        return $ubicationQuery;
    }
}