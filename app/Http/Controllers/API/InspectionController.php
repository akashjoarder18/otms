<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Traits\UtilityTrait;
use Illuminate\Http\Request;
use App\Models\Inspection;

class InspectionController extends Controller
{
    use UtilityTrait;
    public function index()
    {
        try {
            $inspaction = Inspection::with('batch.training.trainingTitle', 'createdBy')->paginate(15);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'error' => true,
                'message' => $th->getMessage(),
            ]);
        }
        return response()->json([
            'success' => true,
            'data' => $inspaction,
        ]);
    }
    public function store(Request $request)
    {
        $request['created_by'] = 41;
        return Inspection::create($request->all());
    }

    public function show($id)
    {
        return Inspection::with('batch.training.trainingTitle', 'batch.primaryTrainer.profile', 'createdBy')->find($id);
    }

    public function update(Request $request, $id)
    {
        $inspection = Inspection::findOrFail($id);
        $inspection->update($request->all());
        return $inspection;
    }

    public function destroy($id)
    {
        Inspection::find($id)->delete();
        return 204;
    }

}