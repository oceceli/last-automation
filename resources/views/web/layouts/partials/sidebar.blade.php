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




        <div class="h-full bg-white overflow-x-hidden shadow-md">
            <div class="h-full border bg-white border-indigo-200 shadow flex flex-col overflow-x-hidden">
                <div class="ui middle aligned selection animated link divided small list">
                    @foreach ($routes as $route)
                        @if (route($route['name']) == request()->url())
                            <div class="active item">
                        @else
                            <div class="item">
                        @endif
                                <a href="{{ route($route['name']) }}"> 
                                    <div class="h-11 p-3 flex items-center">
                                        <div><i class="{{ $route['icon'] }} text-gray-600"></i></div>
                                        <div class="pl-2"><p class="font-extrabold  text-gray-600">{{ __('common.'. $route['label']) }}</p></div>
                                    </div>
                                </a>  
                            </div>
                    @endforeach            
                </div>
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

