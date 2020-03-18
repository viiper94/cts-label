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

    public function delete(Request $request, $id){
        if($id){
            $user = User::find($id);
            if($user->image){
                // delete image
                $path = public_path('images/users/').$user->image;
                if(file_exists($path) && is_file($path)){
                    unlink($path);
                }
            }
            return $user->delete() ?
                redirect()->back()->with(['success' => 'Пользователь успешно удалён!']) :
                redirect()->back()->withErrors(['Возникла ошибка =(']);
        }else{
            return abort(404);
        }
    }

}
