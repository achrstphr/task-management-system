
@include('partials.header')

    <section class="mt-10">
        <div class="w-10/12 max-h-[40rem] mt-10 mx-auto overflow-y-auto">
        <table class="w-full text-sm text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 sticky top-0">
            <tr class="text-center">
                <th scope="col" class="py-3 px-6">
                    Timestamp
                </th>
                <th scope="col" class="py-3 px-6">
                    User Name
                    </th>
                <th scope="col" class="py-3 px-6">
                    Action
                </th>
                <th scope="col" class="py-3 px-6">
                    Details
                    </th>
            </tr>
            </thead>
            <tbody>
                @foreach ($activityLogs as $activityLog)

                    <tr class="bg-gray-800 text-white text-center border-b h-12">
                        <td class="py-4 px-6 border-collapse border-r border-slate-100">
                            {{ $activityLog->created_at }}
                        </td>
                        <td class="py-4 px-6 border-collapse border-r border-slate-100">
                            {{ $activityLog->user->name }}
                        </td>
                        <td class="py-4 px-6 border-collapse border-r border-slate-100">
                            {{ $activityLog->action }}
                        </td>
                        <td class="py-4 px-6 border-collapse border-r border-slate-100">
                            {{ $activityLog->details }}
                        </td>  
                    </tr>
                @endforeach
                {{-- It will show minimum of 5 rows even no data --}}
                @for ($i = count($activityLogs); $i < 5; $i++)
            
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
            </tbody>
        </table>

        </div>
    </section>
   
 @include('partials.footer')