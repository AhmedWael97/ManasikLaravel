<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use Auth;
class JobController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
        $this->middleware("Permission:Job_View",['only'=>['index']]);
        $this->middleware("Permission:Job_Create",['only'=>['create','store']]);
        $this->middleware("Permission:Job_Update",['only'=>['edit','update']]);
        $this->middleware("Permission:Job_Delete",['only'=>['destroy']]);
    }
    public function index(){
        $jobs = Job::get();
        return view('Dashboard.pages.jobs.index')->with('jobs',$jobs);
        }
    
        public function create(){
            return view('Dashboard.pages.jobs.create');
        }
    
        public function store(Request $request){
            $job = new Job($request->all());
            $job->user_id = Auth::user()->id; 
            $job->save();
            return redirect()->route('job-index')->with('success',translate('Your Job Added Succfully'));
        }
    
        public function edit($id){
            $job = Job::findOrFail($id)  ;
            return view('Dashboard.pages.jobs.update')->with('job',$job);
        }
    
        public function update(Request $request){
            $job =  Job::findOrFail($request->id)  ;
            $job->update($request->all());
            $job->save();
            return redirect()->route('job-index')->with('success', translate('Your Job Updated Succfully'));
        }
    
        public function destroy($id){
            $job = Job::findOrFail($id)  ;
            $job->delete();
            return redirect()->route('job-index')->with('success',translate('Your Job Deleted Succfully'));
        }
}
