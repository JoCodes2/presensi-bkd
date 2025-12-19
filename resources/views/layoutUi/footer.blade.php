<div
    class="fixed bottom-0 left-0 right-0 max-w-md mx-auto bg-white border-t border-light py-3 px-5 flex justify-between shadow-lg">

    {{-- HOME --}}
    <a href="{{ url('/') }}"
        class="flex flex-col items-center {{ request()->is('/') ? 'text-primary' : 'text-gray-500' }}">
        <i class="fas fa-home text-lg mb-1"></i>
        <span class="text-xs font-medium">HOME</span>
    </a>

    {{-- NOTIFIKASI --}}
    {{-- <a href="{{ url('/notifikasi-ui') }}"
        class="flex flex-col items-center {{ request()->is('notifikasi-ui*') ? 'text-primary' : 'text-gray-500' }}">
        <i class="fas fa-bell text-lg mb-1"></i>
        <span class="text-xs font-medium">NOTIFIKASI</span>
    </a> --}}
    <a href="{{ url('/notifikasi-ui') }}"
        class="relative flex flex-col items-center
   {{ request()->is('notifikasi-ui*') ? 'text-primary' : 'text-gray-500' }}">

        {{-- Icon --}}
    <i class="fas fa-bell text-lg mb-1"></i>

    {{-- Badge (Id ditambahkan: notif-badge) --}}
    <span id="notif-badge"
        class="hidden absolute -top-1 right-2
               bg-red-500 text-white
               text-[10px] font-bold
               w-4 h-4 flex items-center justify-center
               rounded-full border-2 border-white">
        !
    </span>

        {{-- Label --}}
        <span class="text-xs font-medium">NOTIFIKASI</span>
    </a>


    {{-- PROFILE --}}
    <a href="{{ url('/profil-ui') }}"
        class="flex flex-col items-center {{ request()->is('profil-ui*') ? 'text-primary' : 'text-gray-500' }}">
        <i class="fas fa-user text-lg mb-1"></i>
        <span class="text-xs font-medium">PROFILE</span>
    </a>

</div>
