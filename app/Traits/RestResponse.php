<?php

namespace App\Traits;

trait RestResponse
{
    public function restFormatSuccess($data): array
    {
        return [
            'status' => 'success',
            'data' => $data
        ];
    }
}
