<?php

namespace App\Services;

use App\Repositries\BankRepositry;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class BankService {
    protected $bankRepositry;

    public function __construct(BankRepositry $bankRepositry) {
        $this->bankRepositry = $bankRepositry;
    }

    public function getTotalBanks() {
        return $this->bankRepositry->getTotalBanks();
    }

    public function saveBank($data) {
        $validator = Validator::make($data,[
            'name_en' => 'required|string',
            'name_ar' => 'required|string',
        ]);

        if($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        return $this->bankRepositry->saveBank($data);
    }


}

?>
