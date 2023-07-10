<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DefaultResource;
use App\Services\TugasService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TugasController extends Controller
{

    private $tugasService;

    public function __construct(TugasService $tugasService)
    {
        $this->tugasService = $tugasService;
    }
    public function index(Request $request)
    {
        $tugas = $this->tugasService->getAllResources($request->query("users_id"));
        return new DefaultResource(Response::HTTP_OK, 'List Data Tugas', $tugas);
    }


    public function store(Request $request)
    {
        $tugas = $this->tugasService->createResource($request->all());
        return new DefaultResource(Response::HTTP_CREATED, "Berhasil menambahkan tugas", $tugas);
    }


    public function show($id)
    {
        $tugas = $this->tugasService->getResourceById($id);
        return new DefaultResource(200, "Berhasil mendapatkan tugas", $tugas);
    }


    public function update(Request $request, $id)
    {
        $this->tugasService->updateResource($id, $request->all());
        return new DefaultResource(Response::HTTP_NO_CONTENT, "Berhasil merubah data tugas dengan id: $id", null);
    }


    public function destroy($id)
    {
        //
        $this->tugasService->deleteResource($id);
        return new DefaultResource(Response::HTTP_NO_CONTENT, "Berhasil menghapus tugas dengan id: $id", null);
    }
}