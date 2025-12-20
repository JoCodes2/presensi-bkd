@extends('Layouts.Base')

@section('content')

    <x-base-header title="Kalender Presensi Pegawai" icon="fas fa-calendar-alt">
        <x-base-body :show-add-button="false" :show-export-button="true">

            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="filterUser" class="font-weight-bold">Pilih Pegawai:</label>
                        <select id="filterUser" class="form-control select2">
                            <option value="">-- Tampilkan Semua --</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-body">
                    <div id="presensiCalendar"></div>
                </div>
            </div>

        </x-base-body>
    </x-base-header>

    {{-- Menggunakan Komponen Modal --}}
    <x-base-modal id="modalExport" title="Export Laporan Presensi" icon="fas fa-file-export">
        <form id="formExport">
            <p class="text-muted small">Sistem akan mengekspor data seluruh pegawai berdasarkan rentang tanggal yang dipilih.</p>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Dari Tanggal</label>
                    <input type="date" name="from_date" id="exportFrom" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Sampai Tanggal</label>
                    <input type="date" name="to_date" id="exportTo" class="form-control" required>
                </div>
            </div>
        </form>

        <x-slot name="footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            <button type="button" id="btnProcessExport" class="btn btn-primary">
                <i class="fas fa-file-export me-1"></i> Mulai Export
            </button>
        </x-slot>
    </x-base-modal>

@endsection

@section('script')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css"/>

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales-all.min.js"></script>

<!-- Tooltip -->
<script src="https://unpkg.com/@popperjs/core@2"></script>
<script src="https://unpkg.com/tippy.js@6"></script>

<!-- Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet"/>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>

<!-- Custom style -->
<link rel="stylesheet" href="{{ asset('css/presensi-calender.css') }}">

<script type="module" src="{{ asset('js/controllers/presensi.controller.js')}}"></script>
@endsection

