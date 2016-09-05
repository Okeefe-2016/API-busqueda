# Okeefe API Buscador

## Pasos para deploy

###Clonar el repo

`$ git clone https://github.com/Okeefe-2016/API-busqueda.git`

`$ cd okeefe`

`$ composer install`

Configurar .env con los datos locales

## Base de datos

La base de datos original fue indexada en varias tablas para mejorar el rendimiento de la busqueda,
por favor descargar consultas y ejecutar: (Ejecutar en orden)

http://pastebin.com/cEYki0T0

**Script PHP Para cocheras default 0 en todas las propiedades**
http://pastebin.com/GLQ19bva

**Script PHP Para antiguedad default 0 en todas las propiedades**
http://pastebin.com/2t5maHyt

# Api Docs

## Busqueda de propiedades por zona

- Tipo = Integer
- Operacion = Integer

`/api/v1/propiedades/{ubicacion}/{tipo}/{operacion}/?emp={bool}?rural={bool}`

- Esta busqueda entregara un array donde se sacara la el id de la ubicacion

## Busqueda de inmuebles segun tipo, operacion, ubicacion

- Los valores por defectos son Casa en Venta

***Busqueda de todos los departamentos en venta.***

`/api/v1/propiedades/{tipo}/{operacion}/?ubicacion=id`

***Busqueda de departamentos en venta en una ubicacion***

`/api/v1/propiedades/{tipo/s}/{operacion}/?ubicacion=id`

**Es posible consultar mas de un tipo de propiedad**

`/api/v1/propiedades/9,2/{operacion}/?ubicacion=id`

**Tipos de operacion (IDs)**

- Alquiler -> 2
- Alquiler temporario -> 4
- Venta -> 12


## Busqueda de recidencial

* Tipos de busquedas recidenciales (IDs)

- Casas -> 9
- Departamentos y PH -> 1
- Lotes -> 7
- Quintas -> 17

***Rango de valor del inmueble***

`/api/v1/propiedades/{tipo/s}/{operacion}/?ubicacion=id&valMin=0&valMax=100000`

***Rango Superficie (m2)***

`/api/v1/propiedades/{tipo/s}/{operacion}/?ubicacion=id&supMin=0&supMax=100`

***Cantidad de ambientes***

`/api/v1/propiedades/{tipo/s}/{operacion}/?ubicacion=id&amb==5`

***Cantidad de cocheras***

`/api/v1/propiedades/{tipo/s}/{operacion}/?ubicacion=id&coch==5`

***Antiguedad***

`/api/v1/propiedades/{tipo/s}/{operacion}/?ubicacion=id&ant==5`

***Tipo de moneda (Default U$D y $)***

*Busqueda disponible para pesos argentinos y dolares americanos*

`/api/v1/propiedades/{tipo/s}/{operacion}/?ubicacion=id&moneda=$`

***Cantidad de baños***

`/api/v1/propiedades/{tipo/s}/{operacion}/?ubicacion=id&banos==2`

## Busqueda de comercial/industrial

* Tipos de busquedas comerciales/industriales (IDs)

- Lotes -> 7
- Industrial -> 19
- Locales -> 2
- Oficinas -> 11
- Galpones -> 15
- Cocheras -> 18

`/api/v1/propiedades/{tipo/s}/{operacion}/?ubicacion=id&tipo=11`

***Rango de valor del inmueble***

`/api/v1/propiedades/{tipo/s}/{operacion}/?ubicacion=id&valMin=0&valMax=100000`

***Cantidad de baños***

`/api/v1/propiedades/{tipo/s}/{operacion}/?ubicacion=id&tipo=11&banos==2`

***Cantidad de ambientes***

`/api/v1/propiedades/{tipo/s}/{operacion}/?ubicacion=id&tipo=11&amb==1`

***Cantidad de cocheras***

`/api/v1/propiedades/{tipo/s}/{operacion}/?ubicacion=id&tipo=11&coch==1`

***Antiguedad***

`/api/v1/propiedades/{tipo/s}/{operacion}/?ubicacion=id&tipo=11&ant==1`

***Rango Superficie (m2)***

`/api/v1/propiedades/{tipo/s}/{operacion}/?ubicacion=id&&supMin=0&supMax=100`

*Busqueda disponible para pesos argentinos y dolares americanos*

`/api/v1/propiedades/{tipo/s}/{operacion}/?ubicacion=id&moneda=$`

## Busqueda rural

* Tipos de busquedas rural (IDs)

- Lotes -> 7,
- Quintas -> 17,
- Estancias -> 22,
- Chacras -> 16,
- Campos -> 6,
- Galpones' -> 15

EJ: `/api/v1/propiedades/{tipo/s}/{operacion}/?ubicacion=id&rural=true`

`/api/v1/propiedades/{tipo/s}/{operacion}/?ubicacion=id&&rural=true`

***Cantidad de cocheras***

`/api/v1/propiedades/{tipo/s}/{operacion}/?ubicacion=id&coch==1&rural=true`

***Antiguedad***

`/api/v1/propiedades/{tipo/s}/{operacion}/?ubicacion=id&&ant==1&rural=true`

***Rango Superficie (h)***

`/api/v1/propiedades/{tipo/s}/{operacion}/?ubicacion=id&supMin=0&supMax=100&rural=true`

***Rango de valor del inmueble***

`/api/v1/propiedades/{tipo/s}/{operacion}/?ubicacion=id&valMin=0&valMax=100000&rural=true`

*Busqueda disponible para pesos argentinos y dolares americanos*

`/api/v1/propiedades/{tipo/s}/{operacion}/?ubicacion=id&moneda=$&rural=true`

##Filtros Especiales

**Moneda**

Si la moneda de la propiedad es USD (Dolares americanos) se podra buscar por su
conversión en pesos. La converción es dinamica al valor del dia segun BCRA.

`/api/v1/propiedades/{tipo/s}/{operacion}/?ubicacion=id&filtroMon=ARS`  (Valor por defecto)

`/api/v1/propiedades/{tipo/s}/{operacion}/?ubicacion=id&filtroMon=USD` (Filtro segun su moneda)

## Busqueda de propiedades
Esta disponible la busqueda individual de propiedades con sus caracteristicas
`/api/v1/propiedad/{id_prop}`




