<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\SubCategoryRepositoryInterface;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Requests\StoreSubCategoryRequest;
use App\Http\Requests\UpdateSubCategoryRequest;
use App\Models\SubCategory;
use Symfony\Component\HttpFoundation\Response;

class SubCategoryController extends Controller
{
    /*
     * Handle Bridge Between Database and Business layer
     */
    private $subCategoryRepository;
    private $categoryRepository;
    public function __construct(SubCategoryRepositoryInterface $subCategoryRepository, CategoryRepositoryInterface $categoryRepository)
    {
        $this->middleware('auth.jwt');
        $this->categoryRepository = $categoryRepository;
        $this->subCategoryRepository = $subCategoryRepository;
    }

    /**
     * Display all sub categories
     *
     * @return Json Response
     */
    public function index($id = null)
    {
        try {
            if($id) {
                $subCategories = $this->subCategoryRepository->all($id);
            } else {
                $subCategories = $this->subCategoryRepository->all();
            }

            return response()->json([
                'success' => true,
                'data' => $subCategories,
            ]);
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
    /**
     * Handle Course Category details
     * @return Json Response
     */
    public function show(SubCategory $subCategory)
    {
        try {
            $subCategory = $this->subCategoryRepository->details($subCategory->id);
            return response()->json([
                'success' => true,
                'data' => $subCategory,
            ]);
        } catch (JWTException $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
    /**
     * Handle Course Category request
     *
     * @param StoreSubCategoryRequest $request
     *
     * @return Json Response
     */
    public function store(StoreSubCategoryRequest $request)
    {
        try {
            $data = $request->all();
            $subCategories = $this->subCategoryRepository->store($data);
            return response()->json([
                'success' => true,
                'message' =>  __('sub-categorie-list.sub_category_create'),
            ]);
        } catch (JWTException $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

     /**
     * Handle Course Sub Category Edit request
     *
     * @param subCategory $subcategory
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(SubCategory $subCategory)
    {
        try {
            $categories = $this->categoryRepository->all();
            $data = [
                'subcategory' => $subCategory,
                'categories' => $categories,
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
     * Update Category data
     *
     * @param SubCategory $category
     * @param UpdateSubCategoryRequest $request
     *
     * @return json Response
     */
    public function update(SubCategory $subCategory, UpdateSubCategoryRequest $request)
    {

        try {
            $data = $request->all();
            $this->subCategoryRepository->update($subCategory, $data);
            return response()->json([
                'success' => true,
                'data' => $subCategory->name,
                'message' => __('sub-categorie-list.sub_category_update'),
            ]);
        } catch (JWTException $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Delete Category data
     *
     * @param SubCategory $category
     *
     * @return json Response
     */
    public function destroy(SubCategory $subCategory)
    {
        try {
            $subCategory->delete();
            return response()->json([
                'success' => true,
                'message' => __('sub-categorie-list.sub_category_delete'),
            ]);
        } catch (JWTException $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
