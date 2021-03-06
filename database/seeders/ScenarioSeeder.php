<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Company;
use App\Models\Product;
use App\Models\Recipe;
use App\Models\Unit;
use App\Models\User;
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
        $yariMamul = $this->cCategory('Yarı mamül');
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

        // yarı mamül
        $fb01 = $this->cProduct($yariMamul->id, 'litre', 'Ren Bikar Bazik Solüsyon', 'fb01', null, true);
        

        // içerik  **********************
        // kimyasallar
        $sodyumBikarbonat = $this->cProduct($hammadde->id, 'kilogram', 'Sodyum bikarbonat', 'sdymbkr');
        $sodyumKlorur = $this->cProduct($hammadde->id, 'Kilogram', 'Sodyum Klorür', 'sdymklr');
        $potasyumKlorur = $this->cProduct($hammadde->id, 'Kilogram', 'Potasyum klorür', 'ptsklr');
        $kalsiyumKlorur = $this->cProduct($hammadde->id, 'Kilogram', 'Kalsiyum Klorür', 'klsklr');
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
        
        $ribonLg = $this->cProduct($sarf->id, 'adet', 'Ribon 110x600', 'rbn110x600');
        $ribonSm = $this->cProduct($sarf->id, 'adet', 'Ribon 50x600', 'rbn50x600');
        

        // extra units ***************************************************** 
        $this->cUnit($rm004->id, 'litre', 'lt', 6, false, $rm004->baseUnit->id);
        $this->cUnit($rm001->id, 'litre', 'lt', 10, false, $rm001->baseUnit->id);
        $this->cUnit($rm029->id, 'litre', 'lt', 10, false, $rm029->baseUnit->id);
        $this->cUnit($rm026->id, 'litre', 'lt', 10, false, $rm026->baseUnit->id);
        $this->cUnit($rm036->id, 'litre', 'lt', 10, false, $rm036->baseUnit->id);
        $this->cUnit($rm038->id, 'litre', 'lt', 5, false, $rm038->baseUnit->id);
        $this->cUnit($rmd02->id, 'litre', 'lt', 5, false, $rmd02->baseUnit->id);
        $this->cUnit($rm033->id, 'litre', 'lt', 10, false, $rm033->baseUnit->id);
        // kimyasallar
        $sodyumBikarbonatGram = $this->cUnit($sodyumBikarbonat->id, 'gram', 'gr', 1000, false, $sodyumBikarbonat->baseUnit->id);
        $this->cUnit($sodyumKlorur->id, 'gram', 'gr', 1000, false, $sodyumKlorur->baseUnit->id);
        $this->cUnit($potasyumKlorur->id, 'gram', 'gr', 1000, false, $potasyumKlorur->baseUnit->id);
        $this->cUnit($kalsiyumKlorur->id, 'gram', 'gr', 1000, false, $kalsiyumKlorur->baseUnit->id);
        $this->cUnit($magnezyumKlorur->id, 'gram', 'gr', 1000, false, $magnezyumKlorur->baseUnit->id);
        $this->cUnit($asetikAsit->id, 'gram', 'gr', 1000, false, $asetikAsit->baseUnit->id);
        $this->cUnit($su->id, 'gram', 'gr', 1000, false, $su->baseUnit->id);

        $ribonLgCm = $this->cUnit($ribonLg->id, 'santimetre', 'cm', 60000, false, $ribonLg->baseUnit->id);
        $ribonSmCm = $this->cUnit($ribonSm->id, 'santimetre', 'cm', 60000, false, $ribonSm->baseUnit->id);




        // recipes ***********************************************************
        $rct_fb01 = $this->cRecipe($fb01->id, 'rct_fb01', [
            $sodyumBikarbonat->id => ['amount' => '84', 'unit_id' => $sodyumBikarbonatGram->id, 'literal' => true],
        ]);

        $rct_rm004 = $this->cRecipe($rm004->id, 'rct_rm004', [
            $fb01->id => ['amount' => '6', 'unit_id' => $fb01->baseUnit->id, 'literal' => false],
            $bidon6Lt->id => ['amount' => '1', 'unit_id' => $bidon6Lt->baseUnit->id, 'literal' => false],
            $etiketBazik->id => ['amount' => '1', 'unit_id' => $etiketBazik->baseUnit->id, 'literal' => false],
            $kapakMavi->id => ['amount' => '1', 'unit_id' => $kapakMavi->baseUnit->id, 'literal' => false],
            $ribonSm->id => ['amount' => '7.5', 'unit_id' => $ribonSmCm->id, 'literal' => false],
        ]);
        
        $rct_rm001 = $this->cRecipe($rm001->id, 'rct_rm001', [
            $fb01->id => ['amount' => '10', 'unit_id' => $fb01->baseUnit->id, 'literal' => false],
            $bidon10Lt->id => ['amount' => '1', 'unit_id' => $bidon10Lt->baseUnit->id, 'literal' => false],
            $etiketBazik->id => ['amount' => '1', 'unit_id' => $etiketBazik->baseUnit->id, 'literal' => false],
            $kapakMavi->id => ['amount' => '1', 'unit_id' => $kapakMavi->baseUnit->id, 'literal' => false],
            $ribonSm->id => ['amount' => '7.5', 'unit_id' => $ribonSmCm->id, 'literal' => false],
        ]);



        // müşteri ve adres
        $company = Company::create([
            'cmp_name' => 'Rfm',
            'cmp_commercial_title' => 'Rfm Aş',
            'cmp_current_code' => '28346',
            'cmp_supplier' => true,
            'cmp_customer' => true,
            'cmp_note' => 'Firma notu',
            'cmp_phone' => '03124357589',
            'cmp_tax_number' => '11111',
        ]);
        $address = $company->addresses()->create([
            'adr_name' => 'Ankara Numune Hast',
            'adr_country' => 'Türkiye',
            'adr_province' => 'Ankara',
            'adr_district' => 'Çankaya',
            'adr_body' => 'Cebeci Mah. Keskin cad 234/2',
            'adr_phone' => '03124758374',
        ]);
        
    }


    private function cProduct($categoryId, $unitName, $prd_name, $prd_code, $prd_barcode = null, $prd_producible = false)
    {
        $product = Product::create([
            'category_id' => $categoryId,
            'prd_code' => $prd_code, 
            'prd_barcode' => $prd_barcode, 
            'prd_name' => $prd_name, 
            'prd_shelf_life' => 2,
            'prd_producible' => $prd_producible, 
            'prd_min_threshold' => 50,
        ]);
        $product->units()->create([
            'name' => $unitName, 
            'abbreviation' => 'kısa'. $unitName, 
            'operator' => true,
            'factor' => 1,
            // 'parent_id' => null,
            'is_base' => true,
        ]);
        return $product;
    }

    private function cRecipe($productId, $rcp_code, array $ingredients = [])
    {
        $recipe = Recipe::create([
            'product_id' => $productId,
            'rcp_code' => $rcp_code,
        ]);
        $recipe->ingredients()->sync($ingredients);
    }

    private function cCategory($name)
    {
        return Category::create(['ctg_name' => $name]);
    }   

    private function cUnit($productId, $name, $abbreviation, $factor, $operator, $parentId = null)
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
