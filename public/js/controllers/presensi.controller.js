import PresensiService from "../services/presensi.service.js";

$(document).ready(function () {
    const presensi = new PresensiService();

    // 1. Load daftar pegawai ke dropdown filter
    presensi.loadUsers();

    // 2. Inisialisasi Kalender
    if ($('#presensiCalendar').length) {
        presensi.initCalendar();
    }

    // 3. Event listener untuk filter
    $('#filterUser').on('change', function () {
        presensi.reloadCalendar();
    });
    // 1. Saat tombol Export di Header diklik
    $(document).on('click', '.btnExport', function (e) {
        e.preventDefault();

        // Tampilkan Modal
        $('#modalExport').modal('show');
    });

    $('#btnProcessExport').on('click', function () {
        const fromDate = $('#exportFrom').val();
        const toDate = $('#exportTo').val();

        if (!fromDate || !toDate) {
            alert('Pilih tanggal!'); return;
        }

        // URL tanpa id_user karena export ALL
        const url = `${appUrl}/presensi/export?from_date=${fromDate}&to_date=${toDate}`;
        window.location.href = url;
        $('#modalExport').modal('hide');
    });
});
