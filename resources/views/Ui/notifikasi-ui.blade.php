@extends('layoutUi.base')

@section('content')
    <!-- User Info -->
    <div class="px-5 py-4 border-b border-light">
        <h2 class="text-lg font-semibold text-gray-800">AKBAR TRI WICAKSONO</h2>
        <p class="text-gray-500 text-sm">Selasa, 16 Desember 2025</p>
    </div>

    <!-- Notifikasi -->
    <div class="px-5 py-4 space-y-3">

        {{-- Notifikasi Terlambat --}}
        <div class="flex items-start gap-3 p-4 bg-red-50 border border-red-200 rounded-lg">
            <div class="text-red-600 text-xl">
                <i class="fas fa-clock"></i>
            </div>
            <div class="flex-1">
                <p class="text-sm font-semibold text-red-700">
                    Anda Terlambat Melakukan Absensi
                </p>
                <p class="text-xs text-gray-600 mt-1">
                    Absensi dilakukan pukul <span class="font-medium">08:15</span>.
                    Batas waktu absensi adalah <span class="font-medium">08:00</span>.
                </p>
                <p class="text-xs text-gray-400 mt-1">
                    Selasa, 16 Desember 2025
                </p>
            </div>
        </div>

        {{-- Contoh Notifikasi Normal --}}
        <div class="flex items-start gap-3 p-4 bg-green-50 border border-green-200 rounded-lg">
            <div class="text-green-600 text-xl">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="flex-1">
                <p class="text-sm font-semibold text-green-700">
                    Absensi Berhasil
                </p>
                <p class="text-xs text-gray-600 mt-1">
                    Absensi dilakukan tepat waktu pada pukul <span class="font-medium">07:45</span>.
                </p>
                <p class="text-xs text-gray-400 mt-1">
                    Senin, 15 Desember 2025
                </p>
            </div>
        </div>

    </div>
@endsection

@section('scripts')
@endsection
