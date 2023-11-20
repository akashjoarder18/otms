<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\DevelopmentPartner;
use App\Models\Provider;
use App\Models\TrainingBatch;
use App\Models\UserType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\UtilityTrait;

class BatchController extends Controller
{
    use UtilityTrait;
    //
    public function index(Request $request)
    {
        try {
            $user = auth()->user();
            $userType = $this->authUser($user->email);
            

            $provider_id = $userType['provider_id'];

            if ($request->input('pageSize') !== null) {
                $pageSize = $request->input('pageSize', 12);
                $batches = TrainingBatch::with('training', 'training.trainingTitle', 'trainingBatchSchedule')->where('provider_id', $provider_id)->paginate($pageSize);
            } else {
                $batches = TrainingBatch::where('provider_id', $provider_id)->get();
            }
            $user_id = Auth::user()->id;
            $role = $userType->role->name;
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
