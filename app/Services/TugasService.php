<?php

namespace App\Services;

use App\Exceptions\ApiException;
use App\Models\Tugas;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class TugasService
{
    public function getAllResources($users_id = null)
    {
        if ($users_id) {
            return Tugas::where("users_id", $users_id)->orderByRaw(
                "CASE prioritas 
                    WHEN 'tinggi' THEN 1
                    WHEN 'menengah' THEN 2
                    ELSE 3
                END
                "
            )->get();
        }
        return Tugas::orderByRaw(
            "CASE prioritas 
                WHEN 'tinggi' THEN 1
                WHEN 'menengah' THEN 2
                ELSE 3
            END
            "
        )->get();
    }

    public function createResource(array $data)
    {
        $validator = Validator::make($data, [
            "users_id" => "required",
            "nama_tugas" => "required|string",
            "prioritas" => "required|string",
            "deadline" => "required|string",
        ]);
        if ($validator->fails()) {
            $validatorData = validatorErrorHandler($validator);
            throw new ApiException(Response::HTTP_BAD_REQUEST, $validatorData['message'], $validatorData['errors']);
        }
        $tugas = Tugas::create($data);
        return $tugas;
    }

    public function getResourceById($id)
    {
        $tugas = Tugas::find($id);
        if (!$tugas) {
            throw new ApiException(Response::HTTP_NOT_FOUND, "Tidak ada data tugas dengan id: $id");
        }
        return $tugas;
    }

    public function updateResource($id, array $data)
    {
        $tugas = Tugas::where("id", $id);
        if ($tugas->exists()) {
            $validator = Validator::make($data, [
                "nama_tugas" => "required|string",
                "prioritas" => "required|string",
                "is_checked" => "required|integer",
                "deadline" => "required|string",
            ]);
            if ($validator->fails()) {
                $validatorData = validatorErrorHandler($validator);
                throw new ApiException(Response::HTTP_BAD_REQUEST, $validatorData['message'], $validatorData['errors']);
            }
            $isSuccess = $tugas->update($data);
            if ($isSuccess) {
                return true;
            }
            throw new ApiException(Response::HTTP_BAD_REQUEST, "Gagal merubah data tugas dengan id: $id");
        }
        throw new ApiException(Response::HTTP_NOT_FOUND, "Data tugas dengan id: $id tidak ditemukan");

    }

    public function deleteResource($id)
    {
        $record = Tugas::find($id);
        if ($record) {
            $record->delete();
            return true;
        } else {
            throw new ApiException(Response::HTTP_NOT_FOUND, "Tugas dengan id: $id tidak ditemukan");
        }
    }
}