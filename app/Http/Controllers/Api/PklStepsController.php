<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DefaultResource;
use App\Services\PklStepsService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use OpenApi\Annotations as OA;

class PklStepsController extends Controller
{
    private $pklStepsService;

    public function __construct(PklStepsService $pklStepsService)
    {
        $this->pklStepsService = $pklStepsService;
    }

    /**
     * @OA\Get(
     *     path="/pkl-steps",
     *     operationId="getAllPklSteps",
     *     tags={"Pkl Steps"},
     *     summary="Get all Pkl Steps",
     *     description="Retrieve all Pkl Steps.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="active",
     *         in="query",
     *         description="Get active Pkl Steps",
     *         required=false,
     *         @OA\Schema(
     *             type="boolean"
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Pkl Steps retrieved successfully"
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="Unauthorized"
     *     )
     * )
     */
    public function index(Request $request)
    {
        if ($request->query("active")) {
            return $this->getActiveStep();
        }
        $dates = $this->pklStepsService->getAllResources();
        return new DefaultResource(Response::HTTP_OK, "Mendapatkan data jadwal pkl", $dates);
    }

    /**
     * @OA\Get(
     *     path="/pkl-steps/active",
     *     operationId="getActivePklStep",
     *     tags={"Pkl Steps"},
     *     summary="Get the active Pkl Step",
     *     description="Retrieve the active Pkl Step.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response="200",
     *         description="Active Pkl Step retrieved successfully"
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="Unauthorized"
     *     )
     * )
     */
    public function getActiveStep()
    {
        $data = $this->pklStepsService->getCurrentActive();
        return new DefaultResource(Response::HTTP_OK, "Berhasil mendapatkan step pkl aktif", $data);
    }

    /**
     * @OA\Post(
     *     path="/pkl-steps",
     *     operationId="createPklStep",
     *     tags={"Pkl Steps"},
     *     summary="Create a Pkl Step",
     *     description="Create a new Pkl Step.",
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         description="Pkl Step details",
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="title",
     *                 type="string"
     *             ),
     *             @OA\Property(
     *                 property="dates",
     *                 type="string"
     *             ),
     *             @OA\Property(
     *                 property="order",
     *                 type="integer"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="201",
     *         description="Pkl Step created successfully"
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Bad request"
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="Unauthorized"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $data = $this->pklStepsService->createResource($request->all());
        return new DefaultResource(Response::HTTP_CREATED, "Berhasil membuat data", $data);
    }

    /**
     * @OA\Put(
     *     path="/pkl-steps/{id}",
     *     operationId="updatePklStep",
     *     tags={"Pkl Steps"},
     *     summary="Update a Pkl Step",
     *     description="Update an existing Pkl Step.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the Pkl Step",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         description="Pkl Step details",
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="title",
     *                 type="string"
     *             ),
     *             @OA\Property(
     *                 property="dates",
     *                 type="string"
     *             ),
     *             @OA\Property(
     *                 property="order",
     *                 type="integer"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="201",
     *         description="Pkl Step updated successfully"
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Bad request"
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Not found"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $data = $this->pklStepsService->updateResource($id, $request->all());

        if (!$data) {
            return new DefaultResource(Response::HTTP_NOT_FOUND, "Data not found", null);
        }

        return new DefaultResource(Response::HTTP_CREATED, "Berhasil update data dengan id: $id", $data);
    }

    /**
     * @OA\Delete(
     *     path="/pkl-steps/{id}",
     *     operationId="deletePklStep",
     *     tags={"Pkl Steps"},
     *     summary="Delete a Pkl Step",
     *     description="Delete a Pkl Step by ID.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the Pkl Step",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response="201",
     *         description="Pkl Step deleted successfully"
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Not found"
     *     )
     * )
     */
    public function destroy($id)
    {
        $data = $this->pklStepsService->deleteResourceById($id);

        if (!$data) {
            return new DefaultResource(Response::HTTP_NOT_FOUND, "Data not found", null);
        }

        return new DefaultResource(Response::HTTP_CREATED, "Berhasil menghapus data dengan id: $id", $data);
    }

    /**
     * @OA\Delete(
     *     path="/pkl-steps",
     *     operationId="deleteAllPklSteps",
     *     tags={"Pkl Steps"},
     *     summary="Delete all Pkl Steps",
     *     description="Delete all Pkl Steps.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response="201",
     *         description="All Pkl Steps deleted successfully"
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="Unauthorized"
     *     )
     * )
     */
    public function destroyAll()
    {
        $data = $this->pklStepsService->deleteAllResource();
        return new DefaultResource(Response::HTTP_CREATED, "Berhasil menghapus semua data step pkl", $data);
    }
}