<?php

namespace App\Http\Controllers\API\V1;

use App\Data\StatusCode;
use App\Http\Controllers\Controller;
use App\Http\Resources\Permission\PermissionCollection;
use App\Http\Resources\Role\RoleCollection;
use App\Http\Resources\Role\RoleResource;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = [];

        // $roles = Role::with('permissions')->orderBy('id', 'ASC')->get();

        // $response['users'] = new UserCollection($users);
        $response['roles'] = new RoleCollection(Role::all());
        $response['permissions'] = new PermissionCollection(Permission::all());
        return $response;
    }

    /**
     * Store the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = [];
        // return $request;
        try {

            $request->validate([
                'name'=>'string|required',
                'permissions'=>'required',
            ]);

            
            $userService = new UserService();

            if( Role::where('name', $request->name)->exists()){
                throw new \Exception('Role already exist');
            }

            $role = new Role();
            $role->name = $request['name'];
            // $role->created_by = Auth::user()->id;
            $role->save();

            $permissions = Permission::whereIn('id', $request['permissions'])->get();
            $role->syncPermissions($permissions);

            $data['role'] = new RoleResource($role);
            return response($data, StatusCode::HTTP_OK);

        } catch (\Exception $e) {
            if ($e instanceof ValidationException) {
                $data['message'] = $e->validator->errors()->first();
                return response()->json($data, StatusCode::HTTP_UNPROCESSABLE_ENTITY);
            }

            $data['message'] = $e->getMessage();
            return response()->json($data, StatusCode::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */


     public function update(Request $request, $id)
     {
         $data = [];
     
         try {
             $validator = Validator::make($request->all(), [
                 'name' => 'string|required',
                 'permissions' => 'required|array',
             ]);
     
             if ($validator->fails()) {
                 throw new \Exception($validator->errors()->first());
             }
     
             DB::beginTransaction();
     
             $role = Role::findOrFail($id);
             $role->name = $request->input('name');
             $role->save();
     
             $permissions = Permission::whereIn('id', $request->input('permissions'))->get();
             $role->syncPermissions($permissions);
     
             // Assign the updated permissions to users with this role
             $users = User::role($role->name)->get();
             foreach ($users as $user) {
                 $user->syncPermissions($permissions);
             }
     
             DB::commit();
     
             $data['role'] = new RoleResource($role);
             return response($data, StatusCode::HTTP_OK);
         } catch (ModelNotFoundException $e) {
             DB::rollBack();
             $data['message'] = 'Role not found';
             return response()->json($data, StatusCode::HTTP_NOT_FOUND);
         } catch (\Exception $e) {
             DB::rollBack();
             $data['message'] = $e->getMessage();
             return response()->json($data, StatusCode::HTTP_UNPROCESSABLE_ENTITY);
         }
     }


    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $response = [];
    
        try {
            $role = Role::findById($id);
    
            if (!$role) {
                throw new ModelNotFoundException('Role not found');
            }
    
            // Detach all permissions associated with the role
            $role->permissions()->detach();
    
            // Detach the role from all users
            $users = User::role($role->name)->get();
            foreach ($users as $user) {
                $user->removeRole($role->name);
            }
    
            // Delete the role
            $role->delete();
    
            $response['status'] = 'success';
            $response['message'] = 'Successfully removed';
        } catch (ModelNotFoundException $e) {
            $response['status'] = 'error';
            $response['message'] = 'Role not found';
        } catch (\Exception $e) {
            $response['status'] = 'error';
            $response['message'] = $e->getMessage();
        }
    
        return $response;
    }

   
}
