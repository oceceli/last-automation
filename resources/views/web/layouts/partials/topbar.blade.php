
<div class="px-2 py-2 shadow bg-white relative">
    <div class="flex-1 h-full grid md:grid-cols-3 gap-4">

        <div class="text-center md:flex items-center">
            <div>
                <i  class="link hamburger icon hover:text-red-600" @click="sidebar = !sidebar"></i>
            </div>
        </div>


        <div class="text-center md:flex justify-center items-center">
            
        </div>


        <div class="flex justify-center md:justify-end gap-4 items-center">
            <div>
                <i class="large link bell icon"></i>
            </div>
            <div>
                <i class="large link envelope icon"></i>
            </div>
            <div class="relative" x-data="{userModal: false}" x-cloak>
                <div @click="userModal = ! userModal">
                    <i class="large link fingerprint icon"></i>
                </div>
                <div x-show="userModal" @click.away="userModal = false" 
                    class="absolute right-0 mt-1 z-40  border shadow bg-white rounded flex flex-col " style="min-width: 15rem;">

                    <div class="border-b border-dashed px-3 py-2 text-ease">
                        <i class="user icon"></i>
                        <span>{{ auth()->user()->name}}</span>
                    </div>

                    <div class="p-2 text-center">
                        <span>{{ __('auth.logout')}}</span>
                        <i class="icon circular power cursor-pointer"></i>
                    </div>

                </div>
            </div>
        </div>

        
    </div>
</div>




{{-- <div class="absolute right-0 mt-3 mr-3 flex items-center justify-center">
    <x-circle-image height="h-14 w-14"/>
</div> --}}