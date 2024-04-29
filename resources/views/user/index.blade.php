
@include('partials.header')

    <section class="mt-10">
        <div class="w-10/12 max-h-[40rem] mx-auto overflow-y-auto">
        <table class="w-full text-sm text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 sticky top-0">
            <tr class="text-center">
                <th scope="col" class="py-3 px-6">
                    Name
                </th>
                <th scope="col" class="py-3 px-6">
                    Email
                    </th>
                <th scope="col" class="py-3 px-6">
                    Department
                </th>
                <th scope="col" class="py-3 px-6">
                    Role
                    </th>
                <th scope="col" class="py-3 px-6 w-40">
                    Actions
                </th>
            </tr>
            </thead>
            <tbody>
            {{-- @foreach ($users as $user)
                <tr class="bg-gray-800 text-white border-b">
                <td class="py-4 px-6">
                    {{ $user->name }}
                </td>
                <td class="py-4 px-6">
                    {{ $user->email }}
                </td>
                <td class="py-4 px-6">
                    {{ $user->department->name }}
                </td>
                <td class="py-4 px-6">
                    {{ $user->role->name }}
                </td>
                <td class="py-4 px-6">
                    <a href="/users/{{ $user->id }}/edit" class="bg-sky-600 hover:bg-sky-700 text-white px-4 py-1 rounded shadow-lg hover:shadow-xl transition duration-200">Edit</a>
                    <form action="/users/{{ $user->id }}" method="POST">                                              
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white mt-2 px-2 py-1 rounded shadow-lg hover:shadow-xl transition duration-200" type="submit">Delete</button>
                    </form>
                </td>
                </tr>
                @endforeach --}}
                <x-table    :datas="$users"
                            :columnCount="$columnCount"
                            :routeFirstPrefix="$firstPrefix"
                            :routeSecondPrefix="$secondPrefix"
                            
                />
            </tbody>
        </table>
        {{-- <div class="mx-auto max-w-lg pt-6 p-4">
            {{ $departments->links() }}
        </div> --}}
        </div>
    </section>
   
 @include('partials.footer')