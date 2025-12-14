@component('mail::message')
# Peringatan Keterlambatan Harian

Halo **{{ $user->name }}**,

Berdasarkan catatan presensi Anda hari ini, Anda tercatat melakukan **keterlambatan presensi masuk**.

* **Jenis Pelanggaran:** {{ Str::title(str_replace('_', ' ', $violationType)) }} (Terlambat)
* **Waktu Deteksi:** {{ now()->format('d M Y H:i:s') }}
* **Detail Akun:** {{ $user->email }}

Kami mohon agar Anda dapat lebih meningkatkan kedisiplinan dan ketepatan waktu dalam melakukan presensi masuk di hari kerja berikutnya. Pelanggaran berulang dapat mempengaruhi catatan kinerja Anda.

@component('mail::button', ['url' => url('/login')])
Masuk ke Sistem Presensi
@endcomponent

Terima kasih,
Tim Administrasi
@endcomponent
