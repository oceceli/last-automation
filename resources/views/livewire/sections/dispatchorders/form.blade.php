<div>
    <x-content>
        <x-slot name="header">
            <x-page-header icon="truck" header="{{ __('dispatchorders.create_dispatchorder') }}" />
        </x-slot>
        <form class="ui tiny form" wire:submit.prevent="submit">
            <x-form-divider>

                <x-slot name="left">
                    <x-dropdown model="company_id" :collection="$this->companies" value="id" text="cmp_name,cmp_current_code" sClass="search" class="required"
                                label="{{ __('dispatchorders.customer') }}" placeholder="{{ __('dispatchorders.customer') }}" sId="do_company" />
    
                    <x-dropdown model="address_id" initnone dataSourceFunction="getCompanyAddressesProperty" value="id" text="adr_name,adr_province,adr_phone" triggerOnEvent="do_company_selected" sClass="search" class="required" 
                                label="{{ __('dispatchorders.dispatch_address') }}" placeholder="{{ __('dispatchorders.dispatch_address') }}" sId="do_address"  />
                </x-slot>
                
                <x-slot name="right">
                    <x-input defer model="do_number" label="{{ __('validation.attributes.do_number') }}" placeholder="{{ __('validation.attributes.do_number') }}" class="required" />
                    {{-- <x-input defer model="do_datetime" label="{{ __('validation.attributes.do_datetime') }}" placeholder="{{ __('validation.attributes.do_datetime') }}" class="required" /> --}}
                    <x-datepicker model="do_datetime" initialDate="{{ $do_datetime }}" label="{{ __('validation.attributes.do_datetime') }}" class="required field" />
                </x-slot>



                <x-slot name="bottom">
                    <x-page-header>
                        <x-slot name="customHeader">
                            <div class="flex gap-2 text-xs md:text-base">
                                <span class="font-bold text-teal-700">!!! Sevk edilecek ürünler</span>
                            </div>
                        </x-slot>
                        <x-slot name="buttons">
                            <div class="ui mini icon buttons">
                                <button wire:click.prevent @click="materials = true" class="ui mini teal button" data-tooltip="{{ __('sections/recipes.add_ingredients') }}" data-variation="mini">
                                    <i class="plus icon"></i>
                                </button>
                            </div>
                        </x-slot>
                    </x-page-header>

                    {{-- CARD --}}
                    <div class="pt-2"> 
                        <x-card>
                            <x-slot name="square">
                                test
                            </x-slot>
                            <div class="flex gap-3 items-center px-4 flex-1">
                                    <div class="pt-2 equal width fields w-6/12">
                                        <x-dropdown model="product_id" :collection="$this->products" value="id" text="name" sClass="search" class=""
                                            placeholder="{{ __('sections/products.product') }}" sId="dp_product" />
                                            
                                        <x-dropdown model="dp_lot_number" initnone triggerOnEvent="dp_product_selected" dataSourceFunction="getLotsProperty" value="id" text="name" sClass="search" 
                                                placeholder="{{ __('inventory.lot_number') }}" sId="dp_lot" />
                                    </div>
                                    <div class="">
                                        asdfj
                                    </div>
                                </div>
                            </div>
                        </x-card>
                    </div>
                </x-slot>



            </x-form-divider>
        </form>
    </x-content>
</div>