<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateDomicilioAPIRequest;
use App\Http\Requests\API\UpdateDomicilioAPIRequest;
use App\Models\Domicilio;
use App\Repositories\DomicilioRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use InfyOm\Generator\Utils\ResponseUtil;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class DomicilioController
 * @package App\Http\Controllers\API
 */

class DomicilioAPIController extends AppBaseController
{
    /** @var  DomicilioRepository */
    private $domicilioRepository;

    public function __construct(DomicilioRepository $domicilioRepo)
    {
        $this->domicilioRepository = $domicilioRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/domicilios",
     *      summary="Get a listing of the Domicilios.",
     *      tags={"Domicilio"},
     *      description="Get all Domicilios",
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
     *                  @SWG\Items(ref="#/definitions/Domicilio")
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
        $this->domicilioRepository->pushCriteria(new RequestCriteria($request));
        $this->domicilioRepository->pushCriteria(new LimitOffsetCriteria($request));
        $domicilios = $this->domicilioRepository->all();

        return $this->sendResponse($domicilios->toArray(), 'Domicilios retrieved successfully');
    }

    /**
     * @param CreateDomicilioAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/domicilios",
     *      summary="Store a newly created Domicilio in storage",
     *      tags={"Domicilio"},
     *      description="Store Domicilio",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Domicilio that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Domicilio")
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
     *                  ref="#/definitions/Domicilio"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateDomicilioAPIRequest $request)
    {
        $input = $request->all();

        $domicilios = $this->domicilioRepository->create($input);

        return $this->sendResponse($domicilios->toArray(), 'Domicilio saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/domicilios/{id}",
     *      summary="Display the specified Domicilio",
     *      tags={"Domicilio"},
     *      description="Get Domicilio",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Domicilio",
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
     *                  ref="#/definitions/Domicilio"
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
        /** @var Domicilio $domicilio */
        $domicilio = $this->domicilioRepository->find($id);

        if (empty($domicilio)) {
            return Response::json(ResponseUtil::makeError('Domicilio not found'), 400);
        }

        return $this->sendResponse($domicilio->toArray(), 'Domicilio retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateDomicilioAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/domicilios/{id}",
     *      summary="Update the specified Domicilio in storage",
     *      tags={"Domicilio"},
     *      description="Update Domicilio",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Domicilio",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Domicilio that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Domicilio")
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
     *                  ref="#/definitions/Domicilio"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateDomicilioAPIRequest $request)
    {
        $input = $request->all();

        /** @var Domicilio $domicilio */
        $domicilio = $this->domicilioRepository->find($id);

        if (empty($domicilio)) {
            return Response::json(ResponseUtil::makeError('Domicilio not found'), 400);
        }

        $domicilio = $this->domicilioRepository->update($input, $id);

        return $this->sendResponse($domicilio->toArray(), 'Domicilio updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/domicilios/{id}",
     *      summary="Remove the specified Domicilio from storage",
     *      tags={"Domicilio"},
     *      description="Delete Domicilio",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Domicilio",
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
        /** @var Domicilio $domicilio */
        $domicilio = $this->domicilioRepository->find($id);

        if (empty($domicilio)) {
            return Response::json(ResponseUtil::makeError('Domicilio not found'), 400);
        }

        $domicilio->delete();

        return $this->sendResponse($id, 'Domicilio deleted successfully');
    }
}
