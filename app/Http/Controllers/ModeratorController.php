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

class ModeratorController extends Controller
{
    public function getInfo()
    {
        return Section::all();
    }

    public function createSection(Request $request)
    {
        $valid = $request->validate([
            'section_name' => 'required|string|max:255',
        ]);
        if ($valid){
            return redirect()->route('case_content');
        }
        $this->sectionBD([
            'section_name' => $request->input('section_name'),
        ]);

        return redirect()->route('case_content');
    }

    private function sectionBD(array $data)
    {
        $lastOrder = Section::orderBy('id_sections', 'desc')->first();
        $orderNumber = $lastOrder ? $lastOrder->order_number + 1 : 1;

        Section::create([
            'section_name' => $data['section_name'],
            'order_number' => $orderNumber,
            'created_at' => now(),
            'updated_at' => now(),
            'created_by' => auth()->id(),
            'updated_by' => auth()->id(),
        ]);
    }

    public function changeName(Request $request)
    {
        $valid = $request->validate([
            'section_id' => 'required|integer|exists:sections,id_sections',
            'section_name' => 'required|string|max:255',
        ]);
        if ($valid){
            return redirect()->route('case_content');
        }
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
        $case = CaseModel::findOrFail($case_id);
        CaseItem::where('cases_id_case', $case->id_case)->delete();
        $case->delete();

        return redirect()->route('case_content');
    }

    public function createCase(Request $request)
    {
        $valid = $request->validate([
            'id_section' => 'required|integer|exists:sections,id_sections',
        ]);
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
            $valid = $request->validate([
                'avatar' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
            $file = $request->file('avatar');
            $filename = $case->name . '.' . $file->getClientOriginalExtension();
            $file->storeAs('images/cases', $filename);
            $case->image_url = $filename;
        }
    }

    public function generateViewCaseUpdating($id_case)
    {
        $case = CaseModel::findOrFail($id_case);
        $items = CaseItem::with('item')->where('cases_id_case', $case->id_case)->get();
        return view('case_creating', compact('case', 'items'));
    }

    public function caseUpdating($id_case, Request $request)
    {
        $valid = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'price' => 'required|numeric|min:0',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $case = CaseModel::findOrFail($id_case);
        $this->avatarUpload($request, $case);
        $case->name = $request->input('name');
        $case->description = $request->input('description');
        $case->price = $request->input('price');
        $case->updated_by = auth()->id();
        $case->updated_at = now();
        $items = CaseItem::with('item')->where('cases_id_case', $case->id_case)->get();

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
        $valid = $request->validate([
            'name' => 'required|string|max:255',
            'drop_rate' => 'required|numeric|min:0|max:100',
            'rarity' => 'required|string|max:50',
            'price' => 'required|numeric|min:0',
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $case = CaseModel::findOrFail($id_case);

        $item = Item::create([
            'name' => $request->input('name'),
            'rarity' => $request->input('rarity'),
            'price' => $request->input('price'),
            'image_url' => '',
        ]);

        CaseItem::create([
            'cases_id_case' => $id_case,
            'items_id_item' => $item->id_item,
            'drop_rate' => $request->input('drop_rate'),
        ]);

        $this->itemPhotoUpload($request, $item);

        $items = CaseItem::with('item')->where('cases_id_case', $case->id_case)->get();
        return view('case_creating', compact('case', 'items'));
    }
}
