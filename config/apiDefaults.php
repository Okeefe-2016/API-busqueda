<?php


/**
 * Valores por defecto de las consultas, si se cambia el
 * nombre del key de cualquier valor se debe cambiar el mismo
 * en la query de \App\Repositories\PropiedadRepository
 */
return [
    
    'valMin' => 0,

    'valMax' => 100000000000,

    'supMin' => 0,

    'supMax' => 1000000000000,

    // Valores con opciones
    'moneda' => [
        'options' => ['U$S', '$']
    ],

    // Los valores que tienen true se reflejan como < 100 en el query y la consulta especifica como,
    // nombre==valor

    'banos' => true,

    'amb' => true,

    'coch' => true,

    'ant' => true,

    'emp' => 0,

    'rural' => false,

    'filtroMon' => 'ARS'
];