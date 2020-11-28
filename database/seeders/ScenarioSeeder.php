<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Unit;
use Illuminate\Database\Seeder;

class ScenarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // categories
        $bazik = $this->cCategory('bazik');
        $acet = $this->cCategory('acet');
        $glukoz = $this->cCategory('glukoz');
        $diyaplus = $this->cCategory('diyaplus');
        $hammadde = $this->cCategory('hammadde');
        $sarf = $this->cCategory('sarf malzeme');


        // products
        $rm004 = $this->cProduct($bazik->id, 'adet', 'ren bikar bazik 6lt', 'rm004', '8699645660025', true);
        $rmd02 = $this->cProduct($diyaplus->id, 'adet', 'DİYAPLUS C50', 'rmd02', '8699645662869', true);
        $rm001 = $this->cProduct($bazik->id, 'adet', 'ren bikar bazik 10lt', 'rm001', '8699645660018', true);
        $rm026 = $this->cProduct($acet->id, 'adet', 'K2 Ca 1,25', 'rm026', '8699645660698', true);
        $rm029 = $this->cProduct($acet->id, 'adet', 'K2 Ca 1,75 Mg 1,0 Ac 8 10Lt', 'rm029', '8699645660902', true);
        $rm036 = $this->cProduct($glukoz->id, 'adet', 'K2 Ca 1,5 G+ 10lt', 'rm036', '8699645660759', true);
        $rm038 = $this->cProduct($glukoz->id, 'adet', 'K2 Ca 1,5 G+ 5lt', 'rm038', '8699645660773', true);
        $rm033 = $this->cProduct($acet->id, 'adet', 'K2 Ca 1,5 10lt', 'rm033', '8699645660230', true);
        

        // içerik  **********************
        // kimyasallar
        $sodyumBikarbonat = $this->cProduct($hammadde->id, 'kilogram', 'Sodyum bikarbonat', 'sdymbkr');
        $sodyumKlorur = $this->cProduct($hammadde->id, 'Kilogram', 'Sodyum Klorür', 'sdymklr');
        $potasyumKlorur = $this->cProduct($hammadde->id, 'Kilogram', 'Potasyum klorür', 'ptsklr');
        $kalsiyumKlorur = $this->cProduct($hammadde->id, 'Kilogram', 'Kalsiyum Klorur', 'klsklr');
        $magnezyumKlorur = $this->cProduct($hammadde->id, 'Kilogram', 'magnezyum klorür', 'mgnzymklr');
        $asetikAsit = $this->cProduct($hammadde->id, 'Kilogram', 'asetik asit', 'astkast');
        $su = $this->cProduct($hammadde->id, 'Litre', 'su', 'su');

        // diğer 
        // bidon -------
        $bidon5Lt = $this->cProduct($hammadde->id, 'adet', 'Bidon 5lt', 'bdn5lt');
        $bidon6Lt = $this->cProduct($hammadde->id, 'adet', 'Bidon 6lt', 'bdn6lt');
        $bidon8Lt = $this->cProduct($hammadde->id, 'adet', 'Bidon 8lt', 'bdn8lt');
        $bidon10Lt = $this->cProduct($hammadde->id, 'adet', 'Bidon 10lt', 'bdn10lt');
        // etiket ------
        $etiketBazik = $this->cProduct($hammadde->id, 'adet', 'etiket bazik', 'etktbzk');
        $etiketAsit = $this->cProduct($hammadde->id, 'adet', 'etiket asit', 'etktast');
        $etiketGlukoz = $this->cProduct($hammadde->id, 'adet', 'etiket glukoz', 'etktglkz');
        $etiketDiyaplus = $this->cProduct($hammadde->id, 'adet', 'etiket diyaplus', 'etktdypls');
        // kapak ---------
        $kapakKirmizi = $this->cProduct($hammadde->id, 'adet', 'kapak kırmızı', 'kpkkrmz');
        $kapakMavi = $this->cProduct($hammadde->id, 'adet', 'kapak mavi', 'kpkmv');
        $kapaksari = $this->cProduct($hammadde->id, 'adet', 'kapak sarı', 'kpksr');
        
        
        



        // extra units ***************************************************** 
        $this->cUnit($rm004->id, 'litre', 'lt', 6, false, $rm004->baseUnit->id);
        $this->cUnit($rm029->id, 'litre', 'lt', 10, false, $rm029->baseUnit->id);
        $this->cUnit($rm026->id, 'litre', 'lt', 10, false, $rm026->baseUnit->id);
        $this->cUnit($rm036->id, 'litre', 'lt', 10, false, $rm036->baseUnit->id);
        $this->cUnit($rm038->id, 'litre', 'lt', 5, false, $rm038->baseUnit->id);
        $this->cUnit($rmd02->id, 'litre', 'lt', 5, false, $rmd02->baseUnit->id);
        $this->cUnit($rm033->id, 'litre', 'lt', 10, false, $rm033->baseUnit->id);
        // kimyasallar
        $this->cUnit($sodyumBikarbonat->id, 'gram', 'gr', 1000, false, $sodyumBikarbonat->baseUnit->id);
        $this->cUnit($sodyumKlorur->id, 'gram', 'gr', 1000, false, $sodyumKlorur->baseUnit->id);
        $this->cUnit($potasyumKlorur->id, 'gram', 'gr', 1000, false, $potasyumKlorur->baseUnit->id);
        $this->cUnit($kalsiyumKlorur->id, 'gram', 'gr', 1000, false, $kalsiyumKlorur->baseUnit->id);
        $this->cUnit($magnezyumKlorur->id, 'gram', 'gr', 1000, false, $magnezyumKlorur->baseUnit->id);
        $this->cUnit($asetikAsit->id, 'gram', 'gr', 1000, false, $asetikAsit->baseUnit->id);
        $this->cUnit($su->id, 'gram', 'gr', 1000, false, $su->baseUnit->id);
        
    }


    private function cProduct($categoryId, $unitName, $name, $code, $barcode = null, $producible = false)
    {
        $product = Product::create([
            'category_id' => $categoryId,
            'code' => $code, 
            'barcode' => $barcode, 
            'name' => $name, 
            'shelf_life' => 2,
            'producible' => $producible, 
            'min_threshold' => 50,
        ]);
        $product->units()->create([
            'name' => $unitName, 
            'abbreviation' => 'kısa'. $unitName, 
            'operator' => true,
            'factor' => 1,
            'parent_id' => 0
        ]);
        return $product;

    }

    private function cCategory($name)
    {
        return Category::create(['name' => $name]);
    }   

    private function cUnit($productId, $name, $abbreviation, $factor, $operator, $parentId)
    {
        return Unit::create([
            'product_id' => $productId, 
            'name' => $name, 
            'abbreviation' => $abbreviation, 
            'factor' => $factor,
            'operator' => $operator, 
            'parent_id' => $parentId,
        ]);
    }

}
