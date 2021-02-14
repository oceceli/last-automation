@if ($deleteModal)
    <div x-data="{deleteModal: @entangle('deleteModal')}">
        <x-confirm active="deleteModal" color="red" atConfirm="confirmDelete()">
            <div class="pb-5"><i class="large triangle exclamation icon text-red-700 hover:text-red-500 ease"></i></div>
            <span>{{ __('common.are_you_sure_you_want_to_delete') }}</span>
        </x-confirm>
    </div>
@endif