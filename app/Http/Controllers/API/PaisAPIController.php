<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatePaisAPIRequest;
use App\Http\Requests\API\UpdatePaisAPIRequest;
use App\Models\Pais;
use App\Repositories\PaisRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use InfyOm\Generator\Utils\ResponseUtil;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class PaisController
 * @package App\Http\Controllers\API
 */

class PaisAPIController extends AppBaseController
{
    /** @var  PaisRepository */
    private $paisRepository;

    public function __construct(PaisRepository $paisRepo)
    {
        $this->paisRepository = $paisRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/pais",
     *      summary="Get a listing of the Pais.",
     *      tags={"Pais"},
     *      description="Get all Pais",
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
     *                  @SWG\Items(ref="#/definitions/Pais")
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
        $this->paisRepository->pushCriteria(new RequestCriteria($request));
        $this->paisRepository->pushCriteria(new LimitOffsetCriteria($request));
        $pais = $this->paisRepository->all();

        return $this->sendResponse($pais->toArray(), 'Pais retrieved successfully');
    }

    /**
     * @param CreatePaisAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/pais",
     *      summary="Store a newly created Pais in storage",
     *      tags={"Pais"},
     *      description="Store Pais",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Pais that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Pais")
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
     *                  ref="#/definitions/Pais"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreatePaisAPIRequest $request)
    {
        $input = $request->all();

        $pais = $this->paisRepository->create($input);

        return $this->sendResponse($pais->toArray(), 'Pais saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/pais/{id}",
     *      summary="Display the specified Pais",
     *      tags={"Pais"},
     *      description="Get Pais",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Pais",
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
     *                  ref="#/definitions/Pais"
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
        /** @var Pais $pais */
        $pais = $this->paisRepository->find($id);

        if (empty($pais)) {
            return Response::json(ResponseUtil::makeError('Pais not found'), 400);
        }

        return $this->sendResponse($pais->toArray(), 'Pais retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdatePaisAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/pais/{id}",
     *      summary="Update the specified Pais in storage",
     *      tags={"Pais"},
     *      description="Update Pais",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Pais",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Pais that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Pais")
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
     *                  ref="#/definitions/Pais"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdatePaisAPIRequest $request)
    {
        $input = $request->all();

        /** @var Pais $pais */
        $pais = $this->paisRepository->find($id);

        if (empty($pais)) {
            return Response::json(ResponseUtil::makeError('Pais not found'), 400);
        }

        $pais = $this->paisRepository->update($input, $id);

        return $this->sendResponse($pais->toArray(), 'Pais updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/pais/{id}",
     *      summary="Remove the specified Pais from storage",
     *      tags={"Pais"},
     *      description="Delete Pais",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Pais",
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
        /** @var Pais $pais */
        $pais = $this->paisRepository->find($id);

        if (empty($pais)) {
            return Response::json(ResponseUtil::makeError('Pais not found'), 400);
        }

        $pais->delete();

        return $this->sendResponse($id, 'Pais deleted successfully');
    }
}
