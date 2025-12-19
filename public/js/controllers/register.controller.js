import authService from "../services/auth.service.js";

$(document).ready(function () {
    const registerService = new authService();

    // 1. Tambahkan Custom Method untuk validasi File
    if ($.validator) {
        $.validator.addMethod('filesize', function (value, element, param) {
            return this.optional(element) || (element.files[0].size <= param * 1024);
        }, 'Ukuran file maksimal {0} KB');

        $.validator.addMethod('extension', function (value, element, param) {
            param = typeof param === 'string' ? param.replace(/,/g, '|') : param;
            return this.optional(element) || value.match(new RegExp(".(" + param + ")$", "i"));
        }, "Format file tidak didukung.");
    }

    // Load Data Dropdown Dinamis
    async function loadDropdownData() {
        try {
            const [jabatanRes, kantorRes] = await Promise.all([
                registerService.getJabatan(),
                registerService.getKantor()
            ]);

            const dataJabatan = jabatanRes.data || jabatanRes;
            $('#jabatan_id').empty().append('<option value="" selected disabled>-- Pilih Jabatan --</option>');
            dataJabatan.forEach(item => {
                $('#jabatan_id').append(`<option value="${item.id}">${item.nama_jabatan || item.name || 'Jabatan'}</option>`);
            });

            const dataKantor = kantorRes.data || kantorRes;
            $('#lokasi_kantor_id').empty().append('<option value="" selected disabled>-- Pilih Lokasi --</option>');
            dataKantor.forEach(item => {
                $('#lokasi_kantor_id').append(`<option value="${item.id}">${item.nama_lokasi || item.nama_kantor || 'Lokasi'}</option>`);
            });
        } catch (error) {
            console.error("Gagal load dropdown:", error);
        }
    }

    loadDropdownData();

    // 2. Konfigurasi Validasi
    $("#formRegister").validate({
        ignore: [],
        errorClass: "text-red-500 text-[10px] mt-1 font-bold italic block",
        errorElement: "span",

        errorPlacement: function (error, element) {
            let container = element.closest('div');
            container.find("span.text-red-500").remove(); // Bersihkan error lama
            error.appendTo(container);
        },

        highlight: function (element) {
            $(element).addClass("border-red-500 ring-1 ring-red-500").removeClass("border-white/40 border-green-500");
        },
        unhighlight: function (element) {
            $(element).removeClass("border-red-500 ring-1 ring-red-500").addClass("border-green-500");
            $(element).closest('div').find("span.text-red-500").remove();
        },

        rules: {
            name: { required: true, minlength: 3 },
            email: { required: true, email: true },
            password: { required: true, minlength: 6 },
            password_confirmation: { required: true, equalTo: "#password" },
            nik: { required: true, digits: true, minlength: 16, maxlength: 16 },
            nip: { required: false, digits: true }, // Tidak wajib, tapi jika diisi harus angka
            alamat: { required: true },
            no_hp: { required: true, digits: true },
            jenis_kelamin: { required: true },
            tempat_lahir: { required: true },
            tanggal_lahir: { required: true },
            agama: { required: true },
            status_ikatan_kerja: { required: true },
            jabatan_id: { required: true },
            lokasi_kantor_id: { required: true },
            foto_profile: {
                required: false, // Tidak wajib
                extension: "jpg|jpeg|png",
                filesize: 2048
            }
        },

        messages: {
            name: {
                required: "Nama lengkap wajib diisi",
                minlength: "Nama minimal harus 3 karakter"
            },
            email: {
                required: "Alamat email wajib diisi",
                email: "Format email yang Anda masukkan tidak valid"
            },
            password: {
                required: "Password wajib diisi",
                minlength: "Password minimal harus 6 karakter"
            },
            password_confirmation: {
                required: "Konfirmasi password wajib diisi",
                equalTo: "Password konfirmasi tidak cocok dengan password"
            },
            nik: {
                required: "NIK wajib diisi",
                digits: "NIK hanya boleh berisi angka",
                minlength: "NIK harus tepat 16 digit",
                maxlength: "NIK tidak boleh lebih dari 16 digit"
            },
            nip: {
                digits: "NIP hanya boleh berisi angka"
            },
            alamat: {
                required: "Alamat domisili wajib diisi"
            },
            no_hp: {
                required: "Nomor HP wajib diisi",
                digits: "Nomor HP hanya boleh berisi angka"
            },
            jenis_kelamin: {
                required: "Silakan pilih jenis kelamin"
            },
            tempat_lahir: {
                required: "Tempat lahir wajib diisi"
            },
            tanggal_lahir: {
                required: "Tanggal lahir wajib diisi"
            },
            agama: {
                required: "Silakan pilih agama"
            },
            status_ikatan_kerja: {
                required: "Silakan pilih status ikatan kerja"
            },
            jabatan_id: {
                required: "Silakan pilih jabatan Anda"
            },
            lokasi_kantor_id: {
                required: "Silakan pilih lokasi kantor Anda"
            },
            foto_profile: {
                extension: "Hanya diperbolehkan format .jpg, .jpeg, atau .png",
                filesize: "Ukuran foto profil tidak boleh lebih dari 2MB"
            }
        },

        submitHandler: function (form, e) {
            e.preventDefault();
            confirmDeleteAlert("Apakah data pendaftaran sudah benar?").then((result) => {
                if (result.isConfirmed) {
                    registerService.register(form);
                }
            });
        }
    });
});
