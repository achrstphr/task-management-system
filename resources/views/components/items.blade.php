<ul class="flex md:flex-row flex-col md:items-center px-4">
@auth

  <li>
      <a href="/users" class="block py-2 px-4 text-gray-500 hover:text-purple-700 {{ request()->is('users') || request()->is('users/*') ? 'pointer-events-none text-white' : '' }}">User</a>
  </li>
  <li>
      <a href="/admin/roles" class="block py-2 px-4 text-gray-500 hover:text-purple-700 {{ request()->is('admin/roles') || request()->is('admin/roles/*') ? 'pointer-events-none text-white' : '' }}">Role</a>
  </li>
  <li>
      <a href="/admin/departments" class="block py-2 px-4 text-gray-500 hover:text-purple-700  {{ request()->is('admin/departments') || request()->is('admin/departments/*') ? 'pointer-events-none text-white' : '' }}">Department</a>
  </li> 
  <li>
    <a href="/admin/tasks" class="block py-2 px-4 text-gray-500 hover:text-purple-700  {{ request()->is('admin/tasks') || request()->is('admin/tasks/*') ? 'pointer-events-none text-white' : '' }}">Task</a>
  </li> 
  <li>
    <a href="/admin/activity/log" class="block py-2 px-4 text-gray-500 hover:text-purple-700  {{ request()->is('admin/activity/log')  ? 'pointer-events-none text-white' : '' }}">Activity Log</a>
  </li>  
  <div class="relative grid place-items-center">
    <button id="userDropdown" class="inline-flex items-center px-4 py-2  text-sm leading-5 font-medium rounded-md text-blue-800  focus:outline-none transition duration-150 ease-in-out">
      @php
            $fullNameParts = explode(' ', Auth::user()->name);
            $first_name = $fullNameParts[0];
        @endphp
        {{ $first_name }}
        <svg class="ml-2 -mr-0.5 h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M10 12a1 1 0 0 1-.707-.293l-4-4a1 1 0 1 1 1.414-1.414L10 9.586l3.293-3.293a1 1 0 1 1 1.414 1.414l-4 4A1 1 0 0 1 10 12z"/>
        </svg>
    </button>
    <div id="userDropdownMenu" class="bg-white shadow-lg absolute top-10 right-0 rounded-lg w-max overflow-hidden hidden">
          <p class="username whitespace-no-wrap text-gray-500 block px-4 py-2 text-sm ">{{ auth()->user()->name }}</p>
            <a href="{{ route('logout') }}" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900 transition duration-150 ease-in-out" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Logout
            </a> 
    </div>
  </div>
  <li>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
      @csrf
    </form>
  </li>
@endauth
    
    
  </ul>