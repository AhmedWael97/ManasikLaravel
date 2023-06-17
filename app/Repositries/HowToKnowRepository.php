<?php
    namespace App\Repositries;

    use App\Services\HowToKnowService;

    class HowToKnowRepository {
        protected $htks;

        public function __construct(HowToKnowService $htks)
        {
            $this->htks = $htks;
        }

        public function getAll() {
          return $this->htks->getAll();
        }
    }
?>
