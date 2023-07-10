<?php

namespace App\Services;

use App\Exceptions\ApiException;
use App\Models\PklStep;
use DateTime;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PklStepsService
{

    public function getAllResources()
    {
        $dates = PklStep::orderBy("order", "asc")->get();
        $newDates = [];
        foreach ($dates as $date) {
            $dateArray = explode(',', $date['dates']);
            if (!in_array($date, $newDates)) {
                $date['dates'] = $dateArray;
                array_push($newDates, $date);
            }
        }
        return $newDates;
    }

    public function createResource(array $data)
    {

        $validator = Validator::make($data, [
            "title" => "required|string",
            "dates" => [
                "required",
                'regex:/^\d{4}-\d{2}-\d{2}(,\d{4}-\d{2}-\d{2})*$/'
            ],
            "order" => "required|integer|unique:pkl_steps,order",
        ]);

        if ($validator->fails()) {
            $validatorData = validatorErrorHandler($validator);
            throw new ApiException(Response::HTTP_BAD_REQUEST, $validatorData['message'], $validatorData['errors']);
        }
        $data = PklStep::create($data);
        return $data;
    }

    public function getCurrentActive()
    {
        $dates = PklStep::orderBy("order", "asc")->get();
        $actives = [];
        foreach ($dates as $date) {
            $dateArray = explode(',', $date['dates']);
            foreach ($dateArray as $dateString) {
                $dateObject = DateTime::createFromFormat("Y-m-d", $dateString);
                $currentDate = new DateTime();
                if ($currentDate >= $dateObject) {
                    if (!in_array($date['id'], $actives)) {
                        array_push($actives, $date['id']);
                    }
                }
            }
        }
        return $actives;
    }

    public function updateResource($id, array $data)
    {
        $steps = PklStep::where("id", $id);
        if ($steps->exists()) {
            $validator = Validator::make($data, [
                "title" => "required|string",
                "dates" => [
                    "required",
                    Rule::regex('/^(\d{2}-\d{2}-\d{2},)*\d{2}-\d{2}-\d{2}$/')
                ],
                "order" => "required|integer",
            ]);
            if ($validator->fails()) {
                $validatorData = validatorErrorHandler($validator);
                throw new ApiException(Response::HTTP_BAD_REQUEST, $validatorData['message'], $validatorData['errors']);
            }
            $isSuccess = $steps->update($data);
            if ($isSuccess) {
                return true;
            }
            throw new ApiException(Response::HTTP_BAD_REQUEST, "Gagal merubah data pkl dengan id: $id");
        }
        throw new ApiException(Response::HTTP_NOT_FOUND, "Data pkl dengan id: $id tidak ditemukan");
    }

    public function deleteResourceById($id)
    {
        $steps = PklStep::find($id);
        if ($steps) {
            $steps->delete();
            return true;
        }
        throw new ApiException(Response::HTTP_NOT_FOUND, "Data pkl dengan id: $id tidak ditemukan");
    }

    public function deleteAllResource()
    {
        PklStep::truncate();
        return true;
    }

}