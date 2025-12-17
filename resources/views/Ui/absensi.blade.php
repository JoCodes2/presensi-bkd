@extends('layoutUi.base')
@section('content')
   <!-- User Info -->
    <div class="px-5 py-4 border-b border-light">
            <h2 class="text-lg font-semibold text-gray-800">AKBAR TRI WICAKSONO</h2>
            <p class="text-gray-500 text-sm">Selasa, 16 Desember 2025</p>
        </div>

        <!-- Status Info -->
        <div class="flex justify-between px-5 py-4 border-b border-light">
            <div class="text-center">
                <p class="text-gray-500 text-xs mb-1">Status</p>
                <p class="font-semibold text-gray-800">Hadir</p>
            </div>
            <div class="text-center">
                <p class="text-gray-500 text-xs mb-1">Lokasi</p>
                <p class="font-semibold text-gray-800">Kantor</p>
            </div>
            <div class="text-center">
                <p class="text-gray-500 text-xs mb-1">Mode</p>
                <p class="font-semibold text-primary">WFO</p>
            </div>
        </div>

        <!-- Time Info -->
        <div class="px-5 py-4 border-b border-light">
            <!-- Jam Masuk -->
            <div class="flex justify-between items-center mb-5">
                <div>
                    <h3 class="font-medium text-gray-800">Jam Masuk</h3>
                </div>
                <div class="text-right">
                    <p class="text-gray-500 text-sm">08:15:00</p>
                    <p class="font-semibold text-green-600 text-lg">08:03:12</p>
                </div>
            </div>

            <!-- Jam Pulang -->
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="font-medium text-gray-800">Jam Pulang</h3>
                </div>
                <div class="text-right">
                    <p class="text-gray-500 text-sm">16:00:00</p>
                    <p class="font-semibold text-gray-800 text-lg">16:09:11</p>
                </div>
            </div>
        </div>

        <!-- Location & WFH/WFO Section -->
        <div class="px-5 py-4 border-b border-light">
            <div class="flex items-center mb-4">
                <i class="fas fa-map-marker-alt text-primary mr-2"></i>
                <h3 class="font-medium text-gray-800">Mode Kerja</h3>
            </div>

            {{-- <div class="bg-gray-50 rounded-xl p-4 mb-4">
                <div class="flex justify-between mb-2">
                    <span class="text-gray-600 text-sm">Lokasi Saat Ini:</span>
                    <span class="font-medium text-gray-800 text-sm">Kantor Pusat - Lantai 5</span>
                </div>
                <div class="flex justify-between mb-2">
                    <span class="text-gray-600 text-sm">Koordinat:</span>
                    <span class="font-medium text-gray-800 text-sm">-6.3021, 106.6529</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600 text-sm">Jarak dari Kantor:</span>
                    <span class="font-medium text-green-600 text-sm">150 m</span>
                </div>
            </div> --}}

            <!-- Work Mode Selector -->
            <div class="mb-3">
                <p class="text-gray-600 text-sm mb-2">Pilih Mode Kerja:</p>
                <div class="flex space-x-3">
                    <button id="wfo-btn"
                        class="flex-1 py-3 px-2 border-2 border-primary bg-blue-50 text-primary font-medium rounded-xl flex items-center justify-center transition-all duration-200">
                        <i class="fas fa-building mr-2"></i>
                        <span>WFO</span>
                    </button>
                    <button id="wfh-btn"
                        class="flex-1 py-3 px-2 border-2 border-gray-300 text-gray-700 font-medium rounded-xl flex items-center justify-center transition-all duration-200">
                        <i class="fas fa-home mr-2"></i>
                        <span>WFH</span>
                    </button>
                </div>
            </div>

            <button id="get-location-btn"
                class="w-full bg-primary text-white font-medium py-3 rounded-xl mt-2 flex items-center justify-center">
                <i class="fas fa-location-crosshairs mr-2"></i>
                <span>Ambil Lokasi Sekarang</span>
            </button>
        </div>

        <!-- Monthly Summary -->
        <div class="px-5 py-4 border-b border-light text-center">
            <h3 class="font-medium text-gray-800 mb-4">
                Absensi Bulan Desember ~ 2025
            </h3>

            <div class="flex justify-center gap-3">
                <div class="bg-gray-50 rounded-lg p-3 w-20">
                    <p class="font-bold text-gray-800 text-lg">10</p>
                    <p class="text-gray-500 text-xs">WFO</p>
                </div>

                <div class="bg-gray-50 rounded-lg p-3 w-20">
                    <p class="font-bold text-gray-800 text-lg">2</p>
                    <p class="text-gray-500 text-xs">WFH</p>
                </div>

                <div class="bg-gray-50 rounded-lg p-3 w-20">
                    <p class="font-bold text-gray-800 text-lg">2</p>
                    <p class="text-gray-500 text-xs">TELAT</p>
                </div>
            </div>
        </div>


        <!-- Recent Attendance -->
        <div class="px-5 py-4">
            <h3 class="font-medium text-gray-800 mb-4">1 Minggu Terakhir</h3>

            <!-- Today -->
            <div class="flex justify-between items-center py-3 border-b border-light">
                <div>
                    <p class="font-medium text-gray-800">16 Des 2025</p>
                </div>
                <div class="flex items-center">
                    <div class="text-right mr-3">
                        <p class="font-medium text-primary">08:03:12</p>
                        <p class="font-medium text-gray-800">16:09:11</p>
                    </div>
                    <span class="mode-label mode-wfo">WFO</span>
                </div>
            </div>

            <!-- Yesterday -->
            <div class="flex justify-between items-center py-3 border-b border-light">
                <div>
                    <p class="font-medium text-gray-800">15 Des 2025</p>
                </div>
                <div class="flex items-center">
                    <div class="text-right mr-3">
                        <p class="font-medium text-primary">08:06:21</p>
                        <p class="font-medium text-gray-800">16:01:27</p>
                    </div>
                    <span class="mode-label mode-wfh">WFH</span>
                </div>
            </div>

            <!-- Day before yesterday -->
            <div class="flex justify-between items-center py-3 border-b border-light">
                <div>
                    <p class="font-medium text-gray-800">14 Des 2025</p>
                </div>
                <div class="flex items-center">
                    <div class="text-right mr-3">
                        <p class="font-medium text-primary">08:01:45</p>
                        <p class="font-medium text-gray-800">16:05:33</p>
                    </div>
                    <span class="mode-label mode-wfo">WFO</span>
                </div>
            </div>

            <!-- 2 days before -->
            <div class="flex justify-between items-center py-3">
                <div>
                    <p class="font-medium text-gray-800">13 Des 2025</p>
                </div>
                <div class="flex items-center">
                    <div class="text-right mr-3">
                        <p class="font-medium text-red-500">08:22:10</p>
                        <p class="font-medium text-gray-800">15:58:42</p>
                    </div>
                    <span class="mode-label mode-wfo">WFO</span>
                </div>
            </div>
        </div>
@endsection
@section('scripts')

@endsection
