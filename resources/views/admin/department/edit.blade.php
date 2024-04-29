
@include('partials.header')

<main class="bg-white max-w-lg mx-auto p-8 my-10 rounded-lg shadow-2xl">
    <section>
        <h3 class="font-bold text-2xl text-center">UPDATE '{{$department->department_name}}' DEPARTMENT</h3>
    </section>
    <section class="mt-10">
        <form action="/admin/department/{{$department->id}}/update" method="POST" class="flex flex-col">
            @csrf
            @method('PUT')
            <div class="mb-6 pt-3 rounded bg-gray-200">
                <label for="department_name" class="block text-gray-700 text-sm font-bold mb-2 ml-3">Department</label>
                <input type="text" id="department_name" name="department_name" class="bg-gray-200 rounded w-full text-gray-700 focus:outline-none border-b-4 border-gray-400 px-3" value={{$department->department_name}}>
                @error('department_name')
                    <p class="text-red-500 text-xs p-1 bg-white">
                        {{$message}}
                    </p>
                @enderror
            </div>
        
            <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 rounded shadow-lg hover:shadow-xl transition duration-200" type="submit">Update Department</button>
        </form>
    </section>
</main>

 @include('partials.footer')