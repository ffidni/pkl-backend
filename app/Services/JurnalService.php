<?php

namespace App\Services;

use App\Exceptions\ApiException;
use App\Models\Jurnal;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class JurnalService
{

    public function getAllResources($users_id = null)
    {
        if ($users_id) {
            return Jurnal::where("users_id", $users_id)->get();
        }
        return Jurnal::all();
    }

    public function createResource(array $data)
    {
        $validator = Validator::make($data, [
            "users_id" => "required",
            "title" => "required|string",
            "desc" => "required|string",
            "content" => "required|string",
            "date" => "required",
        ]);
        if ($validator->fails()) {
            $validatorData = validatorErrorHandler($validator);
            throw new ApiException(Response::HTTP_BAD_REQUEST, $validatorData['message'], $validatorData['errors']);
        }
        $jurnal = Jurnal::create($data);
        return $jurnal;
    }

    public function getResourceById($id)
    {
        $jurnal = Jurnal::find($id);
        if ($jurnal) {
            return $jurnal;
        }
        throw new ApiException(Response::HTTP_NOT_FOUND, "Jurnal dengan id: $id tidak ditemukan");
    }

    public function updateResource($id, array $data)
    {
        $jurnal = Jurnal::where("id", $id);
        if ($jurnal->exists()) {
            $validator = Validator::make($data, [
                "title" => "required|string",
                "desc" => "required|string",
                "content" => "required|string",
                "date" => "required",
            ]);
            if ($validator->fails()) {
                $validatorData = validatorErrorHandler($validator);
                throw new ApiException(Response::HTTP_BAD_REQUEST, $validatorData['message'], $validatorData['errors']);
            }
            $isSuccess = $jurnal->update($data);
            if ($isSuccess) {
                return true;
            }
            throw new ApiException(Response::HTTP_BAD_REQUEST, "Gagal merubah data jurnal dengan id: $id");
        }
        throw new ApiException(Response::HTTP_NOT_FOUND, "Data jurnal dengan id: $id tidak ditemukan");
    }

    public function deleteResource($id)
    {
        $jurnal = Jurnal::find($id);
        if ($jurnal) {
            $jurnal->delete();
            return true;
        }
        throw new ApiException(Response::HTTP_NOT_FOUND, "Jurnal dengan id: $id tidak ditemukan");
    }

}