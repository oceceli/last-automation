<div>
    <x-content theme="purple">
        <x-slot name="header">
            @if ($editMode)
                <x-page-header icon="project diagram" header="sections/workorders.edit.header">
                    <x-slot name="buttons">
                        <div class="ui mini icon buttons">
                            @if ($workOrder->isSuspended())
                                <button wire:key="unsuspend" wire:click.prevent="unsuspend()" class="ui mini basic button" data-tooltip="{{ __('common.suspended') }}" data-variation="mini" data-position="bottom right">
                                    <i class="gray circle icon"></i>
                                </button>
                            @elseif($workOrder->isFinalized())
                                <button class="ui mini basic button" data-tooltip="{{ __('sections/workorders.production_is_completed') }}" data-variation="mini" data-position="bottom right">
                                    <i class="green checkmark icon"></i>
                                </button>
                            @elseif($workOrder->isInProgress())
                                <button class="ui mini basic button" data-tooltip="{{ __('sections/workorders.production_continues') }}" data-variation="mini" data-position="bottom right">
                                    <i class="orange loading cog icon"></i>
                                </button>
                            @else 
                                <button wire:key="suspend" wire:click.prevent="suspend()" class="ui mini basic button" data-tooltip="{{ __('common.active') }}" data-variation="mini" data-position="bottom right">
                                    <i class="green circle icon"></i>
                                </button>
                            @endif
                            @if (!$workOrder->isInProgress())
                                <button wire:click.prevent="openDeleteModal()" class="ui mini basic button" data-tooltip="{{ __('sections/workorders.wo_delete') }}" data-variation="mini" data-position="bottom right">
                                    <i class="red trash icon"></i>
                                </button>
                            @endif
                        </div>
                    </x-slot>
                </x-page-header>
            @else
                <x-page-header icon="project diagram" header="sections/workorders.create.header" subheader="sections/workorders.create.subheader" />
            @endif
        </x-slot>
        <form class="ui small form" wire:submit.prevent="submit">
            <x-form-divider>

                <x-slot name="left">
                    @if ($editMode)
                        <x-dropdown model="product_id" dataSourceFunction="getProductsProperty" class="required" sClass="disabled search" sId="selectProduct"
                            value="id" text="name,code" label="sections/products.product" placeholder="{{ __('sections/units.unit') }}" />
                    @else
                        <x-dropdown model="product_id" dataSourceFunction="getProductsProperty" class="required" sClass="search" sId="selectProduct"
                            value="id" text="name,code" label="sections/products.product" placeholder="{{ __('sections/units.unit') }}" />
                    @endif
                    <x-input model="lot_no" label="sections/workorders.lot_no" placeholder="sections/workorders.lot_no" class="required field" />
                    @if ($editMode)
                    <x-dropdown iModel="amount" iPlaceholder="sections/recipes.amount" label="sections/workorders.amount" class="required"
                        model="unit_id" triggerOnEvent="woProductChanged" dataSourceFunction="getUnitsProperty" sId="units" sClass="basic"
                        value="id" text="name" placeholder="{{ __('sections/units.unit') }}" 
                    />
                    @else 
                    <x-dropdown iModel="amount" iPlaceholder="sections/recipes.amount" label="sections/workorders.amount" class="required"
                        initnone model="unit_id" triggerOnEvent="woProductChanged" dataSourceFunction="getUnitsProperty" sId="units" sClass="basic"
                        value="id" text="name" placeholder="{{ __('sections/units.unit') }}" 
                    />
                    @endif
                    <x-datepicker model="datetime" initialDate="{{ $datetime }}" label="sections/workorders.datetime"   class="required field" />
                    <x-input model="code" label="sections/workorders.code" placeholder="sections/workorders.code" class="required field" />                
                    <x-input model="queue" label="sections/workorders.queue" placeholder="sections/workorders.queue" class="required field" /> 
                </x-slot>
        
        
        
                <x-slot name="right">
                    @if ($this->productSelected())
                    
                        <div class="rounded shadow-lg h-full border md:h-30-rem md:overflow-x-hidden">
                            {{-- @if ($preferStockForm)
                                @include('web.sections.workorders.create.workorderPreferStock') --}}
                            @if($selectedProduct->recipe->ingredients->isEmpty())
                                <x-placeholder icon="red exclamation">
                                    <div class="text-sm">
                                        <div>{{ __('sections/recipes.no_recipe_ingredients_found') }}</div>
                                        <div>{{ __('sections/workorders.recipe_ingredients_must_be_correct_for_keep_inventory_flawless') }}</div>
                                        <div class="pt-5">
                                            <button wire:click.prevent="redirectForAddIngredients()" class="ui mini button">
                                                {{ __('sections/recipes.add_recipe_ingredients') }}
                                            </button>
                                        </div>
                                    </div>
                                </x-placeholder>
                            @else
                                <x-necessary-ingredients :product="$selectedProduct" :amount="$amount" :unitId="$unit_id" noHeader>
                                    {{-- <x-slot name="actions">
                                        <button wire:click.prevent="activatePreferStockForm()" class="ui primary tiny button">
                                            {{ __('sections/workorders.specify_sources') }}
                                        </button>
                                    </x-slot> --}}
                                </x-necessary-ingredients>
                            @endif
                        </div>

                    @else 
                        <x-placeholder icon="primary tasks">
                            <span class="text-sm">
                                {{ __('sections/workorders.necessary_items_and_amounts_will_be_shown_here') }}...
                            </span>
                        </x-placeholder>
                    @endif
                </x-slot>
        
        
                
                <x-slot name="bottom">
                    <div x-data="{addNote: false}">
                        <div x-show="!addNote" class="text-ease">
                            <i class="write icon"></i>
                            <span class="cursor-pointer pt-1 text-sm font-bold" @click="addNote = true">{{ __('common.add_note') }}</span>
                        </div>
                        <div x-show="addNote" class="field">
                            <label><i class="write icon"></i>{{ __('common.note' )}}</label>
                            <textarea wire:model.lazy="note" rows="6"></textarea>
                        </div>
                    </div>
                </x-slot>
        
        
            </x-form-divider>
        </form>

    </x-content>

    @if ($editMode && $workOrder)
        <div x-data="{deleteModal: @entangle('deleteModal')}" x-cloak>
            <x-confirm atConfirm="confirmDelete()" active="deleteModal" color="red" confirm="{{ __('common.delete') }}" deny="{{ __('common.cancel') }}">
                @if ($workOrder->isFinalized())
                    <div class="pb-3"><i class="large red exclamation icon"></i></div>
                    <div>{{ __('common.are_you_sure_you_want_to_delete') }}</div>
                    <div class="text-xs text-ease-red pt-5">{{ __('sections/workorders.all_stock_moves_will_be_deleted_which_is_added_by_this_wo') }}</div>
                @else 
                    <div>{{ __('common.are_you_sure_you_want_to_delete') }}</div>
                @endif
            </x-confirm>
        </div>
    @endif

</div>
