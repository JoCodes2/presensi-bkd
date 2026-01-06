import ProfileService from "../services/profile.service.js";
$(document).ready(function () {
    const Profile = new ProfileService();

    // 1. Fungsi Load Data
    function loadData() {
        if (typeof userId === 'undefined') return console.error("userId tidak terdefinisi!");

        Profile.getProfile(userId)
            .done(function (response) {
                if (response.code === 200) {
                    const data = response.data;

                    renderHeader(data);
                    fillForm(data);
                }
            })
            .fail(function (xhr) {
                console.error("Gagal mengambil data:", xhr);
            });
    }

    function renderHeader(data) {
        $('#header-name').text(data.name);
        $('#header-jabatan').text(data.jabatan ? data.jabatan.nama_jabatan : 'Pegawai');
        $('#header-nip-text').text(`NIP: ${data.nip || '-'}`);
        $('#info-nik').text(data.nik || '-');
        $('#info-email').text(data.email || '-');

        if (data.foto_profile) {
            $('#display-foto').attr('src', `${appUrl}/profile/${data.foto_profile}`);
        }
    }

    function fillForm(data) {
        // Hidden fields
        $('#field-email-hidden').val(data.email);
        $('#field-nik-hidden').val(data.nik);
        $('#field-nip-hidden').val(data.nip);
        $('#field-jabatan-id-hidden').val(data.jabatan_id);
        $('#field-lokasi-id-hidden').val(data.lokasi_kantor_id);
        $('#field-status-ikatan-hidden').val(data.status_ikatan_kerja);

        // Editable fields
        $('#field-name').val(data.name);
        $('#field-no_hp').val(data.no_hp);
        $('#field-agama').val(data.agama);
        $('#field-alamat').val(data.alamat);
        $('#field-tempat_lahir').val(data.tempat_lahir);
        $('#field-tanggal_lahir').val(data.tanggal_lahir);
        $('#field-jenis_kelamin').val(data.jenis_kelamin);
    }

    // 2. JQuery Validate Setup
    // 2. JQuery Validate Setup
    $("#form-profile").validate({
        rules: {
            name: {
                required: true,
                minlength: 3
            },
            no_hp: {
                required: true,
                digits: true,
                minlength: 10,
                maxlength: 15
            },
            agama: {
                required: true
            },
            alamat: {
                required: true,
            },
            jenis_kelamin: {
                required: true
            },
            tempat_lahir: {
                required: true
            },
            tanggal_lahir: {
                required: true
            },
            password: {
                minlength: 8
            },
            password_confirmation: {
                required: function () {
                    // Wajib diisi hanya jika field password ada isinya
                    return $('input[name="password"]').val().length > 0;
                },
                equalTo: "input[name='password']"
            }
        },
        messages: {
            name: {
                required: "Nama lengkap tidak boleh kosong",
                minlength: "Nama minimal harus 3 karakter"
            },
            no_hp: {
                required: "Nomor handphone wajib diisi",
                digits: "Hanya diperbolehkan memasukkan angka",
                minlength: "Nomor HP minimal 10 digit",
                maxlength: "Nomor HP maksimal 15 digit"
            },
            agama: {
                required: "Silakan pilih atau isi agama Anda"
            },
            alamat: {
                required: "Alamat domisili wajib diisi",
            },
            jenis_kelamin: {
                required: "Pilih jenis kelamin Anda"
            },
            tempat_lahir: {
                required: "Tempat lahir wajib diisi"
            },
            tanggal_lahir: {
                required: "Tanggal lahir wajib diisi"
            },
            password: {
                minlength: "Password baru minimal harus 8 karakter"
            },
            password_confirmation: {
                required: "Silakan konfirmasi password baru Anda",
                equalTo: "Konfirmasi password tidak sesuai dengan password baru"
            }
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('text-red-500 text-[10px] mt-1 font-bold italic block');
            // Mencari pembungkus terdekat agar posisi error rapi
            element.closest('.space-y-1').append(error);
        },
        highlight: function (element) {
            $(element).addClass('border-red-500').removeClass('border-gray-200');
        },
        unhighlight: function (element) {
            $(element).removeClass('border-red-500').addClass('border-gray-200');
        },
        submitHandler: function (form) {
            handleUpdate(form);
        }
    });

    // 3. Handle Update Action
    function handleUpdate(form) {
        confirmDeleteAlert('Apakah Anda yakin ingin menyimpan perubahan profil?').then((result) => {
            if (result.isConfirmed) {

                // Loading state manual karena helper loading belum ada di list global Anda
                Swal.fire({
                    title: 'Memproses...',
                    allowOutsideClick: false,
                    didOpen: () => Swal.showLoading()
                });

                const formData = new FormData(form);

                Profile.updateProfile(userId, formData)
                    .done(function (response) {
                        // 1. Panggil helper successAlert global
                        successAlert('Profil berhasil diperbarui.');

                        // 2. Reload data di page (tanpa refresh browser)
                        loadData();

                        // 3. Kosongkan field password
                        $('input[type="password"]').val('');
                    })
                    .fail(function (xhr) {
                        const response = xhr.responseJSON;

                        if (xhr.status === 422 && response.errors) {
                            // Jika error validasi dari Laravel, tampilkan pesan spesifik
                            let msg = Object.values(response.errors).flat().join('<br>');
                            warningAlert(msg);
                        } else {
                            // 4. Panggil helper errorAlert global jika error sistem
                            errorAlert();
                        }
                    });
            }
        });
    }

    // 4. Preview Foto
    $('#input-foto').on('change', function () {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = (e) => $('#display-foto').attr('src', e.target.result);
            reader.readAsDataURL(file);
        }
    });

    // Jalankan Load Data
    loadData();
});
