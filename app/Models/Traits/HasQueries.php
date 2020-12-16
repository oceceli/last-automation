<?php 

namespace App\Models\Traits;

use App\Models\Setting;

trait HasQueries
{
    public function getDatatablePerpage($default = 30) : int
    {
        $result = Setting::where(['user_id' => auth()->user()->id, 'name' => 'datatable_perpage'])->first();

        return $result 
            ? (int)abs($result->value)
            : $default;
    }

    public function setDatatablePerpage($value)
    {
        auth()->user()->settings()->updateOrCreate(
            ['name' => 'datatable_perpage'], 
            ['value' => $value],
        );
    }
}