<div>
    {{-- {{ print_r($cards) }}
    <br>
    -----------------
    <br>
    {{ print_r($backupCards) }} --}}
    <x-page-header icon="balance scale" header="sections/units.header" subheader="sections/units.subheader" />
    <x-content theme="red">

        <div class="p-4 shadow-md">
            <div class="ui small form">
                <div class="equal width fields">
                    <x-dropdown label="{{ __('modelnames.product') }}" noErrors
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

                <div class="relative rounded-t" style="min-height: 60%">
                    {{-- x-data="{'materials' : false}" --}}

                       
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
                                        <div wire:key="{{ $key }}">
                                            <div >
                                                @include('web.sections.units.unitCard')
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                </div>

            </div>
        @endif
    </x-content>
    <div x-data="{'questionModal': @entangle('questionModal')}">
        <x-custom-modal position="center" active="questionModal">
            <div class="p-5 flex flex-col gap-5">
                <div class="text-center">
                    <span class="font-bold text-ease text-xl"> Formda değişiklikler var, kaydedilsin mi?</span>
                </div>
                <div class="ui tiny buttons">
                    <button wire:click.prevent="modalCancel()" class="ui basic button">Hayır</button>
                    <button wire:click.prevent="modalSaveEdited()" class="ui primary button">Kaydet</button>
                </div>
            </div>
        </x-custom-modal>   
    </div>
    
</div>

