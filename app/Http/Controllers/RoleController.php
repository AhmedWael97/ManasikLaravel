<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Exception;
class RoleController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
        $this->middleware("Permission:Roles",['only'=>['index']]);
        $this->middleware("Permission:Role_Create",['only'=>['create','store']]);
        $this->middleware("Permission:Role_Edit",['only'=>['edit','update']]);
        $this->middleware("Permission:Role_Delete",['only'=>['destroy']]);
    }

    public function index() {
        return view('Dashboard.pages.Roles.index')->with([
            'Roles' => Role::get(),
        ]);
    }

    public function create() {
        return view('Dashboard.pages.Roles.create')->with([
            'Permissions' => Permission::get(),
        ]);
    }

    public function edit($id) {
        $role = Role::findOrFail($id);
        return view('Dashboard.pages.Roles.edit')->with([
            'Role' => $role,
            'Permissions' => Permission::get(),
        ]);
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string',
            'permissions[]' => 'min:1',
        ]);

        try {
            $role = new Role(['name' => $request->name]);
           if(isset($request->permissions) && count($request->permissions) >= 1) {
            $role->save();
           } else {
            return redirect()->route('Roles-Create')->with('danger', translate('Please Select at least 1 permission'));
           }
            $permissions = Permission::whereIn('id',$request->permissions)->get();
            $role->syncPermissions($permissions);
            return redirect()->route('Roles')->with('success','Created Successfully');
        } catch(Exception $e) {
            return redirect()->route('Roles-Create')->with('danger', $e->getMessage());
        }
    }

    public function update(Request $request) {
        $request->validate([
            'name' => 'required|string',
            'permissions' => 'min:1',
        ]);

        try {
            $role = Role::findOrFail($request->id);
            if(isset($request->permissions) && count($request->permissions) >= 1) {
                $role->update(['name' => $request->name]);
               } else {
                return redirect()->route('Roles-Create')->with('danger', translate('Please Select at least 1 permission'));
               }

            $permissions = Permission::whereIn('id',$request->permissions)->get();
            $role->syncPermissions($permissions);
            return redirect()->route('Roles')->with('success','Created Successfully');
        } catch(Exception $e) {
            return redirect()->route('Roles-Create')->with('danger', $e->getMessage());
        }
    }

    public function destroy($id) {
        $role = Role::findOrFail($id);
        $role->delete();

        return redirect()->route('Roles')->with('success',translate('Deleted Successfully'));
    }

}
