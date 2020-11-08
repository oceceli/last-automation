<div>
    @if ($editMode)
        <x-page-header icon="project diagram" header="sections/workorders.edit.header" subheader="{{ __('sections/workorders.edit.subheader', []) }}" />
    @else
        <x-page-header icon="project diagram" header="sections/workorders.create.header" subheader="sections/workorders.create.subheader" />
    @endif
    
    <x-content theme="purple" buttons>
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
            <div class="equal width fields">
                <div class="field">
                    <label>{{ __('common.note' )}}</label>
                    <textarea wire:model.lazy="note" rows="2"></textarea>
                </div>
            </div>
        </form>
    </x-content>
</div>


