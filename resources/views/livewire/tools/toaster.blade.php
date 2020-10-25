<div>
    {{-- <div x-data="{show:false}" @stamp-toast.window="show = true; setTimeout(() => show=false, 5000);"
        class="bg-red-500"
        x-show="show"
        x-cloak>
        içerik
    </div> --}}
</div>


<script>
    window.addEventListener('stamp-toast', function (event) {
        $('body')
        .toast({
            title: event.detail.title,
            message: event.detail.message,

            showProgress: 'bottom',
            classProgress: event.detail.classProgress,

            minDisplayTime: 3000,
            displayTime: 'auto',

            showIcon: event.detail.icon,

            closeIcon: event.detail.closeIcon,
            closeOnClick: false,

            class: event.detail.class,
            position: event.detail.position,

            transition: {
                showMethod   : event.detail.showMethod,
                showDuration : 500,
                hideMethod   : 'fade left',
                hideDuration : 500,
                closeEasing  : 'easeOutCubic'
            },

            showImage: event.detail.showImage,
            classImage: 'avatar', // mini, tiny, small, avatar

            // classActions: 'left',
            // actions: [
            //     {
            //     text    : 'Wait',
            //     class   : 'red',
            //     icon    : 'exclamation',
            //     click   : function(){}
            //     },
            // ],
        });
    });        
</script>