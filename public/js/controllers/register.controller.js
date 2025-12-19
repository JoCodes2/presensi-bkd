import authService from "../services/auth.service.js";

$(document).ready(function () {
    const registerService = new authService();

    // Tambahan style error Tailwind
    $.validator.setDefaults({
        errorClass: "text-red-500 text-xs mt-1",
        validClass: "border-green-500",
        errorElement: "span",
        highlight: function (element) {
            $(element).addClass("border-red-500");
        },
        unhighlight: function (element) {
            $(element).removeClass("border-red-500");
        },
    });
    function valdation() {
        $("#formRegister").validate({
            rules: {
                name: {
                    required: true,
                    minlength: 3,
                },
                email: {
                    required: true,
                    email: true,
                },
                password: {
                    required: true,
                    minlength: 6,
                },
                password_confirmation: {
                    required: true,
                    equalTo: "#password",
                },
                nik: {
                    required: true,
                    digits: true,
                    minlength: 16,
                    maxlength: 20,
                },
                nip: {
                    digits: true,
                },
                jenis_kelamin: {
                    required: true,
                },
                status_ikatan_kerja: {
                    required: true,
                },
                agama: {
                    required: true,
                },
                jabatan_id: {
                    required: true,
                },
                lokasi_kantor_id: {
                    required: true,
                },
                foto_profile: {
                    extension: "jpg|jpeg|png",
                    filesize: 2048, // KB
                },
            },

            messages: {
                name: {
                    required: "Nama wajib diisi",
                    minlength: "Minimal 3 karakter",
                },
                email: {
                    required: "Email wajib diisi",
                    email: "Format email tidak valid",
                },
                password: {
                    required: "Password wajib diisi",
                    minlength: "Minimal 6 karakter",
                },
                password_confirmation: {
                    required: "Konfirmasi password wajib diisi",
                    equalTo: "Password tidak sama",
                },
                nik: {
                    required: "NIK wajib diisi",
                    digits: "NIK harus berupa angka",
                    minlength: "Minimal 16 digit",
                    maxlength: "Maksimal 20 digit",
                },
                jenis_kelamin: {
                    required: "Pilih jenis kelamin",
                },
                status_ikatan_kerja: {
                    required: "Pilih status ikatan kerja",
                },
                agama: {
                    required: "Pilih agama",
                },
                jabatan_id: {
                    required: "Pilih jabatan",
                },
                lokasi_kantor_id: {
                    required: "Pilih lokasi kantor",
                },
                foto_profile: {
                    extension: "Format harus jpg, jpeg, atau png",
                    filesize: "Ukuran maksimal 2MB",
                },
            }
        });
    }
    valdation();

    $("#formRegister").on("submit", function (e) {
        registerService.register(e);
    });
    // Init validate
});
