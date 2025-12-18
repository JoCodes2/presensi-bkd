import absensiService from "../services/absensi.service.js";

$(document).ready(function () {
    const service = new absensiService();

    service.loadJamKerja();
});
