<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\UpazilaRepositoryInterface;
use App\Repositories\Interfaces\DistrictRepositoryInterface;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Requests\StoreUpazilaRequest;
use App\Http\Requests\UpdateUpazilaRequest;
use App\Models\Upazila;
use Symfony\Component\HttpFoundation\Response;

class UpazilaController extends Controller
{
    /*
     * Handle Bridge Between Database and Business layer
     */
    private $upazilaRepository;
    private $districtRepository;
    public function __construct(UpazilaRepositoryInterface $upazilaRepository, DistrictRepositoryInterface $districtRepository)
    {
        $this->middleware('auth.jwt');
        $this->districtRepository = $districtRepository;
        $this->upazilaRepository = $upazilaRepository;
    }

    /**
     * Display all Upazila
     *
     * @return Json Response
     */

     
    public function index($code = null)
    {
        try {
            if ($code) {
                $upazilas = $this->upazilaRepository->all($code);
            } else {
                $upazilas = $this->upazilaRepository->all();
            }

            return response()->json([
                'success' => true,
                'data' => $upazilas,
            ]);
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
    /**
     * Handle Course Upazila details
     * @return Json Response
     */
    public function show(Upazila $upazila)
    {
        try {
            $upazila = $this->upazilaRepository->details($upazila->id);
            return response()->json([
                'success' => true,
                'data' => $upazila,
            ]);
        } catch (JWTException $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
    /**
     * Handle Course Upazila request
     *
     * @param StoreUpazilaRequest $request
     *
     * @return Json Response
     */
    public function store(StoreUpazilaRequest $request)
    {
        try {
            $data = $request->all();
            $upazilas = $this->upazilaRepository->store($data);
            return response()->json([
                'success' => true,
                'message' => 'Upazila Created Successfully',
            ]);
        } catch (JWTException $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Handle Course Upazila Edit request
     *
     * @param Upazila $upazila
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Upazila $upazila)
    {
        try {
            $districts = $this->districtRepository->all();
            $data = [
                'upazila' => $upazila,
                'districts' => $districts,
            ];
            return response()->json([
                'success' => true,
                'data' => $data,
            ]);
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Update Upazila data
     *
     * @param Upazila $upazila
     * @param UpdateUpazilaRequest $request
     *
     * @return json Response
     */
    public function update(Upazila $upazila, UpdateUpazilaRequest $request)
    {

        try {
            $data = $request->all();
            $this->upazilaRepository->update($upazila, $data);
            return response()->json([
                'success' => true,
                'data' => $upazila->name,
                'message' => 'Upazila Updated Successfully',
            ]);
        } catch (JWTException $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Delete Upazila data
     *
     * @param Upazila $upazila
     *
     * @return json Response
     */
    public function destroy(Upazila $upazila)
    {
        try {
            $upazila->delete();
            return response()->json([
                'success' => true,
                'message' => 'Upazila Deleted Successfully',
            ]);
        } catch (JWTException $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
