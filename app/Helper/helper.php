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

    if(!function_exists('AssignServicesToExecuters')) {
        function AssignServicesToExecuters() {
            // first get services where is kfarat
            $servicesIds =  \App\Models\ServiceKfaratChoice::select('service_id')->distinct('service_id')->get()->pluck('service_id');
            //second select all orders which has this service and no have executer
            $orders = \App\Models\OrderDetail::whereIn('service_id',$servicesIds)->where('executer_id',null)->where('is_confirmed',1)->get();
            $lastExecuterIds = [];
            foreach($orders as $order) {
                //third get all executers for kfarat
                $executers = \App\Models\AutoAssignService::where(
                    [ 'auto_assign'=>1 , 'service_id' => $order->service_id, ['maxCount' , '>' , 0] ]
                    )->select(['executer_id','maxCount'])->get();
                $OrderAssigned = false;
                foreach($executers as $executer) {
                    //check if order already assigned to executer
                    if(!$OrderAssigned) {
                         // to make services distbrute equally
                        if(count($lastExecuterIds) == count($executers)) {
                           echo '<p>11</p>';
                            $lastExecuterIds = [];
                        }
                         //fourth step to give order to the executer
                        $totalExecuterOrders = \App\Models\OrderDetail::where(['executer_id' => $executer->executer_id, ['order_status_id' , '!=' , 11]])->count();
                        if($totalExecuterOrders < $executer->maxCount) {

                            if(!in_array($executer->executer_id , $lastExecuterIds)) {
                                   // Assign Order to executer
                                    $order->executer_id = $executer->executer_id;
                                    $order->order_status_id = 3;
                                    $order->save();
                                    $OrderAssigned = true;
                                    array_push($lastExecuterIds, $executer->executer_id);
                            }

                        }
                    }
                }
            }

        }
    }


?>
