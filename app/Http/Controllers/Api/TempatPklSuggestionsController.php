<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DefaultResource;
use App\Services\TempatPklSuggestionsService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use OpenApi\Annotations as OA;

class TempatPklSuggestionsController extends Controller
{
    private $service;

    public function __construct(TempatPklSuggestionsService $service)
    {
        $this->service = $service;
    }

    /**
     * @OA\Get(
     *     path="/tempat-pkl-suggestions",
     *     operationId="getAllTempatPklSuggestions",
     *     tags={"Tempat PKL Suggestions"},
     *     summary="Get all Tempat PKL Suggestions",
     *     description="Retrieve a list of all Tempat PKL Suggestions.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response="200",
     *         description="Tempat PKL Suggestions retrieved successfully"
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="Unauthorized"
     *     )
     * )
     */
    public function index(Request $request)
    {
        $suggestions = $this->service->getAllResources();
        return new DefaultResource(Response::HTTP_OK, 'List Data Suggestions Pkl', $suggestions);
    }

    /**
     * @OA\Post(
     *     path="/tempat-pkl-suggestions",
     *     operationId="createTempatPklSuggestions",
     *     tags={"Tempat PKL Suggestions"},
     *     summary="Create a Tempat PKL Suggestions",
     *     description="Create a new Tempat PKL Suggestions.",
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         description="Tempat PKL Suggestions details",
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="nama_tempat",
     *                 type="string"
     *             ),
     *             @OA\Property(
     *                 property="latitude",
     *                 type="number",
     *                 format="float"
     *             ),
     *             @OA\Property(
     *                 property="longitude",
     *                 type="number",
     *                 format="float"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="201",
     *         description="Tempat PKL Suggestions created successfully"
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
        $suggestions = $this->service->createResource($request->all());
        return new DefaultResource(Response::HTTP_CREATED, "Berhasil menambahkan suggestions", $suggestions);
    }

    /**
     * @OA\Get(
     *     path="/tempat-pkl-suggestions/{id}",
     *     operationId="getTempatPklSuggestions",
     *     tags={"Tempat PKL Suggestions"},
     *     summary="Get a Tempat PKL Suggestions by ID",
     *     description="Retrieve a specific Tempat PKL Suggestions by its ID.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the Tempat PKL Suggestions",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Tempat PKL Suggestions retrieved successfully"
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
        $suggestions = $this->service->getResourceById($id);

        if (!$suggestions) {
            return new DefaultResource(Response::HTTP_NOT_FOUND, "Data not found", null);
        }

        return new DefaultResource(Response::HTTP_OK, "Berhasil mendapatkan suggestions", $suggestions);
    }

    /**
     * @OA\Put(
     *     path="/tempat-pkl-suggestions/{id}",
     *     operationId="updateTempatPklSuggestions",
     *     tags={"Tempat PKL Suggestions"},
     *     summary="Update a Tempat PKL Suggestions",
     *     description="Update an existing Tempat PKL Suggestions.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the Tempat PKL Suggestions",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         description="Tempat PKL Suggestions details",
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="nama_tempat",
     *                 type="string"
     *             ),
     *             @OA\Property(
     *                 property="latitude",
     *                 type="number",
     *                 format="float"
     *             ),
     *             @OA\Property(
     *                 property="longitude",
     *                 type="number",
     *                 format="float"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="204",
     *         description="Tempat PKL Suggestions updated successfully"
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
        $suggestions = $this->service->updateResource($id, $request->all());

        if (!$suggestions) {
            return new DefaultResource(Response::HTTP_NOT_FOUND, "Data not found", null);
        }

        return new DefaultResource(Response::HTTP_NO_CONTENT, "Berhasil merubah data suggestions pkl dengan id: $id", null);
    }

    /**
     * @OA\Delete(
     *     path="/tempat-pkl-suggestions/{id}",
     *     operationId="deleteTempatPklSuggestions",
     *     tags={"Tempat PKL Suggestions"},
     *     summary="Delete a Tempat PKL Suggestions",
     *     description="Delete a Tempat PKL Suggestions by its ID.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the Tempat PKL Suggestions",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response="204",
     *         description="Tempat PKL Suggestions deleted successfully"
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
        $suggestions = $this->service->deleteResource($id);

        if (!$suggestions) {
            return new DefaultResource(Response::HTTP_NOT_FOUND, "Data not found", null);
        }

        return new DefaultResource(Response::HTTP_NO_CONTENT, "Berhasil menghapus suggestions pkl dengan id: $id", null);
    }
}