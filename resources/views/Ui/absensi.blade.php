<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BKD SULTENG - Absensi by Lokasi</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .gradient-bg {
            background: linear-gradient(135deg, #4b6cb7 0%, #182848 100%);
        }

        .mode-wfo {
            background-color: #e1f5fe;
            color: #0288d1;
        }

        .mode-wfh {
            background-color: #e8f5e9;
            color: #2e7d32;
        }

        .mode-label {
            display: inline-block;
            padding: 0.2rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        /* Custom styles untuk memastikan konsistensi di semua browser */
        .shadow-custom {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .border-light {
            border-color: #eef2f7;
        }

        .text-primary {
            color: #1e40af;
        }

        .bg-primary {
            background-color: #1e40af;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800">
    <div class="max-w-md mx-auto bg-white min-h-screen shadow-custom">
        <!-- Header -->
        <header class="gradient-bg text-white pt-6 pb-8 px-5 rounded-b-2xl">
            <div class="flex items-center justify-between">
                <!-- Logo di kiri -->
                <div class="flex-shrink-0">
                    <img src="{{ asset('assets/img/Logo_BKD.png') }}" alt="Logo BKD SULTENG" class="h-16 w-auto">
                </div>

                <!-- Teks judul di kanan -->
                <div class="ml-4 text-right">
                    <h1 class="text-xl font-bold leading-tight">BKD SULTENG</h1>
                    <p class="text-white/90 text-sm mt-1">Absensi by Lokasi</p>
                </div>
            </div>
        </header>

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

        <!-- Bottom Navigation -->
        <div
            class="fixed bottom-0 left-0 right-0 max-w-md mx-auto bg-white border-t border-light py-3 px-5 flex justify-between shadow-lg">
            <a href="#" class="flex flex-col items-center text-primary">
                <i class="fas fa-home text-lg mb-1"></i>
                <span class="text-xs font-medium">HOME</span>
            </a>
            {{-- <a href="#" class="flex flex-col items-center text-gray-500">
                <i class="fas fa-file-alt text-lg mb-1"></i>
                <span class="text-xs font-medium">IZIN</span>
            </a> --}}
            <a href="#" class="flex flex-col items-center text-gray-500">
                <i class="fas fa-fingerprint text-lg mb-1"></i>
                <span class="text-xs font-medium">ABSEN</span>
            </a>
            {{-- <a href="#" class="flex flex-col items-center text-gray-500">
                <i class="fas fa-history text-lg mb-1"></i>
                <span class="text-xs font-medium">HISTORY</span>
            </a> --}}
            <a href="{{ url('/profile') }}" class="flex flex-col items-center text-gray-500">
                <i class="fas fa-user text-lg mb-1"></i>
                <span class="text-xs font-medium">PROFILE</span>
            </a>
        </div>

        <!-- Modal untuk lokasi -->
        <div id="location-modal" class="fixed inset-0 bg-black/50 flex items-center justify-center p-5 z-50 hidden">
            <div class="bg-white rounded-2xl w-full max-w-sm overflow-hidden">
                <div class="gradient-bg text-white p-5">
                    <h3 class="text-lg font-bold text-center">Konfirmasi Lokasi</h3>
                </div>

                <div class="p-5">
                    <div class="bg-gray-100 h-48 rounded-xl flex flex-col items-center justify-center mb-4">
                        <i class="fas fa-map-marker-alt text-4xl text-primary mb-3"></i>
                        <p class="text-gray-600 font-medium">Memuat lokasi...</p>
                    </div>

                    <div class="mb-4">
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-600">Alamat:</span>
                            <span class="font-medium text-gray-800 text-right">Jl. Sudirman No. 123, Jakarta</span>
                        </div>
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-600">Koordinat:</span>
                            <span class="font-medium text-gray-800">-6.3021, 106.6529</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Jarak ke kantor:</span>
                            <span class="font-medium text-green-600">150 meter</span>
                        </div>
                    </div>

                    <div class="flex space-x-3">
                        <button id="cancel-btn" class="flex-1 py-3 bg-gray-200 text-gray-800 font-medium rounded-xl">
                            Batal
                        </button>
                        <button id="confirm-btn" class="flex-1 py-3 bg-primary text-white font-medium rounded-xl">
                            Konfirmasi
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Toggle WFO/WFH buttons
        const wfoBtn = document.getElementById('wfo-btn');
        const wfhBtn = document.getElementById('wfh-btn');
        const getLocationBtn = document.getElementById('get-location-btn');
        const locationModal = document.getElementById('location-modal');
        const cancelBtn = document.getElementById('cancel-btn');
        const confirmBtn = document.getElementById('confirm-btn');

        // Mode kerja aktif
        let activeMode = 'wfo';

        // Fungsi untuk update tampilan mode kerja
        function updateWorkMode(mode) {
            activeMode = mode;

            if (mode === 'wfo') {
                wfoBtn.classList.add('border-primary', 'bg-blue-50', 'text-primary');
                wfoBtn.classList.remove('border-gray-300', 'text-gray-700');

                wfhBtn.classList.add('border-gray-300', 'text-gray-700');
                wfhBtn.classList.remove('border-primary', 'bg-blue-50', 'text-primary');

                // Update status di header
                document.querySelector('.text-primary').textContent = 'WFO';
            } else {
                wfhBtn.classList.add('border-primary', 'bg-blue-50', 'text-primary');
                wfhBtn.classList.remove('border-gray-300', 'text-gray-700');

                wfoBtn.classList.add('border-gray-300', 'text-gray-700');
                wfoBtn.classList.remove('border-primary', 'bg-blue-50', 'text-primary');

                // Update status di header
                document.querySelector('.text-primary').textContent = 'WFH';
            }
        }

        // Event listeners untuk tombol mode kerja
        wfoBtn.addEventListener('click', () => updateWorkMode('wfo'));
        wfhBtn.addEventListener('click', () => updateWorkMode('wfh'));

        // Event listener untuk tombol ambil lokasi
        getLocationBtn.addEventListener('click', () => {
            // Tampilkan modal lokasi
            locationModal.classList.remove('hidden');

            // Simulasi pengambilan lokasi
            setTimeout(() => {
                const modalContent = locationModal.querySelector('.bg-gray-100');
                modalContent.innerHTML = `
                    <i class="fas fa-check-circle text-4xl text-green-500 mb-3"></i>
                    <p class="text-gray-600 font-medium">Lokasi berhasil diperoleh</p>
                    <p class="text-sm text-gray-500 mt-2">${activeMode === 'wfo' ? 'Lokasi kantor terdeteksi' : 'Lokasi rumah terdeteksi'}</p>
                `;
            }, 1000);
        });

        // Event listener untuk tombol batal di modal
        cancelBtn.addEventListener('click', () => {
            locationModal.classList.add('hidden');
        });

        // Event listener untuk tombol konfirmasi di modal
        confirmBtn.addEventListener('click', () => {
            locationModal.classList.add('hidden');

            // Update lokasi di halaman utama berdasarkan mode
            const locationElement = document.querySelectorAll('.flex.justify-between')[1].querySelector(
                '.font-medium');
            const statusElement = document.querySelectorAll('.text-center')[1].querySelector('.font-semibold');

            if (activeMode === 'wfo') {
                locationElement.textContent = 'Kantor';
                statusElement.textContent = 'Kantor';

                // Update koordinat contoh untuk kantor
                document.querySelectorAll('.flex.justify-between')[5].querySelectorAll('.font-medium')[1]
                    .textContent = '-6.3021, 106.6529';
            } else {
                locationElement.textContent = 'Rumah';
                statusElement.textContent = 'Rumah';

                // Update koordinat contoh untuk rumah
                document.querySelectorAll('.flex.justify-between')[5].querySelectorAll('.font-medium')[1]
                    .textContent = '-6.3015, 106.6535';
            }

            // Tampilkan pesan sukses
            alert(`Absensi dengan mode ${activeMode.toUpperCase()} berhasil direkam!`);
        });

        // Inisialisasi mode kerja
        updateWorkMode('wfo');
    </script>
</body>

</html>
