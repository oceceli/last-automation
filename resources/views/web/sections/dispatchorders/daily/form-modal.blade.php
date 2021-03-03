@if ($do_form_modal)
    <div x-data="{do_form_modal: @entangle('do_form_modal')}">
        <x-custom-modal active="do_form_modal" position="center">
            <livewire:dispatch-orders.form>
        </x-custom-modal>
    </div>
@endif