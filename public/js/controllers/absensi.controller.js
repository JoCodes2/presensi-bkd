import absensiService from "../services/absensi.service.js";

$(document).ready(function () {
    const service = new absensiService();

    service.loadJamKerja();
    service.updateTodayStatus();

    $('#btn-absen-masuk').on('click', function () {
        handlePresensi('in');
    });

    // Tombol Pulang
    $('#btn-absen-pulang').on('click', function () {
        handlePresensi('out');
    });

    // Tambahkan async di sini agar bisa menggunakan await di dalamnya
    async function handlePresensi(type) {
        const title = type === 'in' ? 'Presensi Masuk' : 'Presensi Pulang';
        const currentTime = moment().format('HH:mm:ss');

        // 1. Proteksi Waktu
        if (type === 'in' && service.jamKerjaConfig) {
            const jamPulang = service.jamKerjaConfig.jam_keluar;
            if (currentTime >= jamPulang) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Batas Waktu Habis',
                    text: `Anda tidak bisa absen masuk karena sudah melewati jam pulang kantor (${jamPulang.substring(0, 5)}).`,
                    confirmButtonColor: '#f89406'
                });
                return;
            }
        }

        // 2. Loading State
        Swal.fire({
            title: title,
            text: "Sedang mengambil lokasi dan memproses data...",
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });

        try {
            const response = await service.submitPresensi(type);

            if (response && response.code === 200) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: response.message || 'Presensi berhasil dicatat.',
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    service.updateTodayStatus();
                });
            } else {
                Swal.fire('Gagal', response.message || 'Terjadi kesalahan.', 'warning');
            }
        } catch (error) {
            Swal.close();
            console.error("Error Catch:", error);

            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: typeof error === 'string' ? error : "Terjadi kesalahan sistem."
            });
        }
    }
});
