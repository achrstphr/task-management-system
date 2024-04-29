
@include('partials.header')
    <main class="bg-white max-w-lg mx-auto p-8 my-10 rounded-lg shadow-2xl">
        <section>
            <h3 class="font-bold text-2xl text-center">CREATE A USER</h3>
        </section>
        <section class="mt-10">
            <form action="/users/store" method="POST" class="flex flex-col">
                @csrf
                <div class="mb-6 pt-3 rounded bg-gray-200">
                    <label for="user_name" class="block text-gray-700 text-sm font-bold mb-2 ml-3">Name</label>
                    <input type="text" name="user_name" class="bg-gray-200 rounded w-full text-gray-700 focus:outline-none border-b-4 border-gray-400 px-3" value={{old('user_name')}}>
                    @error('user_name')
                        <p class="text-red-500 text-xs p-1 bg-white">
                            {{$message}}
                        </p>
                    @enderror
                </div>
                <div class="mb-6 pt-3 rounded bg-gray-200">
                    <label for="email" class="block text-gray-700 text-sm font-bold mb-2 ml-3">Email</label>
                    <input type="email" name="email" class="bg-gray-200 rounded w-full text-gray-700 focus:outline-none border-b-4 border-gray-400 px-3" value={{old('email')}}>
                    @error('email')
                        <p class="text-red-500 text-xs p-1 bg-white">
                            {{$message}}
                        </p>
                    @enderror
                </div>
                <div class="mb-6 pt-3 rounded bg-gray-200">
                    <label for="password" class="block text-gray-700 text-sm font-bold mb-2 ml-3">Password</label>
                    <input type="password" name="password" class="bg-gray-200 rounded w-full text-gray-700 focus:outline-none border-b-4 border-gray-400 px-3">
                    @error('password')
                        <p class="text-red-500 text-xs p-1 bg-white">
                            {{$message}}
                        </p>
                    @enderror
                </div>
                <div class="mb-6 pt-3 rounded bg-gray-200">
                    <label for="department_name" class="block text-gray-700 text-sm font-bold mb-2 ml-3">Department</label>
                    <select name="department_name" class="bg-gray-200 rounded w-full text-gray-700 focus:outline-none border-b-4 border-gray-400 px-3">
                        <option value="">Select Department</option>
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}" {{old('department_name') == $department->id ? 'selected' : ''}}>{{ $department->name }}</option>
                        @endforeach
                    </select>
                    @error('department_name')
                        <p class="text-red-500 text-xs p-1 bg-white">
                            {{$message}}
                        </p>
                    @enderror
                </div>
                <div class="mb-6 pt-3 rounded bg-gray-200">
                    <label for="role_name" class="block text-gray-700 text-sm font-bold mb-2 ml-3">Role</label>
                    <select name="role_name" class="bg-gray-200 rounded w-full text-gray-700 focus:outline-none border-b-4 border-gray-400 px-3">
                        <option value="">Select Role</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}" {{old('role_name') == $role->id ? 'selected' : ''}}>{{ $role->name }}</option>
                        @endforeach
                    </select>
                    @error('role_name')
                        <p class="text-red-500 text-xs p-1 bg-white">
                            {{$message}}
                        </p>
                    @enderror
                </div>
            
                <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 rounded shadow-lg hover:shadow-xl transition duration-200" type="submit">Add User</button>
            </form>
        </section>
    </main>
 @include('partials.footer')
