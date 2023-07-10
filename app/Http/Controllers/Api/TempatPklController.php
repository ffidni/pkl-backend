<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DefaultResource;
use App\Services\TempatPklService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TempatPklController extends Controller
{

    private $tempatPklService;

    public function __construct(TempatPklService $tempatPklService)
    {
        $this->tempatPklService = $tempatPklService;
    }

    public function index(Request $request)
    {
        $data = $this->tempatPklService->getAllResources($request->query("users_id"));
        return new DefaultResource(Response::HTTP_OK, "Berhasil mendapatkan data tempat PKL", $data);
    }


    public function store(Request $request)
    {
        $data = $this->tempatPklService->createResource($request->all());
        return new DefaultResource(Response::HTTP_CREATED, "Berhasil menambah data tempat PKL", $data);
    }


    public function show($id)
    {
        $data = $this->tempatPklService->getResourceById($id);
        return new DefaultResource(200, "Berhasil mendapatkan data tempat PKL dengan id: $id", $data);
    }

    public function update(Request $request, $id)
    {
        $this->tempatPklService->updateResource($id, $request->all());
        return new DefaultResource(Response::HTTP_NO_CONTENT, "Berhasil merubah data tempat PKL dengan id: $id", null);
    }


    public function destroy($id)
    {
        $this->tempatPklService->deleteResource($id);
        return new DefaultResource(Response::HTTP_NO_CONTENT, "Berhasil menghapus data tempat PKL dengan id: $id", null);
    }
}