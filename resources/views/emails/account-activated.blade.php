@component('mail::message')
# Akun Anda Sudah Aktif

Halo **{{ $name }}**,

Kami senang memberitahu Anda bahwa akun presensi Anda (`{{ $email }}`) telah berhasil diverifikasi oleh Administrator dan sekarang **aktif**.

Anda dapat mulai menggunakan sistem presensi kami dengan detail berikut:
* **Status Akun:** Aktif
* **Presensi:** Anda kini dapat melakukan Presensi Masuk dan Keluar.

@component('mail::button', ['url' => url('/login')])
Masuk ke Sistem
@endcomponent

Terima kasih,
Tim Administrasi
@endcomponent
