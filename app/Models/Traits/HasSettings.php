<?php 

namespace App\Models\Traits;

use App\Models\Setting;

trait HasSettings 
{
    
    // Bağlantı polymorhic olacak
    public function settings()
    {
        return $this->hasMany(Setting::class);
    }
    



}