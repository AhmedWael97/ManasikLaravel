<?php

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


?>
