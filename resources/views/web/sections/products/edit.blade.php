<x-app-layout>
	<x-content>
		<x-slot name="header">
			<x-page-header icon="brown box" header="products.edit_product"/>
        </x-slot>
		<livewire:products.form :product="$product">
	</x-content>
</x-app-layout>