@extends('layoutUi.base')

@section('content')
    <!-- Header User -->
    <div class="px-5 py-4 border-b border-light flex items-center gap-4">
        <img src="" class="w-16 h-16 rounded-full object-cover border" alt="Profile">

        <div>
            <h2 class="text-lg font-semibold text-gray-800">
                {{-- {{ auth()->user()->name }} --}}
            </h2>
            <p class="text-gray-500 text-sm">
                {{-- {{ auth()->user()->email }} --}}
            </p>
        </div>
    </div>

    <!-- Profile Detail -->
    <div class="px-5 py-4 space-y-4 text-sm">

        <div class="grid grid-cols-2 gap-3">
            <div>
                <p class="text-gray-400">NIK</p>
                {{-- <p class="font-medium text-gray-800">{{ auth()->user()->nik ?? '-' }}</p> --}}
            </div>
            <div>
                <p class="text-gray-400">NIP</p>
                {{-- <p class="font-medium text-gray-800">{{ auth()->user()->nip ?? '-' }}</p> --}}
            </div>
        </div>

        <div>
            <p class="text-gray-400">Alamat</p>
            {{-- <p class="font-medium text-gray-800">{{ auth()->user()->alamat ?? '-' }}</p> --}}
        </div>

        <div class="grid grid-cols-2 gap-3">
            <div>
                <p class="text-gray-400">No. HP</p>
                {{-- <p class="font-medium text-gray-800">{{ auth()->user()->no_hp ?? '-' }}</p> --}}
            </div>
            <div>
                <p class="text-gray-400">Jenis Kelamin</p>
                <p class="font-medium text-gray-800">
                    {{-- {{ auth()->user()->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }} --}}
                </p>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-3">
            <div>
                <p class="text-gray-400">Tempat Lahir</p>
                {{-- <p class="font-medium text-gray-800">{{ auth()->user()->tempat_lahir ?? '-' }}</p> --}}
            </div>
            <div>
                <p class="text-gray-400">Tanggal Lahir</p>
                <p class="font-medium text-gray-800">
                    {{-- {{ auth()->user()->tanggal_lahir ? \Carbon\Carbon::parse(auth()->user()->tanggal_lahir)->format('d M Y') : '-' }} --}}
                </p>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-3">
            <div>
                <p class="text-gray-400">Agama</p>
                {{-- <p class="font-medium text-gray-800">{{ auth()->user()->agama ?? '-' }}</p> --}}
            </div>
            <div>
                <p class="text-gray-400">Status</p>
                <span
                    class="inline-block px-2 py-1 text-xs rounded
                    {{-- {{ auth()->user()->status == 'aktif' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                    {{ ucfirst(auth()->user()->status) }} --}}
                </span>
            </div>
        </div>

        <div class="grid
                    grid-cols-2 gap-3">
                    <div>
                        <p class="text-gray-400">Jabatan</p>
                        <p class="font-medium text-gray-800">
                            {{-- {{ auth()->user()->jabatan->nama_jabatan ?? '-' }} --}}
                        </p>
                    </div>
                    <div>
                        <p class="text-gray-400">Lokasi Kantor</p>
                        <p class="font-medium text-gray-800">
                            {{-- {{ auth()->user()->lokasiKantor->nama_lokasi ?? '-' }} --}}
                        </p>
                    </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <p class="text-gray-400">Role</p>
                    {{-- <p class="font-medium text-gray-800">{{ strtoupper(auth()->user()->role) }}</p> --}}
                </div>
                <div>
                    <p class="text-gray-400">Password</p>
                    <p class="font-medium text-gray-500 italic">********</p>
                </div>
            </div>

        </div>
    @endsection

    @section('scripts')
    @endsection
