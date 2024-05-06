<ul class="flex md:flex-row flex-col md:items-center px-4">
    {{-- <li>
      <a href="/add/student" class="block py-2 pr-4 pl-3">Add New</a>
    </li>
    <li>
      <form action="/logout" method="post">
        @csrf
        <button class="block py-2 pr-4 pl-3">Sign Out</button>
      </form>
    </li>

    <li>
      <a href="/login" class="block py-2 pr-4 pl-3">Sign In</a>
    </li>
    <li>
      <a href="/register" class="block py-2 pr-4 pl-3">Sign Up</a>
    </li> --}}

      {{-- <li>
          <a href="/users/register" class="block py-2 px-4 text-gray-500 hover:text-purple-700 {{ request()->is('users/register') ? 'pointer-events-none text-white' : '' }}">Create User</a>
      </li> --}}
      <li>
          <a href="/users" class="block py-2 px-4 text-gray-500 hover:text-purple-700 {{ request()->is('users') || request()->is('users/*') ? 'pointer-events-none text-white' : '' }}">User</a>
      </li>
      {{-- <li>
          <a href="/admin/roles/create" class="block py-2 px-4 text-gray-500 hover:text-purple-700  {{ request()->is('admin/roles/create') ? 'pointer-events-none text-white' : '' }}">Create Role</a>
      </li> --}}
      <li>
          <a href="/admin/roles" class="block py-2 px-4 text-gray-500 hover:text-purple-700 {{ request()->is('admin/roles') || request()->is('admin/roles/*') ? 'pointer-events-none text-white' : '' }}">Role</a>
      </li>
      {{-- <li>
          <a href="/admin/departments/create" class="block py-2 px-4 text-gray-500 hover:text-purple-700  {{ request()->is('admin/departments/create') ? 'pointer-events-none text-white' : '' }}">Create Department</a>
      </li> --}}
      <li>
          <a href="/admin/departments" class="block py-2 px-4 text-gray-500 hover:text-purple-700  {{ request()->is('admin/departments') || request()->is('admin/departments/*') ? 'pointer-events-none text-white' : '' }}">Department</a>
      </li> 
      <li>
        <a href="/admin/tasks" class="block py-2 px-4 text-gray-500 hover:text-purple-700  {{ request()->is('admin/tasks') || request()->is('admin/tasks/*') ? 'pointer-events-none text-white' : '' }}">Task</a>
    </li>  
    
  </ul>