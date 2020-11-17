<div>
    <x-page-header icon="balance scale" header="sections/units.header" subheader="sections/units.subheader" />
    <x-content theme="red">

        <div class="p-4 shadow-md">
            <div class="ui small form">
                <div class="equal width fields">
                    <x-dropdown label="{{ __('modelnames.product') }}"
                        placeholder="{{ __('common.dropdown_placeholder') }}" model="product_id"
                        dataSourceFunction="getProductsProperty" sId="selectProduct" sClass="search" value="id"
                        text="name">
                    </x-dropdown>
                </div>
            </div>
        </div>


        @if ($selectedProduct)
            <div class="px-5 pb-5">

                @include('web.sections.units.unitsHeader')

                <div class="relative rounded-t" style="min-height: 60%"
                    x-data="{'materials' : false}">

                       
                        <div class="px-2 py-7">
                            <div class="flex flex-col gap-3">
                                @if ( ! $cards)
                                    <div class="ui placeholder segment h-full">
                                        <div class="ui icon header">
                                            <i class="weight icon"></i>
                                            Birim oluşturmak için ekle butonunu kullanın
                                        </div>
                                        <div class="text-sm text-center"></div>
                                    </div>
                                @else
                                    @foreach ($cards as $key => $card)
                                        @include('web.sections.units.unitCard')
                                    @endforeach
                                @endif
                            </div>
                        </div>
                </div>

            </div>
        @endif
    </x-content>

</div>
