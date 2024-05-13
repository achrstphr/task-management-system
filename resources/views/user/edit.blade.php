
@include('partials.header')
    <main class="bg-white max-w-lg mx-auto p-8 my-10 rounded-lg shadow-2xl">
        <section>
            <h3 class="font-bold text-2xl text-center">EDIT USER '{{$user->name}}'</h3>
        </section>
        <section class="mt-10">
            <form action="/users/{{$user->id}}/update" method="POST" class="flex flex-col">
                @csrf
                @method('PUT')
                <div class="mb-6 pt-3 rounded bg-gray-200">
                    <label for="name" class="block text-gray-700 text-sm font-bold mb-2 ml-3">Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" class="bg-gray-200 rounded w-full text-gray-700 focus:outline-none border-b-4 border-gray-400 px-3" value="{{$errors->has('password_confirmation') ? old('name') : $user->name}}">
                    @error('name')
                        <p class="text-red-500 text-xs p-1 bg-white">
                            {{$message}}
                        </p>
                    @enderror
                </div>
                <div class="mb-6 pt-3 rounded bg-gray-200 hidden">
                    <label for="email" class="block text-gray-700 text-sm font-bold mb-2 ml-3">Email</label>
                    <input type="email" name="email" class="bg-gray-200 rounded w-full text-gray-700 focus:outline-none border-b-4 border-gray-400 px-3" value={{$user->email}}>
                    @error('email')
                        <p class="text-red-500 text-xs p-1 bg-white">
                            {{$message}}
                        </p>
                    @enderror
                </div>
                <div class="mb-6 pt-3 rounded bg-gray-200">
                    <label for="password_confirmation" class="block text-gray-700 text-sm font-bold mb-2 ml-3">Verify Password <span class="text-red-500">*</span></label>
                    <input type="password" name="password_confirmation" class="bg-gray-200 rounded w-full text-gray-700 focus:outline-none border-b-4 border-gray-400 px-3">
                    @error('password')
                        <p class="text-red-500 text-xs p-1 bg-white">
                            {{$message}}
                        </p>
                    @enderror
                    @error('password_confirmation')
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
                            <option value="{{ $department->id }}" {{$errors->has('password_confirmation') ? (old('department_name') == $department->id ? 'selected' : '') : (optional($user->department)->department_name == $department->department_name ? 'selected' : '' )}}>{{ $department->department_name }}</option>
                        @endforeach
                    </select>
                    @error('department_name')
                        <p class="text-red-500 text-xs p-1 bg-white">
                            {{$message}}
                        </p>
                    @enderror
                </div>
                <div class="mb-6 pt-3 rounded bg-gray-200">
                    <label for="role_name" class="block text-gray-700 text-sm font-bold mb-2 ml-3">Role <span class="text-red-500">*</span></label>
                    <select name="role_name" class="bg-gray-200 rounded w-full text-gray-700 focus:outline-none border-b-4 border-gray-400 px-3">
                        <option value="">Select Role</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}" {{$errors->has('password_confirmation') ? (old('role_name') == $role->id ? 'selected' : '') : ($user->role->role_name == $role->role_name ? 'selected' : '' )}}>{{ $role->role_name }}</option>
                        @endforeach
                    </select>
                    @error('role_name')
                        <p class="text-red-500 text-xs p-1 bg-white">
                            {{$message}}
                        </p>
                    @enderror
                </div>
            
                <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 rounded shadow-lg hover:shadow-xl transition duration-200" type="submit">UPDATE</button>
            </form>
        </section>
    </main>
 @include('partials.footer')
