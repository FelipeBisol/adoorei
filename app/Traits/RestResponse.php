<?php

namespace App\Traits;

trait RestResponse
{
    public function restFormatSuccess($data): array
    {
        return $this->getArray('success', $data);
    }

    public function restFormatNotFound(): array
    {
        return $this->getArray('failed', []);
    }

    public function restFormatEmptyData(): array
    {
        return $this->getArray('success', []);
    }

    private function getArray(string $status, array $data): array
    {
        return [
            'status' => $status,
            'data' => $data
        ];
    }
}
