<?php

namespace App\Services;

use App\Exceptions\ApiException;
use App\Models\TempatPklSuggestion;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class TempatPklSuggestionsService
{
    public function getAllResources($users_id = null)
    {
        return TempatPklSuggestion::all();
    }

    public function createResource(array $data)
    {
        $validator = Validator::make($data, [
            "nama_tempat" => "required|string",
            "latitude" => "numeric",
            "longitude" => "numeric",
        ]);
        if ($validator->fails()) {
            $validatorData = validatorErrorHandler($validator);
            throw new ApiException(Response::HTTP_BAD_REQUEST, $validatorData['message'], $validatorData['errors']);
        }
        $tempat = TempatPklSuggestion::create($data);
        return $tempat;
    }

    public function getResourceById($id)
    {
        $tugas = TempatPklSuggestion::find($id);
        if (!$tugas) {
            throw new ApiException(Response::HTTP_NOT_FOUND, "Tidak ada suggestions pkl dengan id: $id");
        }
        return $tugas;
    }

    public function updateResource($id, array $data)
    {
        $tugas = TempatPklSuggestion::where("id", $id);
        if ($tugas->exists()) {
            $validator = Validator::make($data, [
                "nama_tempat" => "required|string",
            ]);
            if ($validator->fails()) {
                $validatorData = validatorErrorHandler($validator);
                throw new ApiException(Response::HTTP_BAD_REQUEST, $validatorData['message'], $validatorData['errors']);
            }
            $isSuccess = $tugas->update($data);
            if ($isSuccess) {
                return true;
            }
            throw new ApiException(Response::HTTP_BAD_REQUEST, "Gagal merubah data suggestions pkl dengan id: $id");
        }
        throw new ApiException(Response::HTTP_NOT_FOUND, "Data suggestions pkl dengan id: $id tidak ditemukan");
    }

    public function deleteResource($id)
    {
        // Service logic to delete a resource
        $record = TempatPklSuggestion::find($id);
        if ($record) {
            $record->delete();
            return true;
        }
        throw new ApiException(Response::HTTP_NOT_FOUND, "Suggestions pkl dengan id: $id tidak ditemukan");
    }
}