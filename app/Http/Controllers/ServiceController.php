<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use Exception;
use App\Models\ServiceStep;
class ServiceController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
        $this->middleware("Permission:Services",['only'=>['index']]);
        $this->middleware("Permission:Services_Create",['only'=>['create','store']]);
        $this->middleware("Permission:Services_Update",['only'=>['edit','update']]);
        $this->middleware("Permission:Services_Delete",['only'=>['destroy']]);
    }

    public function index() {
        return view('Dashboard.pages.Services.index')->with([
            'Services' => Service::get(),
        ]);
    }

    public function create() {
        return view('Dashboard.pages.Services.create')->with([
            'parents' => Service::select('id','name_en','name_ar')->get(),
        ]);
    }

    public function store(Request $request) {
        $request->validate([
            'name_en' => 'required',
            'name_ar' => 'required',
            'earning_points' => 'required'
        ]);

      try {

        $service = new Service($request->all());

        if($request->has('photo')) {
            $imageName = 'services_'.time().'.'.$request->photo->extension();
            $request->photo->move(public_path('images/services'), $imageName);
            $service->photo = $imageName ;
        }
        $service->save();

        if($request->has('step_name_en') && count($request->step_name_en) > 0) {
            foreach($request->step_name_en as $key=>$step_name_en) {
                $imageName = '';
                if($request->has('step_photo') && count($request->step_photo) > $key) {
                    $imageName = 'step_services_'.time().'.'.$request->step_photo[$key]->extension();
                    $request->step_photo[$key]->move(public_path('images/services'), $imageName);

                }
                $stepDetails = [
                    'service_id' => $service->id,
                    'name_en' => $step_name_en,
                    'photo' => $imageName,
                    'name_ar' => count($request->step_name_ar) >= $key ? $request->step_name_ar[$key] : '-',
                    'max_time_in_minute' => count($request->max_time_in_minute) >= $key ? $request->max_time_in_minute[$key] : '0',
                    'min_time_in_minute' => count($request->min_time_in_minute) >= $key ? $request->min_time_in_minute[$key] : '0',
                ];
                $newStep = new ServiceStep($stepDetails);
                $newStep->save();
            }
        }

        return redirect()->route('Services')->with('success',translate('Saved Successfully'));
      } catch(Exception $e) {
        return back()->with('warning', $e->getMessage());
      }
    }

    public function edit($id) {
        $service = Service::findOrFail($id);
        return view('Dashboard.pages.Services.edit')->with([
            'parents' => Service::select('id','name_en','name_ar')->get(),
            'service' => $service,
        ]);
    }

    public function update(Request $request) {
        $request->validate([
            'name_en' => 'required',
            'name_ar' => 'required',
            'earning_points' => 'required'
        ]);

      try {
        $service = Service::findOrFail($request->service_id);
        $service->update($request->all());
        if($request->has('photo')) {
            $imageName = 'services_'.time().'.'.$request->photo->extension();
            $request->photo->move(public_path('images/services'), $imageName);
            $service->photo = $imageName ;
        }

        if($request->has('old_step_name_en') && count($request->old_step_name_en) > 0) {

            foreach($request->old_step_name_en as $key=>$step_name_en) {
                $step = ServiceStep::findOrFail($request->old_step_id[$key]);
                $imageName = $step->photo;
                if($request->has('old_step_photo') && count($request->old_step_photo) > $key) {
                    $imageName = 'step_services_'.time().'.'.$request->old_step_photo[$key]->extension();
                    $request->old_step_photo[$key]->move(public_path('images/services'), $imageName);

                }
                $stepDetails = [
                    'service_id' => $service->id,
                    'name_en' => $step_name_en,
                    'photo' => $imageName,
                    'name_ar' => count($request->old_step_name_ar) >= $key ? $request->old_step_name_ar[$key] : '-',
                    'max_time_in_minute' => count($request->old_max_time_in_minute) >= $key ? $request->old_max_time_in_minute[$key] : '0',
                    'min_time_in_minute' => count($request->old_min_time_in_minute) >= $key ? $request->old_min_time_in_minute[$key] : '0',
                ];


                $step->update($stepDetails);
                $step->save();
            }
        }


        if($request->has('step_name_en') && count($request->step_name_en) > 0) {
            foreach($request->step_name_en as $key=>$step_name_en) {
                $imageName = '';
                if($request->has('step_photo') && count($request->step_photo) > $key) {
                    $imageName = 'step_services_'.time().'.'.$request->step_photo[$key]->extension();
                    $request->step_photo[$key]->move(public_path('images/services'), $imageName);

                }
                $stepDetails = [
                    'service_id' => $service->id,
                    'name_en' => $step_name_en,
                    'photo' => $imageName,
                    'name_ar' => count($request->step_name_ar) >= $key ? $request->step_name_ar[$key] : '-',
                    'max_time_in_minute' => count($request->max_time_in_minute) >= $key ? $request->max_time_in_minute[$key] : '0',
                    'min_time_in_minute' => count($request->min_time_in_minute) >= $key ? $request->min_time_in_minute[$key] : '0',
                ];
                $newStep = new ServiceStep($stepDetails);
                $newStep->save();
            }
        }

        $service->save();

        return redirect()->route('Services')->with('success',translate('Saved Successfully'));
      } catch(Exception $e) {
        return back()->with('warning', $e->getMessage());
      }
    }

    public function destroy($id) {
        $service = Service::findOrFail($id);
        $service->delete();

        return redirect()->route("Services")->with('success','Deleted Successfully');
    }

    public function destroyStep($id) {
        $service = ServiceStep::findOrFail($id);
        $service->delete();

        return back()->with('success','Deleted Successfully');
    }

}
