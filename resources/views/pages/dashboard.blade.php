@extends('Layouts.Base')

@section('content')

    <x-base-header title="Dashboard" icon="fas fa-users">

        <x-base-body :show-add-button="false" :show-export-button="false">

            <div class="row">
                {{-- 1. CARD UTAMA: STATUS ABSENSI HARI INI --}}
                {{-- TAMBAHKAN ID DISINI --}}
                <div class="col-md-12" id="yourAttendanceCard">
                    <div class="card shadow-sm border-primary">
                        {{-- TAMBAHKAN ID DISINI --}}
                        <div class="card-header bg-primary text-white d-flex justify-content-between">
                            <h5 class="mb-0"><i class="fas fa-calendar-day mr-2"></i> Status Absensi Anda Hari Ini</h5>
                            <small class="mt-1">Jam Kerja: -- : --</small>
                        </div>
                        <div class="card-body">
                            {{-- Placeholder Awal --}}
                            <div class="text-center p-5">
                                <i class="fas fa-sync-alt fa-spin mr-2"></i> Memuat Data Absensi Anda...
                            </div>

                            {{-- Struktur Target jQuery (akan di-replace saat data datang) --}}
                            </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">

                {{-- 2. TABEL KIRI: ABSEN MASUK PEGAWAI --}}
                <div class="col-md-6">
                    <div class="card shadow-sm">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0"><i class="fas fa-sign-in-alt mr-2"></i> Status Absen Masuk Pegawai</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                {{-- TAMBAHKAN ID PADA TABLE --}}
                                <table class="table table-striped table-hover mb-0" id="tableAbsenMasuk">
                                    <thead>
                                        <tr>
                                            <th>Nama Pegawai</th>
                                            <th>Waktu Masuk</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr><td colspan="3" class="text-center text-muted">Memuat Data Pegawai...</td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 3. TABEL KANAN: ABSEN PULANG PEGAWAI --}}
                <div class="col-md-6">
                    <div class="card shadow-sm">
                        <div class="card-header bg-secondary text-white">
                            <h5 class="mb-0"><i class="fas fa-sign-out-alt mr-2"></i> Status Absen Pulang Pegawai</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                {{-- TAMBAHKAN ID PADA TABLE --}}
                                <table class="table table-striped table-hover mb-0" id="tableAbsenPulang">
                                    <thead>
                                        <tr>
                                            <th>Nama Pegawai</th>
                                            <th>Waktu Pulang</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr><td colspan="3" class="text-center text-muted">Memuat Data Pegawai...</td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </x-base-body>

    </x-base-header>

@endsection
@section('script')
    <script type="module" src="{{ asset('js/controllers/dashboard.controller.js') }}"></script>
@endsection
