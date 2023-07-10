<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Http\Resources\DefaultResource;
use App\Services\JurnalService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class JurnalController extends Controller
{


    private $jurnalService;
    public function __construct(JurnalService $jurnalService)
    {
        $this->jurnalService = $jurnalService;
    }

    public function index(Request $request)
    {
        $jurnal = $this->jurnalService->getAllResources($request->query("users_id"));
        return new DefaultResource(Response::HTTP_OK, "Berhasil mendapatkan data jurnal", $jurnal);
    }


    public function store(Request $request)
    {
        $jurnal = $this->jurnalService->createResource($request->all());
        return new DefaultResource(Response::HTTP_CREATED, "Berhasil menambahkan jurnal", $jurnal);
    }


    public function show($id)
    {
        $jurnal = $this->jurnalService->getResourceById($id);
        return new DefaultResource(200, "Berhasil mendapatkan data jurnal dengan id: $id", $jurnal);
    }


    public function update(Request $request, $id)
    {
        $this->jurnalService->updateResource($id, $request->all());
        return new DefaultResource(Response::HTTP_NO_CONTENT, "Berhasil merubah data dengan id: $id", null);
    }


    public function destroy($id)
    {
        $this->jurnalService->deleteResource($id);
        return new DefaultResource(Response::HTTP_NO_CONTENT, "Berhasil menghapus data jurnal dengan id: $id", null);
    }
}