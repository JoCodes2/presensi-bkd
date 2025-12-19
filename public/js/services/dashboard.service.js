// dashboard.service.js

class DashboardService {

    // Metode AJAX Request (Tidak Berubah)
    ajaxRequest(url, method, data = null) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url,
                method,
                data,
                success: (response) => resolve(response),
                error: (error) => reject(error),
            });
        });
    }

    /**
     * Helper untuk menghitung durasi shift
     */
    calculateShiftDuration(startTime, endTime) {
        if (!startTime || !endTime) return '-';
        try {
            const [startHour, startMinute] = startTime.split(':').map(Number);
            const [endHour, endMinute] = endTime.split(':').map(Number);

            let startTotalMinutes = (startHour * 60) + startMinute;
            let endTotalMinutes = (endHour * 60) + endMinute;

            if (endTotalMinutes < startTotalMinutes) endTotalMinutes += (24 * 60);

            const durationMinutes = endTotalMinutes - startTotalMinutes;
            const hours = Math.floor(durationMinutes / 60);
            const minutes = durationMinutes % 60;

            if (hours === 0 && minutes === 0) return '-';
            return minutes === 0 ? `${hours} jam` : `${hours} jam ${minutes} menit`;
        } catch (e) {
            return '-';
        }
    }

    /**
     * Helper untuk memformat status badge Absen MASUK.
     */
    formatStatusMasuk(status) {
        // Jika status_masuk null di DB (User belum absen masuk sama sekali)
        if (!status) {
            return { text: 'Belum Presensi', class: 'badge-secondary' };
        }

        switch (status) {
            case 'tepat_waktu':
            case 'hadir':
                return { text: 'Tepat Waktu', class: 'badge-success' };
            case 'terlambat':
                return { text: 'Terlambat', class: 'badge-warning' };
            case 'tidak_absen':
                return { text: 'Alpha', class: 'badge-danger' };
            default:
                return { text: 'N/A', class: 'badge-secondary' };
        }
    }

    /**
     * PERBAIKAN: Helper untuk memformat status badge Absen KELUAR.
     * Tidak lagi langsung menganggap null sebagai Alpha.
     */
    formatStatusKeluar(status) {
        // Jika status_keluar null di DB (User sudah masuk tapi belum pulang)
        if (!status) {
            return { text: 'Belum Presensi', class: 'badge-light text-muted border' };
        }

        switch (status) {
            case 'tepat_waktu':
            case 'pulang_tepat_waktu':
                return { text: 'Pulang Tepat Waktu', class: 'badge-success' };
            case 'pulang_cepat':
                return { text: 'Pulang Cepat', class: 'badge-info' };
            case 'tidak_absen':
                return { text: 'Tidak Absen (Alpha)', class: 'badge-danger' };
            default:
                return { text: 'N/A', class: 'badge-secondary' };
        }
    }

    renderYourAttendance(jamKerja) {
        const $cardHeader = $('#yourAttendanceCard').find('.card-header');
        const jamKerjaMasuk = jamKerja ? jamKerja.jam_masuk.substring(0, 5) : '-- : --';
        const jamKerjaKeluar = jamKerja ? jamKerja.jam_keluar.substring(0, 5) : '-- : --';
        const shiftDuration = this.calculateShiftDuration(jamKerja?.jam_masuk, jamKerja?.jam_keluar);

        $cardHeader.html(`
            <h5 class="mb-0"><i class="fas fa-calendar-day mr-2"></i> Jam Kerja Hari Ini (${jamKerja ? jamKerja.nama_shift : 'N/A'})</h5>
            <small class="mt-1">Tanggal: ${new Date().toLocaleDateString('id-ID', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' })}</small>
        `);

        const cardBodyContent = `
            <div class="row text-center p-3">
                <div class="col-md-6 border-right">
                    <h6 class="text-muted small uppercase">Jadwal Masuk</h6>
                    <h2 class="display-4 text-primary font-weight-bold">${jamKerjaMasuk}</h2>
                    <p class="text-sm m-0">Durasi Kerja: ${shiftDuration}</p>
                </div>
                <div class="col-md-6">
                    <h6 class="text-muted small uppercase">Jadwal Pulang</h6>
                    <h2 class="display-4 text-secondary font-weight-bold">${jamKerjaKeluar}</h2>
                    <p class="text-sm m-0">Status: <span class="badge badge-success">Hari Kerja</span></p>
                </div>
            </div>
        `;
        $('#yourAttendanceCard').find('.card-body').html(cardBodyContent);
    }

    /**
     * Merender tabel absensi dengan pengecekan status yang benar.
     */
    renderEmployeeAttendance(absensiPegawai) {
        const $tableMasukBody = $('#tableAbsenMasuk tbody');
        const $tablePulangBody = $('#tableAbsenPulang tbody');
        let htmlMasuk = '';
        let htmlPulang = '';

        if (absensiPegawai.length === 0) {
            const emptyRow = '<tr><td colspan="3" class="text-center text-muted p-4">Belum ada aktivitas absensi hari ini.</td></tr>';
            $tableMasukBody.html(emptyRow);
            $tablePulangBody.html(emptyRow);
            return;
        }

        absensiPegawai.forEach(absen => {
            const userName = absen.user ? absen.user.name : 'Pegawai';

            // --- Absen Masuk ---
            // Hilangkan default 'tidak_absen' agar null tetap null
            const statusMasuk = this.formatStatusMasuk(absen.status_masuk);
            const waktuMasuk = absen.jam_masuk ? absen.jam_masuk.substring(0, 5) : '--:--';

            htmlMasuk += `
                <tr>
                    <td><div class="font-weight-bold">${userName}</div></td>
                    <td><i class="far fa-clock text-primary mr-1"></i> ${waktuMasuk}</td>
                    <td><span class="badge ${statusMasuk.class}">${statusMasuk.text}</span></td>
                </tr>
            `;

            // --- Absen Pulang ---
            // PERBAIKAN: Hilangkan (absen.status_keluar || 'tidak_absen')
            // Cukup kirim absen.status_keluar agar fungsi formatStatusKeluar bisa mendeteksi null
            const statusKeluar = this.formatStatusKeluar(absen.status_keluar);
            const waktuPulang = absen.jam_keluar ? absen.jam_keluar.substring(0, 5) : '--:--';

            htmlPulang += `
                <tr>
                    <td><div class="font-weight-bold">${userName}</div></td>
                    <td><i class="far fa-clock text-secondary mr-1"></i> ${waktuPulang}</td>
                    <td><span class="badge ${statusKeluar.class}">${statusKeluar.text}</span></td>
                </tr>
            `;
        });

        $tableMasukBody.html(htmlMasuk);
        $tablePulangBody.html(htmlPulang);
    }

    async loadDashboardData() {
        try {
            const now = new Date();
            const today = now.toISOString().split('T')[0];

            this.setLoadingState();

            const [jamKerjaResponse, absensiPegawaiResponse] = await Promise.all([
                this.ajaxRequest(`${appUrl}/presensi/jam/`, 'GET'),
                this.ajaxRequest(`${appUrl}/presensi/bkd/`, 'GET'),
            ]);

            const jamKerja = jamKerjaResponse.data && jamKerjaResponse.data.length > 0 ? jamKerjaResponse.data[0] : null;
            const allData = absensiPegawaiResponse.data || [];

            const absensiPegawaiHariIni = allData.filter(absen => {
                return absen.tanggal && absen.tanggal.substring(0, 10) === today;
            });

            this.renderYourAttendance(jamKerja);
            this.renderEmployeeAttendance(absensiPegawaiHariIni);

        } catch (error) {
            console.error('Error load dashboard:', error);
            this.setErrorState();
        }
    }

    setLoadingState() {
        const loadingHtml = '<div class="text-center p-5"><i class="fas fa-circle-notch fa-spin fa-2x text-primary"></i><p class="mt-2">Memproses data...</p></div>';
        const loadingRow = '<tr><td colspan="3" class="text-center p-3"><i class="fas fa-sync fa-spin"></i></td></tr>';
        $('#yourAttendanceCard').find('.card-body').html(loadingHtml);
        $('#tableAbsenMasuk tbody').html(loadingRow);
        $('#tableAbsenPulang tbody').html(loadingRow);
    }

    setErrorState() {
        $('#yourAttendanceCard').find('.card-body').html('<div class="alert alert-danger">Gagal sinkronisasi data.</div>');
    }
}

export default DashboardService;
