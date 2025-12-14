@extends('Layouts.Base')
@section('title')
    Pengguna
@endsection
@section('content')
    <div class="page-inner">
        <div class="page-header ">
            <h4 class="page-title"><i class="fas fa-list-alt pr-2"></i>Daftar Pegawai</h4>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-end">
                            <button class="btn btn-primary " id="myBtn">
                                <i class="fas fa-plus pr-2"></i>Tambah
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="loadData" class="display table table-striped table-hover" width="100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Shift</th>
                                        <th>Jam Masuk</th>
                                        <th>Jam Keluar</th>
                                        <th>Hari Kerja</th>
                                        <th>Aktif</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="tBody"></tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Modal Jam Kerja --}}
    <div class="modal fade" id="upsertDataModal" role="dialog" aria-labelledby="upsertDataModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl center" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="upsertDataModalLabel">
                        <i class="fas fa-clock pr-2"></i> Form Jam Kerja
                    </h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form id="upsertDataForm" method="POST">
                        @csrf
                        <input type="hidden" name="id" id="id">

                        <div class="row">
                            {{-- KIRI --}}
                            <div class="col-md-6">

                                <div class="form-group">
                                    <label for="nama_shift">Nama Shift</label>
                                    <input type="text" class="form-control" name="nama_shift" id="nama_shift"
                                        placeholder="Contoh: Shift Pagi">
                                    <small id="nama_shift-error" class="text-danger"></small>
                                </div>

                                <div class="form-group">
                                    <label for="jam_masuk">Jam Masuk</label>
                                    <input type="time" class="form-control" name="jam_masuk" id="jam_masuk">
                                    <small id="jam_masuk-error" class="text-danger"></small>
                                </div>

                                <div class="form-group">
                                    <label for="jam_keluar">Jam Keluar</label>
                                    <input type="time" class="form-control" name="jam_keluar" id="jam_keluar">
                                    <small id="jam_keluar-error" class="text-danger"></small>
                                </div>

                                <div class="form-group">
                                    <label for="batas_terlambat">Batas Keterlambatan</label>
                                    <input type="time" class="form-control" name="batas_terlambat" id="batas_terlambat">
                                    <small id="batas_terlambat-error" class="text-danger"></small>
                                </div>

                            </div>

                            {{-- KANAN --}}
                            <div class="col-md-6">

                                <label class="d-block mb-2">Hari Kerja</label>

                                <div class="row">
                                    @php
                                        $days = [
                                            'senin' => 'Senin',
                                            'selasa' => 'Selasa',
                                            'rabu' => 'Rabu',
                                            'kamis' => 'Kamis',
                                            'jumat' => 'Jumat',
                                            'sabtu' => 'Sabtu',
                                            'minggu' => 'Minggu',
                                        ];
                                    @endphp

                                    @foreach ($days as $key => $label)
                                        <div class="col-6 mb-2">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input"
                                                    id="{{ $key }}_kerja" name="{{ $key }}_kerja"
                                                    value="1">
                                                <label class="custom-control-label" for="{{ $key }}_kerja">
                                                    {{ $label }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="form-group mt-3">
                                    <label>Status</label>
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="is_active" name="is_active"
                                            value="1" checked>
                                        <label class="custom-control-label" for="is_active">
                                            Aktif
                                        </label>
                                    </div>
                                    <small id="is_active-error" class="text-danger"></small>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Batal
                    </button>
                    <button type="button" class="btn btn-primary" id="simpanData">
                        Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {

            function getData() {
                $.ajax({
                    url: `/presensi/jam`,
                    method: "GET",
                    dataType: "json",
                    success: function(response) {
                        console.log(response);

                        let tableBody = "";

                        $.each(response.data, function(index, item) {

                            // Hari kerja aktif
                            let hariKerja = [];
                            if (item.senin_kerja) hariKerja.push("Senin");
                            if (item.selasa_kerja) hariKerja.push("Selasa");
                            if (item.rabu_kerja) hariKerja.push("Rabu");
                            if (item.kamis_kerja) hariKerja.push("Kamis");
                            if (item.jumat_kerja) hariKerja.push("Jumat");
                            if (item.sabtu_kerja) hariKerja.push("Sabtu");
                            if (item.minggu_kerja) hariKerja.push("Minggu");

                            tableBody += "<tr>";
                            tableBody += "<td>" + (index + 1) + "</td>";

                            tableBody +=
                                "<td class='text-center'><strong>" +
                                item.nama_shift +
                                "</strong></td>";

                            tableBody += "<td>" + item.jam_masuk + "</td>";
                            tableBody += "<td>" + item.jam_keluar + "</td>";

                            tableBody += "<td>" + hariKerja.join(", ") + "</td>";

                            tableBody +=
                                "<td class='text-center'>" +
                                (item.is_active ?
                                    "<span class='badge badge-success'>Aktif</span>" :
                                    "<span class='badge badge-danger'>Nonaktif</span>") +
                                "</td>";

                            tableBody += "<td class='text-center'>";
                            tableBody +=
                                "<button type='button' class='btn btn-outline-primary btn-sm edit-btn' data-id='" +
                                item.id +
                                "'><i class='fas fa-edit'></i></button> ";
                            tableBody +=
                                "<button type='button' class='btn btn-outline-danger btn-sm delete-confirm' data-id='" +
                                item.id +
                                "'><i class='fas fa-trash'></i></button>";
                            tableBody += "</td>";

                            tableBody += "</tr>";
                        });

                        $("#loadData tbody").html(tableBody);

                        $('#loadData').DataTable({
                            destroy: true,
                            paging: true,
                            searching: true,
                            ordering: true,
                            info: true,
                            order: []
                        });
                    },
                    error: function() {
                        console.log("Gagal mengambil data jam kerja");
                    }
                });
            }

            getData();

            $(document).on('click', '#simpanData', function(e) {
                e.preventDefault();
                $('.text-danger').text('');

                let formData = new FormData($('#upsertDataForm')[0]);

                loadingAllert();

                $.ajax({
                    type: 'POST',
                    url: '/presensi/jam/create', // sesuaikan dengan route kamu
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        console.log(response);
                        Swal.close();

                        // validasi gagal
                        if (response.code === 422) {
                            let errors = response.errors;
                            $.each(errors, function(key, value) {
                                $('#' + key + '-error').text(value[0]);
                            });
                            return;
                        }

                        // sukses
                        if (response.code === 200) {
                            successAlert('Data jam kerja berhasil ditambahkan');

                            setTimeout(() => {
                                location.reload();
                            }, 1200);

                            return;
                        }


                        // error lain
                        errorAlert();
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        Swal.close();
                        errorAlert();
                    }
                });
            });



            // Delete data button click handler
            $(document).on('click', '.delete-confirm', function() {
                let id = $(this).data('id');

                // Function to delete data
                function deleteData() {
                    $.ajax({
                        type: 'DELETE',
                        url: `/presensi/jam/delete/${id}`,
                        success: function(response) {
                            if (response.code === 200) {
                                successAlert();
                                reloadBrowsers();
                            } else {
                                errorAlert();
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    });
                }

                // Show confirmation alert
                confirmAlert('Apakah Anda yakin ingin menghapus data?', deleteData);
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            // messeage alert
            // alert success message
            function successAlert(message) {
                Swal.fire({
                    title: 'Berhasil!',
                    text: message,
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 1000,
                })
            }

            // alert error message
            function errorAlert() {
                Swal.fire({
                    title: 'Error',
                    text: 'Terjadi kesalahan!',
                    icon: 'error',
                    showConfirmButton: false,
                    timer: 1000,
                });
            }

            function reloadBrowsers() {
                setTimeout(function() {
                    location.reload();
                }, 1500);
            }


            function confirmAlert(message, callback) {
                Swal.fire({
                    title: '<span style="font-size: 22px"> Konfirmasi!</span>',
                    html: message,
                    showCancelButton: true,
                    showConfirmButton: true,
                    cancelButtonText: 'Tidak',
                    confirmButtonText: 'Ya',
                    reverseButtons: true,
                    confirmButtonColor: '#48ABF7',
                    cancelButtonColor: '#EFEFEF',
                    customClass: {
                        cancelButton: 'text-dark'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        callback();
                    }
                });
            }

            // loading alert
            function loadingAllert() {
                Swal.fire({
                    title: 'Loading...',
                    text: 'Please wait',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            }

            // reset modal
            $('#upsertDataModal').on('hidden.bs.modal', function() {
                $('.text-danger').text('');
                $('#upsertDataForm')[0].reset();
                $('#id').val('');
            });
            // event click btn create
            $(document).on('click', '#myBtn', function() {
                $('.text-danger').text('');
                $('#upsertDataForm')[0].reset();
                $('#id').val('');
                $('#upsertDataModal').modal('show');
                $('#imagePreview').html('');
            })

        });
    </script>
@endsection
