<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class AdminUsersController extends Controller{

    public function index(Request $request){
        $users = User::with('cv');
        if($request->input('q')) $users->where('name', 'like', '%'.$request->input('q').'%')
            ->orWhere('email', 'like', '%'.$request->input('q').'%');
        return view('admin.users.index', [
            'users' => $users->orderBy('created_at', 'desc')->get()
        ]);
    }

    public function destroy(User $user){
        if($user->image){
            // delete image
            $path = public_path('images/users/').$user->image;
            if(file_exists($path) && is_file($path)){
                unlink($path);
            }
        }
        return $user->delete() ?
            redirect()->route('users.index')->with(['success' => trans('user.user_deleted')]) :
            redirect()->back()->withErrors([trans('alert.error')]);
    }

}
