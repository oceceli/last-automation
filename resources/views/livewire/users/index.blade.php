<x-content>
    <div class="p-5 grid md:grid-cols-2 lg:grid-cols-4 gap-5">
        @foreach ($this->users as $user)
            <x-user-card :user="$user" />
        @endforeach
    </div>



    {{-- Roles MODAL --}}
    @if ($selectedUser)
        <div x-data="{rolesModal: @entangle('rolesModal')}">
            <x-custom-modal active="rolesModal">
                <div class="p-3 border rounded shadow bg-white">
                    <x-dropdown-multiple label="{{ __('roles.roles_for_user', ['user' => ucwords($selectedUser->name)]) }}" model="roleIds" sId="role_select" class="mini">
                        @foreach ($this->roles as $role)
                            <option value="{{ $role->id }}">
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </x-dropdown-multiple>
                    <div class="pt-4" wire:loading.class="bg-red-700 invisible" wire:target="roleIds">
                        <button wire:click.prevent="submitRoles()" class="ui mini green button">
                            {{ __('common.save') }}
                        </button>
                    </div>
                </div>
            </x-custom-modal>
        </div>
    @endif

    @include('web.helpers.deletable')


</x-content>