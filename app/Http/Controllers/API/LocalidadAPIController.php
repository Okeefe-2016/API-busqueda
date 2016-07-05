<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateLocalidadAPIRequest;
use App\Http\Requests\API\UpdateLocalidadAPIRequest;
use App\Models\Localidad;
use App\Repositories\LocalidadRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use InfyOm\Generator\Utils\ResponseUtil;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class LocalidadController
 * @package App\Http\Controllers\API
 */

class LocalidadAPIController extends AppBaseController
{
    /** @var  LocalidadRepository */
    private $localidadRepository;

    public function __construct(LocalidadRepository $localidadRepo)
    {
        $this->localidadRepository = $localidadRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/localidads",
     *      summary="Get a listing of the Localidads.",
     *      tags={"Localidad"},
     *      description="Get all Localidads",
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
     *                  @SWG\Items(ref="#/definitions/Localidad")
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
        $this->localidadRepository->pushCriteria(new RequestCriteria($request));
        $this->localidadRepository->pushCriteria(new LimitOffsetCriteria($request));
        $localidads = $this->localidadRepository->all();

        return $this->sendResponse($localidads->toArray(), 'Localidads retrieved successfully');
    }

    /**
     * @param CreateLocalidadAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/localidads",
     *      summary="Store a newly created Localidad in storage",
     *      tags={"Localidad"},
     *      description="Store Localidad",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Localidad that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Localidad")
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
     *                  ref="#/definitions/Localidad"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateLocalidadAPIRequest $request)
    {
        $input = $request->all();

        $localidads = $this->localidadRepository->create($input);

        return $this->sendResponse($localidads->toArray(), 'Localidad saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/localidads/{id}",
     *      summary="Display the specified Localidad",
     *      tags={"Localidad"},
     *      description="Get Localidad",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Localidad",
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
     *                  ref="#/definitions/Localidad"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function show($id)
    {
        /** @var Localidad $localidad */
        $localidad = $this->localidadRepository->find($id);

        if (empty($localidad)) {
            return Response::json(ResponseUtil::makeError('Localidad not found'), 400);
        }

        return $this->sendResponse($localidad->toArray(), 'Localidad retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateLocalidadAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/localidads/{id}",
     *      summary="Update the specified Localidad in storage",
     *      tags={"Localidad"},
     *      description="Update Localidad",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Localidad",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Localidad that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Localidad")
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
     *                  ref="#/definitions/Localidad"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateLocalidadAPIRequest $request)
    {
        $input = $request->all();

        /** @var Localidad $localidad */
        $localidad = $this->localidadRepository->find($id);

        if (empty($localidad)) {
            return Response::json(ResponseUtil::makeError('Localidad not found'), 400);
        }

        $localidad = $this->localidadRepository->update($input, $id);

        return $this->sendResponse($localidad->toArray(), 'Localidad updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/localidads/{id}",
     *      summary="Remove the specified Localidad from storage",
     *      tags={"Localidad"},
     *      description="Delete Localidad",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Localidad",
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
        /** @var Localidad $localidad */
        $localidad = $this->localidadRepository->find($id);

        if (empty($localidad)) {
            return Response::json(ResponseUtil::makeError('Localidad not found'), 400);
        }

        $localidad->delete();

        return $this->sendResponse($id, 'Localidad deleted successfully');
    }
}
