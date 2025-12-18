@extends('layoutUi.base')
@section('content')

<section>
<div class="max-w-md mx-auto bg-white min-h-screen shadow-sm">

    <div class="px-6 py-8">
        <div class="flex items-center space-x-4">
            <div class="h-14 w-14 rounded-full bg-white/20 flex items-center justify-center border-2 border-white/30">
                <i class="fas fa-user-tie text-2xl"></i>
            </div>
            <div>
                <p class="text-blue-100 text-sm opacity-90">Selamat datang,</p>
                <h2 class="text-xl font-bold uppercase tracking-tight">AKBAR TRI WICAKSONO</h2>
                <span class="inline-block px-2 py-0.5 bg-white/20 rounded text-xs font-medium mt-1 uppercase">Staf Administrasi</span>
            </div>
        </div>
    </div>

    <div class="px-6 -mt-6">
        <div class="bg-white rounded-2xl shadow-md p-4 flex justify-around border border-gray-100 text-center">
            <div>
                <p class="text-gray-400 text-[10px] uppercase font-bold tracking-wider mb-1">
                    Jadwal Masuk</span>
                </p>
                <p id="display-jadwal-masuk" class="text-gray-800 font-bold text-lg">--:--</p>
            </div>
            <div class="w-px bg-gray-100 h-10 my-auto"></div>
            <div>
                <p class="text-gray-400 text-[10px] uppercase font-bold tracking-wider mb-1">Jadwal Pulang</p>
                <p id="display-jadwal-pulang" class="text-gray-800 font-bold text-lg">--:--</p>
            </div>
        </div>
    </div>

    <div class="px-6 py-8 space-y-4">
        <div class="grid grid-cols-2 gap-4">
            <button class="flex flex-col items-center justify-center bg-green-50 hover:bg-green-100 border-2 border-green-200 p-5 rounded-2xl transition-all group">
                <div class="h-12 w-12 bg-green-500 text-white rounded-full flex items-center justify-center mb-3 shadow-sm group-active:scale-95 transition-transform">
                    <i class="fas fa-sign-in-alt text-xl"></i>
                </div>
                <span class="font-bold text-green-700 text-sm">ABSEN MASUK</span>
                <small class="text-green-600/70 text-[10px]">Klik untuk check-in</small>
            </button>

            <button class="flex flex-col items-center justify-center bg-red-50 hover:bg-red-100 border-2 border-red-200 p-5 rounded-2xl transition-all group">
                <div class="h-12 w-12 bg-red-500 text-white rounded-full flex items-center justify-center mb-3 shadow-sm group-active:scale-95 transition-transform">
                    <i class="fas fa-sign-out-alt text-xl"></i>
                </div>
                <span class="font-bold text-red-700 text-sm">ABSEN PULANG</span>
                <small class="text-red-600/70 text-[10px]">Klik untuk check-out</small>
            </button>
        </div>
    </div>

    <div class="px-6 pb-10">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-bold text-gray-800">Status Hari Ini</h3>
            <span id="current-date" class="text-[11px] text-blue-600 font-bold px-2 py-1 bg-blue-50 rounded-full italic">
                Memuat tanggal...
            </span>
        </div>

        <div class="space-y-3">
            <div class="flex items-center p-4 bg-gray-50 rounded-xl border border-gray-100">
                <div class="h-10 w-10 bg-white rounded-lg flex items-center justify-center text-primary shadow-sm mr-4">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="flex-grow">
                    <p class="text-gray-500 text-[11px] leading-none mb-1">Jam Masuk Anda</p>
                    <p class="text-gray-800 font-bold">08:03:12</p>
                </div>
                <div class="text-right">
                    <span class="px-2 py-1 bg-green-100 text-green-700 text-[10px] font-bold rounded uppercase">Tepat Waktu</span>
                </div>
            </div>

            <div class="flex items-center p-4 bg-gray-50 rounded-xl border border-gray-100">
                <div class="h-10 w-10 bg-white rounded-lg flex items-center justify-center text-secondary shadow-sm mr-4">
                    <i class="fas fa-door-open"></i>
                </div>
                <div class="flex-grow">
                    <p class="text-gray-500 text-[11px] leading-none mb-1">Jam Pulang Anda</p>
                    <p class="text-gray-800 font-bold">-- : -- : --</p>
                </div>
                <div class="text-right">
                    <span class="px-2 py-1 bg-gray-200 text-gray-500 text-[10px] font-bold rounded uppercase">Belum Absen</span>
                </div>
            </div>
        </div>
    </div>
</div>
</section>

@endsection
@section('scripts')
 <script type="module" src="{{ asset('js/controllers/absensi.controller.js')}}"></script>
@endsection
