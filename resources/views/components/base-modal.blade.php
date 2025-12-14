@props([
    'id',
    'title' => 'Modal Title',
    'size' => 'md',
    'static' => false
])

<div
    class="modal fade"
    id="{{ $id }}"
    tabindex="-1"
    role="dialog"
    aria-labelledby="{{ $id }}Label"
    aria-hidden="true"
    {{ $static ? 'data-backdrop=static data-keyboard=false' : '' }}
>
    <div class="modal-dialog modal-{{ $size }}" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="{{ $id }}Label">
                    {{ $title }}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                {{ $slot }}
            </div>

            @if(isset($footer))
                <div class="modal-footer">
                    {{ $footer }}
                </div>
            @else
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            @endif

        </div>
    </div>
</div>
