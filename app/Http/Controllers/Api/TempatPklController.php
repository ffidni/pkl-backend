<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DefaultResource;
use App\Services\TempatPklService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use OpenApi\Annotations as OA;

class TempatPklController extends Controller
{
    private $tempatPklService;

    public function __construct(TempatPklService $tempatPklService)
    {
        $this->tempatPklService = $tempatPklService;
    }

    /**
     * @OA\Get(
     *     path="/tempat-pkl",
     *     operationId="getAllTempatPkl",
     *     tags={"Tempat PKL"},
     *     summary="Get all Tempat PKL",
     *     description="Retrieve all Tempat PKL records.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="users_id",
     *         in="query",
     *         description="Filter by user ID",
     *         required=false,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Tempat PKL retrieved successfully"
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="Unauthorized"
     *     )
     * )
     */
    public function index(Request $request)
    {
        $data = $this->tempatPklService->getAllResources($request->query("users_id"));
        return new DefaultResource(Response::HTTP_OK, "Berhasil mendapatkan data tempat PKL", $data);
    }

    /**
     * @OA\Post(
     *     path="/tempat-pkl",
     *     operationId="createTempatPkl",
     *     tags={"Tempat PKL"},
     *     summary="Create a Tempat PKL",
     *     description="Create a new Tempat PKL record.",
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         description="Tempat PKL details",
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="users_id",
     *                 type="integer"
     *             ),
     *             @OA\Property(
     *                 property="latitude",
     *                 type="string"
     *             ),
     *             @OA\Property(
     *                 property="longitude",
     *                 type="string"
     *             ),
     *             @OA\Property(
     *                 property="nama_tempat",
     *                 type="string"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="201",
     *         description="Tempat PKL created successfully"
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
        $data = $this->tempatPklService->createResource($request->all());
        return new DefaultResource(Response::HTTP_CREATED, "Berhasil menambah data tempat PKL", $data);
    }

    /**
     * @OA\Get(
     *     path="/tempat-pkl/{id}",
     *     operationId="getTempatPkl",
     *     tags={"Tempat PKL"},
     *     summary="Get a Tempat PKL by ID",
     *     description="Retrieve a specific Tempat PKL record by ID.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the Tempat PKL",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Tempat PKL retrieved successfully"
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
        $data = $this->tempatPklService->getResourceById($id);

        if (!$data) {
            return new DefaultResource(Response::HTTP_NOT_FOUND, "Data not found", null);
        }

        return new DefaultResource(Response::HTTP_OK, "Berhasil mendapatkan data tempat PKL dengan id: $id", $data);
    }

    /**
     * @OA\Put(
     *     path="/tempat-pkl/{id}",
     *     operationId="updateTempatPkl",
     *     tags={"Tempat PKL"},
     *     summary="Update a Tempat PKL",
     *     description="Update an existing Tempat PKL record.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the Tempat PKL",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         description="Tempat PKL details",
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="users_id",
     *                 type="integer"
     *             ),
     *             @OA\Property(
     *                 property="latitude",
     *                 type="string"
     *             ),
     *             @OA\Property(
     *                 property="longitude",
     *                 type="string"
     *             ),
     *             @OA\Property(
     *                 property="nama_tempat",
     *                 type="string"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="204",
     *         description="Tempat PKL updated successfully"
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
        $data = $this->tempatPklService->updateResource($id, $request->all());

        if (!$data) {
            return new DefaultResource(Response::HTTP_NOT_FOUND, "Data not found", null);
        }

        return new DefaultResource(Response::HTTP_NO_CONTENT, "Berhasil merubah data tempat PKL dengan id: $id", null);
    }

    /**
     * @OA\Delete(
     *     path="/tempat-pkl/{id}",
     *     operationId="deleteTempatPkl",
     *     tags={"Tempat PKL"},
     *     summary="Delete a Tempat PKL",
     *     description="Delete a Tempat PKL record by ID.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the Tempat PKL",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response="204",
     *         description="Tempat PKL deleted successfully"
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
        $data = $this->tempatPklService->deleteResource($id);

        if (!$data) {
            return new DefaultResource(Response::HTTP_NOT_FOUND, "Data not found", null);
        }

        return new DefaultResource(Response::HTTP_NO_CONTENT, "Berhasil menghapus data tempat PKL dengan id: $id", null);
    }
}