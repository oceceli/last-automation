<div class="shadow h-full border-r">
    
    <div class="h-full flex flex-col">

        <div class="bg-white">
            <div class="h-40 p-5 flex justify-center flex-shrink-0 shadow-lg relative border-b border-indigo-200">
                <div class="text-center pt-6 flex-1">
                    <p class="text-ease border-b">{{ __('staff_position') }}</p>
                </div>
                <div class="flex-shrink-0">
                    <a href="{{ url('user/profile') }}">
                        <x-circle-image height="h-20 w-20"/>
                    </a>
                    <p class="text-center pt-2 font-bold">{{ $user->name }}</p>
                </div>
                <div class="text-center pt-6 flex-1 flex-shrink-0">
                    <p class="text-ease border-b">{{ __('user_role') }}</p>
                </div>
            </div>

            <div class="h-20 p-3 px-5 flex justify-between items-center bg-gradient-to-b from-white to-gray-100">

                <a href="{{ route('work-orders.create') }}" data-tooltip="{{ __('workorders.create_work_order')}}" data-position="top left" data-variation="mini">
                    <i class="large link project diagram icon"></i>
                </a>
                <a href="{{ route('stock-moves.create') }}" data-tooltip="{{ __('stockmoves.stock_moves_create')}}" data-position="top left" data-variation="mini">
                    <i class="large link dolly flatbed icon"></i>
                </a>
                <a href="{{ route('inventory.index') }}">
                    <i class="large link warehouse icon"></i>
                </a>
                <a href="{{ route('work-orders.daily') }}">
                    <i class="large link setting icon"></i>
                </a>
                

                
            </div>

        </div>




        <div class="h-full bg-white overflow-x-hidden shadow-md border-t">
            <div class="flex flex-col ">
                @foreach ($menuItems as $key => $menu)
                    <div x-data="{submenu: false, submenuConfirm: false}" class="border-b border-dotted">

                        <div class="pl-4 flex ease-in-out duration-200 @if($key === $activeMenuGroupKey) bg-orange-500 @else hover:bg-indigo-50 @endif">
                            <a href="{{ route($menu['name']) }}" class="py-1 @if ( ! array_key_exists('submenus', $menu)) flex-1 @endif  @if($key === $activeMenuGroupKey) text-white @endif"> 
                                <div class="h-8 flex items-center">
                                    <div><i class="{{ $menu['icon'] }} @if($key === $activeMenuGroupKey) text-white @else text-gray-600 @endif"></i></div>
                                    <div class="pl-2"><p class="font-extrabold @if($key === $activeMenuGroupKey) text-white @else text-gray-600 @endif">{{ __($menu['label']) }}</p></div>
                                </div>
                            </a> 
                            @if (array_key_exists('submenus', $menu))
                                <div @click="submenu = ! submenu; submenuConfirm = true;" class="flex justify-end items-center cursor-pointer flex-1 text-right">
                                    <div class="pr-2">
                                        <i class="caret down icon @if($key === $activeMenuGroupKey) text-white @else text-gray-600 @endif"></i>
                                    </div>
                                </div>
                            @endif
                        </div>
                        @if (array_key_exists('submenus', $menu))
                            <div x-show="submenu || ('{{ $key }}' === '{{ $activeMenuGroupKey }}') && ! submenuConfirm" class="shadow-inner bg-cool-gray-50 flex">
                                <div class="border-r border-orange-300 pr-6"></div>
                                <div class="flex-1">
                                    @foreach ($menu['submenus'] as $submenu)
                                        
                                        <div class="flex justify-between border-b border-dashed last:border-b-0 hover:bg-blue-100">
                                            <div class="flex-1 px-4 font-bold cursor-pointer">
                                                <a href="{{ route($submenu['name']) }}"> 
                                                    <div class="flex items-center py-2 @if(route($submenu['name']) == request()->url()) text-orange-500 @else text-gray-600 @endif">
                                                        <div><i class="{{ $submenu['icon'] }} "></i></div>
                                                        <div class="pl-2"><p class="font-extrabold">{{ __($submenu['label']) }}</p></div>
                                                    </div>
                                                </a> 
                                            </div>
                                            @if (route($submenu['name']) == request()->url())
                                                <div class="flex items-center justify-center pr-3">
                                                    <div class="p-2 rounded-full bg-orange-500 shadow"></div>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                    </div>
                @endforeach
            </div>
        </div>



        <div class="h-20 p-3 flex justify-between items-center">
            <div class="text-sm text-center text-gray-500">
                <p>Son giriş: 21.10.2020</p>
                <p>Ve bunun gibi loglar...</p>
            </div>
            <a href="{{route('logout')}}">
                <i class="icon circular large power"></i>
            </a>
        </div>
        

    </div>
</div>


{{-- <div class="ui inline dropdown sidebardrop z-50">
    <div class="text">today</div>
    <i class="dropdown icon"></i>
    <div class="menu bg-white">
        <div class="header">Adjust time span</div>
        <div class="active item" data-text="today">Today</div>
        <div class="item" data-text="this week">This Week</div>
        <div class="item" data-text="this month">This Month</div>
    </div>
</div> --}}


<script>
    $('document').ready(function(){
        $('.sidebardrop').dropdown();
    })
</script>
