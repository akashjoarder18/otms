<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;
use App\Models\Permissions;
use App\Models\Role;
use App\Repositories\Interfaces\PermissionRepositoryInterface;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use App\Traits\UtilityTrait;

class PermissionController extends Controller
{
   
    /*
     * Handle Bridge Between Database and Business layer
     */
    use UtilityTrait;
    private $permissionRepository;
    public function __construct(PermissionRepositoryInterface $permissionRepository)
    {
        $this->middleware('auth.jwt');
        $this->permissionRepository = $permissionRepository;
    }

    /**
     * Display all permissions
     *
     * @return Json Response
     */
    public function index()
    {
        try {
            $permissions = $this->permissionRepository->all();
            return response()->json([
                'success' => true,
                'data' => $permissions,
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
    public function show(Permission $permission)
    {
        try {
            $permission = $this->permissionRepository->details($permission->id);
            return response()->json([
                'success' => true,
                'data' => $permission,
            ]);
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function permissions(){

        try {
            $user = auth()->user();
            $userType = $this->authUser($user->email);
            //$permission = $this->permissionRepository->details($permission->id);
            if (!is_null($user)) {
                $permissions = Role::select('permissions.*')
                    ->join('role_has_permissions', 'role_has_permissions.role_id', '=', 'roles.id')
                    ->join('permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                    ->where('roles.id', '=', $userType->role->id)
                    ->get();
    
                $route_permissions = $permissions->pluck('name')->toArray();
            }
            return response()->json([
                'success' => true,
                'data' => $route_permissions,
            ]);
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
        /*$route_permissions = null;
        $role = User::select('roles.id as roleID', 'roles.name as roleName')
            ->join('model_has_roles', 'model_has_roles.model_id', '=', 'users.user_id')
            ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->where('users.user_id', '=', $user->user_id)
            ->first();

        if (!is_null($role)) {
            $permissions = Role::select('permissions.*')
                ->join('role_has_permissions', 'role_has_permissions.role_id', '=', 'roles.id')
                ->join('permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                ->where('roles.id', '=', $role->roleID)
                ->get();

            $route_permissions = $permissions->pluck('name')->toArray();
        }*/
    }
     /**
     * Handle Course Provider Edit request
     *
     * @param Provider $provider
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission)
    {
        try {
            $permission = $this->permissionRepository->find($permission->id);            
            return response()->json([
                'success' => true,
                'data' => $permission,
            ]);
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Handle Course Provider request
     *
     * @param StoreProviderRequest $request
     *
     * @return Json Response
     */
    public function store(StorePermissionRequest $storeRequest)
    {
        try {
            $data = $storeRequest->all();
            $permissions = $this->permissionRepository->store($data);
            return response()->json([
                'success' => true,
                'message' => 'Permission access created successfully',
            ]);
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Update Permission data
     *
     * @param Permission $permission
     * @param UpdateProviderRequest $request
     *
     * @return json Response
     */
    public function update(Provider $provider, UpdateProviderRequest $request)
    {
        try {            
            $data = $request->all();
            $this->providerRepository->update($provider, $data);
            return response()->json([
                'success' => true,
                'data' => $provider->name,
                'message' => __('provider-list.provider_updated'),
            ]);
        } catch (JWTException $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Delete Provider data
     *
     * @param Provider $provider
     *
     * @return json Response
     */
    public function destroy(Provider $provider)
    {
        try {
            $provider->delete();
            return response()->json([
                'success' => true,
                'message' => __('provider-list.provider_deleted'),
            ]);
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
