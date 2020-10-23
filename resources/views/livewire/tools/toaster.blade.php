<div>
    {{-- <div x-data="{show:false}" @stamp-toast.window="show = true; setTimeout(() => show=false, 5000);"
        class="bg-red-500"
        x-show="show"
        x-cloak>
        içerik
    </div> --}}
</div>


<script>
    // Livewire.on('fireToast', function ()  {
    window.addEventListener('stamp-toast', function () {
        $('body')
        .toast({
            title: '{{ $title }}',
            message: '{{ $message }}',
            showProgress: '{{ $pbpos }}',
            classProgress: 'teal',
            class: '{{ $type }}',
            position: '{{ $position }}',
        });
    });
    
    // });

        
</script>