<?php

namespace App\Repositories;

use App\Models\Propiedad;
use App\Models\UbicacionPropiedad;
use App\Services\CotizationService;
use Illuminate\Http\Response;
use InfyOm\Generator\Common\BaseRepository;
use Illuminate\Container\Container AS Application;
use Mockery\CountValidator\Exception;
use Tymon\JWTAuth\JWTAuth;

/**
 * @property  ubicaRepo
 */
class PropiedadRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [

    ];

    /**
     * @var CotizationService
     */
    protected $cotizationService;


    /**
     * Configure the Model
     **/
    public function model()
    {
        return Propiedad::class;
    }

    public function __construct(CotizationService $cotizationService)
    {
        $this->publicURL = env('PUBLIC_URL');
        $this->cotizationService = $cotizationService;
    }

    /**
     * Get from configurations default values
     *
     * @param $request
     * @return array
     */
    public function setDefaultsValues($request)
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

    /**
     * @param $id
     */
    public function getWithUbication($id, $ubica)
    {

        $propiedad = Propiedad::with(['foto', 'propiedad_caracteristicas' => function ($q) {
            $q->select('id_prop_carac', 'id_prop', 'id_carac', 'contenido');
        }, 'propiedad_caracteristicas.caracteristica' => function ($q) {
            $q->select('id_carac', 'id_tipo_carac', 'titulo');
        }])->find($id);

        $propiedad->ubica = $ubica->getById($propiedad->id_ubica);
        
        return $propiedad;
    }
    
    

    /**
     * @param UbicacionPropiedad $ubica
     * @param $ids
     */
    public function getManyWithUbica($ids, $ubica)
    {

        $propiedad = Propiedad::with(['foto', 'propiedad_caracteristicas' => function ($q) {
            $q->select('id_prop_carac', 'id_prop', 'id_carac', 'contenido');
        }, 'propiedad_caracteristicas.caracteristica' => function ($q) {
            $q->select('id_carac', 'id_tipo_carac', 'titulo');
        }])->find($ids);

        $propiedad->map(function ($value) use ($ubica) {
            $value->ubica = $ubica->getById($value->id_ubica);
        });

        return $propiedad;
    }

    /**
     * Find properties by spect
     *
     * @param $element
     * @param $searchValues
     * @return mixed
     */
    public function byPropertiesSpec($element, $searchValues, $params)
    {

        if ($searchValues['rural'] === false) {
            $query = $this->getPropiedadQuery($element, $searchValues, $params);
        } else {
            $query = $this->getPropiedadByRuralQuery($element, $searchValues, $params);
        }

        $result = Propiedad::hydrateRaw($query);

        return $result;
    }

    public function byIdProps($ids, $ubica)
    {
        if (is_array($ids)) {
            $props = implode(",", $ids);
        } else {
            $props = $ids;
        }

        $query = '
            SELECT p.id_prop,
                p.id_ubica,
                p.calle,
                p.nro,
                p.id_tipo_prop,
                p.subtipo_prop,
                p.tipo_oper_id,
                p.piso,
                p.dpto,
                p.activa,
                p.id_sucursal,
                p.id_emp,
                p.compartir,
                p.goglat,
                p.goglong,
                z.nombre_ubicacion,
                t.tipo_prop,
                st.sup_total,
                sca.cantidad_ambientes,
                sba.cantidad_banos,
                cco.cantidad_cocheras,
                caa.cantidad_antiguedad,
                monv.moneda_venta,
                mona.moneda_alq,
                valv.valor_venta,
                vala.valor_alq, 
                webindex.fichaweb,
                description.descripcion,              
                caa.cantidad_antiguedad,
                IF(sca.cantidad_ambientes is null, 1, sca.cantidad_ambientes) AS cantidad_ambientes,
                e.nombre AS nombre_emprendimiento,
                IF(fo.foto_principal IS NOT null, CONCAT("' . $this->publicURL . '", fo.foto_principal), "") AS foto_url,
                (CASE  WHEN p.oportunidad = 1 THEN "oportunidad"
                      WHEN p.destacado = 1 THEN "destacado"
                      ELSE "otro"
                END) as tipo_prioridad
        FROM propiedad AS p
        INNER JOIN ubicacionpropiedad AS z ON p.id_ubica = z.id_ubica
        INNER JOIN tipoprop AS t ON p.id_tipo_prop = t.id_tipo_prop
        LEFT JOIN (select id_prop, foto as foto_principal from fotos where posicion = 1) as fo on p.id_prop = fo.id_prop
        LEFT JOIN emprendimiento AS e ON p.id_emp = e.id_emp 
                  
        LEFT JOIN
        (SELECT id_prop, contenido AS descripcion FROM propiedad_caracteristicas WHERE id_carac = 198) AS description
                ON p.id_prop=description.id_prop 
         
        LEFT JOIN
        (SELECT id_prop, contenido AS sup_total FROM propiedad_caracteristicas WHERE id_carac = 198) AS st
                ON p.id_prop=st.id_prop
          LEFT JOIN
        (SELECT id_prop, contenido AS fichaweb FROM propiedad_caracteristicas WHERE id_carac = 257) AS webindex
                ON p.id_prop=webindex.id_prop
        LEFT JOIN
        (SELECT id_prop, contenido AS cantidad_ambientes FROM propiedad_caracteristicas WHERE id_carac = 208) AS sca
                ON p.id_prop=sca.id_prop
        LEFT JOIN
        (SELECT id_prop,
             CASE WHEN contenido IS NULL THEN 0 ELSE contenido END
             AS cantidad_banos FROM propiedad_caracteristicas WHERE id_carac = 71) AS sba
                ON p.id_prop=sba.id_prop
        LEFT JOIN
        (SELECT id_prop, contenido AS cantidad_cocheras FROM propiedad_caracteristicas WHERE id_carac = 373) AS cco
                ON p.id_prop=cco.id_prop
         LEFT JOIN
        (SELECT id_prop, contenido AS cantidad_antiguedad FROM propiedad_caracteristicas WHERE id_carac = 374) AS caa
                ON p.id_prop=caa.id_prop
          
        LEFT JOIN
		(SELECT id_prop, contenido AS moneda_venta FROM propiedad_caracteristicas WHERE id_carac=165) AS monv
		    ON p.id_prop=monv.id_prop
		LEFT JOIN
		(SELECT id_prop, contenido AS valor_venta FROM propiedad_caracteristicas WHERE id_carac=161) AS valv
		    ON p.id_prop=valv.id_prop
          
        LEFT JOIN
		(SELECT id_prop, contenido AS moneda_alq FROM propiedad_caracteristicas WHERE id_carac=166) AS mona
            ON p.id_prop=mona.id_prop
		LEFT JOIN
        (SELECT id_prop, contenido AS valor_alq FROM propiedad_caracteristicas WHERE id_carac=164) AS vala
            ON p.id_prop=vala.id_prop
         
         WHERE p.id_prop in(' . $props . ') 
            ORDER BY
                (CASE
                    WHEN p.oportunidad = 1 THEN p.oportunidad
                    WHEN p.destacado = 1 THEN p.destacado
                END) DESC';


        $result = Propiedad::hydrateRaw($query);
        

        $result->map(function($element) use ($ubica) {
            $element->ubica = $ubica->getById($element->id_ubica);
        });


        return $result;
    }


    /**
     * Pick the value of money from type of operation
     *
     * @param $values
     * @return string
     */
    private function getMoneyType($values, $params)
    {

        $moneyType = " ";

        if ($params['operacion'] == 12) {
            $moneyType = "
                  LEFT JOIN
				    (SELECT id_prop, contenido AS moneda FROM propiedad_caracteristicas WHERE id_carac=165) AS mon
				        ON p.id_prop=mon.id_prop
				  LEFT JOIN
				    (SELECT id_prop, contenido AS valor FROM propiedad_caracteristicas WHERE id_carac=161) AS val
				        ON p.id_prop=val.id_prop";
        } else if ($params['operacion'] == 2 || $params['operacion'] == 4) {
            $moneyType = "
                 LEFT JOIN
				    (SELECT id_prop, contenido AS moneda FROM propiedad_caracteristicas WHERE id_carac=166) AS mon
				        ON p.id_prop=mon.id_prop
				  LEFT JOIN
				    (SELECT id_prop, contenido AS valor FROM propiedad_caracteristicas WHERE id_carac=164) AS val
				        ON p.id_prop=val.id_prop";
        }

        return $moneyType;
    }

    /**
     * Build propiedad query
     *
     * @param $element
     * @param $searchValues
     * @return string
     */
    private function getPropiedadQuery($element, $searchValues, $params)
    {
        $moneyType = $this->getMoneyType($searchValues, $params);
        $nameFilter = $searchValues['filtroMon'] == 'ARS' ? 'valor_convertido' : 'valor';

        return '
          SELECT p.id_prop,
                p.id_ubica,
                p.calle,
                p.nro,
                p.id_tipo_prop,
                p.subtipo_prop,
                p.tipo_oper_id,
                p.piso,
                p.dpto,
                p.activa,
                p.id_sucursal,
                p.id_emp,
                p.compartir,
                p.goglat,
                p.goglong,
                z.nombre_ubicacion,
                t.tipo_prop,
                st.sup_total,
                sca.cantidad_ambientes,
                sba.cantidad_banos,
                cco.cantidad_cocheras,
                caa.cantidad_antiguedad,
                mon.moneda,
                webindex.fichaweb,
                val.valor,
                IF(mon.moneda = "U$S", val.valor * 14, val.valor) AS valor_convertido,
                caa.cantidad_antiguedad,
                IF(sca.cantidad_ambientes is null, 1, sca.cantidad_ambientes) AS cantidad_ambientes,
                e.nombre AS nombre_emprendimiento,
                IF(fo.foto_principal IS NOT null, CONCAT("' . $this->publicURL . '", fo.foto_principal), "") AS foto_url,
                (CASE  WHEN p.oportunidad = 1 THEN "oportunidad"
                      WHEN p.destacado = 1 THEN "destacado"
                      ELSE "otro"
                END) as tipo_prioridad
          FROM propiedad AS p
          INNER JOIN ubicacionpropiedad AS z ON p.id_ubica = z.id_ubica
          INNER JOIN tipoprop AS t ON p.id_tipo_prop = t.id_tipo_prop
          LEFT JOIN (select id_prop, foto as foto_principal from fotos where posicion = 1) as fo on p.id_prop = fo.id_prop
          LEFT JOIN emprendimiento AS e ON p.id_emp = e.id_emp
          LEFT JOIN
              (SELECT id_prop, contenido AS sup_total FROM propiedad_caracteristicas WHERE id_carac = 198) AS st
                ON p.id_prop=st.id_prop
          LEFT JOIN
              (SELECT id_prop, contenido AS fichaweb FROM propiedad_caracteristicas WHERE id_carac = 257) AS webindex
                ON p.id_prop=webindex.id_prop
          LEFT JOIN
            (SELECT id_prop, contenido AS cantidad_ambientes FROM propiedad_caracteristicas WHERE id_carac = 208) AS sca
                ON p.id_prop=sca.id_prop
          LEFT JOIN
            (SELECT id_prop,
             CASE WHEN contenido IS NULL THEN 0 ELSE contenido END
             AS cantidad_banos FROM propiedad_caracteristicas WHERE id_carac = 71) AS sba
                ON p.id_prop=sba.id_prop
          LEFT JOIN
            (SELECT id_prop, contenido AS cantidad_cocheras FROM propiedad_caracteristicas WHERE id_carac = 373) AS cco
                ON p.id_prop=cco.id_prop
          LEFT JOIN
            (SELECT id_prop, contenido AS cantidad_antiguedad FROM propiedad_caracteristicas WHERE id_carac = 374) AS caa
                ON p.id_prop=caa.id_prop
          ' . $moneyType . '
          WHERE p.id_ubica = ' . $element->idZona . '
              AND p.tipo_oper_id = "' . $params['operacion'] . '"
              AND  p.id_tipo_prop IN (' . $params['tipo'] . ')
              AND (cco.cantidad_cocheras ' . $searchValues['coch'] . ' or cco.cantidad_cocheras is null)
              AND (caa.cantidad_antiguedad ' . $searchValues['ant'] . ' or caa.cantidad_antiguedad is null)
              AND (st.sup_total BETWEEN ' . $searchValues['supMin'] . ' AND ' . $searchValues['supMax'] . ' or st.sup_total is null)
              AND mon.moneda IN ("' . $searchValues['moneda'][0] . '", "' . $searchValues['moneda'][1] . '")
              AND (sba.cantidad_banos ' . $searchValues['banos'] . ' or sba.cantidad_banos is null)
              AND p.tiene_emprendimiento  = ' . $searchValues['emp'] . '
          HAVING ' . $nameFilter . ' BETWEEN ' . $searchValues['valMin'] . ' AND ' . $searchValues['valMax'] . '
              AND (cantidad_ambientes ' . $searchValues['amb'] . ' or sba.cantidad_banos is null)
          ORDER BY
                CASE
                    WHEN p.oportunidad = 1 THEN p.oportunidad
                    WHEN p.destacado = 1 THEN p.destacado
                    ELSE -1
                END DESC';
    }

    /**
     * Build rural query
     *
     * @param $element
     * @param $searchValues
     * @return bool
     */
    private function getPropiedadByRuralQuery($element, $searchValues, $params)
    {
        $moneyType = $this->getMoneyType($searchValues, $params);



        return '
          SELECT p.id_prop,
                p.id_ubica,
                p.calle,
                p.nro,
                p.id_tipo_prop,
                p.subtipo_prop,
                p.tipo_oper_id,
                p.activa,
                p.id_sucursal,
                p.id_emp,
                p.compartir,
                p.goglat,
                p.goglong,
                z.nombre_ubicacion,
                t.tipo_prop,
                st.sup_total,
                sca.cantidad_ambientes,
                mon.moneda,
                val.valor,
                cco.cantidad_cocheras,
                webindex.fichaweb,
                caa.cantidad_antiguedad,
                IF(mon.moneda = "U$S", val.valor * 14, val.valor) AS valor_convertido, caa.cantidad_antiguedad,
                IF(sca.cantidad_ambientes is null, 0, sca.cantidad_ambientes) AS cantidad_ambientes,
                e.nombre AS nombre_emprendimiento,
                IF(fo.foto_principal IS NOT null, CONCAT("' . $this->publicURL . '", fo.foto_principal), "") AS foto_url
          FROM propiedad AS p
          INNER JOIN ubicacionpropiedad AS z ON p.id_ubica = z.id_ubica
          INNER JOIN tipoprop AS t ON p.id_tipo_prop = t.id_tipo_prop
          LEFT JOIN (select id_prop, foto as foto_principal from fotos where posicion = 1) as fo on p.id_prop = fo.id_prop
          LEFT JOIN emprendimiento AS e ON p.id_emp = e.id_emp
          LEFT JOIN
              (SELECT id_prop, contenido AS sup_total FROM propiedad_caracteristicas WHERE id_carac = 198) AS st
                ON p.id_prop=st.id_prop
          LEFT JOIN
            (SELECT id_prop, contenido AS fichaweb FROM propiedad_caracteristicas WHERE id_carac = 257) AS webindex
                ON p.id_prop=webindex.id_prop
          LEFT JOIN
            (SELECT id_prop, contenido AS cantidad_ambientes FROM propiedad_caracteristicas WHERE id_carac = 208) AS sca
                ON p.id_prop=sca.id_prop
          LEFT JOIN
            (SELECT id_prop, contenido AS cantidad_cocheras FROM propiedad_caracteristicas WHERE id_carac = 373) AS cco
                ON p.id_prop=cco.id_prop
          LEFT JOIN
            (SELECT id_prop, contenido AS cantidad_antiguedad FROM propiedad_caracteristicas WHERE id_carac = 374) AS caa
                ON p.id_prop=caa.id_prop
       
          ' . $moneyType . '
          WHERE p.id_ubica = ' . $element->idZona . '
              AND p.tipo_oper_id = "' . $params['operacion'] . '"
              AND p.id_tipo_prop = ' . $params['tipo'] . '
              AND cco.cantidad_cocheras ' . $searchValues['coch'] . '
              AND caa.cantidad_antiguedad ' . $searchValues['ant'] . '
              AND st.sup_total BETWEEN ' . $searchValues['supMin'] . ' AND ' . $searchValues['supMax'] . '
              AND mon.moneda IN ("' . $searchValues['moneda'][0] . '", "' . $searchValues['moneda'][1] . '")
              AND p.tiene_emprendimiento  = ' . $searchValues['emp'] . '
          HAVING valor_convertido BETWEEN ' . $searchValues['valMin'] . ' AND ' . $searchValues['valMax'];
    }

    public function getSimilar($id, $ubica)
    {
        $prop  = $this->byIdProps($id, $ubica)->first();

        if (is_null($prop->sup_total)) {
            $prop->sup_total = 1000;
        }

        $prop->sup_total = (int)$prop->sup_total;

        $idZona = $prop->id_ubica;


        $query = $this->similarQuery($idZona, $prop);

        $result = Propiedad::hydrateRaw($query);


        if ($result->count() < 3) {
            $idZona = UbicacionPropiedad::find($idZona)->id_padre;

            $query = $this->similarQuery($idZona, $prop);

            $result = Propiedad::hydrateRaw($query);
        }

        $result->map(function($element) use ($ubica) {
            $element->ubica = $ubica->getById($element->id_ubica);
        });

        return $result;
    }

    /**
     * @param $idZona
     * @param $prop
     * @return string
     */
    public function similarQuery($idZona, $prop)
    {
        return '
          SELECT p.id_prop,
                p.id_ubica,
                p.calle,
                p.nro,
                p.id_tipo_prop,
                monv.moneda_venta,
                mona.moneda_alq,
                valv.valor_venta,
                vala.valor_alq,
                p.subtipo_prop,
                p.tipo_oper_id,
                p.activa,
                p.id_sucursal,
                p.id_emp,
                p.compartir,
                p.goglat,
                p.goglong,
                z.nombre_ubicacion,
                t.tipo_prop,
                st.sup_total,
                sca.cantidad_ambientes,              
                cco.cantidad_cocheras,
                webindex.fichaweb,
                caa.cantidad_antiguedad,
                IF(sca.cantidad_ambientes is null, 0, sca.cantidad_ambientes) AS cantidad_ambientes,
                e.nombre AS nombre_emprendimiento,
                IF(fo.foto_principal IS NOT null, CONCAT("' . $this->publicURL . '", fo.foto_principal), "") AS foto_url
          FROM propiedad AS p
          INNER JOIN ubicacionpropiedad AS z ON p.id_ubica = z.id_ubica
          INNER JOIN tipoprop AS t ON p.id_tipo_prop = t.id_tipo_prop
          LEFT JOIN (select id_prop, foto as foto_principal from fotos where posicion = 1) as fo on p.id_prop = fo.id_prop
          LEFT JOIN emprendimiento AS e ON p.id_emp = e.id_emp
          LEFT JOIN
              (SELECT id_prop, contenido AS sup_total FROM propiedad_caracteristicas WHERE id_carac = 198) AS st
                ON p.id_prop=st.id_prop
          LEFT JOIN
            (SELECT id_prop, contenido AS fichaweb FROM propiedad_caracteristicas WHERE id_carac = 257) AS webindex
                ON p.id_prop=webindex.id_prop
          LEFT JOIN
            (SELECT id_prop, contenido AS cantidad_ambientes FROM propiedad_caracteristicas WHERE id_carac = 208) AS sca
                ON p.id_prop=sca.id_prop
          LEFT JOIN
            (SELECT id_prop, contenido AS cantidad_cocheras FROM propiedad_caracteristicas WHERE id_carac = 373) AS cco
                ON p.id_prop=cco.id_prop
          LEFT JOIN
            (SELECT id_prop, contenido AS cantidad_antiguedad FROM propiedad_caracteristicas WHERE id_carac = 374) AS caa
                ON p.id_prop=caa.id_prop 
              LEFT JOIN
		(SELECT id_prop, contenido AS moneda_venta FROM propiedad_caracteristicas WHERE id_carac=165) AS monv
		    ON p.id_prop=monv.id_prop
		LEFT JOIN
		(SELECT id_prop, contenido AS valor_venta FROM propiedad_caracteristicas WHERE id_carac=161) AS valv
		    ON p.id_prop=valv.id_prop
          
        LEFT JOIN
		(SELECT id_prop, contenido AS moneda_alq FROM propiedad_caracteristicas WHERE id_carac=166) AS mona
            ON p.id_prop=mona.id_prop
		LEFT JOIN
        (SELECT id_prop, contenido AS valor_alq FROM propiedad_caracteristicas WHERE id_carac=164) AS vala
            ON p.id_prop=vala.id_prop
         
          WHERE p.id_ubica = ' . $idZona . '
              AND p.id_prop != ' . $prop->id_prop . '
              AND p.tipo_oper_id = ' . $prop->tipo_oper_id . '
              AND p.id_tipo_prop = ' . $prop->id_tipo_prop . '
              AND cco.cantidad_cocheras = ' . $prop->cantidad_cocheras . '
              AND caa.cantidad_antiguedad = ' . $prop->cantidad_antiguedad . '
              AND st.sup_total BETWEEN 0 AND ' . $prop->sup_total . ' LIMIT 9';
    }
}
