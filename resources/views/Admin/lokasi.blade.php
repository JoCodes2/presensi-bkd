@extends('Layouts.Base')
@section('title')
    Lokasi
@endsection
@section('content')
    <div class="page-inner">
        <div class="page-header ">
            <h4 class="page-title"><i class="fas fa-list-alt pr-2"></i>Daftar Lokasi</h4>
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
                                        <th>Nama Lokasi</th>
                                        <th>Alamat</th>
                                        <th>Latitude</th>
                                        <th>Longitude</th>
                                        <th>Radius</th>
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
    {{-- Modal Lokasi Kantor --}}
    <div class="modal fade" id="upsertDataModal" tabindex="-1" aria-labelledby="upsertDataModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content shadow-sm">

                {{-- Header --}}
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="upsertDataModalLabel">
                        <i class="fas fa-map-marker-alt mr-2"></i> Form Lokasi Kantor
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                {{-- Body --}}
                <div class="modal-body">
                    <form id="upsertDataForm" method="POST">
                        @csrf
                        <input type="hidden" name="id" id="id">

                        <div class="row">
                            {{-- KIRI --}}
                            <div class="col-md-6">

                                <div class="form-group">
                                    <label class="font-weight-bold" for="nama_lokasi">
                                        Nama Lokasi
                                    </label>
                                    <input type="text" class="form-control" name="nama_lokasi" id="nama_lokasi"
                                        placeholder="Contoh: Kantor Pusat">
                                    <small id="nama_lokasi-error" class="text-danger"></small>
                                </div>

                                <div class="form-group">
                                    <label class="font-weight-bold" for="radius_meter">
                                        Radius (Meter)
                                    </label>
                                    <input type="number" class="form-control" name="radius_meter" id="radius_meter"
                                        placeholder="Contoh: 100">
                                    <small id="radius_meter-error" class="text-danger"></small>
                                </div>

                                <div class="form-group">
                                    <label class="font-weight-bold" for="latitude">
                                        Latitude
                                    </label>
                                    <input type="text" class="form-control" name="latitude" id="latitude" readonly>
                                    <small id="latitude-error" class="text-danger"></small>
                                </div>




                            </div>

                            {{-- KANAN --}}
                            <div class="col-md-6">

                                <div class="form-group">
                                    <label class="font-weight-bold" for="alamat">
                                        Alamat
                                    </label>
                                    <textarea class="form-control" name="alamat" id="alamat" rows="2"
                                        placeholder="Alamat akan terisi otomatis dari map"></textarea>
                                    <small id="alamat-error" class="text-danger"></small>
                                </div>

                                <div class="form-group">
                                    <label class="font-weight-bold">Pilih Lokasi di Map</label>
                                    <div id="map" style="height:300px;border-radius:8px;"></div>
                                </div>


                                <div class="form-group">
                                    <label class="font-weight-bold" for="longitude">
                                        Longitude
                                    </label>
                                    <input type="text" class="form-control" name="longitude" id="longitude" readonly>
                                    <small id="longitude-error" class="text-danger"></small>
                                </div>


                            </div>
                        </div>
                    </form>
                </div>

                {{-- Footer --}}
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i> Batal
                    </button>
                    <button type="button" class="btn btn-primary" id="simpanData">
                        <i class="fas fa-save mr-1"></i> Simpan
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
                    url: `/presensi/kantor`,
                    method: "GET",
                    dataType: "json",
                    success: function(response) {
                        console.log(response);

                        // 🔒 hanya boleh 1 lokasi
                        if (response.data.length >= 1) {
                            $('#myBtn').hide();
                        } else {
                            $('#myBtn').show();
                        }

                        let tableBody = "";

                        $.each(response.data, function(index, item) {
                            tableBody += "<tr>";
                            tableBody += "<td>" + (index + 1) + "</td>";
                            tableBody += "<td>" + item.nama_lokasi + "</td>";
                            tableBody += "<td>" + item.alamat + "</td>";
                            tableBody += "<td>" + item.latitude + "</td>";
                            tableBody += "<td>" + item.longitude + "</td>";
                            tableBody += "<td>" + item.radius_meter + "</td>";
                            tableBody += "<td class='text-center'>";
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

            let map;
            let marker;
            let isEdit = false;


            $('#upsertDataModal').on('shown.bs.modal', function() {

                let lat = $('#latitude').val() || -1.430000;
                let lng = $('#longitude').val() || 120.800000;

                lat = parseFloat(lat);
                lng = parseFloat(lng);

                if (!map) {
                    map = L.map('map').setView([lat, lng], 7);

                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; OpenStreetMap contributors'
                    }).addTo(map);

                    marker = L.marker([lat, lng], {
                        draggable: true
                    }).addTo(map);

                    map.on('click', function(e) {
                        updateLocation(e.latlng.lat, e.latlng.lng);
                    });

                    marker.on('dragend', function(e) {
                        let pos = e.target.getLatLng();
                        updateLocation(pos.lat, pos.lng);
                    });
                } else {
                    map.setView([lat, lng], 14);
                    marker.setLatLng([lat, lng]);
                }

                setTimeout(() => {
                    map.invalidateSize();
                }, 300);
            });


            function updateLocation(lat, lng) {
                $('#latitude').val(lat.toFixed(6));
                $('#longitude').val(lng.toFixed(6));

                marker.setLatLng([lat, lng]);

                axios.get('https://nominatim.openstreetmap.org/reverse', {
                    params: {
                        lat: lat,
                        lon: lng,
                        format: 'json'
                    }
                }).then(res => {
                    if (res.data?.display_name) {
                        $('#alamat').val(res.data.display_name);
                    }
                });
            }



            $(document).on('click', '#simpanData', function(e) {
                e.preventDefault();
                $('.text-danger').text('');

                let formData = new FormData($('#upsertDataForm')[0]);
                let url = '/presensi/kantor/create';

                loadingAllert();

                $.ajax({
                    type: 'POST',
                    url: url,
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        Swal.close();

                        if (response.code === 422) {
                            $.each(response.errors, function(key, value) {
                                $('#' + key + '-error').text(value[0]);
                            });
                        } else if (response.code === 200) {
                            successAlert('Data berhasil disimpan');
                            reloadBrowsers();
                        } else {
                            errorAlert();
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        Swal.close();
                        errorAlert();
                    }
                });
            });



            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });






            // Delete data button click handler
            $(document).on('click', '.delete-confirm', function() {
                let id = $(this).data('id');

                // Function to delete data
                function deleteData() {
                    $.ajax({
                        type: 'DELETE',
                        url: `/presensi/kantor/delete/${id}`,
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
                isEdit = false;
                $('.text-danger').text('');
                $('#upsertDataForm')[0].reset();
                $('#id').val('');
                $('#upsertDataModal').modal('show');
            });


        });
    </script>
@endsection
