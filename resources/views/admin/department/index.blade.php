
@include('partials.header')

<section class="mt-10">
    <div class="w-2/6 max-h-80 mx-auto overflow-y-auto">
        <table class="w-full text-sm text-gray-500 ">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 sticky top-0">
            <tr class="text-center">
                <th scope="col" class="py-3 px-6 ">
                Department
                </th>
                <th scope="col" class="py-3 px-6 w-40">
                Actions
                </th>
            </tr>
            </thead>
            <tbody>
                <x-table    :datas="$departments"
                            :columnCount="$columnCount"
                            :routeFirstPrefix="$firstPrefix"
                            :routeSecondPrefix="$secondPrefix"
                            
                />
            </tbody>
        </table>

    </div>
</section>

 @include('partials.footer')