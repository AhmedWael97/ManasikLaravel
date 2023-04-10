<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KfaratChoice;
use Exception;

class KfaratChoiceController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
        $this->middleware("Permission:KfaratChoice",['only'=>['index']]);
        $this->middleware("Permission:KfaratChoice_Create",['only'=>['create','store']]);
        $this->middleware("Permission:KfaratChoice_Update",['only'=>['edit','update']]);
        $this->middleware("Permission:KfaratChoice_Delete",['only'=>['destroy']]);
    }

    public function index() {
        return view('Dashboard.pages.KfaratChoices.index')->with(['Choices' => KfaratChoice::get()]);
    }

    public function create() {
        return view('Dashboard.pages.KfaratChoices.create');
    }

    public function store(Request $request) {
        $request->validate([
            'name_ar' => 'required|string',
            'name_en' => 'required|string',
        ]);



       try {
        $kfaraChoice = new KfaratChoice($request->all());
        if($request->has('image')) {
            $imageName = 'kfarat_choices_'. time() . '.'.$request->image->extension();
            $request->image->move(public_path('images/kfarat_choices'), $imageName);
            $kfaraChoice->image = $imageName;
        }

        if($request->has('menu_image_path')) {
            $imageName = 'kfarat_choices_'. time() . '.'.$request->menu_image_path->extension();
            $request->menu_image_path->move(public_path('images/kfarat_choices'), $imageName);
            $kfaraChoice->menu_image_path = $imageName;
        }

        $kfaraChoice->save();
        return redirect()->route('KfaratChoice')->with('success',translate('Saved Successfully'));

       }catch(Exception $e) {
        return redirect()->back()->with('warning', $e->getMessage());
       }

    }

    public function edit($id) {
        $kfara = KfaratChoice::findOrFail($id);
        return view('Dashboard.pages.KfaratChoices.edit')->with('Choice', $kfara);
    }

    public function update(Request $request) {
        $request->validate([
            'name_ar' => 'required|string',
            'name_en' => 'required|string',
        ]);


       try {
        $kfaraChoice =  KfaratChoice::findOrFail($request->choice_id);
        $kfaraChoice->update($request->all());
        if($request->has('image')) {
            $imageName = 'kfarat_choices_'. time() . '.'.$request->image->extension();
            $request->image->move(public_path('images/kfarat_choices'), $imageName);
            $kfaraChoice->image = $imageName;
        }

        if($request->has('menu_image_path')) {
            $imageName = 'kfarat_choices_'. time() . '.'.$request->menu_image_path->extension();
            $request->menu_image_path->move(public_path('images/kfarat_choices'), $imageName);
            $kfaraChoice->menu_image_path = $imageName;
        }

        $kfaraChoice->save();
        return redirect()->route('KfaratChoice')->with('success',translate('Saved Successfully'));

       }catch(Exception $e) {
        return redirect()->back()->with('warning', $e->getMessage());
       }

    }

    public function destroy($id) {
        $kfara = KfaratChoice::findOrFail($id);
        $kfara->delete();

        return redirect()->route('KfaratChoice')->with('success',translate('Deleted Successfully'));

    }
}
