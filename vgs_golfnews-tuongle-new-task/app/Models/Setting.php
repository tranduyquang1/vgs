<?php

namespace App\Models;

use Arcanedev\Support\Database\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Setting extends AdminModel
{
    protected $casts = [
        'value' => 'array',
    ];

    protected $crudNotAccepted = ['_token', 'key_value', 'q'];

    public function saveItem($params)
    {
        $keyValue = $params['key_value'];
        $prepareParams = $this->prepareParams($params);
//        if ($keyValue == 'setting-social') {
//            foreach ($prepareParams as $key => $value) {
//                if (!empty($value)) {
//                    $value = json_decode($value, true);
//                    $value = array_column($value, 'value');
//                    $prepareParams[$key] = $value;
//                }
//            }
//        }

        $data['value'] = json_encode($prepareParams, JSON_UNESCAPED_UNICODE);
        if ($params['key_value'] != 'setting-email') {
            file_put_contents(public_path("cache/{$params['key_value']}.json"), $data['value']);
        }
        $this->where('key_value', $keyValue)->update($data);
    }
}
