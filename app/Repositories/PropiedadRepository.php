<?php

namespace App\Repositories;

use App\Models\Propiedad;
use App\Models\UbicacionPropiedad;
use App\Services\CotizationService;
use Illuminate\Http\Response;
use InfyOm\Generator\Common\BaseRepository;
use Illuminate\Container\Container AS Application;
use Mockery\CountValidator\Exception;

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

    public function __construct(Application $app, CotizationService $cotizationService)
    {
        parent::__construct($app);

        $this->publicURL = env('PUBLIC_URL');
        $this->cotizationService = $cotizationService;
    }

    /**
     * @param $id
     */
    public function getWithUbication($ubica, $id) {

        $propiedad = Propiedad::with(['propiedad_caracteristicas' => function($q) {
            $q->select('id_prop_carac', 'id_prop', 'id_carac', 'contenido');
        }, 'propiedad_caracteristicas.caracteristica' => function($q) {
            $q->select( 'id_carac', 'id_tipo_carac', 'titulo');
        }])->find($id);

        $propiedad->ubica = $ubica->getById($propiedad->id_ubica);
    }

    /**
     * @param UbicacionPropiedad $ubica
     * @param $ids
     */
    public function getManyWithUbica($ids, $ubica) {

        $propiedad = Propiedad::with(['propiedad_caracteristicas' => function($q) {
            $q->select('id_prop_carac', 'id_prop', 'id_carac', 'contenido');
        }, 'propiedad_caracteristicas.caracteristica' => function($q) {
            $q->select( 'id_carac', 'id_tipo_carac', 'titulo');
        }])->find($ids);

        $propiedad->map(function($value) use ($ubica) {
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
    public function byPropertiesSpec($element, $searchValues)
    {

            if ($searchValues['rural'] === false) {
                $query = $this->getPropiedadQuery($element, $searchValues);
            } else {
                $query = $this->getPropiedadByRuralQuery($element, $searchValues);
            }

            $result = $this->model->hydrateRaw($query);

            return $result;
    }


    /**
     * Pick the value of money from type of operation
     *
     * @param $values
     * @return string
     */
    private function getMoneyType($values) {

        $moneyType = " ";

        if ($values['operacion'] == 12) {
            $moneyType = "
                  LEFT JOIN
				    (SELECT id_prop, contenido AS moneda FROM propiedad_caracteristicas WHERE id_carac=165) AS mon 
				        ON p.id_prop=mon.id_prop
				  LEFT JOIN
				    (SELECT id_prop, contenido AS valor FROM propiedad_caracteristicas WHERE id_carac=161) AS val 
				        ON p.id_prop=val.id_prop";
        } else if ($values['operacion'] == 2 || $values['operacion'] == 4) {
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
    private function getPropiedadQuery($element, $searchValues)
    {
        $moneyType = $this->getMoneyType($searchValues);
        $nameFilter = $searchValues['filtroMon'] == 'ARS' ? 'valor_convertido' : 'valor';

        return'
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
                val.valor, 
                IF(mon.moneda = "U$S", val.valor * 14, val.valor) AS valor_convertido, 
                caa.cantidad_antiguedad,
                IF(sca.cantidad_ambientes is null, 1, sca.cantidad_ambientes) AS cantidad_ambientes,
                e.nombre AS nombre_emprendimiento,
                IF(fo.foto_principal IS NOT null, CONCAT("'. $this->publicURL .'", fo.foto_principal), "") AS foto_url
          FROM propiedad AS p
          INNER JOIN ubicacionpropiedad AS z ON p.id_ubica = z.id_ubica 
          INNER JOIN tipoprop AS t ON p.id_tipo_prop = t.id_tipo_prop
          LEFT JOIN (select id_prop, foto as foto_principal from fotos where posicion = 1) as fo on p.id_prop = fo.id_prop
          LEFT JOIN emprendimiento AS e ON p.id_emp = e.id_emp
          LEFT JOIN 
              (SELECT id_prop, contenido AS sup_total FROM propiedad_caracteristicas WHERE id_carac = 198) AS st 
                ON p.id_prop=st.id_prop
          LEFT JOIN 
            (SELECT id_prop, contenido AS cantidad_ambientes FROM propiedad_caracteristicas WHERE id_carac = 208) AS sca 
                ON p.id_prop=sca.id_prop
          LEFT JOIN 
            (SELECT id_prop, contenido AS cantidad_banos FROM propiedad_caracteristicas WHERE id_carac = 71) AS sba 
                ON p.id_prop=sba.id_prop
          LEFT JOIN 
            (SELECT id_prop, contenido AS cantidad_cocheras FROM propiedad_caracteristicas WHERE id_carac = 373) AS cco 
                ON p.id_prop=cco.id_prop
          LEFT JOIN 
            (SELECT id_prop, contenido AS cantidad_antiguedad FROM propiedad_caracteristicas WHERE id_carac = 374) AS caa 
                ON p.id_prop=caa.id_prop
          ' . $moneyType . '
          WHERE p.id_ubica = ' . $element->idZona . ' 
              AND p.tipo_oper_id = "' . $searchValues['operacion'] . '"
              AND  p.id_tipo_prop IN (' . $searchValues['tipo'] .')
              AND cco.cantidad_cocheras '. $searchValues['coch'] .'
              AND caa.cantidad_antiguedad '. $searchValues['ant'] .'
              AND st.sup_total BETWEEN '. $searchValues['supMin'] .' AND '. $searchValues['supMax'] .' 
              AND mon.moneda IN ("'. $searchValues['moneda'][0] .'", "'. $searchValues['moneda'][1] .'")
              AND sba.cantidad_banos ' . $searchValues['banos'] .'
              AND p.tiene_emprendimiento  = '. $searchValues['emp'] .'
          HAVING '. $nameFilter .' BETWEEN '. $searchValues['valMin'] . ' AND '. $searchValues['valMax']  . ' 
              AND cantidad_ambientes '. $searchValues['amb'];


    }

    /**
     * Build rural query
     *
     * @param $element
     * @param $searchValues
     * @return bool
     */
    private function getPropiedadByRuralQuery($element, $searchValues)
    {
        $moneyType = $this->getMoneyType($searchValues);

        return'
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
                caa.cantidad_antiguedad,
                IF(mon.moneda = "U$S", val.valor * 14, val.valor) AS valor_convertido, caa.cantidad_antiguedad,
                IF(sca.cantidad_ambientes is null, 0, sca.cantidad_ambientes) AS cantidad_ambientes,
                e.nombre AS nombre_emprendimiento,
                IF(fo.foto_principal IS NOT null, CONCAT("'. $this->publicURL .'", fo.foto_principal), "") AS foto_url
          FROM propiedad AS p
          INNER JOIN ubicacionpropiedad AS z ON p.id_ubica = z.id_ubica 
          INNER JOIN tipoprop AS t ON p.id_tipo_prop = t.id_tipo_prop 
          LEFT JOIN (select id_prop, foto as foto_principal from fotos where posicion = 1) as fo on p.id_prop = fo.id_prop
          LEFT JOIN emprendimiento AS e ON p.id_emp = e.id_emp
          LEFT JOIN 
              (SELECT id_prop, contenido AS sup_total FROM propiedad_caracteristicas WHERE id_carac = 198) AS st 
                ON p.id_prop=st.id_prop
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
              AND p.tipo_oper_id = "' . $searchValues['operacion'] . '"
              AND p.id_tipo_prop = ' . $searchValues['tipo'] .'
              AND cco.cantidad_cocheras '. $searchValues['coch'] .'
              AND caa.cantidad_antiguedad '. $searchValues['ant'] .'
              AND st.sup_total BETWEEN '. $searchValues['supMin'] .' AND '. $searchValues['supMax'] .' 
              AND mon.moneda IN ("'. $searchValues['moneda'][0] .'", "'. $searchValues['moneda'][1] .'")
              AND p.tiene_emprendimiento  = '. $searchValues['emp'] .'
          HAVING valor_convertido BETWEEN '. $searchValues['valMin'] . ' AND '. $searchValues['valMax'];
    }
}
