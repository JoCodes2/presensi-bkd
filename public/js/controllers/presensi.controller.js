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
});
