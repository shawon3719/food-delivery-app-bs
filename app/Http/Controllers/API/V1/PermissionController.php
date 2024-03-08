<?php

namespace App\Http\Controllers\API\V1;

use App\Data\StatusCode;
use App\Http\Controllers\Controller;
use App\Http\Resources\Permission\PermissionResource;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Illuminate\Validation\ValidationException;

class PermissionController extends Controller
{
    public function store(Request $request)
    {
        $data = [];
        try {
            $request->validate([
                'name' => 'required|string',
            ]);

            $permission = Permission::create(['name' => $request->name]);
            $data['permission'] = new PermissionResource($permission);
            return response($data, StatusCode::HTTP_OK);

        }catch (\Exception $e) {
            if ($e instanceof ValidationException) {
                $data['message'] = $e->validator->errors()->first();
                return response()->json($data, StatusCode::HTTP_UNPROCESSABLE_ENTITY);
            }

            $data['message'] = $e->getMessage();
            return response()->json($data, StatusCode::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function update(Request $request, Permission $permission)
    {
        $data = [];

        try {
            $request->validate([
                'name' => 'required|string',
            ]);

            $permission->update(['name' => $request->name]);
            $data['permission'] = new PermissionResource($permission);
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
}
