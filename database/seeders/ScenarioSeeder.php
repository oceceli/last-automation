<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\StockMove;
use App\Models\Company;
use App\Models\Product;
use App\Models\WorkOrder;
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
        $baklava = $this->cCategory('baklava');
        $pogaca = $this->cCategory('poğaça');
        $hammadde = $this->cCategory("hammadde");
        // $paket = $this->cCategory("paket");

        // $sarf = $this->cCategory('sarf malzeme');
        $yariMamul = $this->cCategory('Yarı mamül');


        // products
        $bklv_ev = $this->cProduct($baklava->id, 'kg', 'Ev Baklavası', 'bklv_ev', '8697521976558', true);
        $bklv_sbyt = $this->cProduct($baklava->id, 'kg', 'Şöbiyet', 'bklv_sbyt', '8699155674821', true);
        $bklv_cvz = $this->cProduct($baklava->id, 'kg', 'Cevizli Baklava', 'bklv_cvz', '8699155674882', true);
        $bklv_fstk = $this->cProduct($baklava->id, 'kg', 'Fıstıklı Baklava', 'bklv_fstk', '8699155674884', true);
        
        $pgc_sd = $this->cProduct($pogaca->id, 'adet', 'Sade Poğaça', 'pgc_sd', '8699155671125', true);
        $pgc_zytn = $this->cProduct($pogaca->id, 'adet', 'Zeytinli Poğaça', 'pgc_zytn', '8699155679917', true);
        $pgc_pynr = $this->cProduct($pogaca->id, 'adet', 'Peynirli Poğaça', 'pgc_pynr', '8699155678534', true);
        $pgc_ksr = $this->cProduct($pogaca->id, 'adet', 'Kaşarlı Poğaça', 'pgc_ksr', '8699155679335', true);
        $pgc_cklt = $this->cProduct($pogaca->id, 'adet', 'Çikolatalı Poğaça', 'pgc_cklt', '8699155679334', true);
        $pgc_ygrt = $this->cProduct($pogaca->id, 'adet', 'Yoğurtlu Poğaça', 'pgc_ygrt', '8699155679339', true);


        // yarı mamül
        $srbt_1 = $this->cProduct($yariMamul->id, 'litre', 'Şerbet', 'srbt_1', null, true);
        $hmr_1 = $this->cProduct($yariMamul->id, 'kg', 'Hamur', 'hmr_1', null, true);
        
        // içerik  **********************
        $un_1 = $this->cProduct($hammadde->id, 'Kilogram', 'Un', 'un_1'); // 13
        $skr_1 = $this->cProduct($hammadde->id, 'Kilogram', 'Şeker', 'skr_1');
        $su = $this->cProduct($hammadde->id, 'Litre', 'su', 'su');
        $ymrt_1 = $this->cProduct($hammadde->id, 'Adet', 'Yumurta', 'ymrt_1');
        $sut_1 = $this->cProduct($hammadde->id, 'Litre', 'Süt', 'sut_1');
        $tuz_1 = $this->cProduct($hammadde->id, 'Kilogram', 'Tuz', 'tuz_1');
        $cvz_1 = $this->cProduct($hammadde->id, 'Kilogram', 'Ceviz', 'cvz_1');
        $fstk_1 = $this->cProduct($hammadde->id, 'Kilogram', 'Fıstık', 'fstk_1');
        $tryg_1 = $this->cProduct($hammadde->id, 'Kilogram', 'Tereyağı', 'tryg_1');
        $my_1 = $this->cProduct($hammadde->id, 'Kilogram', 'Maya', 'my_1');
        $ygrt_1 = $this->cProduct($hammadde->id, 'Kilogram', 'Yoğurt', 'ygrt_1');
        $antp_fstk_tz = $this->cProduct($hammadde->id, 'Kilogram', 'Antep Fıstığı Toz', 'antp_fstk_tz');
        $ksr_1 = $this->cProduct($hammadde->id, 'Kilogram', 'Kaşar Peyniri', 'ksr_1');
        $byz_pynr_1 = $this->cProduct($hammadde->id, 'Kilogram', 'Beyaz Peynir', 'byz_pynr_1');
        $cklt_1 = $this->cProduct($hammadde->id, 'Kilogram', 'Çikolata', 'cklt_1'); // yarı mamül?
        $ssm_1 = $this->cProduct($hammadde->id, 'Kilogram', 'Susam', 'ssm_1');
        $zytn_1 = $this->cProduct($hammadde->id, 'Kilogram', 'Zeytin', 'zytn_1'); // 29




        // diğer 
        // $bklv_kt_kck = $this->cProduct($paket->id, 'adet', 'Baklava Kutusu 500g', 'bklv_kt_kck');
        // $bklv_kt_byk = $this->cProduct($paket->id, 'adet', 'Baklava Kutusu 1000g', 'bklv_kt_byk');
        // $bklv_tps = $this->cProduct($paket->id, 'adet', 'Baklava Tepsisi 5kg', 'bklv_tps');


        

        // extra units ***************************************************** 
        // $this->cUnit($bklv_ev->id, 'kutu', 'kt', 1, false, $bklv_ev->baseUnit->id);
        $this->cUnit($pgc_sd->id, 'tepsi', 'tps', 20, true, $pgc_sd->baseUnit->id);
        $this->cUnit($pgc_zytn->id, 'tepsi', 'tps', 20, true, $pgc_zytn->baseUnit->id);
        $this->cUnit($pgc_pynr->id, 'tepsi', 'tps', 20, true, $pgc_pynr->baseUnit->id);
        $this->cUnit($pgc_ksr->id, 'tepsi', 'tps', 20, true, $pgc_ksr->baseUnit->id);
        $this->cUnit($pgc_cklt->id, 'tepsi', 'tps', 10, true, $pgc_cklt->baseUnit->id);
        $this->cUnit($pgc_ygrt->id, 'tepsi', 'tps', 10, true, $pgc_ygrt->baseUnit->id);


        $srbt_1_lt = $this->cUnit($srbt_1->id, 'mililitre', 'ml', 1000, false, $srbt_1->baseUnit->id);
        $hmr_1_grm = $this->cUnit($hmr_1->id, 'gram', 'gr', 1000, false, $hmr_1->baseUnit->id);
        $un_1_grm = $this->cUnit($un_1->id, 'gram', 'gr', 1000, false, $un_1->baseUnit->id);
        $skr_1_grm = $this->cUnit($skr_1->id, 'gram', 'gr', 1000, false, $skr_1->baseUnit->id);
        $sut_1_grm = $this->cUnit($sut_1->id, 'mililitre', 'ml', 1000, false, $sut_1->baseUnit->id);
        $tuz_1_grm = $this->cUnit($tuz_1->id, 'gram', 'gr', 1000, false, $tuz_1->baseUnit->id);
        $cvz_1_grm = $this->cUnit($cvz_1->id, 'gram', 'gr', 1000, false, $cvz_1->baseUnit->id);
        $fstk_1_grm = $this->cUnit($fstk_1->id, 'gram', 'gr', 1000, false, $fstk_1->baseUnit->id);
        $tryg_1_grm = $this->cUnit($tryg_1->id, 'gram', 'gr', 1000, false, $tryg_1->baseUnit->id);
        $tryg_1_grm = $this->cUnit($tryg_1->id, 'kutu', 'kt', 10, true, $tryg_1->baseUnit->id); // ?
        $my_1_grm = $this->cUnit($my_1->id, 'gram', 'gr', 1000, false, $my_1->baseUnit->id);
        $ygrt_1_grm = $this->cUnit($ygrt_1->id, 'gram', 'gr', 1000, false, $ygrt_1->baseUnit->id);
        $antp_fstk_tz_grm = $this->cUnit($antp_fstk_tz->id, 'gram', 'gr', 1000, false, $antp_fstk_tz->baseUnit->id);
        $ksr_1_grm = $this->cUnit($ksr_1->id, 'gram', 'gr', 1000, false, $ksr_1->baseUnit->id);
        $byz_pynr_1_grm = $this->cUnit($byz_pynr_1->id, 'gram', 'gr', 1000, false, $byz_pynr_1->baseUnit->id);
        $cklt_1_grm = $this->cUnit($cklt_1->id, 'gram', 'gr', 1000, false, $cklt_1->baseUnit->id);
        $ssm_1_grm = $this->cUnit($ssm_1->id, 'gram', 'gr', 1000, false, $ssm_1->baseUnit->id);
        $zytn_1_grm = $this->cUnit($zytn_1->id, 'gram', 'gr', 1000, false, $zytn_1->baseUnit->id);
        $su_grm = $this->cUnit($su->id, 'gram', 'gr', 1000, false, $su->baseUnit->id);
        
        $this->cUnit($ymrt_1->id, 'koli', 'koli', 30, true, $ymrt_1->baseUnit->id); // ?

        // $ribonLgCm = $this->cUnit($ribonLg->id, 'santimetre', 'cm', 60000, false, $ribonLg->baseUnit->id);
        // $ribonSmCm = $this->cUnit($ribonSm->id, 'santimetre', 'cm', 60000, false, $ribonSm->baseUnit->id);




        // recipes ***********************************************************
        $rct_bklv_ev = $this->cRecipe($bklv_ev->id, 'rct_bklv_ev', [
            $srbt_1->id => ['amount' => '400', 'unit_id' => $srbt_1_lt->id, 'literal' => true],
            $hmr_1->id => ['amount' => '600', 'unit_id' => $hmr_1_grm->id, 'literal' => true],
            $su->id => ['amount' => '300', 'unit_id' => $su_grm->id, 'literal' => true],
            $ymrt_1->id => ['amount' => '5', 'unit_id' => $ymrt_1->baseUnit->id, 'literal' => true],
        ]);
        
        $rct_bklv_sbyt = $this->cRecipe($bklv_sbyt->id, 'rct_bklv_sbyt', [
            $srbt_1->id => ['amount' => '500', 'unit_id' => $srbt_1_lt->id, 'literal' => true],
            $hmr_1->id => ['amount' => '500', 'unit_id' => $hmr_1_grm->id, 'literal' => true],
            $su->id => ['amount' => '300', 'unit_id' => $su_grm->id, 'literal' => true],
            $antp_fstk_tz->id => ['amount' => '50', 'unit_id' => $antp_fstk_tz_grm->id, 'literal' => true],
            $ymrt_1->id => ['amount' => '6', 'unit_id' => $ymrt_1->baseUnit->id, 'literal' => true],
        ]);
        
        $rct_bklv_cvz = $this->cRecipe($bklv_cvz->id, 'rct_bklv_cvz', [
            $ymrt_1->id => ['amount' => '4', 'unit_id' => $ymrt_1->baseUnit->id, 'literal' => true],
            $srbt_1->id => ['amount' => '400', 'unit_id' => $srbt_1_lt->id, 'literal' => true],
            $hmr_1->id => ['amount' => '500', 'unit_id' => $hmr_1_grm->id, 'literal' => true],
            $su->id => ['amount' => '300', 'unit_id' => $su_grm->id, 'literal' => true],
            $antp_fstk_tz->id => ['amount' => '50', 'unit_id' => $antp_fstk_tz_grm->id, 'literal' => true],
            $cvz_1->id => ['amount' => '100', 'unit_id' => $cvz_1_grm->id, 'literal' => true],
        ]);
        
        $rct_bklv_fstk = $this->cRecipe($bklv_fstk->id, 'rct_bklv_fstk', [
            $ymrt_1->id => ['amount' => '4', 'unit_id' => $ymrt_1->baseUnit->id, 'literal' => true],
            $srbt_1->id => ['amount' => '400', 'unit_id' => $srbt_1_lt->id, 'literal' => true],
            $hmr_1->id => ['amount' => '500', 'unit_id' => $hmr_1_grm->id, 'literal' => true],
            $su->id => ['amount' => '300', 'unit_id' => $su_grm->id, 'literal' => true],
            $antp_fstk_tz->id => ['amount' => '50', 'unit_id' => $antp_fstk_tz_grm->id, 'literal' => true],
            $fstk_1->id => ['amount' => '100', 'unit_id' => $fstk_1_grm->id, 'literal' => true],
        ]);
        
        

        $rct_pgc_sd = $this->cRecipe($pgc_sd->id, 'rct_pgc_sd', [
            $ymrt_1->id => ['amount' => '1', 'unit_id' => $ymrt_1->baseUnit->id, 'literal' => true],
            $hmr_1->id => ['amount' => '100', 'unit_id' => $hmr_1_grm->id, 'literal' => true],
            $su->id => ['amount' => '300', 'unit_id' => $su_grm->id, 'literal' => true],
            $my_1->id => ['amount' => '300', 'unit_id' => $my_1_grm->id, 'literal' => true],
            $tuz_1->id => ['amount' => '300', 'unit_id' => $tuz_1_grm->id, 'literal' => true],
            $ssm_1->id => ['amount' => '5', 'unit_id' => $ssm_1_grm->id, 'literal' => true],
        ]);
        
        $rct_pgc_zytn = $this->cRecipe($pgc_zytn->id, 'rct_pgc_zytn', [
            $ymrt_1->id => ['amount' => '1', 'unit_id' => $ymrt_1->baseUnit->id, 'literal' => true],
            $hmr_1->id => ['amount' => '100', 'unit_id' => $hmr_1_grm->id, 'literal' => true],
            $su->id => ['amount' => '300', 'unit_id' => $su_grm->id, 'literal' => true],
            $my_1->id => ['amount' => '300', 'unit_id' => $my_1_grm->id, 'literal' => true],
            $tuz_1->id => ['amount' => '300', 'unit_id' => $tuz_1_grm->id, 'literal' => true],
            $zytn_1->id => ['amount' => '30', 'unit_id' => $zytn_1_grm->id, 'literal' => true],
        ]);
        
        $rct_pgc_pynr = $this->cRecipe($pgc_pynr->id, 'rct_pgc_pynr', [
            $ymrt_1->id => ['amount' => '1', 'unit_id' => $ymrt_1->baseUnit->id, 'literal' => true],
            $hmr_1->id => ['amount' => '100', 'unit_id' => $hmr_1_grm->id, 'literal' => true],
            $su->id => ['amount' => '300', 'unit_id' => $su_grm->id, 'literal' => true],
            $my_1->id => ['amount' => '300', 'unit_id' => $my_1_grm->id, 'literal' => true],
            $tuz_1->id => ['amount' => '300', 'unit_id' => $tuz_1_grm->id, 'literal' => true],
            $byz_pynr_1->id => ['amount' => '30', 'unit_id' => $byz_pynr_1_grm->id, 'literal' => true],
        ]);
        
        $rct_pgc_ksr = $this->cRecipe($pgc_ksr->id, 'rct_pgc_ksr', [
            $ymrt_1->id => ['amount' => '1', 'unit_id' => $ymrt_1->baseUnit->id, 'literal' => true],
            $hmr_1->id => ['amount' => '100', 'unit_id' => $hmr_1_grm->id, 'literal' => true],
            $su->id => ['amount' => '300', 'unit_id' => $su_grm->id, 'literal' => true],
            $my_1->id => ['amount' => '300', 'unit_id' => $my_1_grm->id, 'literal' => true],
            $tuz_1->id => ['amount' => '300', 'unit_id' => $tuz_1_grm->id, 'literal' => true],
            $ksr_1->id => ['amount' => '20', 'unit_id' => $ksr_1_grm->id, 'literal' => true],
            $ssm_1->id => ['amount' => '5', 'unit_id' => $ssm_1_grm->id, 'literal' => true],
        ]);
        
        $rct_pgc_cklt = $this->cRecipe($pgc_cklt->id, 'rct_pgc_cklt', [
            $ymrt_1->id => ['amount' => '1', 'unit_id' => $ymrt_1->baseUnit->id, 'literal' => true],
            $hmr_1->id => ['amount' => '100', 'unit_id' => $hmr_1_grm->id, 'literal' => true],
            $su->id => ['amount' => '300', 'unit_id' => $su_grm->id, 'literal' => true],
            $my_1->id => ['amount' => '300', 'unit_id' => $my_1_grm->id, 'literal' => true],
            $tuz_1->id => ['amount' => '300', 'unit_id' => $tuz_1_grm->id, 'literal' => true],
            $cklt_1->id => ['amount' => '15', 'unit_id' => $cklt_1_grm->id, 'literal' => true],
        ]);
        
        $rct_pgc_ygrt = $this->cRecipe($pgc_ygrt->id, 'rct_pgc_ygrt', [
            $ymrt_1->id => ['amount' => '1', 'unit_id' => $ymrt_1->baseUnit->id, 'literal' => true],
            $hmr_1->id => ['amount' => '100', 'unit_id' => $hmr_1_grm->id, 'literal' => true],
            $su->id => ['amount' => '300', 'unit_id' => $su_grm->id, 'literal' => true],
            $my_1->id => ['amount' => '300', 'unit_id' => $my_1_grm->id, 'literal' => true],
            $tuz_1->id => ['amount' => '300', 'unit_id' => $tuz_1_grm->id, 'literal' => true],
            $ygrt_1->id => ['amount' => '15', 'unit_id' => $ygrt_1_grm->id, 'literal' => true],
            $ssm_1->id => ['amount' => '5', 'unit_id' => $ssm_1_grm->id, 'literal' => true],
        ]);
        
        
        
        $rct_srbt_1 = $this->cRecipe($srbt_1->id, 'rct_srbt_1', [
            $skr_1->id => ['amount' => '600', 'unit_id' => $skr_1_grm->id, 'literal' => true],
            $su->id => ['amount' => '500', 'unit_id' => $su_grm->id, 'literal' => true],
        ]);
        
        $rct_hmr_1 = $this->cRecipe($hmr_1->id, 'rct_hmr_1', [
            $un_1->id => ['amount' => '700', 'unit_id' => $un_1_grm->id, 'literal' => true],
            $su->id => ['amount' => '550', 'unit_id' => $su_grm->id, 'literal' => true],
        ]);

        
        WorkOrder::factory()->count(50)->create();
        StockMove::factory()->count(20)->create();
        StockMove::factory()->count(20)->create();
        StockMove::factory()->count(20)->create();
        StockMove::factory()->count(20)->create();


        // müşteri ve adres
        $company1 = Company::create([
            'cmp_name' => 'Halis Gıda',
            'cmp_commercial_title' => 'HALİS GIDA AŞ.',
            'cmp_current_code' => '123456',
            'cmp_supplier' => false,
            'cmp_customer' => true,
            'cmp_note' => 'Değerli b2b müşterimiz',
            'cmp_phone' => '0123456789',
            'cmp_tax_number' => '111121111',
        ]);
        $address1 = $company1->addresses()->create([
            'adr_name' => 'Halis Gıda Ana Bayii',
            'adr_country' => 'Türkiye',
            'adr_province' => 'İstanbul',
            'adr_district' => 'Beykoz',
            'adr_body' => 'Çukurca Mah. Keskin Cad 23A/2',
            'adr_phone' => '02468101214',
            'adr_note' => 'Keskin caddesi üzeri büyük Cami karşısı',
        ]);
        
        $company2 = Company::create([
            'cmp_name' => 'Hikmet Pastanesi',
            'cmp_commercial_title' => 'HİKMET PASTANECİLİK AŞ.',
            'cmp_current_code' => '1234567',
            'cmp_supplier' => false,
            'cmp_customer' => true,
            'cmp_note' => 'Bir diğer değerli b2b müşterimiz',
            'cmp_phone' => '0123456789',
            'cmp_tax_number' => '111131111',
        ]);
        $address2 = $company2->addresses()->create([
            'adr_name' => 'Hikmet Pastanesi',
            'adr_country' => 'Türkiye',
            'adr_province' => 'İstanbul',
            'adr_district' => 'Beşiktaş',
            'adr_body' => 'Elma Mah. Armut Cad. 53S/7',
            'adr_phone' => '013579111315',
        ]);
        
        $company2 = Company::create([
            'cmp_name' => 'Büyük Değirmen Un Fabrikası',
            'cmp_commercial_title' => 'BUYUK DEĞİRMEN URETİM VE TİCARET AŞ.',
            'cmp_current_code' => '12345678',
            'cmp_supplier' => true,
            'cmp_customer' => false,
            'cmp_note' => 'Bir diğer değerli b2b müşterimiz',
            'cmp_phone' => '0123456789',
            'cmp_tax_number' => '11141111',
        ]);
        $address2 = $company2->addresses()->create([
            'adr_name' => 'Büyük Değirmen Kadıköy',
            'adr_country' => 'Türkiye',
            'adr_province' => 'İstanbul',
            'adr_district' => 'Kadıköy',
            'adr_body' => 'Kurşunlu Mah. 2. Bulvar 12. Cd. 45',
            'adr_phone' => '0135791133345',
        ]);
        
        $company3 = Company::create([
            'cmp_name' => 'Yeşilyol Unlu Mamuller',
            'cmp_commercial_title' => 'YEŞİLYOL UNLU MAMULLER AŞ.',
            'cmp_current_code' => '1234565',
            'cmp_supplier' => true,
            'cmp_customer' => true,
            'cmp_note' => 'Bir diğer değerli b2b müşterimiz',
            'cmp_phone' => '0123456789',
            'cmp_tax_number' => '111511111',
        ]);
        $address3a = $company3->addresses()->create([
            'adr_name' => 'Yeşilyol Unlu Mamuller Ataşehir Şube',
            'adr_country' => 'Türkiye',
            'adr_province' => 'İstanbul',
            'adr_district' => 'Ataşehir',
            'adr_body' => 'Kestane Mah. Yağmur Cad. Yıldırım Sk. 53S/7',
            'adr_phone' => '013579112343',
        ]);
        $address3b = $company3->addresses()->create([
            'adr_name' => 'Yeşilyol Unlu Mamuller Fatih Şube',
            'adr_country' => 'Türkiye',
            'adr_province' => 'İstanbul',
            'adr_district' => 'Fatih',
            'adr_body' => 'Güllü Mah. Yağmur Cad. 66/1',
            'adr_phone' => '013579112344',
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
