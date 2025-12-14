{{-- resources/views/components/base-table.blade.php --}}
@props(['initId'])
<div class="card-body">
    <div class="table-responsive">
        <table id="{{ $initId }}" class="display table table-striped table-hover" width="100%">
            <thead>
                {{ $thead }}
            </thead>
            <tbody>
                {{ $tbody ?? '' }}
            </tbody>
        </table>
    </div>
</div>
