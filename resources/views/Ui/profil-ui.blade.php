@extends('layoutUi.base')

@section('content')
<div class="pb-24">
    <div class="px-6 py-8 border-b border-gray-100 shadow-sm">
            <div class="flex items-center space-x-4">
                <div class="relative group">
                    <div class="h-20 w-20 rounded-full bg-gray-100 flex items-center justify-center border-2 border-gray-200 overflow-hidden shadow-sm">
                        <img id="display-foto" src="" class="w-full h-full object-cover">
                    </div>
                    <label for="input-foto" class="absolute -bottom-1 -right-1 bg-primary text-white w-8 h-8 rounded-full flex items-center justify-center cursor-pointer shadow-lg border-2 border-white active:scale-90 transition-transform">
                        <i class="fas fa-camera text-[10px]"></i>
                        <input type="file" id="input-foto" name="foto_profile" form="form-profile" class="hidden" accept="image/*">
                    </label>
                </div>

                <div>
                    <p class="text-gray-400 text-xs font-medium leading-none mb-1.5 uppercase tracking-widest">Selamat datang,</p>
                    <h2 id="header-name" class="text-xl font-extrabold text-gray-800 uppercase tracking-tight leading-tight">--</h2>
                    <div class="flex flex-col gap-1.5 mt-2">
                        <span id="header-jabatan" class="inline-block px-2.5 py-1 bg-gray-100 text-gray-600 rounded-md text-[9px] font-bold uppercase w-fit tracking-wider">--</span>
                        <span id="header-nip-text" class="text-[10px] text-gray-400 font-mono tracking-wider ml-0.5">NIP: --</span>
                    </div>
                </div>
            </div>
        </div>

        <form id="form-profile" class="px-5 mt-8 space-y-6">
            @csrf
            <input type="hidden" name="email" id="field-email-hidden">
            <input type="hidden" name="nik" id="field-nik-hidden">
            <input type="hidden" name="nip" id="field-nip-hidden">
            <input type="hidden" name="jabatan_id" id="field-jabatan-id-hidden">
            <input type="hidden" name="lokasi_kantor_id" id="field-lokasi-id-hidden">
            <input type="hidden" name="status_ikatan_kerja" id="field-status-ikatan-hidden">

            <div class="space-y-5">
                <h3 class="text-gray-800 font-extrabold flex items-center gap-2 text-sm tracking-tight">
                    <span class="w-1.5 h-5 bg-primary rounded-full"></span>
                    Identitas Diri
                </h3>

                <div class="grid grid-cols-1 gap-4">
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-gray-400 uppercase ml-1 tracking-widest">Nama Lengkap</label>
                        <input type="text" name="name" id="field-name"
                            class="w-full bg-gray-50 border-gray-200 rounded-2xl px-4 py-3 text-sm font-semibold text-gray-700 transition-all focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none" placeholder="Masukkan nama lengkap">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-1">
                            <label class="text-[10px] font-bold text-gray-400 uppercase ml-1 tracking-widest">No. Handphone</label>
                            <input type="text" name="no_hp" id="field-no_hp"
                                class="w-full bg-gray-50 border-gray-200 rounded-2xl px-4 py-3 text-sm font-semibold text-gray-700 transition-all focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none">
                        </div>
                        <div class="space-y-1">
                            <label class="text-[10px] font-bold text-gray-400 uppercase ml-1 tracking-widest">Jenis Kelamin</label>
                            <div class="relative">
                                <select name="jenis_kelamin" id="field-jenis_kelamin"
                                    class="w-full bg-gray-50 border-gray-200 rounded-2xl px-4 py-3 text-sm font-semibold text-gray-700 transition-all focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none appearance-none">
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                                <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none text-xs"></i>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-gray-400 uppercase ml-1 tracking-widest">Agama</label>
                        <input type="text" name="agama" id="field-agama"
                            class="w-full bg-gray-50 border-gray-200 rounded-2xl px-4 py-3 text-sm font-semibold text-gray-700 transition-all focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none">
                    </div>

                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-gray-400 uppercase ml-1 tracking-widest">Alamat Domisili</label>
                        <textarea name="alamat" id="field-alamat" rows="2"
                            class="w-full bg-gray-50 border-gray-200 rounded-2xl px-4 py-3 text-sm font-semibold text-gray-700 transition-all focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none resize-none"></textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-1">
                            <label class="text-[10px] font-bold text-gray-400 uppercase ml-1 tracking-widest">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" id="field-tempat_lahir"
                                class="w-full bg-gray-50 border-gray-200 rounded-2xl px-4 py-3 text-sm font-semibold text-gray-700 transition-all focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none">
                        </div>
                        <div class="space-y-1">
                            <label class="text-[10px] font-bold text-gray-400 uppercase ml-1 tracking-widest">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" id="field-tanggal_lahir"
                                class="w-full bg-gray-50 border-gray-200 rounded-2xl px-4 py-3 text-sm font-semibold text-gray-700 transition-all focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none">
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-5 pt-4">
                <h3 class="text-gray-800 font-extrabold flex items-center gap-2 text-sm tracking-tight">
                    <span class="w-1.5 h-5 bg-red-400 rounded-full"></span>
                    Keamanan Akun
                </h3>
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-gray-400 uppercase ml-1 tracking-widest">Password Baru</label>
                        <input type="password" name="password"
                            class="w-full bg-gray-50 border-gray-200 rounded-2xl px-4 py-3 text-sm font-semibold text-gray-700 transition-all focus:bg-white focus:ring-2 focus:ring-red-100 focus:border-red-300 outline-none" placeholder="******">
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-gray-400 uppercase ml-1 tracking-widest">Konfirmasi</label>
                        <input type="password" name="password_confirmation"
                            class="w-full bg-gray-50 border-gray-200 rounded-2xl px-4 py-3 text-sm font-semibold text-gray-700 transition-all focus:bg-white focus:ring-2 focus:ring-red-100 focus:border-red-300 outline-none" placeholder="******">
                    </div>
                </div>
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full bg-primary text-white py-4 rounded-2xl font-bold shadow-lg shadow-primary/30 active:scale-[0.98] transition-all uppercase tracking-widest text-xs italic">
                    Simpan Perubahan
                </button>
            </div>
        </form>
        <div class="px-5 mt-4">
            <button type="button" id="btn-logout" class="w-full bg-white border border-red-100 text-red-500 py-4 rounded-2xl font-bold shadow-sm active:scale-[0.98] transition-all uppercase tracking-widest text-xs flex items-center justify-center gap-2">
                <i class="fas fa-sign-out-alt"></i>
                Keluar dari Akun
            </button>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
<script>
    const userId = "{{ auth()->user()->id }}";
</script>

<script type="module" src="{{ asset('js/services/profile.service.js') }}"></script>
<script type="module" src="{{ asset('js/controllers/profile.controller.js') }}"></script>
<script>
    const urlLogout = 'presensi/logout'
    $(document).ready(function() {
        $('#btn-logout').click(function(e) {
            Swal.fire({
                title: '<span style="font-size: 22px"> Konfirmasi!</span>',
                text: 'Anda yakin?',
                showCancelButton: true,
                showConfirmButton: true,
                cancelButtonText: 'Tidak',
                confirmButtonText: 'Ya',
                reverseButtons: true,
                confirmButtonColor: '#48ABF7',
                cancelButtonColor: '#EFEFEF',
                cancelButtonText: 'Tidak',
                customClass: {
                    cancelButton: 'text-dark'
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    e.preventDefault();
                    $.ajax({
                        url: `{{ url('${urlLogout}') }}`,
                        method: 'POST',
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            console.log(response);
                            window.location.href = '/login';
                        },
                        error: function(xhr, status, error) {
                            alert('Error: Failed to logout. Please try again.');
                        }
                    });
                }
            });
        });
    });
</script>
@endsection
