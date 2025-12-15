@component('mail::message')
# Status Akun Anda: {{ $status === 'active' ? 'AKTIF' : 'DITOLAK' }}

Halo **{{ $name }}**,

@if ($status === 'active')
Kami senang memberitahu Anda bahwa akun presensi Anda (`{{ $email }}`) telah berhasil diverifikasi oleh Administrator dan sekarang **aktif**.

Anda dapat mulai menggunakan sistem presensi kami dengan detail berikut:
* **Status Akun:** Aktif
* **Presensi:** Anda kini dapat melakukan Presensi Masuk dan Keluar.

@component('mail::button', ['url' => url('/login'), 'color' => 'success'])
Masuk ke Sistem
@endcomponent

@else
{{-- Status Rejected --}}
Mohon maaf, permohonan aktivasi akun presensi Anda (`{{ $email }}`) **telah ditolak** oleh Administrator.

Kemungkinan alasan penolakan termasuk:
* Data pendaftaran tidak lengkap atau tidak valid.
* Dokumen pendukung (jika ada) tidak sesuai.
* Akun duplikat telah ditemukan.

Mohon hubungi Tim Administrasi untuk informasi lebih lanjut mengenai status akun Anda.

@component('mail::button', ['url' => url('/contact'), 'color' => 'error'])
Hubungi Administrator
@endcomponent

@endif

Terima kasih,
Tim Administrasi
@endcomponent
