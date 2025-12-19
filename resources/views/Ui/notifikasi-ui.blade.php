@extends('layoutUi.base')

@section('content')
    <div class="px-5 py-4 border-b border-light bg-white sticky top-0 z-10 shadow-sm">
        <h2 class="text-lg font-bold text-gray-800 uppercase">{{ Auth::user()->name }}</h2>
        <p class="text-gray-500 text-[11px] flex items-center gap-1">
            <i class="fas fa-calendar-alt"></i>
            <span id="current-date-display"></span>
        </p>
    </div>

    <div id="notif-page-container" class="px-5 py-6 space-y-4 pb-24">
        <div class="animate-pulse space-y-4">
            <div class="h-20 bg-gray-100 rounded-lg"></div>
            <div class="h-20 bg-gray-100 rounded-lg"></div>
            <div class="h-20 bg-gray-100 rounded-lg"></div>
        </div>
    </div>
@endsection

@section('scripts')
<script type="module">
    import notifService from "{{ asset('js/services/notifUi.service.js') }}";

    $(document).ready(function() {
        const service = new notifService();
        moment.locale('id');
        $('#current-date-display').text(moment().format('dddd, DD MMMM YYYY'));

        service.loadNotifPage();
    });
</script>
@endsection
