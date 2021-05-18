<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class UserController extends Controller
{
    public function userList()
    {
        $users = User::leftJoin('role','users.role_id','role.id')
                ->select([
                    'users.*',
                    'role.name as role_name'
                ])
                ->get();
        
        $data = [];
        if (count($users) > 0) {
            foreach ($users as $usrs) {
                $btn = '<a href="'. url("admin/user-management/edit", base64_encode($usrs->id)) .'" class="btn btn-white">
                    Edit
                </a>
                <a href="#" onclick="deleteConfirm(\''. $usrs->id .'\',\''. $usrs->name .'\')" class="btn btn-white confirm-delete-btn" data-toggle="modal" data-target="#confirm-delete-prompt">
                    Delete
                </a>';

                $data[] = [
                    'id' => $usrs->id,
                    'name' => $usrs->name,
                    'email' => $usrs->email,
                    'role_name' => $usrs->role_name,
                    'created_at' => datetimeIdFormat($usrs->created_at),
                    'action_btn' => $btn
                ];
            }
        }

        return response([
            'data' => $data
        ]);
    }
}
