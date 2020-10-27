<div {{ $attributes->merge(['class' => 'ui modal']) }}>
    <div class="z-10">
        @if ($header)
            <div class="header">{{ $header }}</div>
        @endif

        <div class="{{ $contentClass }} content">
            {{ $slot }}
        </div>

        @if ($buttons)
            <div class="actions">
                {{ $buttons }}
            </div>
        @endif
    </div>


</div>

<script>
    $('.ui.modal')
    .modal({
        blurring: '{{ $blurring }}',
        inverted: '{{ $inverted }}',
        centered: true,
        closable: true,

        allowMultiple: false,

        // animation
        transition: '{{ $transition }}',
        duration: 500,

        closeable: true,

        // onHidden: function() {
        //     @this.set('modal', false);
        // },
    });
    $('#button1').on('click', function () {
        $('.ui.modal').modal('show');
    })
    
</script>