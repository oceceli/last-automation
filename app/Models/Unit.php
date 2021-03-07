<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\ModelHelpers;
use Illuminate\Support\Facades\DB;

class Unit extends Model
{
    use HasFactory, ModelHelpers;

    protected $guarded = [];

    
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    
    // @override
    // public function delete()
    // {
    //     // if($this->isBase()) {
    //     //     return ['message' => '!!! (model) Temel birim silinemez!', 'type' => 'error'];
    //     // } elseif($this->hasChildren()) {
    //     if($this->hasChildren()) {
    //         return ['message' => '!!! (model) Bu birime bağlı birimler olduğu için silinemez!', 'type' => 'error'];
    //     } elseif($this->isUsedInRecipe()) {
    //         return ['message' => '!!! (model) '. $this->product->prd_name .' ürününe ait bu birim bir/birkaç reçetede kullanıldığı için silinemez!', 'type' => 'error'];
    //     } elseif($this->isUsedInWorkOrder()) {
    //         return ['message' => '!!! (model) '. $this->product->prd_name .' ürününe ait bu birim bir/birkaç iş emrinde kullanıldığı için silinemez!', 'type' => 'error'];
    //     }
    //     else {
    //         parent::delete();
    //         return ['message' => '!!! (model) Birim sorunsuzca kaldırıldı...', 'type' => 'success'];
    //     }
    // }

    public function isBase()
    {
        return $this->is_base;
    }

    public function hasChildren()
    {
        return $this->children()->exists();
    }

    
    public function isUsedInRecipe()
    {
        return DB::table('product_recipe')->where('unit_id', $this->id)->exists();
    }

    public function isUsedInWorkOrder() 
    {
        return DB::table('work_orders')->where('unit_id', $this->id)->exists();
    }


    public function hasDescendant($unit) // ? parent_id backend koruması ekle, çocuğunun çocuğu olamasın kendinin. update'e eklenecek
    {
        if( ! $unit) return false;

        if($unit instanceof self) {
            if($this->id == $unit->parent_id) return true;
            return $this->hasDescendant($unit->parent);
        } 
    }


    

    /**
     * Get unit name ucfirst 
     */
    public function getNameAttribute($value)
    {
        return ucfirst($value);
    }
    
    
    

    // /**
    //  * Validate rules for current model
    //  */
    // public static function rules()
    // {
    //     $id = self::getRequestID(); // use for unique keys on update event
    //     return [
    //         'data' => [
    //             'parent_id' => 'required|int|min:0',
    //             'product_id' => 'required|int|min:1',
    //             'name' => 'required|max:30',
    //             'abbreviation' => 'required|max:10',
    //             'operator' => 'required|boolean',
    //             'factor' => 'required|numeric'
    //         ],
    //         'relation' => [ // use for many to many relationships
    //             //
    //         ],
    //     ];
    // }


    // public static function getBaseUnit($productId)
    // {
    //     return self::where(['product_id' => $productId, 'parent_id' => 0])->first();
    // }
    
}
