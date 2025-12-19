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

