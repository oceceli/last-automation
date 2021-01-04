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

                <a href="{{ route('work-orders.create') }}">
                    <i class="circular icons" data-tooltip="{{ __('common.work-orders_create')}}" data-position="top left" data-variation="mini">
                        <i class="large link green project diagram icon"></i>
                        <i class="bottom right green corner small add icon"></i>
                    </i>
                </a>
                <a href="{{ route('stock-moves.create') }}" data-tooltip="{{ __('stockmoves.stock_moves_create')}}" data-position="top left" data-variation="mini">
                    <i class="large green truck packing icon"></i>
                </a>
                <a href="{{ route('inventory.index') }}">
                    <i class="large link warehouse icon"></i>
                </a>
                <a href="{{ route('work-orders.daily') }}">
                    <i class="large link setting icon"></i>
                </a>
                

                <i class="large link circular address card icon"></i>
                
            </div>

        </div>




        <div class="p-2 h-full bg-white overflow-x-hidden shadow-md border-t">
            <div class="flex flex-col gap-2">
                @foreach ($routes as $route)
                    <div x-data="{submenu: false}" class="py-1 px-4 shadow-md rounded">
                        <div class="flex items-center justify-between" >
                            <a href="{{ route($route['name']) }}"> 
                                <div class="h-8 flex items-center">
                                    <div><i class="{{ $route['icon'] }} text-gray-600"></i></div>
                                    <div class="pl-2"><p class="font-extrabold  text-gray-600">{{ __('common.'. $route['label']) }}</p></div>
                                </div>
                            </a> 
                            <div>
                                @if (array_key_exists('submenus', $route))
                                    <div @click="submenu = ! submenu">
                                        <i class="caret down icon"></i>
                                    </div>
                                @endif
                            </div>
                        </div>
                        @if (array_key_exists('submenus', $route))
                            <div x-show="submenu">
                                @foreach ($route['submenus'] as $submenu)
                                    {{ $submenu['name'] }}
                                @endforeach
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
