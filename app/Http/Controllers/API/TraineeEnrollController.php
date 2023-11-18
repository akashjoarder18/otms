<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\TraineeEnrollRepositoryInterface;
use App\Models\TrainingApplicant;

class TraineeEnrollController extends Controller
{
    /*
     * Handle Bridge Between Database and Business layer
     */
    private $traineeEnrollRepository;
    public function __construct(TraineeEnrollRepositoryInterface $traineeEnrollRepository)
    {
        $this->middleware('auth.jwt');
        $this->traineeEnrollRepository = $traineeEnrollRepository;
    }
    //
    public function index()
    {
        try {
            $traineeEnroll = $this->traineeEnrollRepository->all();
            return response()->json([
                'success' => true,
                'data' => $traineeEnroll,
            ]);
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Handle Course Provider details
     * 
     * @param Provider $provider
     * 
     * @return Json Response
     */
    public function show(TrainingApplicant $trainingApplicant)
    {
        try {
            $traineeEnroll = $this->traineeEnrollRepository->details($trainingApplicant->id);
            return response()->json([
                'success' => true,
                'data' => $traineeEnroll,
            ]);
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
