<?php

namespace App\Http\Controllers\API\V1;

use App\Data\StatusCode;
// use App\Models\ActivityStatus;
// use App\Models\Badge;
// use App\Models\StarStatus;
use App\Http\Controllers\Controller;
// use App\Http\Resources\Badge\BadgeResource;
use App\Http\Resources\Role\RoleCollection;
use App\Http\Resources\User\UserCollection;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = [];

        $users = User::with('roles')->orderBy('id', 'ASC')->get();

        $response['users'] = new UserCollection($users);
        $response['roles'] = new RoleCollection(Role::all());

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
                'username' => [
                    'required',
                    Rule::unique('users'),
                ],
                'email' => [
                    'required',
                    Rule::unique('users'),
                ],
                'password' => 'required',
                'role' => 'required|numeric'
            ]);


            $userService = new UserService();
            $role = Role::find($request['role']);

            if(!$role){
                throw new \Exception('Role not found');
            }

            $user = new User();
            $user->name = $request['name'];
            $user->email = $request['email'];
            $user->password = $userService->generateUserHashPassword($request['password']);
            $user->created_by = Auth::user()->id;
            $user->save();
            $user->assignRole($role);

            $data['user'] = new UserResource($user);
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
        $response = [];

        try {

            $request->validate([
                'id' => 'required|numeric',
                'email' => [
                    'required',
                    Rule::unique('users')->ignore($id),
                ],
                'role' => 'required|numeric',
                'password' => 'nullable',
            ]);


            $userId = $request->id;
            $name = $request->name;
            $email = $request->email;
            $role = Role::find((int)$request['role']);
            $password = $request->password;

            $user = User::where('id', $userId)->firstOrFail();

            $user->name = $name;
            $user->email = $email;
            $user->updated_by = Auth::user()->id;

            if ($password && $password != '') {
                $userService = new UserService();
                $user->password = $userService->generateUserHashPassword($password);
            }

            // Update role
            if(!$role){
                throw new \Exception('Role not found');
            }
            if($role) {
                $user->save();
                $user->syncRoles($role);
            }

            $response['user'] = new UserResource($user);
            $response['status'] = 'success';
            $response['message'] = 'Successfully updated.';
            return response()->json($response, StatusCode::HTTP_OK);

        } catch (\Exception $e) {
            if ($e instanceof ValidationException) {
                $response['status'] = 'error';
                $response['message'] = $e->validator->errors()->first();
                return response()->json($response, StatusCode::HTTP_UNPROCESSABLE_ENTITY);
            }

            if ($e instanceof ModelNotFoundException) {
                $response['status'] = 'error';
                $response['message'] = 'User not found';
                return response()->json($response, StatusCode::HTTP_UNPROCESSABLE_ENTITY);
            }

            $response['status'] = 'error';
            $response['message'] = $e->getMessage();
            return response()->json($response, StatusCode::HTTP_UNPROCESSABLE_ENTITY);
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
        $user = User::find($id);
        if ($user) {
            $user->roles()->detach();
            if ($user->delete()) {
                $response['status'] = 'success';
                $response['message'] = 'Successfully removed';
            } else {
                $response['status'] = 'error';
                $response['message'] = 'Sorry, something went wrong.';
            }
        } else {
            $response['status'] = 'error';
            $response['message'] = 'This url is not found';
        }

        return $response;
    }


}
