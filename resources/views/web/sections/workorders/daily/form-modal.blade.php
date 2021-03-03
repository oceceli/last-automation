@if ($wo_form_modal)
    <div x-data="{wo_form_modal: @entangle('wo_form_modal')}">
        <x-custom-modal active="wo_form_modal" position="center">
            <livewire:work-orders.form>
        </x-custom-modal>
    </div>
@endif