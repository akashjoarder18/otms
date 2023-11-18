<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class CategoryController extends Controller
{
   
    /*
     * Handle Bridge Between Database and Business layer
     */
    private $categoryRepository;
    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->middleware('auth.jwt');
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Display all categories
     *
     * @return Json Response
     */
    public function index()
    {
        try {
            $categories = $this->categoryRepository->all();
            return response()->json([
                'success' => true,
                'data' => $categories,
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
     * 
     * @param Category $category
     * 
     * @return Json Response
     */
    public function show(Category $category)
    {
        try {
            $category = $this->categoryRepository->details($category->id);
            return response()->json([
                'success' => true,
                'data' => $category,
            ]);
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
     /**
     * Handle Course Category Edit request
     *
     * @param Category $category
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        try {
            $category = $this->categoryRepository->find($category->id);            
            return response()->json([
                'success' => true,
                'data' => $category,
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
     * @param StoreCategoryRequest $request
     *
     * @return Json Response
     */
    public function store(StoreCategoryRequest $request)
    {
        try {
            $data = $request->all();
            $categories = $this->categoryRepository->store($data);
            return response()->json([
                'success' => true,
                'message' => __('categorie-list.category_create'),
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
     * @param Category $category
     * @param UpdateCategoryRequest $request
     *
     * @return json Response
     */
    public function update(Category $category, UpdateCategoryRequest $request)
    {
        try {            
            $data = $request->all();
            $this->categoryRepository->update($category, $data);
            return response()->json([
                'success' => true,
                'data' => $category->name,
                'message' =>  __('categorie-list.category_update'),
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
     * @param Category $category
     *
     * @return json Response
     */
    public function destroy(Category $category)
    {
        try {
            $category->delete();
            return response()->json([
                'success' => true,
                'message' =>  __('categorie-list.category_delete'),
            ]);
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
