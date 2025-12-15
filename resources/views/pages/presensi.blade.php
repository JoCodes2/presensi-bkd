@extends('Layouts.Base')

@section('content')

    <x-base-header title="Daftar Presensi Pegawai" icon="fas fa-calendar-check">

        <x-base-body :show-add-button="false" :show-export-button="true">

            <x-base-table initId="presensiTable">

                <x-slot name="thead">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Tanggal</th>
                        <th>Jam Masuk</th>
                        <th>Jam Pulang</th>
                        <th>Status Masuk</th>
                        <th>Status Pulang</th>
                        <th>Keterangan</th>
                        {{-- Tambahkan kolom Aksi jika diperlukan --}}
                    </tr>
                </x-slot>

                <x-slot name="tbody">
                    {{-- Data akan diisi oleh DataTables melalui AJAX --}}
                </x-slot>

            </x-base-table>

        </x-base-body>

    </x-base-header>

@endsection

@section('script')
 <script type="module" src="{{ asset('js/controllers/presensi.controller.js')}}"></script>
@endsection
