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

        @include('layoutUi.header')
        <div>
            @yield('content')
        </div>
     

        <!-- Bottom Navigation -->
        @include('layoutUi.footer')

        {{-- <div id="location-modal" class="fixed inset-0 bg-black/50 flex items-center justify-center p-5 z-50 hidden">
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
        </div> --}}
        <!-- Modal untuk lokasi -->
    </div>
    @yield('scripts')
    {{-- <script>
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
    </script> --}}
</body>

</html>
