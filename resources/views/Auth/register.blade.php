<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>BKD SULTENG - Absensi by Lokasi</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
       <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
       <script src="{{ asset('helper/helper.js') }}"></script>
    <script>
        let appUrl = '{{ env('APP_URL') }}';
    </script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .gradient-bg {
            background: linear-gradient(135deg, #4b6cb7 0%, #182848 100%);
        }

        .mode-wfo {
            background-color: #e1f5fe;
            color: #0288d1;
        }

        .mode-wfh {
            background-color: #e8f5e9;
            color: #2e7d32;
        }

        .mode-label {
            display: inline-block;
            padding: 0.2rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        /* Custom styles untuk memastikan konsistensi di semua browser */
        .shadow-custom {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .border-light {
            border-color: #eef2f7;
        }

        .text-primary {
            color: #1e40af;
        }

        .bg-primary {
            background-color: #1e40af;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800">
    <div class="max-w-md mx-auto bg-white min-h-screen shadow-custom">
        <!-- Header -->
        <header class="gradient-bg text-white pt-6 pb-8 px-5 rounded-b-2xl">
            <div class="flex items-center justify-between">
                <div class="flex-shrink-0">
                    <img src="{{ asset('assets/img/Logo_BKD.png') }}" alt="Logo BKD SULTENG" class="h-16 w-auto">
                </div>

                <div class="ml-4 text-right">
                    <h1 class="text-xl font-bold leading-tight">BKD SULTENG</h1>
                    <p class="text-white/90 text-sm mt-1">Absensi by Lokasi</p>
                </div>
            </div>
        </header>
        <div class="relative min-h-screen flex items-center justify-center px-4 py-10 overflow-hidden">

            {{-- Background --}}
            <div class="absolute inset-0 bg-gradient-to-br from-primary/30 via-blue-400/20 to-purple-400/30"></div>
            <div class="absolute -top-24 -left-24 w-96 h-96 bg-blue-400/40 rounded-full blur-3xl"></div>
            <div class="absolute top-1/3 -right-24 w-96 h-96 bg-purple-400/40 rounded-full blur-3xl"></div>

            {{-- Card --}}
            <div
                class="relative w-full max-w-2xl rounded-3xl p-6 md:p-8
                bg-white/60 backdrop-blur-xl
                border border-white/40
                shadow-2xl">

                {{-- Header --}}
                <div class="text-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Register</h2>
                    <p class="text-sm text-gray-600">Buat akun baru</p>
                </div>

                {{-- Form --}}
              <form id="formRegister" onsubmit="return false;" method="POST" enctype="multipart/form-data" class="space-y-5">
                    @csrf

                    {{-- Nama & Email --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                            <input type="text" name="name" id="name"
                                class="w-full px-4 py-2.5 rounded-xl
                                bg-white/80 backdrop-blur
                                border border-white/40
                                focus:outline-none focus:ring-2 focus:ring-primary/30">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" name="email" id="email"
                                class="w-full px-4 py-2.5 rounded-xl
                                bg-white/80 backdrop-blur
                                border border-white/40
                                focus:outline-none focus:ring-2 focus:ring-primary/30">
                        </div>
                    </div>

                    {{-- Password --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                            <input type="password" name="password" id="password"
                                class="w-full px-4 py-2.5 rounded-xl
                                bg-white/80 backdrop-blur
                                border border-white/40
                                focus:outline-none focus:ring-2 focus:ring-primary/30">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="w-full px-4 py-2.5 rounded-xl
                                bg-white/80 backdrop-blur
                                border border-white/40
                                focus:outline-none focus:ring-2 focus:ring-primary/30">
                        </div>
                    </div>

                    {{-- NIK & NIP --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">NIK</label>
                            <input type="text" name="nik" id="nik"
                                class="w-full px-4 py-2.5 rounded-xl bg-white/80 border border-white/40 focus:ring-2 focus:ring-primary/30">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">NIP</label>
                            <input type="text" name="nip" id="nip"
                                class="w-full px-4 py-2.5 rounded-xl bg-white/80 border border-white/40 focus:ring-2 focus:ring-primary/30">
                        </div>
                    </div>

                    {{-- Alamat --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                        <textarea rows="2" name="alamat" id="alamat"
                            class="w-full px-4 py-2.5 rounded-xl bg-white/80 border border-white/40 focus:ring-2 focus:ring-primary/30"></textarea>
                    </div>

                    {{-- No HP & Gender --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">No. HP</label>
                            <input type="text" name="no_hp" id="no_hp"
                                class="w-full px-4 py-2.5 rounded-xl bg-white/80 border border-white/40 focus:ring-2 focus:ring-primary/30">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin</label>
                            <select name="jenis_kelamin" id="jenis_kelamin"
                                class="w-full px-4 py-2.5 rounded-xl bg-white/80 border border-white/40 appearance-none focus:ring-2 focus:ring-primary/30">
                                <option value="">-- Pilih --</option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                    </div>

                    {{-- Tempat & Tanggal Lahir --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" id="tempat_lahir"
                                class="w-full px-4 py-2.5 rounded-xl bg-white/80 border border-white/40 focus:ring-2 focus:ring-primary/30">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" id="tanggal_lahir"
                                class="w-full px-4 py-2.5 rounded-xl bg-white/80 border border-white/40 focus:ring-2 focus:ring-primary/30">
                        </div>
                    </div>

                    {{-- Agama --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Agama</label>
                        <select name="agama" id="agama"
                            class="w-full px-4 py-2.5 rounded-xl bg-white/80 border border-white/40 appearance-none focus:ring-2 focus:ring-primary/30">
                            <option value="" selected disabled>-- Pilih Agama --</option>
                            <option value="Islam">Islam</option>
                            <option value="Kristen">Kristen</option>
                            <option value="Katolik">Katolik</option>
                            <option value="Hindu">Hindu</option>
                            <option value="Buddha">Buddha</option>
                            <option value="Konghucu">Konghucu</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Status Ikatan Kerja
                        </label>
                        <select id="status_ikatan_kerja" name="status_ikatan_kerja"
                            class="w-full px-4 py-2.5 rounded-xl bg-white/80 border border-white/40 appearance-none focus:ring-2 focus:ring-primary/30">
                            <option value="">-- Pilih Status --</option>
                            <option value="pns">PNS</option>
                            <option value="non_pns">Non PNS</option>
                        </select>
                    </div>


                    {{-- Jabatan & Lokasi --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Jabatan</label>
                            <select name="jabatan_id" id="jabatan_id"
                                class="w-full px-4 py-2.5 rounded-xl bg-white/80 border border-white/40 appearance-none focus:ring-2 focus:ring-primary/30">
                                <option value="">-- Pilih Jabatan --</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Lokasi Kantor</label>
                            <select name="lokasi_kantor_id" id="lokasi_kantor_id"
                                class="w-full px-4 py-2.5 rounded-xl bg-white/80 border border-white/40 appearance-none focus:ring-2 focus:ring-primary/30">
                                <option value="">-- Pilih Lokasi --</option>
                            </select>
                        </div>
                    </div>

                    {{-- Foto --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Foto Profile</label>
                        <input type="file" name="foto_profile" id="foto_profile"
                            class="block w-full text-sm text-gray-600
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-lg file:border-0
                            file:bg-primary/90 file:text-white
                            hover:file:bg-primary">
                    </div>

                    {{-- Submit --}}
                    <button type="submit"
                        class="w-full mt-4 py-2.5 rounded-xl font-semibold text-sky-400
                        bg-gradient-to-r from-primary to-blue-600
                        hover:scale-[1.02] active:scale-[0.98]
                        transition shadow-lg">
                        Daftar
                    </button>
                </form>

                {{-- Login --}}
                <p class="mt-5 text-center text-sm text-gray-600">
                    Sudah punya akun?
                    <a href="{{ url('/login') }}" class="font-semibold text-primary hover:underline">Login</a>
                </p>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="{{ asset('assets/js/core/jquery.3.2.1.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.21.0/jquery.validate.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.21.0/additional-methods.min.js"></script>

<script type="module" src="{{ asset('js/controllers/register.controller.js')}}"></script>
</body>
