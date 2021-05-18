<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Http\Controllers\UserManagementController;

class ProfileController extends Controller
{
    
    public function index()
    {
        return view('modules.profile.index');
    }

    public function updateAvatar(Request $req)
    {
        $req->validate([
            'avatar' => 'required',
            'user_id' => 'required'
        ]);

        $avatar = $req->file('avatar');
        $avatarNewName = $req->user_id . strtotime(now()) . '.' . $avatar->getClientOriginalExtension();
        $avatar->move('uploads', $avatarNewName);

        $avatarPath = 'uploads/' . $avatarNewName;
        $update = User::where('id', $req->user_id)->update([
            'profile_picture' => $avatarPath,
            'updated_at' => now()
        ]);

        return response([
            'status' => $update
        ]);
    }

    public function updateEmail(Request $req)
    {
        $req->validate([
            'email' => 'required',
            'user_id' => 'required'
        ]);

        $param = new Request();
        $param['email'] = $req->email;
        $param['exception'] = Auth::user()->email;

        $userManagement = new UserManagementController();

        $verifyEmail = $userManagement->verifyEmail($param);
        $verificationStatus = $verifyEmail->original['status'];
        if (!$verificationStatus) return response([
            'status' => false,
            'msg' => 'EMAIL_IS_NOT_AVAILABLE'
        ]);

        $update = User::where('id', $req->user_id)->update([
            'email' => $req->email
        ]);

        return response([
            'status' => $update,
            'msg' => $update ? 'SUCCESS' : 'FAILED'
        ]);
    }

    public function updateName(Request $req)
    {
        $req->validate([
            'name' => 'required',
            'user_id' => 'required'
        ]);

        $update = User::where('id', $req->user_id)->update([
            'name' => $req->name
        ]);

        return response([
            'status' => $update
        ]);
    }

    public function updatePassword(Request $req)
    {
        $req->validate([
            'password' => 'required',
            'user_id' => 'required'
        ]);

        $update = User::where('id', $req->user_id)->update([
            'password' => bcrypt($req->password)
        ]);

        return response([
            'status' => $update
        ]);
    }
}
