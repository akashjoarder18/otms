<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Repositories\FinalSelectionRepository;
use App\Repositories\PreliminarySelectionRepository;
use App\Repositories\UserDetailRepository;
use App\Repositories\UserRepository;
use App\Traits\UtilityTrait;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;

class PreliminarySelectionController extends Controller
{
    use UtilityTrait;
    /*
     * Handle Bridge Between Database and Business layer
     */
    private $userRepository, $userDetailRepository, $preliminarySelectionRepository, $finalSelectionRepository;
    public function __construct(
        UserRepository $userRepository,
        UserDetailRepository $userDetailRepository,
        PreliminarySelectionRepository $preliminarySelectionRepository,
        FinalSelectionRepository $finalSelectionRepository
    ) {
        $this->middleware('auth.jwt');
        $this->userRepository = $userRepository;
        $this->userDetailRepository = $userDetailRepository;
        $this->preliminarySelectionRepository = $preliminarySelectionRepository;
        $this->finalSelectionRepository = $finalSelectionRepository;
    }

    /**
     * 
     * All preliminary selected Users 
     * 
     */
    public function index(Request $request)
    {
        try {
            $preliminary_users = $this->preliminarySelectionRepository->all();

            // add selection status
            $pre_selections_with_status = $this->selectionStatusAddPre($preliminary_users);

            return response()->json([
                'success' => true,
                'error' => false,
                'data' => $pre_selections_with_status
            ]);
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function final_select(Request $request)
    {
        try {
            $all_selected_users = $request->input('selectedUserIds');
            $auth_id = auth()->id();

            $select_result = $this->finalSelectionRepository->store($all_selected_users, $auth_id);


            return response([
                'success' => true,
                'error' => false
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => true,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
