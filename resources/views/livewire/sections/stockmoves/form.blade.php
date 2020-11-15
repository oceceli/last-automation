<div>
    <x-page-header icon="box" header="Stok girişi" subheader="Stok girişi">
        <x-slot name="buttons">
            <button wire:click.prevent="" class="ui icon mini teal button" data-tooltip="{{ __('common.add_new') }}" data-variation="mini">
                <i class="plus icon"></i>
            </button>
        </x-slot>
    </x-page-header>
    <x-content theme="purple">
        <div class="p-4">
            <form class="ui small form px-4 py-2 rounded-md shadow  border">
                <div class="fields">
                    <x-dropdown label="{{ __('modelnames.product') }}" placeholder="{{ __('common.dropdown_placeholder') }}"
                                model="product_id" :collection="$this->products" value="id" text="name" sId="selectProduct">
                    </x-dropdown>
                    <x-dropdown label="{{ __('stockmoves.type') }}" placeholder="{{ __('common.dropdown_placeholder') }}"
                                model="type" :collection="$this->types" value="value" text="text">
                    </x-dropdown>
                    <x-input model="amount" label="{{ __('stockmoves.amount') }}" placeholder="{{ __('stockmoves.amount') }}">
                    </x-input>                
                </div>
            </form>
        </div>
    </x-content>
</div>
