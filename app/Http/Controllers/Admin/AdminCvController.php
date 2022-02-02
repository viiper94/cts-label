<?php

namespace App\Http\Controllers\Admin;

use App\Cv;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;

class AdminCvController extends Controller{

    public function index(){
        return view('admin.cv.index', [
            'cv_list' => Cv::with('user')->get()
        ]);
    }

    public function edit(Request $request, $id){
        return view('admin.cv.edit', [
            'cv' => Cv::with('user')->findOrFail($id)
        ]);
    }

}
