<?php

use App\Http\Controllers\NotificationController;
use App\Models\Currency;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\Service;
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

        function is_sub_active($term) {
            $route = url()->full();
            $route_array = explode('/',$route);
            return $route_array[count($route_array)-1] == $term;
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


    if(!function_exists('notify')) {
         function notify($data) {
            $notifyController = new NotificationController();
            $notifyController->store($data);
        }
    }


    if(!function_exists('countMyNotification')) {
        function countMyNotification($user_id) {
          return \App\Models\Notification::where('user_id',$user_id)->where('read_at',null)->count();
       }

       function myNotification($user_id){
            $notifications = \App\Models\Notification::where('user_id',$user_id)->where('read_at',null)->get();
            foreach($notifications as $notification){
                $notification->recevied_at = Date('d-m-Y h:i A');
                $notification->save();
            }
            return $notifications;
       }

       function totalNotificaiton($user_id) {
            return \App\Models\Notification::where('user_id',$user_id)->orderBy('created_at','desc')->get();
       }
    }

    if(!function_exists('precent')) {
        function precent($value, $total) {
            if($value == 0) {
                return 0;
            }
            return round(($total/$value)*100 ,2);
        }

        function differenceInDate($date1,$date2) {

        }
    }

    if(!function_exists('reach_limit_for_max_limit')) {
        function reach_limit_for_max_limit($service_id) {
            $maxLimit = Service::where('id',$service_id)->select('max_limit')->first();
            if($maxLimit == null) {
                return false;
            }
            // check limit
            // save a notify when this service get avaliable
            return true;

        }
    }


    if(!function_exists('get_convert_value')) {
        function get_convert_value() {
            $defaultCurrency = Currency::find(1);
            if($defaultCurrency == null) {
                return;
            }
             $anotherCurrencies = Currency::where('id','<>',1)->get();

            foreach($anotherCurrencies as $curr) {
                $req_url = 'https://api.exchangerate.host/convert?from='.$defaultCurrency->symbol.'&to='.$curr->symbol;
                $response_json = file_get_contents($req_url);
                if(false !== $response_json) {
                    try {
                        $response = json_decode($response_json);
                        if($response->success === true) {

                          $curr->convert_value = round($response->info->rate,2);
                          $curr->save();
                        }
                    } catch(Exception $e) {
                       var_dump($e);
                    }
                }
            }
        }
    }
?>
