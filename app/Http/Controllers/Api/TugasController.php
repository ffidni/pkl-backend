<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DefaultResource;
use App\Services\TugasService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use OpenApi\Annotations as OA;

class TugasController extends Controller
{
    private $tugasService;

    public function __construct(TugasService $tugasService)
    {
        $this->tugasService = $tugasService;
    }

    /**
     * @OA\Get(
     *     path="/tugas",
     *     operationId="getAllTugas",
     *     tags={"Tugas"},
     *     summary="Get all Tugas",
     *     description="Retrieve a list of all Tugas.",
     *     @OA\Response(
     *         response="200",
     *         description="Tugas retrieved successfully"
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="Unauthorized"
     *     )
     * )
     */
    public function index(Request $request)
    {
        $tugas = $this->tugasService->getAllResources($request->query("users_id"));
        return new DefaultResource(Response::HTTP_OK, 'List Data Tugas', $tugas);
    }

    /**
     * @OA\Post(
     *     path="/tugas",
     *     operationId="createTugas",
     *     tags={"Tugas"},
     *     summary="Create a Tugas",
     *     description="Create a new Tugas.",
     *     @OA\RequestBody(
     *         description="Tugas details",
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="users_id",
     *                 type="integer"
     *             ),
     *             @OA\Property(
     *                 property="nama_tugas",
     *                 type="string"
     *             ),
     *             @OA\Property(
     *                 property="prioritas",
     *                 type="string"
     *             ),
     *             @OA\Property(
     *                 property="deadline",
     *                 type="string"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="201",
     *         description="Tugas created successfully"
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
        $tugas = $this->tugasService->createResource($request->all());
        return new DefaultResource(Response::HTTP_CREATED, "Berhasil menambahkan tugas", $tugas);
    }

    /**
     * @OA\Get(
     *     path="/tugas/{id}",
     *     operationId="getTugas",
     *     tags={"Tugas"},
     *     summary="Get a Tugas by ID",
     *     description="Retrieve a specific Tugas by its ID.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the Tugas",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Tugas retrieved successfully"
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
        $tugas = $this->tugasService->getResourceById($id);

        if (!$tugas) {
            return new DefaultResource(Response::HTTP_NOT_FOUND, "Data not found", null);
        }

        return new DefaultResource(Response::HTTP_OK, "Berhasil mendapatkan tugas", $tugas);
    }

    /**
     * @OA\Put(
     *     path="/tugas/{id}",
     *     operationId="updateTugas",
     *     tags={"Tugas"},
     *     summary="Update a Tugas",
     *     description="Update an existing Tugas.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the Tugas",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         description="Tugas details",
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="nama_tugas",
     *                 type="string"
     *             ),
     *             @OA\Property(
     *                 property="prioritas",
     *                 type="string"
     *             ),
     *             @OA\Property(
     *                 property="is_checked",
     *                 type="integer"
     *             ),
     *             @OA\Property(
     *                 property="deadline",
     *                 type="string"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="204",
     *         description="Tugas updated successfully"
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
        $tugas = $this->tugasService->updateResource($id, $request->all());

        if (!$tugas) {
            return new DefaultResource(Response::HTTP_NOT_FOUND, "Data not found", null);
        }

        return new DefaultResource(Response::HTTP_NO_CONTENT, "Berhasil merubah data tugas dengan id: $id", null);
    }

    /**
     * @OA\Delete(
     *     path="/tugas/{id}",
     *     operationId="deleteTugas",
     *     tags={"Tugas"},
     *     summary="Delete a Tugas",
     *     description="Delete a Tugas by its ID.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the Tugas",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response="204",
     *         description="Tugas deleted successfully"
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
        $tugas = $this->tugasService->deleteResource($id);

        if (!$tugas) {
            return new DefaultResource(Response::HTTP_NOT_FOUND, "Data not found", null);
        }

        return new DefaultResource(Response::HTTP_NO_CONTENT, "Berhasil menghapus tugas dengan id: $id", null);
    }
}