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

    public function document(Request $request){
        $cv = Cv::findOrFail($request->post('id'));
        $word = new PhpWord();

//        dd($cv->getAttributes());
        $section = $word->addSection();
        foreach($cv->getAttributes() as $attribute => $value){
            $text = $section->addText(
                trans('cv.'.$attribute) .'
                '.
                $value
            );
        }


        $objWriter = IOFactory::createWriter($word, 'Word2007');
        return $objWriter->save(public_path('cv/helloWorld.docx'));
    }

}
