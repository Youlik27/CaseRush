<?php

namespace App\Http\Controllers;

use App\Models\CS_Case;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
    public function getInfo(){
        $cases = CS_Case::all();
        return view('cases_content',  compact('cases'));
    }
    public function validation(){
        $validatedData = request()->validate([
            'name' => 'required|max:255',
            'email' => 'required|email',
            'password' => '<PASSWORD>',
        ]);
    }
}
