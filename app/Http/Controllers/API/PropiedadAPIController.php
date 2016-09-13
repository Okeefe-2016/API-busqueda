<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatePropiedadesAPIRequest;
use App\Http\Requests\API\UpdatePropiedadesAPIRequest;
use App\Models\Propiedades;
use App\Models\UbicacionPropiedad;
use App\Repositories\PropiedadRepository;
use App\Repositories\UbicacionPropiedadRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use InfyOm\Generator\Utils\ResponseUtil;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Symfony\Component\Console\Input\Input;

/**
 * Class PropiedadController
 * @package App\Http\Controllers\API
 */

class PropiedadAPIController extends AppBaseController
{
    /** @var  PropiedadesRepository */
    private $propiedadesRepository;

    public function __construct(PropiedadRepository $propiedadesRepo)
    {
        $this->propiedadesRepository = $propiedadesRepo;
    }

    public function byIds(Request $request)
    {
        $lists = $request->all();

        if (isset($lists['lists'])) {
            $prop = $this->propiedadesRepository->byIdProps($lists['lists']);

            return response()->json($prop);
            
        } else {
            return response()->json([]);
        }
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/propiedades",
     *      summary="Get a listing of the Propiedades.",
     *      tags={"Propiedades"},
     *      description="Get all Propiedades",
     *      produces={"application/json"},
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="array",
     *                  @SWG\Items(ref="#/definitions/Propiedades")
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function index(Request $request)
    {
        $this->propiedadesRepository->pushCriteria(new RequestCriteria($request));
        $this->propiedadesRepository->pushCriteria(new LimitOffsetCriteria($request));
        $propiedades = $this->propiedadesRepository->all();

        return $this->sendResponse($propiedades->toArray(), 'Propiedades retrieved successfully');
    }

    /**
     * @param CreatePropiedadesAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/propiedades",
     *      summary="Store a newly created Propiedades in storage",
     *      tags={"Propiedades"},
     *      description="Store Propiedades",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Propiedades that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Propiedades")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/Propiedades"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreatePropiedadesAPIRequest $request)
    {
        $input = $request->all();

        $propiedades = $this->propiedadesRepository->create($input);

        return $this->sendResponse($propiedades->toArray(), 'Propiedades saved successfully');
    }

    /**
     * @param int $id
     * @param UbicacionPropiedad $ubica
     * @return Response
     * @SWG\Get(
     *      path="/propiedades/{id}",
     *      summary="Display the specified Propiedades",
     *      tags={"Propiedades"},
     *      description="Get Propiedades",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Propiedades",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/Propiedades"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function show($id, UbicacionPropiedadRepository $ubica)
    {
        $propiedad = $this->propiedadesRepository->getWithUbication($ubica, $id);

        return response()->json(['message' => 'success', 'code' => '200', 'data' => $propiedad]);
    }

    /**
     * @param int $id
     * @param UpdatePropiedadesAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/propiedades/{id}",
     *      summary="Update the specified Propiedades in storage",
     *      tags={"Propiedades"},
     *      description="Update Propiedades",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Propiedades",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Propiedades that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Propiedades")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/Propiedades"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdatePropiedadesAPIRequest $request)
    {
        $input = $request->all();

        /** @var Propiedades $propiedades */
        $propiedades = $this->propiedadesRepository->find($id);

        if (empty($propiedades)) {
            return Response::json(ResponseUtil::makeError('Propiedades not found'), 400);
        }

        $propiedades = $this->propiedadesRepository->update($input, $id);

        return $this->sendResponse($propiedades->toArray(), 'Propiedades updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/propiedades/{id}",
     *      summary="Remove the specified Propiedades from storage",
     *      tags={"Propiedades"},
     *      description="Delete Propiedades",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Propiedades",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="string"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function destroy($id)
    {
        /** @var Propiedades $propiedades */
        $propiedades = $this->propiedadesRepository->find($id);

        if (empty($propiedades)) {
            return Response::json(ResponseUtil::makeError('Propiedades not found'), 400);
        }

        $propiedades->delete();

        return $this->sendResponse($id, 'Propiedades deleted successfully');
    }
}
