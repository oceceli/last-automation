<div>
    <x-page-title icon="project diagram" header="sections/workorders.header" subheader="sections/workorders.subheader" />
    
    <div class="p-4 bg-white shadow rounded-lg">
        <form class="ui form p-2"  wire:submit.prevent="submit">

            <div class="fields equal width">
                <div class="required field" wire:ignore>
                    <label>{{ __('sections/products.name') }}</label>
                    <x-dropdown.search model="recipe_id" :collection="$this->products" value="recipe->id" text="name,code" class="ui search selection dropdown" />
                    @error('recipe_id')
                        <p class="text-red-500 py-2">{{ucfirst($message)}}</p>
                    @enderror
                </div>
                <x-input model="lot_no" label="sections/workorders.lot_no" placeholder="sections/workorders.lot_no" class="required field" />

                {{-- <x-input model="amount" label="sections/workorders.amount" placeholder="sections/workorders.amount" class="required field" />  --}}
                <x-input-drop inputModel="amount" label="sections/workorders.amount" selectPlaceholder="sections/units.unit"
                              selectModel="unit_id" :selectData="$this->units" selectValue="id" selectText="name" class="required field" /> 
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


