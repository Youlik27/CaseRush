<?php

namespace App\Http\Controllers;

use App\Models\CaseItem;
use App\Models\Item;
use App\Models\Section;
use App\Models\User;
use App\Models\CaseModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ModeratorController extends Controller
{
    public function getInfo(){
        return Section::all();
    }
    public function createSection(Request $request){
        $this->getInfo();
        $section_name= $request->input('section_name');
        $this->sectionBD([
            'section_name' => $section_name,
        ]);
    return redirect()->route('case_content');
    }
    private function sectionBD(array $data)
    {
        $lastOrder = Section::orderBy('id_sections', 'desc')->first();
        $orderNumber = $lastOrder ? $lastOrder->order_number + 1 : 1;
        $section = Section::create([
            'section_name' => $data['section_name'],
            'order_number' => $orderNumber,
            'created_at' => now(),
            'updated_at' => now(),
            'created_by' => auth()->id(),
            'updated_by' => auth()->id(),
        ]);

    }
    public function changeName(Request $request){
        $section = Section::find($request->input('section_id'));
        $section->section_name = $request->input('section_name');
        $section->updated_by = auth()->id();
        $section->updated_at = now();
        $section->save();
        return redirect()->route('case_content');
    }
    public function deleteSection($section_id)
    {
        $section = Section::find($section_id);
        $section->delete();
        return redirect()->route('case_content');
    }
    public function moveUpSection($section_id)
    {
        $currentSection = Section::find($section_id);

        if (!$currentSection) {
            return redirect()->route('case_content')->with('error', 'Section not found.');
        }

        $previousSection = Section::where('order_number', '<', $currentSection->order_number)
            ->orderBy('order_number', 'desc')
            ->first();

        if ($previousSection) {
            $temp = $currentSection->order_number;
            $currentSection->order_number = $previousSection->order_number;
            $previousSection->order_number = $temp;

            $currentSection->save();
            $previousSection->save();
        }

        return redirect()->route('case_content');
    }

    public function moveDownSection($section_id)
    {
        $currentSection = Section::find($section_id);

        if (!$currentSection) {
            return redirect()->route('case_content')->with('error', 'Section not found.');
        }

        $nextSection = Section::where('order_number', '>', $currentSection->order_number)
            ->orderBy('order_number', 'asc')
            ->first();

        if ($nextSection) {
            $temp = $currentSection->order_number;
            $currentSection->order_number = $nextSection->order_number;
            $nextSection->order_number = $temp;

            $currentSection->save();
            $nextSection->save();
        }

        return redirect()->route('case_content');
    }
    public function generateViewCaseCreating(Request $request){
        $case = $this->createCase($request);
        $items = CaseItem::where('cases_id_case','=', $case->id_case);
        return view('case_creating', compact('case', 'items'));
    }

    public function createCase(Request $request)
    {
        $id = $request->input('id_section');
        $lastOrder = CaseModel::orderBy('id_case', 'desc')->first();
        $orderNumber = $lastOrder ? $lastOrder->order_number + 1 : 1;
        $case = CaseModel::create([
            'name' => '23123213',
            'price' => 2323,
            'description' => 'description',
            'image_url' => 'case.png',
            'order_number' => $orderNumber,
            'created_by' => auth()->id(),
            'updated_by' => auth()->id(),
            'created_at' => now(),
            'updated_at' => now(),
            'sections_id_sections' => $id,
        ]);

        return $case;
    }
//    public function caseUpdating(Request $request)
//    {
//        $case->name = $request->input('name');
//        $case->description = $request->input('description';
//        $case->price = $request->input('price');
//        $case->save();
//    }
}
