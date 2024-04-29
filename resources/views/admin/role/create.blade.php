
@include('partials.header')

<main class="bg-white max-w-lg mx-auto p-8 my-5 rounded-lg shadow-2xl">
    <section>
        <h3 class="font-bold text-2xl text-center">CREATE A ROLE</h3>
    </section>
    <section class="mt-10">
        <form action="/admin/roles/store" method="POST" class="flex flex-col">
            @csrf
            <div class="mb-6 pt-3 rounded bg-gray-200">
                <label for="role_name" class="block text-gray-700 text-sm font-bold mb-2 ml-3">New Role</label>
                <input type="text" id="role_name" name="role_name" class="bg-gray-200 rounded w-full text-gray-700 focus:outline-none border-b-4 border-gray-400 px-3" value={{old('role_name')}}>
                @error('role_name')
                    <p class="text-red-500 text-xs p-1 bg-white">
                        {{$message}}
                    </p>
                @enderror
            </div>
            <div class="mb-6 pt-3 rounded bg-gray-200">
                <label class="block text-gray-700 text-sm font-bold mb-2 ml-3">Permissions</label>
                <div class="flex px-4 py-3">
                    <div class="flex-1 mr-4">
                        <input type="checkbox" name="permission[]" value="View Dashboard" {{ in_array('View Dashboard', old('permission', [])) ? 'checked' : '' }} class="mr-2">
                        <label for="">View Dashboard</label>
                        <br>
                        <input type="checkbox" name="permission[]" value="Create Task" {{ in_array('Create Task', old('permission', [])) ? 'checked' : '' }} class="mr-2">
                        <label for="">Create Task</label>
                    </div>
                    <div class="flex-1 px-4">
                        <input type="checkbox" name="permission[]" value="Assign Task" {{ in_array('Assign Task', old('permission', [])) ? 'checked' : '' }} class="mr-2">
                        <label for="">Assign Task</label>
                        <br>
                        <input type="checkbox" name="permission[]" value="Manage Users" {{ in_array('Manage Users', old('permission', [])) ? 'checked' : '' }} class="mr-2">
                        <label for="">Manage Users</label>
                    </div>
                </div>
                @error('permission')
                    <p class="text-red-500 text-xs p-1 bg-white">
                        {{$message}}
                    </p>
                @enderror
            </div>
            <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 rounded shadow-lg hover:shadow-xl transition duration-200" type="submit">Add Role</button>
        </form>
    </section>
</main>

 @include('partials.footer')
