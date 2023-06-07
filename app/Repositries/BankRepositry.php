<?php
namespace App\Repositries;

use App\Models\Bank;
use App\Models\BankBarnch;

class BankRepositry {
    /**
     * @var Bank
     */
    protected $bank;

    public function __construct(Bank $bank) {
        $this->bank = $bank;
    }

    public function getTotalBanks() {
       return $this->bank->select('id','name_en as englishName','name_ar as arabicName')->get();
    }

    public function saveBank($data) {

        $newBank = new $this->bank;
        $newBank->name_ar = $data['name_ar'];
        $newBank->name_en = $data['name_en'];

        $newBank->save();

       return $this->bank->fresh();
    }

    public function getSpecificBank($id) {
        return $this->bank->where('id',$id)->first();
    }

    public function updateBank($data)  {

    }

    public function deleteBank($id) {

    }
}

?>
