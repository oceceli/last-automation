<div class="shadow h-full border-r">
    
    <div class="h-full flex flex-col">

        <div class="bg-white">
            <div class="h-40 p-5 flex justify-center flex-shrink-0 shadow-lg border-b border-indigo-200">
                <div class="text-center pt-6 flex-1">
                    <p class="text-gray-700 font-hairline border-b">{{ __('staff_position') }}</p>
                </div>
                <div class="flex-shrink-0">
                    <a href="{{ url('user/profile') }}">
                        <x-circle-image height="h-20 w-20"/>
                    </a>
                    <p class="text-center pt-2 font-bold">{{ $user->name }}</p>
                </div>
                <div class="text-center pt-6 flex-1 flex-shrink-0">
                    <p class="text-gray-700 font-hairline border-b">{{ __('user_role') }}</p>
                </div>
            </div>
            <div class="h-20 p-3 flex justify-between items-center">
                <i class="large link circular building outline icon"></i>
                <i class="large link circular store icon"></i>
                <i class="large link circular address card icon"></i>
                <i class="large link circular loading setting icon"></i>
                <i class="large link circular settings book icon"></i>
            </div>
        </div>




        <div class="h-full p-2 border-t bg-gray-50 overflow-x-hidden">
            <div class="h-full p-2 border bg-white border-indigo-200 shadow rounded flex flex-col overflow-x-hidden">
                @foreach ($routes as $route)
                    <a href="{{ route($route['name']) }}"> 
                        <div class="h-14 p-2 flex items-center border-b">
                            <div><i class="{{ $route['icon'] }} text-gray-600"></i></div>
                            <div class="pl-2"><p class="font-extrabold text-lg text-gray-600">{{ ucfirst($route['label']) }}</p></div>
                        </div>
                    </a>  
                @endforeach              
               
            </div>
        </div>



        <div class="h-20 p-3 border-t flex justify-between items-center">
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


<script>
    $('.ui.sidebar')
    .sidebar('toggle');
</script>