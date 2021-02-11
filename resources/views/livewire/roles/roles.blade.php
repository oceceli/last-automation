<x-content>
    
    <x-slot name="header">
        <x-page-header icon="dna" header="{{ __('roles.define_roles') }}" />
    </x-slot>

    <div class="p-4">
        <x-table class="selectable">

            {{-- <x-thead>
                <x-table-row>
                    <x-thead-item>
                        sadf
                    </x-thead-item>
                </x-table-row>
            </x-thead> --}}

            <x-tbody>
                @forelse ($this->roles as $role)
                    <x-table-row>
                        <x-tbody-item class="collapsing">
                            {{ $loop->index + 1}}
                        </x-tbody-item>
                        <x-tbody-item class="center aligned">
                            <span class="font-bold text-red-800">{{ $role->name }}</span>
                        </x-tbody-item>
                        <x-tbody-item>
                            <span class="text-xs text-ease">
                                {{ __('roles.has_count_permissions', ['count' => $role->permissions->count()]) }}
                            </span>
                        </x-tbody-item>
                        <x-tbody-item class="collapsing">
                            <x-crud-actions show delete edit modelName="role" :modelId="$role->id">
                                <div wire:click.prevent="$set('permissionsModal', true)" data-tooltip="{{ __('roles.set_permissions') }}" data-variation="mini">
                                    <i class="settings icon"></i>
                                </div>
                            </x-crud-actions>
                        </x-tbody-item>
                    </x-table-row>
                @empty
                    <tr>
                        <td>{{ __('roles.there_is_no_any_role') }}</td>
                    </tr>
                @endforelse
            </x-tbody>

            <tfoot class="">
                <tr>
                    <th colspan="4">
                        <button wire:click="$set('newRoleModal', true)" class="ui right floated mini primary labeled mini icon button">
                            <i class="cog icon"></i> !Yeni rol
                        </button>
                    </th>
                </tr>
            </tfoot>

        </x-table>
        
        <div x-data="{newRoleModal: @entangle('newRoleModal')}">
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
        </div>



        <div x-data="{permissionsModal: @entangle('permissionsModal')}">
            <x-custom-modal active="permissionsModal">
                <div class="p-3">
                    <x-dropdown-multiple model="permissionIds" sId="permission_select" class="mini">
                        @foreach ($this->permissions as $permission)
                            <option value="{{ $permission->id }}">
                                {{ __("permissions.$permission->name") }}
                            </option>
                        @endforeach
                    </x-dropdown-multiple>
                </div>
            </x-custom-modal>
        </div>

    </div>
    

            

    

</x-content>


























{{-- <div class="p-4">
    <table class="ui compact celled definition table">

        <thead class="full-width">
            <tr>
                <th></th>
                <th>Name</th>
                <th>Registration Date</th>
                <th>E-mail address</th>
                <th>Premium Plan</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td class="collapsing">
                    <div class="ui fitted slider checkbox">
                        <input type="checkbox"> <label></label>
                    </div>
                </td>
                <td>John Lilki</td>
                <td>September 14, 2013</td>
                <td>jhlilk22@yahoo.com</td>
                <td>No</td>
            </tr>
        </tbody>

        <tfoot class="full-width">
            <tr>
                <th></th>
                <th colspan="4">
                    <div class="ui right floated small primary labeled icon button">
                        <i class="user icon"></i> Add User
                    </div>
                    <div class="ui small  button">
                        Approve
                    </div>
                    <div class="ui small  disabled button">
                        Approve All
                    </div>
                </th>
            </tr>
        </tfoot>
        
    </table>
</div> --}}
