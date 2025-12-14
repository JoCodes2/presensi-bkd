@component('mail::message')
# Peringatan Alpha / Tidak Absen

Halo **{{ $user->name }}**,

Kami informasikan bahwa Anda tercatat **Tidak Absen (Alpha)** pada tanggal **{{ $date }}**.

Sistem kami tidak mendeteksi adanya presensi masuk maupun presensi keluar pada hari kerja tersebut.

Pelanggaran jenis ini dianggap serius. Mohon segera cek riwayat presensi Anda dan berikan klarifikasi kepada bagian administrasi jika ada kesalahan.

@component('mail::button', ['url' => url('/login')])
Cek Sistem Presensi
@endcomponent

Terima kasih,
Tim HRD / Administrasi
@endcomponent
