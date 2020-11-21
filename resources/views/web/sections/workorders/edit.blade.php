<x-app-layout>
    <div>
        <x-page-header icon="project diagram" header="sections/workorders.edit.header" subheader="{{ __('sections/workorders.edit.subheader', []) }}" />
        <x-content theme="yellow">
            <livewire:sections.work-orders.form :workOrder="$workOrder">
        </x-content>
    </div>
</x-app-layout>