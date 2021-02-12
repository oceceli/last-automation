<x-content>
    
    <x-slot name="header">
        <x-page-header icon="users" header="{{ __('roles.define_user_roles') }}">
            {{-- <x-slot name="buttons">
                <button wire:click="$set('newRoleModal', true)" class="ui green mini icon button">
                    <i class="plus icon"></i> {{ __('roles.new_role' )}}
                </button>
            </x-slot> --}}
        </x-page-header>
    </x-slot>

    <div class="p-4">
        <x-table class="selectable">
            <x-tbody>
                @foreach ($this->users as $user)
                    <x-table-row>
                        <x-tbody-item class="collapsing">
                            {{ $loop->index + 1}}
                        </x-tbody-item>
                        <x-tbody-item class="center aligned">
                            <span class="font-bold text-red-800">{{ $user->name }}</span>
                        </x-tbody-item>
                        <x-tbody-item>
                            <span class="text-xs text-ease">
                                {{ __('roles.has_count_roles', ['count' => $user->roles->count()]) }}
                            </span>
                        </x-tbody-item>
                        <x-tbody-item class="collapsing">
                            <x-crud-actions delete modelName="user" :modelId="$user->id">
                                <div wire:click.prevent="openRolesModal({{ $user->id }})" data-tooltip="{{ __('permissions.permissions') }}" data-variation="mini">
                                    <i class="settings icon"></i>
                                </div>
                            </x-crud-actions>
                        </x-tbody-item>
                    </x-table-row>
                @endforeach
            </x-tbody>

            {{-- <tfoot class="">
                <tr>
                    <th colspan="4">
                        <button wire:click="$set('newRoleModal', true)" class="ui right floated mini primary labeled mini icon button">
                            <i class="plus icon"></i> {{ __('roles.new_role' )}}
                        </button>
                    </th>
                </tr>
            </tfoot> --}}

        </x-table>



        {{-- Roles MODAL --}}
        @if ($selectedUser)
            <div x-data="{rolesModal: @entangle('rolesModal')}">
                <x-custom-modal active="rolesModal">
                    <div class="p-6 bg-red-800">
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
                    </div>
                </x-custom-modal>
            </div>
        @endif






        {{-- ROLE CREATE MODAL --}}
        {{-- <div x-data="{newRoleModal: @entangle('newRoleModal')}">
            <x-custom-modal active="newRoleModal">
                <div class="p-3">
                    <div class="ui mini form border p-2 rounded">
                        <x-input model="name" label="{{ __('roles.name') }}" placeholder="{{ __('roles.name') }}" />
                    </div>
                    <div class="pt-4">
                        <button wire:click.prevent="submitRole()" class="ui mini green button">
                            {{ __('common.save') }}
                        </button>
                    </div>
                </div>
            </x-custom-modal>
        </div> --}}

    </div>
    

            

    

</x-content>