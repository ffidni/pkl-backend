<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Http\Resources\DefaultResource;
use App\Services\JurnalService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use OpenApi\Annotations as OA;

class JurnalController extends Controller
{
    private $jurnalService;

    public function __construct(JurnalService $jurnalService)
    {
        $this->jurnalService = $jurnalService;
    }

    /**
     * @OA\Get(
     *     path="/jurnal",
     *     operationId="getAllJurnals",
     *     tags={"Jurnal"},
     *     summary="Get all Jurnals",
     *     description="Retrieve all Jurnals.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="users_id",
     *         in="query",
     *         description="ID of the user to filter jurnals",
     *         required=false,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Jurnals retrieved successfully"
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="Unauthorized"
     *     )
     * )
     */
    public function index(Request $request)
    {
        $jurnals = $this->jurnalService->getAllResources($request->query("users_id"));
        return new DefaultResource(Response::HTTP_OK, "Berhasil mendapatkan data jurnal", $jurnals);
    }

    /**
     * @OA\Post(
     *     path="/jurnal",
     *     operationId="createJurnal",
     *     tags={"Jurnal"},
     *     summary="Create a Jurnal",
     *     description="Create a new Jurnal.",
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         description="Jurnal details",
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="users_id",
     *                 type="integer"
     *             ),
     *             @OA\Property(
     *                 property="title",
     *                 type="string"
     *             ),
     *             @OA\Property(
     *                 property="desc",
     *                 type="string"
     *             ),
     *             @OA\Property(
     *                 property="content",
     *                 type="string"
     *             ),
     *             @OA\Property(
     *                 property="date",
     *                 type="string"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="201",
     *         description="Jurnal created successfully"
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
        $jurnal = $this->jurnalService->createResource($request->all());
        return new DefaultResource(Response::HTTP_CREATED, "Berhasil menambahkan jurnal", $jurnal);
    }

    /**
     * @OA\Get(
     *     path="/jurnal/{id}",
     *     operationId="getJurnalById",
     *     tags={"Jurnal"},
     *     summary="Get a Jurnal by ID",
     *     description="Get a Jurnal by its ID.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the jurnal",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Jurnal retrieved successfully"
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
    public function show($id)
    {
        $jurnal = $this->jurnalService->getResourceById($id);

        if (!$jurnal) {
            throw new ApiException("Jurnal not found", Response::HTTP_NOT_FOUND);
        }

        return new DefaultResource(Response::HTTP_OK, "Berhasil mendapatkan data jurnal dengan id: $id", $jurnal);
    }

    /**
     * @OA\Put(
     *     path="/jurnal/{id}",
     *     operationId="updateJurnal",
     *     tags={"Jurnal"},
     *     summary="Update a Jurnal",
     *     description="Update an existing Jurnal.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the jurnal",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         description="Jurnal details",
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="users_id",
     *                 type="integer"
     *             ),
     *             @OA\Property(
     *                 property="title",
     *                 type="string"
     *             ),
     *             @OA\Property(
     *                 property="desc",
     *                 type="string"
     *             ),
     *             @OA\Property(
     *                 property="content",
     *                 type="string"
     *             ),
     *             @OA\Property(
     *                 property="date",
     *                 type="string"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="204",
     *         description="Jurnal updated successfully"
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
        $jurnal = $this->jurnalService->updateResource($id, $request->all());

        if (!$jurnal) {
            throw new ApiException("Jurnal not found", Response::HTTP_NOT_FOUND);
        }

        return new DefaultResource(Response::HTTP_NO_CONTENT, "Berhasil merubah data dengan id: $id", null);
    }

    /**
     * @OA\Delete(
     *     path="/jurnal/{id}",
     *     operationId="deleteJurnal",
     *     tags={"Jurnal"},
     *     summary="Delete a Jurnal",
     *     description="Delete a Jurnal by its ID.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the jurnal",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response="204",
     *         description="Jurnal deleted successfully"
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
        $deleted = $this->jurnalService->deleteResource($id);

        if (!$deleted) {
            throw new ApiException("Jurnal not found", Response::HTTP_NOT_FOUND);
        }

        return new DefaultResource(Response::HTTP_NO_CONTENT, "Berhasil menghapus data jurnal dengan id: $id", null);
    }
}