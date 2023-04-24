<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicationResponse extends Model
{
    public $successStatus = 200;
    public $ErrorStatus = 500;
    public $UnAuthroizeStatus = 401;

    public function successResponse($modelName,$data) {
        return response([
            "Status" => 200,
            "MessageEN" => "Sueccess",
            "MessageAR" => "ناجح",
            "Data" => [
                $modelName => $data
            ]
        ]);
    }

    public function unAuthroizeResponse() {
        return response([
            "Status" => 401,
            "MessageEN" => "UnAuthorized",
            "MessageAR" => "غير مسجل دخول",

        ]);
    }

    public function ErrorResponse($err) {
        return response([
            "Status" => 500,
            "MessageEN" => $err,
            "MessageAR" => $err,

        ]);
    }

    public function notFound($err) {
        return response([
            "Status" => 404,
            "MessageEN" => $err,
            "MessageAR" => $err,

        ]);
    }

}
