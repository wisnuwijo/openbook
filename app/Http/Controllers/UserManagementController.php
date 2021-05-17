<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Model\Role;
use App\Model\Permission;
use App\Model\RoleHasPermission;
use Auth;

class UserManagementController extends Controller
{
    public function managePermission()
    {
        $role = Role::get();
        $permission = Permission::get();

        $data = [
            'role' => $role,
            'permission' => $permission
        ];

        return view('modules.user-management.managePermission', $data);
    }

    public function getPermission($roleId)
    {
        $permission = RoleHasPermission::where('role_id', $roleId)
                      ->leftJoin('permission','role_has_permission.permission_id','permission.id')
                      ->get();

        return response($permission);
    }

    public function updatePermission(Request $req)
    {
        $validator = $req->validate([
            'permission_id' => 'required',
            'role_id' => 'required',
            'action' => 'required'
        ]);

        $permissionId = $req->permission_id;
        $roleId = $req->role_id;
        $action = $req->action;

        $addPermission = $action == 1;
        $removePermission = $action == 0;

        // prevent duplication
        $remove = RoleHasPermission::where([
                    ['role_id', $roleId],
                    ['permission_id', $permissionId]
                ])
                ->delete();

        if ($removePermission) {
            return response([
                'status' => $remove
            ]);
        }

        if ($addPermission) {
            $add = RoleHasPermission::insert([
                'role_id' => $roleId,
                'permission_id' => $permissionId,
                'created_at' => now()
            ]);

            return response([
                'status' => $add
            ]);
        }
    }

    public function viewUserList(Request $req)
    {
        return view('modules.user-management.viewUserList');
    }

    public function create()
    {
        $role = Role::get();
        $data = [
            'role' => $role
        ];

        return view('modules.user-management.create', $data);
    }

    public function verifyEmail(Request $req)
    {
        $req->validate([
            'email' => 'required'
        ]);

        $whereFilter = [
            ['email', $req->email]
        ];

        if (isset($req->exception)) {
            $whereFilter = [
                ['email', $req->email],
                ['email','!=', $req->exception]
            ];
        }

        $verify = User::where($whereFilter)->first();

        if (isset($verify)) return response([
            'status' => false,
            'msg' => 'email is taken'
        ]);

        return response([
            'status' => true,
            'msg' => 'email available'
        ]);
    }

    public function storeUser(Request $req)
    {
        $reqArr = [
            'role_id' => 'required',
            'name' => 'required',
            'email' => 'required',
            'password' => 'required'
        ];
        
        $validator = $req->validate($reqArr);
        
        $newUser = $req->only([
            'role_id',
            'name',
            'email',
            'password',
            'created_at'
        ]);
        $newUser['password'] = bcrypt($req->password);
        $newUser['created_at'] = now();

        $store = User::insert($newUser);

        if ($store) {
            return redirect('/admin/user-management/view-user-list')->with([
                'status-title' => 'Success',
                'status-subtitle' => 'New user successfully added!'
            ]);
        }

        return redirect()->back()->with([
            'status-title' => 'Failed',
            'status-subtitle' => 'Failed! Something went wrong'
        ]);
    }

    public function edit($userId)
    {
        $userId = base64_decode($userId);
        
        $user = User::find($userId);
        $role = Role::get();

        $data = [
            'user' => $user,
            'role' => $role
        ];
        
        return view('modules.user-management.edit', $data);
    }

    public function updateUser(Request $req, $userId)
    {
        $req->validate([
            'name' => 'required',
            'email' => 'required',
            'role_id' => 'required'
        ]);

        if (isset($req->password)) {
            $req['password'] = bcrypt($req->password);
            $newUserData = $req->only([
                'name',
                'email',
                'role_id',
                'password'
            ]);
        } else {
            $newUserData = $req->only([
                'name',
                'email',
                'role_id'
            ]);
        }

        $userId = base64_decode($userId);

        $update = User::where('id', $userId)->update($newUserData);
        if ($update) {
            return redirect('/admin/user-management/view-user-list')->with([
                'status-title' => 'Success',
                'status-subtitle' => 'User successfully updated!'
            ]);
        }

        return redirect()->back()->with([
            'status-title' => 'Failed',
            'status-subtitle' => 'Failed! Something went wrong'
        ]);
    }

    public function deleteUser($userId)
    {
        $delete = User::find($userId)->delete();

        return response([
            'status' => $delete
        ]);
    }
}
