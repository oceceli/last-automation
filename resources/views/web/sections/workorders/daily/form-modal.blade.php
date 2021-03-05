@if ($wo_form_modal)
    <div x-data="{wo_form_modal: @entangle('wo_form_modal')}">
        <x-custom-modal active="wo_form_modal" position="center">
            <livewire:work-orders.form wire:key="create-work-order-modal" />
        </x-custom-modal>
    </div>
@endif