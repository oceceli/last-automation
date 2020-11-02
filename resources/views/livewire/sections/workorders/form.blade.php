<div>
    <x-page-header icon="project diagram" header="sections/workorders.header" subheader="sections/workorders.subheader" />
    
    <x-content theme="purple">
        <form class="ui small form p-6"  wire:submit.prevent="submit">

            <div class="fields equal width">

                <x-dropdown model="product_id" dataSourceFunction="getProductsProperty" class="required" sClass="search" sId="selectProduct"
                    value="id" text="name" label="sections/products.name" placeholder="{{ __('sections/units.unit') }}"  
                />

                <x-input model="lot_no" label="sections/workorders.lot_no" placeholder="sections/workorders.lot_no" class="required field" />

                <x-dropdown iModel="amount" iPlaceholder="sections/recipes.amount" label="sections/workorders.amount"
                    model="unit_id" triggerOn="#selectProduct" dataSourceFunction="getUnitsProperty" sId="asfdsadfsafd" sClass="basic"
                    value="id" text="name" placeholder="{{ __('sections/units.unit') }}" 
                />
            </div>
            <div class="equal width fields">
                <x-input model="code" label="sections/workorders.code" placeholder="sections/workorders.code" class="required field" />                
                <x-input model="queue" label="sections/workorders.queue" placeholder="sections/workorders.queue" class="required field" />                
            </div>

            <div class="equal width fields" wire:ignore>
                <x-datepicker model="datetime" label="sections/workorders.datetime"  class="required field" />
            </div>

            <div class="fields py-4">
                <div class="field">
                    <div class="ui toggle checkbox">
                        <input wire:model.lazy="is_active" type="checkbox">
                        <label>Aktif</label>
                    </div>
                </div>
            </div>  
    
            <div>
                @if ($success)
                    <div class="ui positive icon message">
                        <i class="checkmark  icon"></i>
                        <div class="content">
                            <div class="header">
                                <p>{{ __('common.saved_successfully') }}</p>
                            </div>
                            <p>{{ __('common.saved_successfully') }}</p>
                        </div>
                    </div>
                @endif
                <hr>
            </div>
            
        </form>
    </x-content>
</div>


