@props(['showAddButton' => true, 'showExportButton' => false])

{{-- resources/views/components/base-body.blade.php --}}
<div class="row">
    <div class="col-md-12">
        <div class="card">

            {{-- Bagian Tombol (Card Header) --}}
            <div class="card-header">
                <div class="d-flex justify-content-end">
                    @if ($showExportButton)
                        <button class="btn btn-success mr-2 btnExport" >
                            <i class="fas fa-file-export pr-2"></i>Export
                        </button>
                    @endif

                    @if ($showAddButton)
                        <button class="btn btn-primary" id="myBtn">
                            <i class="fas fa-plus pr-2"></i>Tambah
                        </button>
                    @endif
                </div>
            </div>

            {{-- Konten yang diletakkan di dalam x-base-body (seperti tabel) akan muncul di sini --}}
            {{ $slot }}

        </div>
    </div>
</div>
