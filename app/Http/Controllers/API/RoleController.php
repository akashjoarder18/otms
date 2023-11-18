<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Models\Role;
use App\Repositories\Interfaces\PermissionRepositoryInterface;
use App\Repositories\Interfaces\RoleHasPermissionRepositoryInterface;
use App\Repositories\Interfaces\RoleRepositoryInterface;
use Tymon\JWTAuth\Exceptions\JWTException;

class RoleController extends Controller
{
    /*
     * Handle Bridge Between Database and Business layer
     */
    private $roleRepository;
    private $permissionRepository;
    private $roleHasPermissionRepository;
    public function __construct(RoleRepositoryInterface $roleRepository, PermissionRepositoryInterface $permissionRepository, RoleHasPermissionRepositoryInterface $roleHasPermissionRepository)
    {
        $this->middleware('auth.jwt');
        $this->roleRepository = $roleRepository;
        $this->permissionRepository = $permissionRepository;
        $this->roleHasPermissionRepository = $roleHasPermissionRepository;
    }

    /**
     * Display all Role
     *
     * @return Json Response
     */
    public function index()
    {
        try {
            $roles = $this->roleRepository->all();
            return response()->json([
                'success' => true,
                'data' => $roles,
            ]);
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }

    }

    /**
     * Handle user role request
     *
     * @param roleRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function create(StoreRoleRequest $roleRequest)
    {
        try {
            $data = $roleRequest->all();
            $permissions = $this->roleRepository->store($data, $roleRequest);
            return response()->json([
                'success' => true,
                'message' => __('Role created successfully done.'),
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Handle Role Edit request
     *
     * @param Role $provider
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        try {
            $role = $this->roleRepository->details($role->id);
            $rolePermissions = $role->permissions->pluck('name')->toArray();

            $permissions = $this->permissionRepository->all();
            return response()->json([
                'success' => true,
                'data' => $role,
                'permissions' => $permissions,
                'rolePermissions' => $rolePermissions,
            ]);
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Role $tmsRole, UpdateRoleRequest $request)
    {
        

        try {
            $data = $request->all();
            $roleData = [
                'name' => $data['name']
            ];
            $this->roleRepository->update($tmsRole, $roleData);
            $this->roleHasPermissionRepository->store($tmsRole->id, $data['accessPermissionIds']);
            return response()->json([
                'success' => true,
                'message' => 'Role and permission updated succefully',
            ]);
        } catch (JWTException $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }

    }
}
