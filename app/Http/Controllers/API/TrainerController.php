<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserType;
use App\Models\ProvidersTrainer;
use App\Http\Requests\TrainerBatchesRequest;
use App\Models\TrainerProfile;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Traits\UtilityTrait;

class TrainerController extends Controller
{
    use UtilityTrait;
    public function index(Request $request)
    {
        try {
            $user = auth()->user();
            $userType = $this->authUser($user->email);

            $trainers = UserType::with('profile','role')->where('provider_id',$userType->provider_id)->whereHas('role', function ($query) {
                $query->where('name', '=', 'trainer')
                    ->orWhere('name', '=', 'Trainer');
            })->get();

            return response()->json([
                'success' => true,
                'error' => false,
                'data' => $trainers
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function store(TrainerBatchesRequest $request)
    {
        try {
            $data = $request->all();
            $batch_id = $data['batch_id'];
            $provider_id = $data['provider_id'];
            $trainer_ids_string = $data['trainer_ids'];

            $numberStrings = explode(",", $trainer_ids_string);

            // Initialize an empty array to store the integers
            $trainer_ids_array = [];

            // Convert the string elements to integers
            foreach ($numberStrings as $numberString) {
                $trainer_ids_array[] = (int) $numberString;
            }

            foreach ($trainer_ids_array as $key => $trainer_id) {
                $trainer_batch = ProvidersTrainer::where('ProfileId', $trainer_id)->where('provider_id', $provider_id)->where('batch_id', $batch_id)->first();
                if ($trainer_batch) {
                    continue;
                } else {
                    ProvidersTrainer::create([
                        'provider_id' => $provider_id,
                        'batch_id' => $batch_id,
                        'ProfileId' => $trainer_id,
                    ]);
                }
            }

            return response()->json([
                'success' => true,
                'error' => false,
                'message' =>  __('trainer.trainer_link_batch_success'),
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
