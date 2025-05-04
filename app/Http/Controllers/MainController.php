<?php

namespace App\Http\Controllers;

use App\Models\CaseModel;
use App\Models\CS_Case;
use App\Models\Section;
use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    class MainController extends Controller
        {
            public function generateView(){
                $section = Section::orderBy('order_number')->get();
                $cases = CaseModel::orderBy('order_number')->get();
                return view('cases_content', compact('section', 'cases'));
    }
}
