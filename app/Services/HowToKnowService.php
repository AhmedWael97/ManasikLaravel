<?php
    namespace App\Services;

    use App\Models\HowToKnowApplication;

    class HowToKnowService {
        protected $howToKnow;

        public function __construct(HowToKnowApplication $htka) {
            $this->howToKnow = $htka;
        }

        public function getAll() {
            return $this->howToKnow->select('id','name_ar','name_en')->get();
        }
    }
