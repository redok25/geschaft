<?php

namespace App\Traits;

use Illuminate\Support\Facades\Validator;

trait ValidatorTrait
{
    public function set_validator($data, $validator)
    {
        $validator = Validator::make($data, $validator);

        if ($validator->fails()) {
            toast('Terdapat kesalahan dalam inputan anda, silahkan ulangi!', 'error');
            return redirect()->back();
        }
    }
}
