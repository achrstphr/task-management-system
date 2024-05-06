@if (session()->has('success'))
<div x-data="{show : true}" x-show="show" x-init="setTimeout(()=> show = false, 5000)" class="bg-teal-100 fixed bottom-0 right-0 m-2 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md" role="alert">
    <div class="flex">
      <div class="py-1"><svg class="fill-current h-6 w-6 text-teal-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg></div>
      <div>
        <p class="font-bold">Success Message</p>
        <p class="text-sm">{{ session('success') }}</p>
      </div>
    </div>
  </div>
@endif
@if (session()->has('alert'))
<div x-data="{show : true}" x-show="show" x-init="setTimeout(()=> show = false, 5000)" class="bg-yellow-100 fixed bottom-0 right-0 m-2 border-t-4 border-yellow-500 rounded-b text-yellow-900 px-4 py-3 shadow-md" role="alert">
    <div class="flex">
      <div class="py-1"><svg class="fill-current h-6 w-6 text-yellow-500 mr-4" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="M480-280q17 0 28.5-11.5T520-320q0-17-11.5-28.5T480-360q-17 0-28.5 11.5T440-320q0 17 11.5 28.5T480-280Zm-40-160h80v-240h-80v240ZM330-120 120-330v-300l210-210h300l210 210v300L630-120H330Zm34-80h232l164-164v-232L596-760H364L200-596v232l164 164Zm116-280Z"/></svg></div>
      <div>
        <p class="font-bold">Alert Message</p>
        <p class="text-sm">{{ session('alert') }}</p>
      </div>
    </div>
  </div>
@endif
@if (session()->has('warning'))
<div x-data="{show : true}" x-show="show" x-init="setTimeout(()=> show = false, 5000)" class="bg-red-100 fixed bottom-0 right-0 m-2 border-t-4 border-red-500 rounded-b text-red-900 px-4 py-3 shadow-md" role="alert">
    <div class="flex">
      <div class="py-1"><svg class="fill-current h-6 w-6 text-red-500 mr-4"  xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="m40-120 440-760 440 760H40Zm138-80h604L480-720 178-200Zm302-40q17 0 28.5-11.5T520-280q0-17-11.5-28.5T480-320q-17 0-28.5 11.5T440-280q0 17 11.5 28.5T480-240Zm-40-120h80v-200h-80v200Zm40-100Z"/></svg></div>
      <div>
        <p class="font-bold">Warning Message</p>
        <p class="text-sm">{{ session('warning') }}</p>
      </div>
    </div>
  </div>
@endif
@if (session()->has('error'))
<div x-data="{show : true}" x-show="show" x-init="setTimeout(()=> show = false, 5000)" class="bg-red-100 fixed bottom-0 right-0 m-2 border-t-4 border-red-500 rounded-b text-red-900 px-4 py-3 shadow-md" role="alert">
    <div class="flex">
      <div class="py-1"><svg class="fill-current h-6 w-6 text-red-500 mr-4" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="M480-280q17 0 28.5-11.5T520-320q0-17-11.5-28.5T480-360q-17 0-28.5 11.5T440-320q0 17 11.5 28.5T480-280Zm-40-160h80v-240h-80v240Zm40 360q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z"/></svg></div>
      <div>
        <p class="font-bold">Error Message</p>
        <p class="text-sm">{{ session('error') }}</p>
      </div>
    </div>
  </div>
@endif