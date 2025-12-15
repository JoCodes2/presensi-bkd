@extends('Layouts.Base')

@section('content')

    <x-base-header title="Daftar Presensi Pegawai" icon="fas fa-users">

        <x-base-body :show-add-button="false" :show-export-button="true">

            <x-base-table initId="presensiTable">

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

@endsection
@section('script')
 <script type="module" src="{{ asset('js/controllers/presensi.controller.js')}}"></script>
@endsection
