
@include('partials.header')

<section class="mt-10">
    <div class="w-10/12 max-h-[40rem] mx-auto overflow-y-auto">
        <table class="w-full text-sm text-gray-500" id="my-table">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 sticky top-0">
            <tr class="text-center">
                <th scope="col" class="py-3 px-6 w-100">
                    Task Name
                </th>
                <th scope="col" class="py-3 px-6 ">
                    Difficulty Level
                </th>
                <th scope="col" class="py-3 px-6 ">
                    Priority Level
                </th>
                <th scope="col" class="py-3 px-6 w-60">
                    Assign To
                </th>
                <th scope="col" class="py-3 px-6 ">
                    Task Status
                </th>
                <th scope="col" class="py-3 px-6 w-40">
                    Actions
                </th>
            </tr>
            </thead>
            <tbody>
                <x-table    :datas="$tasks"
                            :columnCount="$columnCount"
                            :routeFirstPrefix="$firstPrefix"
                            :routeSecondPrefix="$secondPrefix"
                            :permission="$permissions"
                />
            </tbody>
        </table>

    </div>
</section>

 @include('partials.footer')