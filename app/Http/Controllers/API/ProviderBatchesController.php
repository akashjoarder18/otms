<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProviderBatchesRequest;
use App\Models\TrainingBatch;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;

class ProviderBatchesController extends Controller
{
    //
    public function store(ProviderBatchesRequest $request)
    {
        try {
            $data = $request->all();
            $provider_id = $data['provider_id'];
            $batch_ids_string = $data['batch_ids'];
            $numberStrings = explode(",", $batch_ids_string);

            // Initialize an empty array to store the integers
            $batch_ids_array = [];

            // Convert the string elements to integers
            foreach ($numberStrings as $numberString) {
                $batch_ids_array[] = (int) $numberString;
            }

            foreach ($batch_ids_array as $key => $batch_id) {
                $training_batch = TrainingBatch::find($batch_id);
                if ($training_batch->provider_id) {
                    return response()->json([
                        'success' => false,
                        'error' => true,
                        'message' => 'already has link with batches',
                    ]);
                } else {
                    $training_batch->provider_id = $provider_id;
                    $training_batch->save();
                }
            }

            return response()->json([
                'success' => true,
                'error' => false,
                'message' => 'Provider Linked With Batches Successfully',
            ]);
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'error' => true,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
