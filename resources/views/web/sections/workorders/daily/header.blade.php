<div x-data="{wo_modal: false}">
    <x-page-header icon="settings" header="sections/workorders.daily_work_orders">
        <x-slot name="buttons">
            <button @click="wo_modal = true" class="ui icon mini teal button"
                data-tooltip="{{ __('common.add_new') }}" data-variation="mini">
                <i class="white plus icon"></i>
            </button>
        </x-slot>
    </x-page-header>
    <x-custom-modal active="wo_modal" position="right">
        <livewire:sections.work-orders.form>
    </x-custom-modal>
</div>