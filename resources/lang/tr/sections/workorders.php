<?php

return [
    // icons ******************* 
    'wo_complete_icon' => 'power',
    'wo_completed_icon' => 'checkmark',
    'wo_in_progress_icon' => 'loading cog',
    'wo_active_icon' => 'clock outline',
    'wo_inactive_icon' => 'grey ban icon',
    // icons ******************* 

    // details
    'production_completed' => 'Üretim tamamlandı',
    'belonged_workorder' => 'Ait olduğu iş emri',

    'product_id' => 'Reçete no ???',
    'lot_no' => 'Lot No',
    'amount' => 'Miktar',
    'datetime' => 'Planlanan Tarih',
    'code' => 'İş Emri No',
    'queue' => 'Şarj no',
    'is_active' => 'Aktif',
    'in_progress' => 'Üretiliyor',
    'is_completed' => 'Tamamlandı',
    'note' => 'Açıklama',
    

    'daily_production' => 'Günlük üretim',

    'create' => [
        'header' => 'İş Emri Oluştur',
        'subheader' => '',
    ],

    'details' => [
        'header' => 'İş emri detay',
        'subheader' => ':workorder',
    ],
    
    'edit' => [
        'header' => 'İş emrini düzenle',
        'subheader' => ':workorder',
    ],

    'no_workorder_found' => 'Hiç iş emri bulunamadı',
    'create_workorder' => 'iş emri oluşturun',
    'select_lot_number' => 'Lot seçiniz',
    'necessary_amount' => 'Gerekli miktar',
    'available' => 'Kullanılabilir',
    'reserve_sources' => 'Kaynakları rezerve et',
    'reserved_sources' => 'Rezerve edilen kaynaklar',
    'reserve_sources_for_product' => ':product Üretimi İçin Kaynak Rezervi',
    'specified_sources_are_enough_for_manufacturing' => 'Belirtilen kaynaklar üretimi karşılar düzeyde.',
    'amount_more_required' => ':amount daha gerekli',
    // 'reserve' => 'Rezerve',
    'reserved' => 'Rezerve edildi',
    'reserve_lot' => 'Rezerve lot',
    'reserve_amount' => 'Rezerve miktarı',
    'reserved_amount' => 'Rezerve edilen miktar',
    'reserved_resources_for_manufacturing_product' => ':product üretimi için rezerve edilen kaynaklar',
    // 'reserved_sources_will_be_deducted_when_manufacturing_finalized' => 'Rezerve edilen kaynaklar üretim bittiğinde stoktan düşecek',
    'specified_resources_reserved_to_use_in_production' => 'Belirtilen kaynaklar üretimde kullanılmak üzere rezerve edildi',
    'reserved_sources_will_be_used_as_needed_when_production_is_finalized' => 'Üretim tamamlandığında rezerve edilen kaynaklar ihtiyaç duyulduğu kadar kullanılır.',
    'insufficient_sources' => 'Yetersiz kaynaklar',
    // 'please_make_sure_if_sources_is_enough_for_production' => '',
    // 'please_fulfil_the_necessary_sources_in_order_to_continue_production' => 'Üretime devam edebilmek için gerekli malzemelerin stok girişini yapmalısınız.',
    'please_reserve_enough_amount_of_sources_in_order_to_continue_production' => 'Üretime devam edebilmek için yeterli miktarda kaynağı rezerve etmelisiniz.',

    'necessary_items_and_amounts_will_be_shown_here' => 'Üretim için gerekli malzeme ve miktarlar burada görüntülenecek',
    'please_fill_in_the_amount_and_unit_fields' => 'Lütfen miktar ve birim alanlarını doldurun.',
    'specify_sources' => 'Kaynakları belirt',
    'please_specify_all_necessary_sources_for_production' => 'Lütfen üretim için gerekli kaynakları belirtin',
    // 'these_items_will_be_reduced_from_stock_after_production' => 'Üretimden sonra stoktan eksilecek malzemeler',
    'items_to_be_used_in_production' => 'Üretimde kullanılacak malzemeler',
    'recipe_ingredients_must_be_correct_for_keep_inventory_flawless' => 'Doğru stok takibi yapabilmek için ürün reçetesi eksiksiz olmalıdır.',
    'workorder_saved_successfully' => 'İş emri kaydedildi',
    // 'todays_work_orders' => 'Bugüne ait iş emirleri',
    'daily_work_orders' => 'Günlük iş emri',
    'production_is_completed' => 'Üretim tamamlandı',
    // 'see_production_results' => 'Üretim sonuçlarını gör',
    'production_continues' => 'Üretim sürüyor',
    'on_hold' => 'Beklemede',

    'wo_status' => 'Durum',
    'wo_suspended' => 'İş emri askıya alındı',
    'wo_unsuspended' => 'İş emri üretimi bekliyor',
    'wo_complete' => 'Bitir',
    'wo_start' => 'İşi başlat',
    'wo_delete' => 'İş emrini sil',
    'abort_this_work_order' => 'Bu üretimi iptal et',
    'production_aborted' => 'Üretim iptal edildi',
    'reserved_sources_released' => 'Rezerve edilen kaynaklar serbest bırakıldı',
    'reserved_sources_deducted_from_stocks_and_product_added_to_stock' => 'Rezerve edilen kaynaklar stoktan çıkarıldı, :product stoğa eklendi.',
    'production_results_will_not_be_processed' => 'Üretim sonucu stoğa işlenmeyecek.',

    'waiting_for_production' => 'Üretim bekleniyor...',
    'production_started' => 'Üretim başladı',
    'started_at_time' => ':time başladı',
    'production_started_at_time' => 'Üretim :time başladı',
    // 'a_work_order_already_in_progress' => 'Bir iş bitmeden diğeri başlayamaz!',
    'all_stock_moves_will_be_deleted_which_is_added_by_this_wo' => 'Üretim sonucu stoğa eklenen/çıkarılan bütün ürünler iptal edilecek!',
    'this_work_order_is_not_finished_in_time_should_end_now' => 'Bu iş emri zamanında bitmemiş, sonlandırılması gerekiyor!',
    // 'wo_completed_with_zero_production' => 'İş bitti, stoğa ekleme yapılmadı...',

    'there_is_no_any_schuled_work_today' => 'Bugün için bir iş programı oluşturulmadı',
];