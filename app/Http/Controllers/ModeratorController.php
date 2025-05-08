<?php

namespace App\Http\Controllers;

use App\Models\CaseItem;
use App\Models\Item;
use App\Models\Section;
use App\Models\User;
use App\Models\CaseModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use function Laravel\Prompts\error;

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
        $case = CaseModel::where('sections_id_sections', '=', $section_id);
        $case->delete();
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
    public function deleteCase($case_id)
    {
        $case = CaseModel::find($case_id);
        $case->delete();
        return redirect()->route('case_content');
    }

    public function createCase(Request $request)
    {
        $id_section = $request->input('id_section');
        $lastOrder = CaseModel::orderBy('id_case', 'desc')->first();
        $orderNumber = $lastOrder ? $lastOrder->order_number + 1 : 1;

        $case = CaseModel::create([
            'name' => 'name',
            'price' => 0,
            'description' => 'description',
            'image_url' => 'case.png',
            'order_number' => $orderNumber,
            'created_by' => auth()->id(),
            'updated_by' => auth()->id(),
            'created_at' => now(),
            'updated_at' => now(),
            'sections_id_sections' => $id_section,
        ]);

        $items = CaseItem::where('cases_id_case', '=', $case->id_case)->get();
        return view('case_creating', ['id_case' => $case->id_case], compact('items', 'case'));
    }
    private function avatarUpload(Request $request, $case)
    {
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');

            $filename = $case->name . '.' . $file->getClientOriginalExtension();

            $file->storeAs('images/cases', $filename);

            $case->image_url = $filename;
        }
    }
    public function generateViewCaseUpdating($id_case){
        $case = CaseModel::find($id_case);
        $items = CaseItem::with('item')
            ->where('cases_id_case', $case->id_case)
            ->get();
        return view('case_creating', compact('case', 'items'));
    }
    public function caseUpdating($id_case, Request $request)
    {
        $case = CaseModel::find($id_case);
        $this->avatarUpload($request, $case);
        $items = CaseItem::where('cases_id_case', '=', $case->id_case);


        $case->name = $request->input('name');
        $case->description = $request->input('description');
        $case->price = $request->input('price');
        $case->updated_by = auth()->id();
        $case->updated_at = now();
        $case->save();

        return view('case_creating', compact('case', 'items'));
    }
    private function itemPhotoUpload(Request $request, $item)
    {
        if ($request->hasFile('image_url')) {
            $file = $request->file('image_url');

            $filename = $item->name . '.' . $file->getClientOriginalExtension();

            $file->storeAs('images/items', $filename);

            $item->image_url = $filename;
            $item->save();
        }
    }
    public function itemCreating(Request $request, $id_case)
    {
        $case = CaseModel::where('id_case', '=', $id_case)->first();
        $name = $request->input('name');
        $drop_rate = $request->input('drop_rate');
        $rarity = $request->input('rarity');
        $price = $request->input('price');
        $image_url = $request->input('image_url');
        $item = Item::create([
            'name' => $name,
            'rarity' => $rarity,
            'price' => $price,
            'image_url' => $image_url,
        ]);
        CaseItem::create([
            'cases_id_case' => $id_case,
            'items_id_item' => $item->id_item,
            'drop_rate' => $drop_rate,
        ]);
        $this->itemPhotoUpload($request, $item);
        $items = CaseItem::with('item')
            ->where('cases_id_case', $case->id_case)
            ->get();
        return view('case_creating', compact('case', 'items'));
    }
}
