<x-app-layout>
    product create

	

</x-app-layout>

<script>
	$('.ui.basic.modal')
		  .modal('show');
	$('.close.icon').click(function () {
		$('.ui.positive.message').removeClass('visible').transition('fade').addClass('hidden');
	})
</script>

