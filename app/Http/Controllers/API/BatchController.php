<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\DevelopmentPartner;
use App\Models\Provider;
use App\Models\TrainingBatch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BatchController extends Controller
{
    //
    public function index(Request $request)
    {
        try {
            if ($request->input('pageSize') !== null) {
                $pageSize = $request->input('pageSize', 12);
                $batches = TrainingBatch::with('training', 'training.trainingTitle', 'trainingBatchSchedule')->paginate($pageSize);
            } else {
                $batches = TrainingBatch::all();
            }
            $user_id = Auth::user()->id;
            $role = Auth::user()->role->name;

            return response()->json([
                'success' => true,
                'error' => false,
                'data' => $batches,
                'user_id' => $user_id,
                'role' => $role,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function batchList(Request $request)
    {
        try {
            $user = auth()->user();
            $provider = Provider::first();
            if ($provider == null) {
                return response()->json([
                    'success' => false,
                    'message' => 'Provider not found',
                ]);
            }
            $batches = TrainingBatch::with('getTraining.title', 'schedule')
                ->whereNotNull('startDate')
                ->where('provider_id', $provider->id)
                ->whereHas('providerTrainers')
                ->paginate(15);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'error' => true,
                'message' => $th->getMessage(),
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => $batches,
        ]);
    }

    public function show($id)
    {
        try {
            $user = auth()->user();
            $provider = Provider::first();
            if ($provider == null) {
                return response()->json([
                    'success' => false,
                    'message' => 'Provider not found',
                ]);
            }
            $batch = TrainingBatch::with('getTraining.title', 'schedule')
                ->whereNotNull('startDate')
                ->where('provider_id', $provider->id)
                ->whereHas('providerTrainers')
                ->where('id', $id)
                ->first();
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'error' => true,
                'message' => $th->getMessage(),
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => $batch,
        ]);
    }
}
