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
        $tipo = explode(',', $tipo);
        $ubications = UbicacionPropiedad::where('id_padre', '>', 0)
            ->where(function ($query) use ($request, $operacion, $tipo) {
                $query->whereHas('childUbication', function ($q) {
                })->orWhereHas('propertiesCount', function ($q) use ($request, $operacion, $tipo) {
                    $q->where('activa', 1)
                        ->where('tipo_oper_id', $operacion)
                        ->whereIn('id_tipo_prop', $tipo);
                });
            })->where('nombre_ubicacion', 'like', '%' . $zona . '%')
            ->with(['childUbication' => function ($query) use ($request, $operacion, $tipo) {
                $query->whereHas('childUbication', function ($q) {
                })->orWhereHas('propertiesCount', function ($q) use ($request, $operacion, $tipo) {
                    $q->where('activa', 1)
                        ->where('tipo_oper_id', $operacion)
                        ->whereIn('id_tipo_prop', $tipo);
                })->with(['childUbication' => function ($query) use ($request, $operacion, $tipo) {
                    $query->whereHas('childUbication', function ($q) {
                    })->orWhereHas('propertiesCount', function ($q) use ($request, $operacion, $tipo) {
                        $q->where('activa', 1)
                            ->where('tipo_oper_id', $operacion)
                            ->whereIn('id_tipo_prop', $tipo);
                    })->with(['childUbication' => function ($query) use ($request, $operacion, $tipo) {
                        $query->whereHas('childUbication', function ($q) {
                        })->orWhereHas('propertiesCount', function ($q) use ($request, $operacion, $tipo) {
                            $q->where('activa', 1)
                                ->where('tipo_oper_id', $operacion)
                                ->whereIn('id_tipo_prop', $tipo);
                        })->with(['childUbication', 'propertiesCount' => function ($query) use ($request, $operacion, $tipo) {
                            $query->where('activa', 1)
                                ->where('tipo_oper_id', $operacion)
                                ->whereIn('id_tipo_prop', $tipo);
                            if (!$request->rural && $request->emp != 0) {
                                $query->where('id_emp','!=',0);
                            }
                            $query->get();
                        }]);
                    }, 'propertiesCount' => function ($query) use ($request, $operacion, $tipo) {
                        $query->where('activa', 1)
                            ->where('tipo_oper_id', $operacion)
                            ->whereIn('id_tipo_prop', $tipo);
                        if (!$request->rural && $request->emp != 0) {
                            $query->where('id_emp','!=',0);
                        }
                        $query->get();

                    }]);
                }, 'propertiesCount' => function ($query) use ($request, $operacion, $tipo) {
                    $query->where('activa', 1)
                        ->where('tipo_oper_id', $operacion)
                        ->whereIn('id_tipo_prop', $tipo);
                    if (!$request->rural && $request->emp != 0) {
                        $query->where('id_emp','!=',0);
                    }
                    $query->get();

                }]);
            }, 'propertiesCount' => function ($query) use ($request, $operacion, $tipo) {
                $query->where('activa', 1)
                    ->where('tipo_oper_id', $operacion)
                    ->whereIn('id_tipo_prop', $tipo);
                if (!$request->rural && $request->emp != 0) {
                    $query->where('id_emp','!=',0);
                }
                $query->get();
            }])->get();
        foreach ($ubications as $key => $ubic) {
            $ubic->total = 0;
            if ($ubic->propertiesCount && $ubic->propertiesCount['count']) {
                $ubic->total += $ubic->propertiesCount['count'];
            }
            if (is_object($ubic->childUbication)) {
                $ubic->total += $this->recursiveUbications($ubic->childUbication);
            }
            unset($ubic->childUbication);
            unset($ubic->propertiesCount);
        }
        foreach ($ubications as $ubic) {
            // if you want to add new fields to the fields that are already appended
            $ubic->append('nombre_completo');
        }
        return $ubications;
    }

    protected function recursiveUbications($ubications, $count = 0, $level = 1)
    {
        foreach ($ubications as $value) {
            if ($value->propertiesCount) {
                $count += $value->propertiesCount['count'];
            }
            if (is_array($value->childUbication) || is_object($value->childUbication)) {
                $count += $this->recursiveUbications($value->childUbication, 0, $level + 1);
            } else {
                return $count;
            }
        }
        return $count;
    }
}