@component('mail::message')
# Peringatan Presensi

Halo **{{ $user->name }}**,

@if($type === 'pulang')
Kami informasikan bahwa Anda tercatat **LUPA ABSEN PULANG** pada tanggal **{{ $date }}**.

Sistem mendeteksi Anda telah melakukan presensi masuk, namun tidak melakukan presensi keluar hingga batas waktu yang ditentukan.
@else
Kami informasikan bahwa Anda tercatat **TIDAK HADIR (ALPHA)** pada tanggal **{{ $date }}**.

Sistem kami tidak mendeteksi adanya aktivitas presensi masuk maupun keluar pada hari kerja tersebut.
@endif

Pelanggaran ini tercatat otomatis dalam sistem. Mohon segera cek riwayat presensi Anda dan berikan klarifikasi kepada bagian administrasi jika terdapat kendala teknis.

@component('mail::button', ['url' => url('/login')])
Cek Riwayat Presensi
@endcomponent

Terima kasih,<br>
Tim HRD / Administrasi
@endcomponent
