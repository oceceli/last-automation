@if ($deleteConfirmModal)
    <div x-data="{deleteConfirmModal: @entangle('deleteConfirmModal')}" x-cloak>
        <x-confirm active="deleteConfirmModal" color="red" confirm="{{ __('common.delete') }}" deny="{{ __('common.cancel') }}"
                atConfirm="removeRecipe()" atDeny="closeDeleteConfirmModal()">
                {{ __('recipes.are_you_sure_you_want_to_delete_this_recipe') }}
        </x-confirm>
    </div>
@endif

@if ($formChangedModal)
    <div x-data="{formChangedModal: @entangle('formChangedModal')}" x-cloak>
        <x-confirm active="formChangedModal" atConfirm="modalStayHere()" atClose="modalStayHere()"
                    color="yellow" confirm="{{ __('common.stay_here') }}" deny="{{ __('common.leave') }}" >
                <div>{{ __('recipes.somethings_changed_in_the_recipe') }}.</div>
                <div>{{ __('recipes.do_you_want_to_leave_for_sure') }}</div>
                <div class="text-sm text-ease pt-6 text-red-400 hover:text-red-700">{{ __('recipes.all_changes_will_be_lost_if_you_leave') }}!</div>
        </x-confirm>
    </div>
@endif