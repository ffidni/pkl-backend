<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DefaultResource;
use App\Services\TempatPklSuggestionsService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TempatPklSuggestionsController extends Controller
{

    private $service;

    public function __construct(TempatPklSuggestionsService $service)
    {
        $this->service = $service;
    }
    public function index(Request $request)
    {
        $suggestions = $this->service->getAllResources();
        return new DefaultResource(Response::HTTP_OK, 'List Data Suggestions Pkl', $suggestions);
    }


    public function store(Request $request)
    {
        $suggestions = $this->service->createResource($request->all());
        return new DefaultResource(Response::HTTP_CREATED, "Berhasil menambahkan suggestions", $suggestions);
    }


    public function show($id)
    {
        $suggestions = $this->service->getResourceById($id);
        return new DefaultResource(200, "Berhasil mendapatkan suggestions", $suggestions);
    }


    public function update(Request $request, $id)
    {
        $this->service->updateResource($id, $request->all());
        return new DefaultResource(Response::HTTP_NO_CONTENT, "Berhasil merubah data suggestiosn pkl dengan id: $id", null);
    }


    public function destroy($id)
    {
        //
        $this->service->deleteResource($id);
        return new DefaultResource(Response::HTTP_NO_CONTENT, "Berhasil menghapus suggestions pkl dengan id: $id", null);

    }
}