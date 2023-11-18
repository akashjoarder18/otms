<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDivisionRequest;
use App\Http\Requests\UpdateDivisionRequest;
use App\Models\Division;
use App\Repositories\Interfaces\DivisionRepositoryInterface;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class DivisionController extends Controller
{

    /*
     * Handle Bridge Between Database and Business layer
     */
    private $divisionRepository;
    public function __construct(DivisionRepositoryInterface $divisionRepository)
    {
        $this->middleware('auth.jwt');
        $this->divisionRepository = $divisionRepository;
    }

    /**
     * Display all divisions
     *
     * @return Json Response
     */
    public function index()
    {
        try {

            $divisions = $this->divisionRepository->all();
            return response()->json([
                'success' => true,
                'data' => $divisions,
            ]);
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
    /**
     * Handle Course Division details
     * 
     * @param Division $division
     * 
     * @return Json Response
     */
    public function show(Division $division)
    {
        try {
            $division = $this->divisionRepository->details($division->id);
            return response()->json([
                'success' => true,
                'data' => $division,
            ]);
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
    /**
     * Handle Course Division Edit request
     *
     * @param Division $division
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Division $division)
    {
        try {
            $division = $this->divisionRepository->find($division->id);
            return response()->json([
                'success' => true,
                'data' => $division,
            ]);
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
    /**
     * Handle Course Division request
     *
     * @param StoreDivisionRequest $request
     *
     * @return Json Response
     */
    public function store(StoreDivisionRequest $storeRequest)
    {
        try {
            $data = $storeRequest->all();
            $divisions = $this->divisionRepository->store($data);
            return response()->json([
                'success' => true,
                'message' => 'Division Created Successfully',
            ]);
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Update Division data
     *
     * @param Division $division
     * @param UpdateDivisionRequest $request
     *
     * @return json Response
     */
    public function update(Division $division, UpdateDivisionRequest $request)
    {
        try {
            $data = $request->all();
            $this->divisionRepository->update($division, $data);
            return response()->json([
                'success' => true,
                'data' => $division->name,
                'message' => 'Division Updated Successfully',
            ]);
        } catch (JWTException $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Delete Division data
     *
     * @param Division $division
     *
     * @return json Response
     */
    public function destroy(Division $division)
    {
        try {
            $division->delete();
            return response()->json([
                'success' => true,
                'message' => 'Division Deleted Successfully',
            ]);
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
