<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\TrainerEnrollRepositoryInterface;
use App\Models\ProvidersTrainer;

class TrainerEnrollController extends Controller
{
    /*
     * Handle Bridge Between Database and Business layer
     */
    private $trainerEnrollRepository;
    public function __construct(TrainerEnrollRepositoryInterface $trainerEnrollRepository)
    {
        $this->middleware('auth.jwt');
        $this->trainerEnrollRepository = $trainerEnrollRepository;
    }
    //
    public function index()
    {
        try {
            $trainerEnroll = $this->trainerEnrollRepository->all();
            return response()->json([
                'success' => true,
                'data' => $trainerEnroll,
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
    public function show(ProvidersTrainer $tmsProvidersTrainer)
    {
        try {
            $trainerEnroll = $this->trainerEnrollRepository->details($tmsProvidersTrainer->id);
            return response()->json([
                'success' => true,
                'data' => $trainerEnroll,
            ]);
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
