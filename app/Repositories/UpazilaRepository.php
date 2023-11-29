<?php

namespace App\Repositories;

use App\Models\Upazila;
use App\Repositories\Interfaces\UpazilaRepositoryInterface;

class UpazilaRepository implements UpazilaRepositoryInterface
{
    public function all($code = null)
    {
        if ($code) {

            $upazilas = Upazila::with('district', 'district.division')
                ->whereHas('district', function ($query) use ($code) {
                    $query->where('Code', $code);
                })
                ->get();
        } else {
            $upazilas = Upazila::with('district', 'district.division')->get();
        }
        return $upazilas;
    }

    public function store($data)
    {
        return Upazila::create($data);
    }

    public function details($id)
    {
        return Upazila::with('district')->where('id', '=', $id)->first();
    }

    public function find($id)
    {
        return Upazila::find($id);
    }

    public function update($upazila, $data)
    {
        $upazila->update($data);
    }

    public function delete($id)
    {
        return Upazila::find($id);
    }
}
