@props(['title', 'icon' => 'fas fa-list-alt'])

<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title ">
            <i class="{{ $icon }} pr-2"></i>{{ $title }}
        </h4>
    </div>
    {{ $slot }}
</div>
