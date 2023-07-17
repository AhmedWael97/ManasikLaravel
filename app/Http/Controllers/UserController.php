<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Gender;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Job;
use App\Models\Language;
use App\Models\Nationality;
use Exception;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\Models\Wallet;
use App\Models\AutoAssignService;
use DB;
use App\Models\OrderDetail;
use App\Models\Executer;
class UserController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
        $this->middleware("Permission:Users",['only'=>['index']]);
        $this->middleware("Permission:Users_Create",['only'=>['create','store']]);
        $this->middleware("Permission:Users_Update",['only'=>['edit','update']]);
        $this->middleware("Permission:Users_Delete",['only'=>['destroy']]);
    }

    public function index($term = null) {
        if($term == null) {
            $pageTitle = translate('Total Users');
            return view('Dashboard.pages.Users.index')->with([
                'Users' => User::select(['id','name','phone','email' ])->with(['roles'])->get(),
                'pageTitle' => $pageTitle,
            ]);
        } else if ($term == 'Super_Admin') {
            $pageTitle = translate('Super Admin Users');
            $users_ids = DB::table('model_has_roles')->where('role_id',1)->select('model_id')->get()->pluck('model_id');
            return view('Dashboard.pages.Users.index')->with([
                'Users' => User::whereIn('id',$users_ids)->select(['id','name','phone','email' ])->with(['roles'])->get(),
                'pageTitle' => $pageTitle,
            ]);
        } else if ($term == 'Executers') {
            $pageTitle = translate('Executers');
           // $users_ids = DB::table('model_has_roles')->where('model_type','App\Models\Executer')->where('role_id',3)->select('model_id')->get()->pluck('model_id');
            return view('Dashboard.pages.Users.index')->with([
                'Users' => Executer::select(['id','name','name_ar','phone','email','is_active'])->with(['roles'])->get(),
                'pageTitle' => $pageTitle,
            ]);
        } else if ($term == 'Application_Users') {
            $pageTitle = translate('Application Users');
            $users_ids = DB::table('model_has_roles')->where('role_id',4)->select('model_id')->get()->pluck('model_id');
            return view('Dashboard.pages.Users.index')->with([
                'Users' => User::whereIn('id',$users_ids)->select(['id','name','phone','email','is_active'])->with(['roles'])->get(),
                'pageTitle' => $pageTitle,
            ]);
        } else if ($term == 'Kfarat_Executers') {
            $pageTitle = translate('Kfarat Executers');
            $users_ids = DB::table('model_has_roles')->where('role_id',2)->select('model_id')->get()->pluck('model_id');
            return view('Dashboard.pages.Users.index')->with([
                'Users' => Executer::whereIn('id',$users_ids)->select(['id','name','phone','email' ])->with(['roles'])->get(),
                'pageTitle' => $pageTitle,
            ]);

        } else {
            abort(404);
        }


    }

    public function create() {
        return view('Dashboard.pages.Users.create')->with([
            'Roles' => Role::get(),
            'Genders' => Gender::get(),
            'Countries' => Country::get(),
            'Languages' => Language::get(),
            'Jobs' => Job::get(),
            'Nationalities' => Nationality::get(),
            'Currencies' => Currency::get(),
        ]);
    }

    public function edit($id) {
        $user = User::findOrFail($id);
        return view('Dashboard.pages.Users.edit')->with([
            'User' => $user,
            'Roles' => Role::get(),
            'Genders' => Gender::get(),
            'Countries' => Country::get(),
            'Languages' => Language::get(),
            'Jobs' => Job::get(),
            'Nationalities' => Nationality::get(),
            'Currencies' => Currency::get(),
        ]);
    }

    public function store(Request $request) {

        $request->validate([
            'name' => 'required|string',
            'name_ar' => 'required|string',
            'email' => 'required|email|unique:users',
            'phone' => 'required|unique:users',
            'password' => 'required|confirmed',
            'role_id' => 'required',
            'currency_id' => 'required',
        ]);

        try {
            $user = new User($request->all());
            $user->password = Hash::make($request->password);

            $role = Role::findOrFail($request->role_id);
            $user->assignRole($role);

            $user->is_active = $request->is_active;
            $user->is_confirmed_executer = $request->is_confirmed_executer;
            $user->is_allow_notification = $request->is_allow_notification;
            $user->save();

            if($request->has('photo_path')) {
                $imageName = 'photo_'.time().'.'.$request->photo_path->extension();
                $request->photo_path->move(public_path('images/photos'), $imageName);
                $user->photo_path = $imageName ;
            }

            if($request->has('government_id_path')) {
                $imageName = 'gov_'.time().'.'.$request->government_id_path->extension();
                $request->government_id_path->move(public_path('images/govs'), $imageName);
                $user->government_id_path = $imageName ;
            }

            if($request->has('activity_license_image_path')) {
                $imageName = 'act_'.time().'.'.$request->activity_license_image_path->extension();
                $request->activity_license_image_path->move(public_path('images/act'), $imageName);
                $user->activity_license_image_path = $imageName ;
            }

            if($request->has('commercial_registration_image_path')) {
                $imageName = 'comm_'.time().'.'.$request->commercial_registration_image_path->extension();
                $request->commercial_registration_image_path->move(public_path('images/comm'), $imageName);
                $user->commercial_registration_image_path = $imageName ;
            }

            $user->save();

            $wallet = new Wallet([
                'user_id' => $user->id,
                'amount' => 0,
                'currency_id' => $request->currency_id
            ]);

            $wallet->save();
            return redirect()->route('Users')->with('success',translate('Saved Successfully'));
        } catch(Exception $e) {
            $user->delete();
            return back()->with('warning', $e->getMessage());
        }

    }

    public function update(Request $request) {

        $request->validate([
            'name' => 'required|string',
            'name_ar' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required',
        ]);


         try {
            $user = User::findOrFail($request->user_id);
            $old_password = $user->password;
            $old_pass = $user->password;
            $user->update($request->all());
            $user->password = $old_pass;
            $user->save();

            if($request->has('photo_path')) {
                $imageName = 'photo_'.time().'.'.$request->photo_path->extension();
                $request->photo_path->move(public_path('images/photos'), $imageName);
                $user->photo_path = $imageName ;
            }

            if($request->has('government_id_path')) {
                $imageName = 'gov_'.time().'.'.$request->government_id_path->extension();
                $request->government_id_path->move(public_path('images/govs'), $imageName);
                $user->government_id_path = $imageName ;
            }

            if($request->has('activity_license_image_path')) {
                $imageName = 'act_'.time().'.'.$request->activity_license_image_path->extension();
                $request->activity_license_image_path->move(public_path('images/act'), $imageName);
                $user->activity_license_image_path = $imageName ;
            }

            if($request->has('commercial_registration_image_path')) {
                $imageName = 'comm_'.time().'.'.$request->commercial_registration_image_path->extension();
                $request->commercial_registration_image_path->move(public_path('images/comm'), $imageName);
                $user->commercial_registration_image_path = $imageName ;
            }

            $user->save();

            return redirect()->route('Users')->with('success',translate('Saved Successfully'));
        } catch(Exception $e) {
            return back()->with('warning', $e->getMessage());
        }

    }

    public function destroy($id) {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('Users')->with('success',translate('Deleted Successfully'));


    }

    public function view($id) {

        $user = Executer::findOrFail($id);
        $orders = OrderDetail::where('executer_id',$id)->get();
        $analysisBag = [
            'orders' => $orders->count(),
            'InitOrders' => $orders->whereIn('order_status_id',[6])->count(),
            'inProgressOrders' => $orders->where('order_status_id',3)->count(),
            'canceledOrders' => $orders->where('order_status_id',2)->count(),
            'completedOrders' => $orders->where('order_status_id',11)->count(),
            'skippedOrders' => $orders->where('order_status_id',4)->count(),
            'delayedOrders' => $orders->where('order_status_id',5)->count(),
            'refusedOrders' => $orders->where('order_status_id',7)->count(),
            'sosOrders' => $orders->where('order_status_id',10)->count(),
        ];
        return view('Dashboard.pages.Users.show')->with([
            'User'=>$user, 'analysisBag' => $analysisBag
        ]);
    }


    public function automateAssign($id) {
        $user = User::findOrFail($id);
        if(! $user->roles[0]->hasPermissionTo('Executer_Dashboard_Login')) {
            return back()->with('warning', translate('this user not kfarat executer'));
        }

        $servicesId = \App\Models\ServiceKfaratChoice::select('service_id')->distinct('service_id')->get()->pluck('service_id');
        $services = \App\Models\Service::whereIn('id',$servicesId)->where('parent_id','<>',0)->where('price','<>',0)->get();

        return view('dashboard.pages.users.automateAssign')->with([
            'user' => $user,
            'services' => $services
        ]);

    }

    public function saveAutoAssign(Request $request) {

        $user = User::findOrFail($request->id);


        if($request->has('services') && count($request->services) > 0) {
            foreach($request->services as $key=>$serviceId) {
                $service = \App\Models\Service::findOrFail($serviceId);
                $AutoService  = AutoAssignService::where(['executer_id' => $request->id , 'service_id' => $serviceId])->first();

                if($AutoService != null) {

                    $AutoService->maxCount = $request->maxCount[$key];
                    $AutoService->save();

                } else {

                    $newAutoService = new AutoAssignService([
                        'executer_id' => $request->id,
                        'service_id' => $serviceId,
                        'maxCount' => $request->maxCount[$key],
                        'auto_assign' => 1
                    ]);
                    $newAutoService->save();
                }

            }
            return redirect()->route('Users-auto',$user->id)->with('success' , translate('Saved Successfully'));
        } else {
            return back()->with('error', translate('Error in selected services'));
        }
    }

    public function getAdminCount(Request $request){
        $users = User::permission('Admin_Dashboard_Login')->get();
        $no_admin_dashboard_login = count($users);
        if ($request->ajax()) {
            return response()->json([
                'admin_no' => $no_admin_dashboard_login,
            ]);
        }
    }
    public function getMobilAppCount(Request $request){
        $users = User::permission('Mobile_Application_User')->get();
        $no_mobil_app_user = count($users);
        if ($request->ajax()) {
            return response()->json([
                'app_user_no' => $no_mobil_app_user,
            ]);
        }
    }

    public function getExecuterDashboardNo(Request $request){
        $users = User::permission('Executer_Dashboard_Login')->get();
        $no_executer_dashboard_user = count($users);
        if ($request->ajax()) {
            return response()->json([
                'executer_dashboard__no' => $no_executer_dashboard_user,
            ]);
        }
    }

    public function getExecuterAppNo(Request $request){
        $users = User::permission('Executer_Mobile_Application')->get();
        $no_executer_app_user = count($users);
        if ($request->ajax()) {
            return response()->json([
                'executer_app__no' => $no_executer_app_user,
            ]);
        }
    }

    public function quickActions($type , $id) {

        if($type == 'Active_Executer_User') {
            $user = Executer::findOrFail($id);
            $user->is_active = 1;
            $user->is_confirmed_executer = 1;
            $user->save();
            return back()->with('success',translate('Success'));
        }

        if($type == 'Deactive_Executer_User') {
            $user = Executer::findOrFail($id);
            $user->is_active = 0;
            $user->is_confirmed_executer = 0;
            $user->save();
            return back()->with('success',translate('Success'));
        }

        if($type == 'Deactive_Executer_User') {
            $user = Executer::findOrFail($id);
            $user->is_active = 0;
            $user->is_confirmed_executer = 0;
            $user->save();
            return back()->with('success',translate('Success'));
        }

        if($type == 'Allow_Notification') {
            $user = Executer::findOrFail($id);
            $user->is_allow_notification = 1;
            $user->save();
            return back()->with('success',translate('Success'));
        }

        if($type == 'Diallow_Notification') {
            $user = Executer::findOrFail($id);
            $user->is_allow_notification = 0;
            $user->save();
            return back()->with('success',translate('Success'));
        }

        if($type == 'Enable_SOS_Status') {
            $user = Executer::findOrFail($id);
            $user->sos_status = 1;
            $user->sos_start_date = Date('d-m-Y h:i A');
            $user->save();
            return back()->with('success',translate('Success'));
        }

        if($type == 'Disable_SOS_Status') {
            $user = Executer::findOrFail($id);
            $user->sos_status = 0;
            $user->sos_start_date = Date('d-m-Y h:i A');
            $user->save();
            return back()->with('success',translate('Success'));
        }

        abort(404);
    }


}
