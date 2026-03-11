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
                processData: isFormData ? false : true,
                contentType: isFormData ? false : 'application/x-www-form-urlencoded; charset=UTF-8',
                success: (response) => resolve(response),
                error: (error) => reject(error),
            });
        });
    }

    async loadJamKerja() {
        try {
            const response = await this.ajaxRequest(`${appUrl}/presensi/jam/`, 'GET');
            const jamKerja = (response.data && response.data.length > 0) ? response.data[0] : null;

            if (jamKerja) {
                const dayNames = ['minggu', 'senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'];
                const nowMakassar = moment().tz("Asia/Makassar");
                const todayIndex = nowMakassar.day();
                const propName = `${dayNames[todayIndex]}_kerja`;

                const isHariKerja = jamKerja[propName] === true || jamKerja[propName] === 1;

                if (isHariKerja) {
                    this.jamKerjaConfig = jamKerja;

                    $('#display-jadwal-masuk').text((jamKerja.jam_masuk || '--:--:--').substring(0, 5));
                    $('#display-jadwal-pulang').text((jamKerja.jam_keluar || '--:--:--').substring(0, 5));
                } else {
                    this.jamKerjaConfig = 'OFF';
                    this.setLiburUI("JADWAL LIBUR (OFF)");
                }
            } else {
                this.jamKerjaConfig = null;
                this.setLiburUI("TIDAK ADA JADWAL");
            }
        } catch (error) {
            this.jamKerjaConfig = null;
            this.setLiburUI("GAGAL MEMUAT JADWAL");
        }
    }

    setLiburUI() {
        $('#display-jadwal-masuk').text('--:--');
        $('#display-jadwal-pulang').text('--:--');
    }

    async updateTodayStatus() {
        try {
            if (!this.jamKerjaConfig) {
                await this.loadJamKerja();
            }

            const response = await this.ajaxRequest(`${appUrl}/presensi/bkd/`, 'GET');
            const allData = response.data || [];

            const today = moment().tz("Asia/Makassar").format('YYYY-MM-DD');

            let displayData = allData.find(item => {
                const tglServer = (item.tanggal || '').substring(0, 10);
                return tglServer === today;
            });

            this.renderStatusUI(displayData);
            this.updateCurrentDateDisplay();
        } catch (error) {
        }
    }

    renderStatusUI(data) {
        const $jamMasuk = $('#jam-masuk');
        const $statusMasuk = $('#status-masuk');
        const $jamPulang = $('#jam-pulang');
        const $statusPulang = $('#status-pulang');
        const $btnMasuk = $('#btn-absen-masuk');
        const $btnPulang = $('#btn-absen-pulang');

        if (!this.jamKerjaConfig || this.jamKerjaConfig === 'OFF') {
            const pesanStatus = 'HARI LIBUR (OFF)';

            $jamMasuk.text('-- : --');
            $jamPulang.text('-- : --');

            this.disableButton($btnMasuk, 'SISTEM TERKUNCI');
            this.disableButton($btnPulang, 'SISTEM TERKUNCI');

            const labelLibur = `<span class="px-2 py-1 bg-red-50 text-red-600 text-[10px] font-bold rounded uppercase">${pesanStatus}</span>`;
            $statusMasuk.html(labelLibur);
            $statusPulang.html(labelLibur);

            $btnMasuk.find('small').text('Tidak dapat melakukan presensi');
            $btnPulang.find('small').text('Silahkan istirahat');
            return;
        }

        const now = moment().tz("Asia/Makassar");
        const todayDate = now.format('YYYY-MM-DD');

        const jamMasukKantorStr = this.jamKerjaConfig?.jam_masuk || "08:00:00";
        const jamPulangKantorStr = this.jamKerjaConfig?.jam_keluar || "17:00:00";

        const jamMasukKantor = moment.tz(`${todayDate} ${jamMasukKantorStr}`, "YYYY-MM-DD HH:mm:ss", "Asia/Makassar");
        const jamPulangKantor = moment.tz(`${todayDate} ${jamPulangKantorStr}`, "YYYY-MM-DD HH:mm:ss", "Asia/Makassar");
        const batasTutupSistem = jamPulangKantor.clone().add(1, 'hours');

        this.resetButton($btnMasuk, '', 'PRESENSI MASUK');
        this.resetButton($btnPulang, '', 'PRESENSI PULANG');

        if (data && data.jam_masuk && data.status_masuk !== 'tidak_absen') {
            $jamMasuk.text(data.jam_masuk);
            this.disableButton($btnMasuk, 'SUDAH CHECK-IN');

            const color = data.status_masuk === 'terlambat'
                ? 'bg-orange-100 text-orange-700'
                : 'bg-green-100 text-green-700';

            $statusMasuk.html(`<span class="px-2 py-1 ${color} text-[10px] font-bold rounded uppercase">${String(data.status_masuk).replace('_', ' ')}</span>`);
        } else {
            $jamMasuk.text('-- : -- : --');

            if ((data && data.status_masuk === 'tidak_absen') || now.isAfter(batasTutupSistem)) {
                this.disableButton($btnMasuk, 'BATAS WAKTU HABIS');
                $statusMasuk.html(`<span class="px-2 py-1 bg-red-100 text-red-700 text-[10px] font-bold rounded uppercase">Tidak Hadir</span>`);
            } else {
                this.resetButton($btnMasuk, '', 'PRESENSI MASUK');
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

    disableButton($btn, text) {
        $btn.prop('disabled', true)
            .addClass('opacity-50 cursor-not-allowed grayscale');

        $btn.find('span').text(text);
        $btn.find('small').text('Akses dikunci');
    }

    resetButton($btn, colorClass, text) {
        let subText = "Klik untuk merekam kehadiran";

        if (text.includes("MASUK") || text.includes("IN")) {
            subText = "Klik untuk Check-in";
        } else if (text.includes("PULANG") || text.includes("OUT")) {
            subText = "Klik untuk Check-out";
        }

        $btn.prop('disabled', false)
            .removeClass('opacity-50 cursor-not-allowed grayscale');

        if (colorClass) {
            $btn.addClass(colorClass);
        }

        $btn.find('span').text(text);
        $btn.find('small').text(subText);
    }

    updateCurrentDateDisplay() {
        moment.locale('id');

        const nowMakassar = moment().tz("Asia/Makassar");
        const formattedDate = nowMakassar.format('dddd, DD MMMM YYYY');

        $('#current-date').text(formattedDate);
    }

    getCurrentLocation() {
        return new Promise((resolve, reject) => {
            if (!navigator.geolocation) {
                reject("Geolocation tidak didukung oleh browser Anda.");
                return;
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
                { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
            );
        });
    }

    async submitPresensi(type) {
        try {
            const coords = await this.getCurrentLocation();

            if (!coords.lat || !coords.long) {
                throw "Gagal mendapatkan koordinat lokasi.";
            }

            const formData = new FormData();
            formData.append('latitude', coords.lat);
            formData.append('longitude', coords.long);
            formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

            return new Promise((resolve, reject) => {
                $.ajax({
                    url: `${appUrl}/presensi/bkd/${type}`,
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'Accept': 'application/json'
                    },
                    success: (response) => resolve(response),
                    error: (error) => reject(error)
                });
            });

        } catch (error) {
            if (error.responseJSON && error.responseJSON.message) {
                throw error.responseJSON.message;
            }

            throw typeof error === 'string' ? error : "Gagal mengirim data presensi.";
        }
    }
}

export default absensiService;
