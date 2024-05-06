@php
    // Get the current route name
    $currentRouteName = \Illuminate\Support\Facades\Route::currentRouteName();

    // Determine the link text based on the current route name
    if (strpos($currentRouteName, 'edit') !== false || strpos($currentRouteName, 'create') !== false) {
        $linkText = 'View Data';
    } else {
        $linkText = 'Add New';
    }
    if (strpos($currentRouteName, 'departments') !== false) {
        if ($linkText === 'View Data') {
            $redirectRoute = route('admin.departments'); // Redirect to /users
        } else {
            $redirectRoute = route('admin.departments.create');
        }
        
    } elseif (strpos($currentRouteName, 'roles') !== false) {
        if ($linkText === 'View Data') {
            $redirectRoute = route('admin.roles'); // Redirect to /users) {
        } else {
            $redirectRoute = route('admin.roles.create');
        }
        
    } elseif (strpos($currentRouteName, 'users') !== false) {
        if ($linkText === 'View Data') {
            $redirectRoute = route('users.index'); // Redirect to /users) {
        } else {
            $redirectRoute = route('users.create');
        }
        
    } elseif (strpos($currentRouteName, 'tasks') !== false) {
        if ($linkText === 'View Data') {
            $redirectRoute = route('admin.tasks'); // Redirect to /users) {
        } else {
            $redirectRoute = route('admin.tasks.create');
        }
        
    } else {
        $redirectRoute = route($currentRouteName);
    }
@endphp

<nav class="flex justify-between w-[92%]  mx-auto items-center py-4">
    <div>
        <a href="/users">
            <span class="text-xl text-white font-semibold whitespace-nowrap">
                Task Management System
            </span>
        </a>
    </div>
    {{-- <div class="w-[15rem]"></div> --}}
    <div class="flex items-center justify-end space-x-80rem]">
        <div class="nav-links duration-500 md:static absolute bg-gray-800 text-white md:min-h-fit min-h-[60vh] left-0 top-[-100%] md:w-auto  w-full flex items-center px-5">
                <x-items />
        </div>
        <div class="flex items-center gap-6 mr-4">
            <a href="{{ $redirectRoute }}" class="bg-[#00c927] text-white px-5 py-2 rounded-full hover:bg-green-600">{{$linkText}}</a>
            {{-- <button class="bg-[#00c927] text-white px-5 py-2 rounded-full hover:bg-green-600">Add New</button> --}}
            <ion-icon onclick="onToggleMenu(this)" name="menu" class="text-3xl text-white cursor-pointer md:hidden"></ion-icon>
        </div>
    </div>
</nav>