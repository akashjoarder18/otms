<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\DistrictRepositoryInterface;
use App\Repositories\Interfaces\DivisionRepositoryInterface;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Requests\StoreDistrictRequest;
use App\Http\Requests\UpdateDistrictRequest;
use App\Models\District;
use Symfony\Component\HttpFoundation\Response;

class DistrictController extends Controller
{
    /*
     * Handle Bridge Between Database and Business layer
     */
    private $districtRepository;
    private $divisionRepository;
    public function __construct(DistrictRepositoryInterface $districtRepository, DivisionRepositoryInterface $divisionRepository)
    {
        $this->middleware('auth.jwt');
        $this->districtRepository = $districtRepository;
        $this->divisionRepository = $divisionRepository;
    }

    /**
     * Display all district
     *
     * @return Json Response
     */
    public function index($division_code = null)
    {
        try {
            if ($division_code) {
                $district = $this->districtRepository->all($division_code);
            } else {
                $district = $this->districtRepository->all();
            }

            return response()->json([
                'success' => true,
                'data' => $district,
            ]);
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
    /**
     * Handle Course District details
     * @return Json Response
     */
    public function show(District $district)
    {
        try {
            $district = $this->districtRepository->details($district->id);
            return response()->json([
                'success' => true,
                'data' => $district,
            ]);
        } catch (JWTException $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
    /**
     * Handle Course District request
     *
     * @param StoreDistrictRequest $request
     *
     * @return Json Response
     */
    public function store(StoreDistrictRequest $request)
    {
        try {
            $data = $request->all();
            $districts = $this->districtRepository->store($data);
            return response()->json([
                'success' => true,
                'message' => 'District Created Successfully',
            ]);
        } catch (JWTException $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Handle Course District Edit request
     *
     * @param District $district
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(District $district)
    {
        try {
            $divisions = $this->divisionRepository->all();
            $data = [
                'district' => $district,
                'divisions' => $divisions,
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
     * Update District data
     *
     * @param District $district
     * @param UpdateDistrictRequest $request
     *
     * @return json Response
     */
    public function update(District $district, UpdateDistrictRequest $request)
    {

        try {
            $data = $request->all();
            $this->districtRepository->update($district, $data);
            return response()->json([
                'success' => true,
                'data' => $district->name,
                'message' => 'District Updated Successfully',
            ]);
        } catch (JWTException $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Delete District data
     *
     * @param District $district
     *
     * @return json Response
     */
    public function destroy(District $district)
    {
        try {
            $district->delete();
            return response()->json([
                'success' => true,
                'message' => 'District Deleted Successfully',
            ]);
        } catch (JWTException $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
