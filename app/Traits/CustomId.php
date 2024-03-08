<?php

namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

trait CustomId
{
    public static function setCustomIdStatic(Model $model): int
    {
        $year = Carbon::now()->year;

        $lastModel = $model::query();

        if (method_exists($model, 'trashed')){
            $lastModel = $model->withTrashed();
        }

        $lastModel = $lastModel->orderByDesc('id')->first();

        return $lastModel ? $lastModel->id + 1 : ($year * 100000) + 1;
    }

    public function setCustomId(Model $model): int
    {
        $year = Carbon::now()->year;
        $lastModel = $model->newQuery()->latest()->get();
        $lastId = $lastModel->isNotEmpty() ? $lastModel->first()->id : $year * 100000;

        return $year.(int)substr($lastId, 4) + 1;
    }
}
