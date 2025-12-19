class absensiService {
    constructor() {
        this.jamKerjaConfig = null;
    }

    ajaxRequest(url, method, data = null) {
        const isFormData = data instanceof FormData;

        return new Promise((resolve, reject) => {
            $.ajax({
                url: url,
                method: method,
                data: data,
                // --- INI PERBAIKANNYA ---
                processData: isFormData ? false : true, // Jangan proses data jika FormData
                contentType: isFormData ? false : 'application/x-www-form-urlencoded; charset=UTF-8', // Jangan atur contentType jika FormData
                // ------------------------
                success: (response) => resolve(response),
                error: (error) => reject(error),
            });
        });
    }

    async loadJamKerja() {
        try {
            const response = await this.ajaxRequest(`${appUrl}/presensi/jam/`, 'GET');
            const jamKerja = response.data && response.data.length > 0 ? response.data[0] : null;

            if (jamKerja) {
                this.jamKerjaConfig = jamKerja;
                $('#display-jadwal-masuk').text(jamKerja.jam_masuk.substring(0, 5));
                $('#display-jadwal-pulang').text(jamKerja.jam_keluar.substring(0, 5));
            }
        } catch (error) {
            console.error("Gagal memuat jam kerja", error);
        }
    }

    async updateTodayStatus() {
        try {
            if (!this.jamKerjaConfig) await this.loadJamKerja();

            const response = await this.ajaxRequest(`${appUrl}/presensi/bkd/`, 'GET');
            const allData = response.data || [];
            const today = moment().format('YYYY-MM-DD');

            let displayData = allData.find(item => item.tanggal === today);

            if (!displayData && allData.length > 0) {
                displayData = allData[0];
            }

            this.renderStatusUI(displayData);
            this.updateCurrentDateDisplay();
        } catch (error) {
            console.error('Gagal memuat status presensi:', error);
        }
    }

    renderStatusUI(data) {
        const $jamMasuk = $('#jam-masuk'), $statusMasuk = $('#status-masuk');
        const $jamPulang = $('#jam-pulang'), $statusPulang = $('#status-pulang');
        const $btnMasuk = $('#btn-absen-masuk'), $btnPulang = $('#btn-absen-pulang');

        // 1. Paksa menggunakan zona waktu Makassar agar sinkron dengan server
        const now = moment().tz("Asia/Makassar");

        // Ambil string jam kerja atau default jam 5 sore
        const jamPulangKantorStr = this.jamKerjaConfig ? this.jamKerjaConfig.jam_keluar : "17:00:00";
        const jamMasukKantorStr = this.jamKerjaConfig ? this.jamKerjaConfig.jam_masuk : "08:00:00";

        // Buat objek moment untuk perbandingan
        const jamPulangKantor = moment.tz(jamPulangKantorStr, "HH:mm:ss", "Asia/Makassar");
        const batasTutupSistem = moment.tz(jamPulangKantorStr, "HH:mm:ss", "Asia/Makassar").add(1, 'hours');

        // Label Default saat tombol aktif
        this.resetButton($btnMasuk, '', 'PRESENSI MASUK');
        this.resetButton($btnPulang, '', 'PRESENSI PULANG');

        // --- LOGIKA TOMBOL MASUK ---
        if (data && data.jam_masuk && data.status_masuk !== 'tidak_absen') {
            $jamMasuk.text(data.jam_masuk);
            this.disableButton($btnMasuk, 'SUDAH CHECK-IN');
            const color = data.status_masuk === 'terlambat' ? 'bg-orange-100 text-orange-700' : 'bg-green-100 text-green-700';
            $statusMasuk.html(`<span class="px-2 py-1 ${color} text-[10px] font-bold rounded uppercase">${data.status_masuk.replace('_', ' ')}</span>`);
        } else {
            $jamMasuk.text('-- : -- : --');
            if ((data && data.status_masuk === 'tidak_absen') || now.isAfter(batasTutupSistem)) {
                this.disableButton($btnMasuk, 'BATAS WAKTU HABIS');
                $statusMasuk.html(`<span class="px-2 py-1 bg-red-100 text-red-700 text-[10px] font-bold rounded uppercase">Tidak Hadir</span>`);
            } else {
                $statusMasuk.html(`<span class="px-2 py-1 bg-gray-200 text-gray-500 text-[10px] font-bold rounded uppercase">Belum Presensi</span>`);
            }
        }

        if (data && data.jam_keluar && data.status_keluar !== 'tidak_absen') {
            $jamPulang.text(data.jam_keluar);
            this.disableButton($btnPulang, 'SUDAH CHECK-OUT');
            $statusPulang.html(`<span class="px-2 py-1 bg-blue-100 text-blue-700 text-[10px] font-bold rounded uppercase">Selesai Kerja</span>`);
        } else {
            $jamPulang.text('-- : -- : --');

            if (data && data.status_keluar === 'tidak_absen') {
                this.disableButton($btnPulang, 'SESI BERAKHIR');
                $statusPulang.html(`<span class="px-2 py-1 bg-red-100 text-red-700 text-[10px] font-bold rounded uppercase">Tidak Hadir</span>`);
            }
            else if (!data || !data.jam_masuk || data.status_masuk === 'tidak_absen') {
                this.disableButton($btnPulang, 'MASUK TERLEBIH DAHULU');
                $statusPulang.html(`<span class="px-2 py-1 bg-gray-200 text-gray-500 text-[10px] font-bold rounded uppercase">Belum Presensi</span>`);
            }
            else if (now.isAfter(batasTutupSistem)) {
                this.disableButton($btnPulang, 'WAKTU PRESENSI HABIS');
                $statusPulang.html(`<span class="px-2 py-1 bg-red-100 text-red-700 text-[10px] font-bold rounded uppercase">Tanpa Keterangan</span>`);
            }
            else if (now.isBefore(jamPulangKantor)) {
                this.disableButton($btnPulang, 'BELUM WAKTUNYA PULANG');
                $statusPulang.html(`<span class="px-2 py-1 bg-gray-200 text-gray-500 text-[10px] font-bold rounded uppercase">Tunggu Jam ${jamPulangKantorStr.substring(0, 5)}</span>`);
            }
            else {
                this.resetButton($btnPulang, '', 'PRESENSI PULANG');
                $statusPulang.html(`<span class="px-2 py-1 bg-green-100 text-green-700 text-[10px] font-bold rounded uppercase">Siap Check-out</span>`);
            }
        }
    }

    /**
     * Helper untuk mematikan tombol (Visual & Fungsi)
     */
    disableButton($btn, text) {
        $btn.prop('disabled', true)
            .addClass('opacity-50 cursor-not-allowed grayscale')
            .find('span').text(text);
        $btn.find('small').text('Akses dikunci');
    }

    /**
     * Helper untuk mengembalikan tombol
     */
    resetButton($btn, colorClass, text) {
        let subText = "Klik untuk merekam kehadiran";
        if (text.includes("MASUK") || text.includes("IN")) {
            subText = "Klik untuk Check-in";
        } else if (text.includes("PULANG") || text.includes("OUT")) {
            subText = "Klik untuk Check-out";
        }
    }

    updateCurrentDateDisplay() {
        moment.locale('id');
        $('#current-date').text(moment().format('dddd, DD MMMM YYYY'));
    }
    getCurrentLocation() {
        return new Promise((resolve, reject) => {
            if (!navigator.geolocation) {
                reject("Geolocation tidak didukung oleh browser Anda.");
            }

            navigator.geolocation.getCurrentPosition(
                (position) => {
                    const lat = position.coords.latitude;
                    const long = position.coords.longitude;
                    resolve({ lat, long });
                },
                (error) => {
                    let msg = "Gagal mengambil lokasi.";
                    if (error.code === 1) msg = "Izin lokasi ditolak. Mohon aktifkan GPS.";
                    if (error.code === 3) msg = "Waktu pengambilan lokasi habis (Timeout). Coba lagi.";
                    reject(msg);
                },
                // Naikkan timeout ke 10000ms (10 detik)
                { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
            );
        });
    }

    /**
     * Kirim data presensi ke Backend
     */
    async submitPresensi(type) {
        try {
            const coords = await this.getCurrentLocation();

            const formData = new FormData();
            formData.append('latitude', coords.lat);
            formData.append('longitude', coords.long);
            formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

            // Gunakan await untuk mendapatkan response sukses
            const response = await this.ajaxRequest(`${appUrl}/presensi/bkd/${type}`, 'POST', formData);
            console.log(response);

            return response;
            // Di dalam catch submitPresensi service
        } catch (error) {
            console.log("Original Error:", error); // Sangat membantu saat debug
            if (error.responseJSON && error.responseJSON.message) {
                throw error.responseJSON.message;
            }
            // Jika server error 500 atau timeout
            if (error.statusText === "error") throw "Koneksi ke server terputus.";

            throw typeof error === 'string' ? error : "Terjadi kesalahan pada server.";
        }
    }
}

export default absensiService;
