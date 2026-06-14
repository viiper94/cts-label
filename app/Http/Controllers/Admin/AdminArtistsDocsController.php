<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ArtistDoc;

class AdminArtistsDocsController extends Controller
{

    public function index()
    {
        $docs = ArtistDoc::with('artist', 'tracks')->get();
        return view('admin.artists.docs.index', compact('docs'));
    }

    public function create()
    {
        return view('admin.artists.docs.create');
    }

}
