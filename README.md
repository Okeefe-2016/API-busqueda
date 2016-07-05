# Okeefe API Buscador

## Pasos para deploy

###Clonar el repo

`$ git clone https://github.com/Lyncros/okeefe.git`

`$ cd okeefe`

`$ git checkout develop`

`$ composer install`

Configurar .env con los datos locales

## Base de datos

La base de datos original fue indexada en varias tablas para mejorar el rendimiento de la busqueda,
por favor descargar consultas y ejecutar: (Ejecutar en orden)

http://pastebin.com/KsQTnTcw

**Script PHP Para cocheras default 0 en todas las propiedades**
http://pastebin.com/GLQ19bva

**Script PHP Para antiguedad default 0 en todas las propiedades**
http://pastebin.com/2t5maHyt

# Api Docs

## Busqueda de inmuebles segun tipo, operacion, ubicacion

- Los valores por defectos son Casa en Venta

***Busqueda de todos los departamentos en venta.***

`/api/v1/propiedad?operacion=12&tipo=9`

***Busqueda de departamentos en venta en Wilde***

`/api/v1/propiedad?q=Wilde&operacion=12&tipo=9`

**Tipos de operacion (IDs)**

- Alquiler -> 2
- Alquiler temporario -> 4
- Venta -> 12

- Por default inversión (emprendimiento) no se muestran para que esten disponibles
se debe usar la llamada:

`/api/v1/propiedad?q=quilmes&emp=1&tipo=9&operacion=12`

## Busqueda de recidencial

* Tipos de busquedas recidenciales (IDs)

- Casas -> 9
- Departamentos y PH -> 1
- Lotes -> 7
- Quintas -> 17

***Rango de valor del inmueble***

`/api/v1/propiedad?valMin=0&valMax=100000`

***Rango Superficie (m2)***

`/api/v1/propiedad?supMin=0&supMax=100`

***Cantidad de ambientes***

`/api/v1/propiedad?amb==5`

***Cantidad de cocheras***

`/api/v1/propiedad?coch==5`

***Antiguedad***

`/api/v1/propiedad?ant==5`

***Tipo de moneda (Default U$D y $)***

*Busqueda disponible para pesos argentinos y dolares americanos*

`/api/v1/propiedad?moneda=$`

***Cantidad de baños***

`/api/v1/propiedad?banos==2`

## Busqueda de comercial/industrial

* Tipos de busquedas comerciales/industriales (IDs)

- Lotes -> 7
- Industrial -> 19
- Locales -> 2
- Oficinas -> 11
- Galpones -> 15
- Cocheras -> 18

`/api/v1/propiedad?tipo=11`

***Rango de valor del inmueble***

`/api/v1/propiedad?valMin=0&valMax=100000`

***Cantidad de baños***

`/api/v1/propiedad?tipo=11&banos==2`

***Cantidad de ambientes***

`/api/v1/propiedad?tipo=11&amb==1`

***Cantidad de cocheras***

`/api/v1/propiedad?tipo=11&coch==1`

***Antiguedad***

`/api/v1/propiedad?tipo=11&ant==1`

***Rango Superficie (m2)***

`/api/v1/propiedad?tipo=11&supMin=0&supMax=100`

*Busqueda disponible para pesos argentinos y dolares americanos*

`/api/v1/propiedad?moneda=$`

## Busqueda rural

* Tipos de busquedas rural (IDs)

- Lotes -> 7,
- Quintas -> 17,
- Estancias -> 22,
- Chacras -> 16,
- Campos -> 6,
- Galpones' -> 15

EJ: `/api/v1/propiedad?tipo=6&operacion=12&rural=true`

`/api/v1/propiedad?tipo=7&rural=true`

***Cantidad de cocheras***

`/api/v1/propiedad?tipo=11&coch==1&rural=true`

***Antiguedad***

`/api/v1/propiedad?tipo=11&ant==1&rural=true`

***Rango Superficie (h)***

`/api/v1/propiedad?tipo=11&supMin=0&supMax=100&rural=true`

***Rango de valor del inmueble***

`/api/v1/propiedad?valMin=0&valMax=100000&rural=true`

*Busqueda disponible para pesos argentinos y dolares americanos*

`/api/v1/propiedad?moneda=$&rural=true`

##Filtros Especiales

**Moneda**

Si la moneda de la propiedad es USD (Dolares americanos) se podra buscar por su
conversión en pesos. La converción es dinamica al valor del dia segun BCRA.

`/api/v1/propiedad&filtroMon=ARS`  (Valor por defecto)

`/api/v1/propiedad&filtroMon=USD` (Filtro segun su moneda)

## Busqueda de propiedades
Esta disponible la busqueda individual de propiedades con sus caracteristicas
`api/v1/propiedades/{id_prop}`




