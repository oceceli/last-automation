<x-app-layout>
	<div>
		<x-content theme="blue">
			<x-slot name="header">
				<x-page-header icon="brown box" header="sections/products.create.header" subheader="sections/products.create.subheader" />
			</x-slot>
			<livewire:products.form>
		</x-content>
	</div>
</x-app-layout>