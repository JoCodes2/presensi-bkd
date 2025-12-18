@extends('layoutUi.base')

@section('content')
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
            <form method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf

                {{-- Nama & Email --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                        <input type="text" name="name" required
                            class="w-full px-4 py-2.5 rounded-xl
                               bg-white/80 backdrop-blur
                               border border-white/40
                               focus:outline-none focus:ring-2 focus:ring-primary/30">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" required
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
                        <input type="password" name="password" required
                            class="w-full px-4 py-2.5 rounded-xl
                               bg-white/80 backdrop-blur
                               border border-white/40
                               focus:outline-none focus:ring-2 focus:ring-primary/30">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" required
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
                        <input type="text" name="nik"
                            class="w-full px-4 py-2.5 rounded-xl bg-white/80 border border-white/40 focus:ring-2 focus:ring-primary/30">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">NIP</label>
                        <input type="text" name="nip"
                            class="w-full px-4 py-2.5 rounded-xl bg-white/80 border border-white/40 focus:ring-2 focus:ring-primary/30">
                    </div>
                </div>

                {{-- Alamat --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                    <textarea rows="2" name="alamat"
                        class="w-full px-4 py-2.5 rounded-xl bg-white/80 border border-white/40 focus:ring-2 focus:ring-primary/30"></textarea>
                </div>

                {{-- No HP & Gender --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">No. HP</label>
                        <input type="text" name="no_hp"
                            class="w-full px-4 py-2.5 rounded-xl bg-white/80 border border-white/40 focus:ring-2 focus:ring-primary/30">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin</label>
                        <select name="jenis_kelamin"
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
                        <input type="text" name="tempat_lahir"
                            class="w-full px-4 py-2.5 rounded-xl bg-white/80 border border-white/40 focus:ring-2 focus:ring-primary/30">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir"
                            class="w-full px-4 py-2.5 rounded-xl bg-white/80 border border-white/40 focus:ring-2 focus:ring-primary/30">
                    </div>
                </div>

                {{-- Agama --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Agama</label>
                    <select name="agama"
                        class="w-full px-4 py-2.5 rounded-xl bg-white/80 border border-white/40 appearance-none focus:ring-2 focus:ring-primary/30">
                        <option value="">-- Pilih Agama --</option>
                        <option>Islam</option>
                        <option>Kristen</option>
                        <option>Katolik</option>
                        <option>Hindu</option>
                        <option>Buddha</option>
                        <option>Konghucu</option>
                    </select>
                </div>

                {{-- Jabatan & Lokasi --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jabatan</label>
                        <select name="jabatan_id"
                            class="w-full px-4 py-2.5 rounded-xl bg-white/80 border border-white/40 appearance-none focus:ring-2 focus:ring-primary/30">
                            <option value="">-- Pilih Jabatan --</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Lokasi Kantor</label>
                        <select name="lokasi_kantor_id"
                            class="w-full px-4 py-2.5 rounded-xl bg-white/80 border border-white/40 appearance-none focus:ring-2 focus:ring-primary/30">
                            <option value="">-- Pilih Lokasi --</option>
                        </select>
                    </div>
                </div>

                {{-- Foto --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Foto Profile</label>
                    <input type="file" name="foto_profile"
                        class="block w-full text-sm text-gray-600
                           file:mr-4 file:py-2 file:px-4
                           file:rounded-lg file:border-0
                           file:bg-primary/90 file:text-white
                           hover:file:bg-primary">
                </div>

                {{-- Hidden --}}
                <input type="hidden" name="status" value="inactive">
                <input type="hidden" name="role" value="pegawai">

                {{-- Submit --}}
                <button type="submit"
                    class="w-full mt-4 py-2.5 rounded-xl font-semibold text-white
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
@endsection
