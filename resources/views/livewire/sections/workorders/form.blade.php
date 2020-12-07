
<div>
    @if ($editMode)
        <x-page-header icon="project diagram" header="sections/workorders.edit.header">
            <x-slot name="buttons">
                <div class="ui mini icon buttons">
                    <button wire:click.prevent="openDeleteModal()" class="ui mini gray basic button" data-tooltip="{{ __('sections/workorders.wo_delete') }}" data-variation="mini" data-position="bottom right">
                        <i class="red trash icon"></i>
                    </button>
                </div>
            </x-slot>
        </x-page-header>
    @else
        <x-page-header icon="project diagram" header="sections/workorders.create.header" subheader="sections/workorders.create.subheader" />
    @endif
    <x-content theme="purple">

        <form class="ui small form"  wire:submit.prevent="submit">
            <x-form-divider>

                <x-slot name="left">
                    @if ($editMode)
                        <x-dropdown model="product_id" dataSourceFunction="getProductsProperty" class="required" sClass="disabled search" sId="selectProduct"
                            value="id" text="name" label="sections/products.product" placeholder="{{ __('sections/units.unit') }}" />
                    @else
                        <x-dropdown model="product_id" dataSourceFunction="getProductsProperty" class="required" sClass="search" sId="selectProduct"
                            value="id" text="name" label="sections/products.product" placeholder="{{ __('sections/units.unit') }}" />
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
                    <div class="rounded shadow-lg border h-full bg-white md:h-30-rem md:overflow-x-hidden ">
                        @if ($this->productSelected())
                            @if ($preferStock)
        
                                @include('web.sections.workorders.create.workorderPreferStock')
        
                            @else
                                <div class="h-full flex flex-col justify-between bg-white">
                                    <div class="py-5 text-center shadow">
                                        <h5 class="leading-tight font-light text-ease">{{ __('sections/workorders.these_items_will_be_reduced_from_stock_after_production') }}</h5>
                                    </div>
                                    <div class="p-8">
                                        @foreach ($selectedProduct->recipe->ingredients as $ingredient)
                                            <x-custom-list>
                                                <div class="flex items-center gap-1">
                                                    <div>{{ $ingredient->name }}</div>
                                                    <span class="text-xs hidden md:block"> ({{ $ingredient->code }})</span> 
                                                </div>
                                                <div>
                                                    @if ($ingredient->pivot->literal) {{ __('common.net') }}
                                                    @else {{ __('common.least') }}
                                                    @endif
                                                    <span class="">
                                                        {{ $this->calculateNeeds($ingredient)['amount'] }} {{ $this->calculateNeeds($ingredient)['unit']->name }}
                                                    </span>
                                                </div>
                                            </x-custom-list>
                                        @endforeach
                                    </div>
                                    <div class="p-8">
                                        <button wire:click.prevent="activatePreferStock()" class="ui primary tiny button shadow">
                                            {{ __('sections/workorders.specify_sources') }}
                                        </button>
                                        <span class="text-ease">ya da boşver...</span>
                                    </div>
                                </div>
                            @endif
                        @else 
                            <x-placeholder icon="tasks">
                                <span class="text-sm">
                                    {{ __('sections/workorders.necessary_items_and_amounts_will_be_shown_here') }}...
                                </span>
                            </x-placeholder>
                        @endif
                    </div>
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

    <div x-data="{deleteModal: @entangle('deleteModal')}" x-cloak>
        <x-confirm atConfirm="confirmDelete()" active="deleteModal" color="red" confirm="{{ __('common.delete') }}" deny="{{ __('common.cancel') }}">
            {{ __('common.are_you_sure_you_want_to_delete') }}
        </x-confirm>
    </div>

</div>





{{-- <div class="ui tiny form -mb-3">
    <x-dropdown model="test" :collection="$ingredient->lots" value="lot_number" text="lot_number" customMessage="döngüyü yakalamak lazım" class="mini" sId="{{ $loop->index }}" >
    </x-dropdown>
</div> --}}