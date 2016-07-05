<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCaracteristicaAPIRequest;
use App\Http\Requests\API\UpdateCaracteristicaAPIRequest;
use App\Models\Caracteristica;
use App\Repositories\CaracteristicaRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use InfyOm\Generator\Utils\ResponseUtil;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class CaracteristicaController
 * @package App\Http\Controllers\API
 */

class CaracteristicaAPIController extends AppBaseController
{
    /** @var  CaracteristicaRepository */
    private $caracteristicaRepository;

    public function __construct(CaracteristicaRepository $caracteristicaRepo)
    {
        $this->caracteristicaRepository = $caracteristicaRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/caracteristicas",
     *      summary="Get a listing of the Caracteristicas.",
     *      tags={"Caracteristica"},
     *      description="Get all Caracteristicas",
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
     *                  @SWG\Items(ref="#/definitions/Caracteristica")
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
        $this->caracteristicaRepository->pushCriteria(new RequestCriteria($request));
        $this->caracteristicaRepository->pushCriteria(new LimitOffsetCriteria($request));
        $caracteristicas = $this->caracteristicaRepository->all();

        return $this->sendResponse($caracteristicas->toArray(), 'Caracteristicas retrieved successfully');
    }

    /**
     * @param CreateCaracteristicaAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/caracteristicas",
     *      summary="Store a newly created Caracteristica in storage",
     *      tags={"Caracteristica"},
     *      description="Store Caracteristica",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Caracteristica that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Caracteristica")
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
     *                  ref="#/definitions/Caracteristica"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateCaracteristicaAPIRequest $request)
    {
        $input = $request->all();

        $caracteristicas = $this->caracteristicaRepository->create($input);

        return $this->sendResponse($caracteristicas->toArray(), 'Caracteristica saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/caracteristicas/{id}",
     *      summary="Display the specified Caracteristica",
     *      tags={"Caracteristica"},
     *      description="Get Caracteristica",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Caracteristica",
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
     *                  ref="#/definitions/Caracteristica"
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
        /** @var Caracteristica $caracteristica */
        $caracteristica = $this->caracteristicaRepository->find($id);

        if (empty($caracteristica)) {
            return Response::json(ResponseUtil::makeError('Caracteristica not found'), 400);
        }

        return $this->sendResponse($caracteristica->toArray(), 'Caracteristica retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateCaracteristicaAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/caracteristicas/{id}",
     *      summary="Update the specified Caracteristica in storage",
     *      tags={"Caracteristica"},
     *      description="Update Caracteristica",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Caracteristica",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Caracteristica that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Caracteristica")
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
     *                  ref="#/definitions/Caracteristica"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateCaracteristicaAPIRequest $request)
    {
        $input = $request->all();

        /** @var Caracteristica $caracteristica */
        $caracteristica = $this->caracteristicaRepository->find($id);

        if (empty($caracteristica)) {
            return Response::json(ResponseUtil::makeError('Caracteristica not found'), 400);
        }

        $caracteristica = $this->caracteristicaRepository->update($input, $id);

        return $this->sendResponse($caracteristica->toArray(), 'Caracteristica updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/caracteristicas/{id}",
     *      summary="Remove the specified Caracteristica from storage",
     *      tags={"Caracteristica"},
     *      description="Delete Caracteristica",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Caracteristica",
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
        /** @var Caracteristica $caracteristica */
        $caracteristica = $this->caracteristicaRepository->find($id);

        if (empty($caracteristica)) {
            return Response::json(ResponseUtil::makeError('Caracteristica not found'), 400);
        }

        $caracteristica->delete();

        return $this->sendResponse($id, 'Caracteristica deleted successfully');
    }
}
