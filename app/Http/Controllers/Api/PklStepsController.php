<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DefaultResource;
use App\Services\PklStepsService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class PklStepsController extends Controller
{

    private $pklStepsService;

    public function __construct(PklStepsService $pklStepsService)
    {
        $this->pklStepsService = $pklStepsService;
    }

    public function index(Request $request)
    {
        if ($request->query("active")) {
            return $this->getActiveStep();
        }
        $dates = $this->pklStepsService->getAllResources();
        return new DefaultResource(200, "Mendapatkan data jadwal pkl", $dates);
    }

    public function getActiveStep()
    {
        $data = $this->pklStepsService->getCurrentActive();
        return new DefaultResource(200, "Berhasil mendapatkan step pkl aktif", $data);
    }


    public function store(Request $request)
    {
        $data = $this->pklStepsService->createResource($request->all());
        return new DefaultResource(Response::HTTP_CREATED, "Berhasil membuat data", $data);

    }


    public function update(Request $request, $id)
    {
        $data = $this->pklStepsService->updateResource($id, $request->all());
        return new DefaultResource(Response::HTTP_CREATED, "Berhasil update data dengan id: $id", $data);
    }


    public function destroy($id)
    {
        $data = $this->pklStepsService->deleteResourceById($id);
        return new DefaultResource(Response::HTTP_CREATED, "Berhasil menghapus data dengan id: $id", $data);
    }

    public function destroyAll()
    {
        $data = $this->pklStepsService->deleteAllResource();
        return new DefaultResource(Response::HTTP_CREATED, "Berhasil menghapus semua data step pkl", $data);
    }
}