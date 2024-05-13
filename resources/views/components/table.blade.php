
    @foreach ($datas as $data)

        <tr class="bg-gray-800 text-white text-center border-b h-12">
            @if (isset($data->role_name))
                <td class="py-4 px-6 border-collapse border-r border-slate-100">
                    {{ $data->role_name }}
                </td>
            @endif
            {{-- @dd(json_decode($data, false)) --}}
            @if (isset($data->permission))
                <td class="py-4 px-6 border-collapse border-r border-slate-100">
                    @php
                        $permissions = json_decode($data->permission, true)
                        
                    @endphp
                    {!! implode(' <span style="color: red;">&diams;</span> ', $permissions) !!}
            @endif
            @if (isset($data->department_name))
                <td class="py-4 px-6 border-collapse border-r border-slate-100">
                    {{ $data->department_name }}
                </td>
            @endif
            @if (isset($data->name))
                <td class="py-4 px-6 border-collapse border-r border-slate-100">
                    {{ $data->name }}
                </td>
            @endif
            @if (isset($data->email))
                <td class="py-4 px-6 border-collapse border-r border-slate-100">
                    {{ $data->email }}
                </td>
            @endif
            @if (isset($data->department->department_name))

                <td class="py-4 px-6 border-collapse border-r border-slate-100">
                    {{ $data->department->department_name }}
                </td>
            @else
                @if (isset($data->role))
                    <td class="py-4 px-6 border-collapse border-r border-slate-100">
                        (Not Set)
                    </td>
                @endif
            @endif
            @if (isset($data->role->role_name))
                <td class="py-4 px-6 border-collapse border-r border-slate-100">
                    {{ $data->role->role_name }}
                </td>
            @endif
            @if (isset($data->task_name))
                <td class="py-4 px-6 border-collapse border-r border-slate-100">
                    {{ $data->task_name }}
                </td>
            @endif
            @if (isset($data->difficulty_level))
                <td class="py-4 px-6 border-collapse border-r border-slate-100">
                    {{ $data->difficulty_level }}
                </td>
            @endif
            @if (isset($data->priority_level))
                <td class="py-4 px-6 border-collapse border-r border-slate-100">
                    {{ $data->priority_level }}
                </td>
            @endif
            @if (isset($data->user->name))
                <td class="py-4 px-6 border-collapse border-r border-slate-100">
                    {{ $data->user->name }}
                </td>
            @else
                @if (isset($data->task_name))
                    <td class="py-4 px-6 border-collapse border-r border-slate-100">
                        (Not Set)
                    </td>
                @endif
            @endif
            @if (isset($data->task_status))
                <td class="py-4 px-6 border-collapse border-r border-slate-100">
                    {{ $data->task_status }}
                </td>
            @endif
            <td class="w-full py-4 px-6 flex flex-row text-center justify-center">
                {{-- <div class="w-auto flex justify-center"> --}}
                
                    <a href="/{{ $routeFirstPrefix }}{{ $routeSecondPrefix }}/edit/{{ $data->id }}" 

                        @if (!in_array('Manage Users', $permission)) 
                            disabled 
                            class="bg-gray-400 text-white px-4 py-1 mx-1 rounded shadow-lg hover:bg-gray-400"
                            title="You do not have permission to edit data"
                        @else
                            class="bg-sky-600 hover:bg-sky-700 text-white px-4 py-1 mx-1 rounded shadow-lg hover:shadow-xl transition duration-200"
                            title="Edit data"
                        @endif>
                        Edit
                    </a>
                    <form action="/{{ $routeFirstPrefix }}{{ $routeSecondPrefix }}/{{ $data->id }}/destroy" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                            @if (!in_array('Manage Users', $permission))
                                disabled
                                class="bg-gray-400 text-white px-4 py-1 mx-1 rounded shadow-lg hover:bg-gray-400"
                                title="You do not have permission to delete data"
                            @else
                                class="bg-red-600 mx-1 hover:bg-red-700 text-white px-4 py-1 rounded shadow-lg hover:shadow-xl transition duration-200"
                                title="Delete data"
                            @endif>
                            Delete
                        </button>
                    </form>
                {{-- </div> --}}
            </td>
        </tr>
        @endforeach
        {{-- It will show minimum of 5 rows even no data --}}
        @for ($i = count($datas); $i < 5; $i++)
    
            <tr class="bg-gray-800 text-white border-b h-12 text-center">
                @if ($columnCount == 10)
                {{-- minus 5 is to exclude 5 columns (createdAt, UpdatedAt, email_verified_at, password, remember_token) --}}
                    @for ($j = 0; $j < $columnCount - 5; $j++)
                        @if ($j == ($columnCount - 5) - 1)
                            <td class="py-4 px-6">(Empty)</td>
                        @else
                            <td class="py-4 px-6 border-collapse border-r border-slate-100">(Empty)</td>
                        @endif
                    @endfor
                @else
                    {{-- minus 2 is to exclude 2 columns (createdAt, UpdatedAt) --}}
                    @for ($j = 0; $j < $columnCount - 2; $j++)
                        @if ($j == ($columnCount - 2) - 1)
                            <td class="py-4 px-6">(Empty)</td>
                        @else
                            <td class="py-4 px-6 border-collapse border-r border-slate-100">(Empty)</td>
                        @endif
                    @endfor
                @endif
            </tr>
        
    @endfor