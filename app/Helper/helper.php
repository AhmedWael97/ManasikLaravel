<?php
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
    if(!function_exists('translate')){
        function translate($term) {
            return $term;
        }
    }

    if(!function_exists('is_active')) {
        function is_active($term){
            $route = Route::currentRouteName();
            $route_array = explode('-',$route);
            return $route_array[0] == $term;
        }
    }

    if(!function_exists('updatePermissions')) {
        function updatePermissions($model) {
            $pers = [$model,$model.'_Show',$model.'_Create',$model.'_Update',$model.'_Delete'];
            $role = Role::first();
            foreach($pers as $per) {
                $permission = Permission::create([
                'name' => $per,
                'guard_name' => 'web',
                ]);
            $role->givePermissionTo($permission);
            }
        }
    }


?>
