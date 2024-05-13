
@include('partials.header')
    <main class="overflow-y-auto max-h-[45rem] bg-white max-w-lg mx-auto p-8 my-5 rounded-lg shadow-2xl">
        <section>
            <h3 class="font-bold text-2xl text-center">CREATE A TASK</h3>
        </section>
        <section class="mt-2">
            <form action="/admin/tasks/store" method="POST" class="flex flex-col">
                @csrf
                <div class="mb-6 pt-3 rounded bg-gray-200">
                    <label for="task_name" class="block text-gray-700 text-sm font-bold mb-2 ml-3">Task Name <span class="text-red-500">*</span></label>
                    <input type="text" name="task_name" class="bg-gray-200 rounded w-full text-gray-700 focus:outline-none border-b-4 border-gray-400 px-1" value={{old('task_name')}}>
                    @error('task_name')
                        <p class="text-red-500 text-xs p-1 bg-white">
                            {{$message}}
                        </p>
                    @enderror
                </div>
                <div class="mb-6 pt-3 rounded bg-gray-200">
                    <label for="difficulty_level" class="block text-gray-700 text-sm font-bold mb-2 ml-3">Difficulty Level <span class="text-red-500">*</span></label>
                    <select name="difficulty_level" class="bg-gray-200 rounded w-full text-gray-700 focus:outline-none border-b-4 border-gray-400 px-1">
                        <option value="">Select Level</option>
                        @foreach(['Beginner', 'Intermediate', 'Advanced', 'Expert', 'Master'] as $difficulty)
                        <option value="{{ $difficulty }}" {{ old('difficulty_level') == $difficulty ? 'selected' : '' }}>{{ $difficulty }}</option>
                        @endforeach
                    </select>
                    @error('difficulty_level')
                    <p class="text-red-500 text-xs p-1 bg-white">
                        {{$message}}
                    </p>
                    @enderror
                </div>
                <div class="mb-6 pt-3 rounded bg-gray-200">
                    <label for="priority_level" class="block text-gray-700 text-sm font-bold mb-2 ml-3">Priority Level <span class="text-red-500">*</span></label>
                    <select name="priority_level" class="bg-gray-200 rounded w-full text-gray-700 focus:outline-none border-b-4 border-gray-400 px-1">
                        <option value="">Select Level</option>
                        @foreach(['Low', 'Medium', 'High', 'Critical'] as $priority)
                        <option value="{{ $priority }}" {{ old('priority_level') == $priority ? 'selected' : '' }}>{{ $priority }}</option>
                        @endforeach
                    </select>
                    @error('priority_level')
                    <p class="text-red-500 text-xs p-1 bg-white">
                        {{$message}}
                    </p>
                    @enderror
                </div>
                <div class="mb-6 pt-3 rounded bg-gray-200">
                    <label for="assign_to" class="block text-gray-700 text-sm font-bold mb-2 ml-3">Assign To</label>
                    <select name="assign_to" class="bg-gray-200 rounded w-full text-gray-700 focus:outline-none border-b-4 border-gray-400 px-1">
                        <option value="">Select User</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{old('assign_to') == $user->id ? 'selected' : ''}}>{{ $user->name }}</option>
                        @endforeach
                    </select>
                    {{-- beginner, intermediate, advanced, expert, master
                        low, medium, high, critical --}}
                    @error('assign_to')
                        <p class="text-red-500 text-xs p-1 bg-white">
                            {{$message}}
                        </p>
                    @enderror
                </div>
                <div class="mb-6 pt-3 rounded bg-gray-200">
                    <label for="task_status" class="block text-gray-700 text-sm font-bold mb-2 ml-3">Task Status <span class="text-red-500">*</span></label>
                    <select name="task_status" class="bg-gray-200 rounded w-full text-gray-700 focus:outline-none border-b-4 border-gray-400 px-1">
                        <option value="">Select Status</option>
                        @foreach(['Pending', 'In Progress', 'Completed', 'On Hold', 'Cancelled'] as $priority)
                        <option value="{{ $priority }}" {{ old('task_status') == $priority ? 'selected' : '' }}>{{ $priority }}</option>
                        @endforeach
                    </select>
                    @error('task_status')
                    <p class="text-red-500 text-xs p-1 bg-white">
                        {{$message}}
                    </p>
                    @enderror
                </div>
                <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 rounded shadow-lg hover:shadow-xl transition duration-200" type="submit">Add</button>
            </form>
        </section>
    </main>
 @include('partials.footer')
