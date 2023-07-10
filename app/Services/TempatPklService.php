<?php

namespace App\Services;

use App\Exceptions\ApiException;
use App\Models\TempatPkl;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class TempatPklService
{

    public function getAllResources($users_id = null)
    {
        if ($users_id) {
            return TempatPkl::where("users_id", $users_id)->get();
        }
        return TempatPkl::all();
    }

    public function createResource(array $data)
    {
        $tempat = TempatPkl::where("users_id", $data['users_id']);
        if ($tempat->exists()) {
            throw new ApiException(Response::HTTP_BAD_REQUEST, "Data tempat PKL maksimal 1 tempat");
        }
        $validator = Validator::make($data, [
            "users_id" => "required",
            "latitude" => "required|string",
            "longitude" => "required|string"
        ]);
        if ($validator->fails()) {
            $validatorData = validatorErrorHandler($validator);
            throw new ApiException(Response::HTTP_BAD_REQUEST, $validatorData['message'], $validatorData['errors']);
        }
        $data = TempatPkl::create($data);
        return $data;
    }

    public function getResourceById($id)
    {
        $data = TempatPkl::find($id);
        if (!$data) {
            throw new ApiException(Response::HTTP_NOT_FOUND, "Data Tempat PKL dengan id: $id tidak ditemukan");
        }
        return $data;
    }

    public function updateResource($id, array $data)
    {
        $tempat = TempatPkl::where("id", $id);
        if ($tempat->exists()) {
            $validator = Validator::make($data, [
                "latitude" => "required|string",
                "longitude" => "required|string"
            ]);
            if ($validator->fails()) {
                $validatorData = validatorErrorHandler($validator);
                throw new ApiException(Response::HTTP_BAD_REQUEST, $validatorData['message'], $validatorData['errors']);
            }
            $isSuccess = $tempat->update($data);
            if ($isSuccess) {
                return true;
            }
            throw new ApiException(Response::HTTP_BAD_REQUEST, "Gagal merubah data tempat PKL dengan id: $id");
        }
        throw new ApiException(Response::HTTP_NOT_FOUND, "Data Tempat PKL dengan id: $id tidak ditemkan");
    }

    public function deleteResource($id)
    {
        $data = TempatPkl::find($id);
        if ($data) {
            $data->delete();
            return true;
        }
        throw new ApiException(Response::HTTP_NOT_FOUND, "Data tempat PKL dengan id: $id tidak ditemukan");
    }
}