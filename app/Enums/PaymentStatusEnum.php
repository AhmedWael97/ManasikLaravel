<?php
namespace App\Enums;

use Illuminate\Validation\Rules\Enum;

Enum PaymentStatusEnum:string {
    case  Waiting = 'wating';
    case  Success = 'Success';
    case  Failed = 'Falied';
    case  Canceled = 'Canceled';
}

?>
