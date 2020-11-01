<div>
    <x-page-header icon="project diagram" header="sections/workorders.header" subheader="sections/workorders.subheader" />
    
    <div class="p-4 bg-white shadow rounded-lg">
        <form class="ui small form p-2"  wire:submit.prevent="submit">

            <div class="fields equal width">
                <div class="required field" wire:ignore>
                    <label>{{ __('sections/products.name') }}</label>
                    <x-dropdown.search model="product_id" :collection="$this->products" value="id" text="name,code" id="selectProduct" class="ui search selection dropdown" />
                    @error('recipe_id')
                        <p class="text-red-500 py-2">{{ucfirst($message)}}</p>
                    @enderror
                </div>
                <x-input model="lot_no" label="sections/workorders.lot_no" placeholder="sections/workorders.lot_no" class="required field" />
                {{-- <x-input model="amount" label="sections/workorders.amount" placeholder="sections/workorders.amount" class="required field" />  --}}
                <x-input-drop iModel="amount" label="sections/workorders.amount" sPlaceholder="sections/units.unit" 
                              sModel="unit_id" sTriggerOn="#selectProduct" sData="getUnitsProperty" sValue="id" sText="name" class="required field" /> 
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
            
            <x-form-buttons />
        </form>
    </div>
</div>


