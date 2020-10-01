<?php 

namespace App\Models\Traits;

use App\Models\Setting;

trait HasQueries
{
    public function getDatatablePerpage($default = 10) : int
    {
        $result =  Setting::where(function($query) {
            return $query->where('user_id', auth()->user()->id)
                  ->where('name', 'datatable_perpage');
        })->get()->first();

        return $result 
            ? $result->value
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