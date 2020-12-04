<div x-data="{deleteConfirmModal: @entangle('deleteConfirmModal')}" x-cloak>
    <x-confirm active="deleteConfirmModal" color="red" confirm="{{ __('common.delete') }}" deny="{{ __('common.cancel') }}"
            atConfirm="removeRecipe()" atDeny="closeDeleteConfirmModal()">
        <x-slot name="question">
            {{ __('sections/recipes.are_you_sure_you_want_to_delete_this_recipe') }}
        </x-slot>
    </x-confirm>
</div>

<div x-data="{formChangedModal: @entangle('formChangedModal')}" x-cloak>
    <x-confirm active="formChangedModal" atConfirm="modalStayHere()" atClose="modalStayHere()"
                color="yellow" confirm="{{ __('common.stay_here') }}" deny="{{ __('common.leave') }}" >
        <x-slot name="question">
            <div>{{ __('sections/recipes.somethings_changed_in_the_recipe') }}.</div>
            <div>{{ __('sections/recipes.do_you_want_to_leave_for_sure') }}</div>
            <div class="text-sm text-ease pt-6 text-red-400 hover:text-red-700">{{ __('sections/recipes.all_changes_will_be_lost_if_you_leave') }}!</div>
        </x-slot>
    </x-confirm>
</div>