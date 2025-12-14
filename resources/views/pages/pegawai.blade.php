@extends('Layouts.Base')

@section('content')

    <x-base-header title="Daftar Pegawai" icon="fas fa-users">

        <x-base-body :show-add-button="false" :show-export-button="false">

            <x-base-table initId="pegawaiTable">

                <x-slot name="thead">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>NIK</th>
                        <th>NIP</th>
                        <th>No Telepon</th>
                        <th>Email</th>
                        <th>Jabatan</th>
                        <th>Status Ikatan kerja</th>
                        <th>Status Akun</th>
                        <th>Aktivasi Akun</th>
                        <th>Aksi</th>
                    </tr>
                </x-slot>

                <x-slot name="tbody">
                    {{-- TBODY content here if any static content is needed --}}
                </x-slot>

            </x-base-table>

        </x-base-body>

    </x-base-header>

    <x-base-modal id="detailPegawaiModal" title="Detail Pegawai" size="lg">

        <div id="detailPegawaiContent">
            <div class="text-center p-5">
                <i class="fas fa-spinner fa-spin fa-2x"></i>
                <p class="mt-2">Memuat data...</p>
            </div>
        </div>

        <x-slot name="footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        </x-slot>

    </x-base-modal>

@endsection
@section('script')
 <script type="module" src="{{ asset('js/controllers/pegawai.controller.js')}}"></script>
@endsection
