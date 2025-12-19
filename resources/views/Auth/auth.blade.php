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
        <div class="relative min-h-screen flex items-center justify-center px-5 overflow-hidden">

            {{-- Background Gradient --}}
            <div class="absolute inset-0 bg-gradient-to-br from-primary/30 via-blue-400/20 to-purple-400/30"></div>

            {{-- Liquid Blur Shapes --}}
            <div class="absolute -top-20 -left-20 w-72 h-72 bg-blue-400/40 rounded-full blur-3xl"></div>
            <div class="absolute top-1/3 -right-20 w-72 h-72 bg-purple-400/40 rounded-full blur-3xl"></div>

            {{-- Glass Card --}}
            <div
                class="relative w-full max-w-md p-6 rounded-2xl
                    bg-white/20 backdrop-blur-xl
                    border border-white/30
                    shadow-2xl">

                {{-- Header --}}
                <div class="mb-6 text-center">
                    <h2 class="text-2xl font-bold text-gray-800">Login</h2>
                    <p class="mt-1 text-sm text-gray-600">
                        Silakan masuk ke akun Anda
                    </p>
                </div>

                {{-- Form --}}
                <form method="POST" id="formLogin" class="space-y-4">
                    @csrf

                    {{-- Email --}}
                    <div>
                        <label class="text-sm font-medium text-gray-700">
                            Email
                        </label>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            class="mt-1 w-full px-4 py-2 rounded-lg
                                bg-white/60 border border-white/40
                                outline-none transition
                                focus:bg-white
                                focus:border-primary
                                focus:ring focus:ring-primary/30">
                    </div>

                    {{-- Password --}}
                    <div>
                        <label class="text-sm font-medium text-gray-700">
                            Password
                        </label>
                        <input
                            type="password"
                            name="password"
                            id="password"
                            class="mt-1 w-full px-4 py-2 rounded-lg
                                bg-white/60 border border-white/40
                                outline-none transition
                                focus:bg-white
                                focus:border-primary
                                focus:ring focus:ring-primary/30">
                    </div>

                    {{-- Submit --}}
                    <button
                        type="submit"
                        class="w-full py-2 rounded-lg font-semibold text-sky-400
                            bg-gradient-to-r from-primary to-blue-600
                            shadow-lg transition-all duration-200
                            hover:scale-[1.02]
                            active:scale-[0.98]">
                        Masuk
                    </button>
                </form>

                {{-- Register --}}
                <p class="mt-5 text-center text-sm text-gray-700">
                    Belum punya akun?
                    <a href="{{ url('/register') }}" class="font-semibold text-primary hover:underline">
                        Daftar
                    </a>
                </p>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/js/core/jquery.3.2.1.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.21.0/jquery.validate.min.js"
     integrity="sha512-KFHXdr2oObHKI9w4Hv1XPKc898mE4kgYx58oqsc/JqqdLMDI4YjOLzom+EMlW8HFUd0QfjfAvxSL6sEq/a42fQ=="
     crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    const loginApi = "{{ url('auth/login') }}";

    $(document).ready(function() {
        // Konfigurasi JQuery Validate
        $("#formLogin").validate({
            rules: {
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true,
                    minlength: 5
                }
            },
            messages: {
                email: {
                    required: "Email tidak boleh kosong",
                    email: "Format email tidak valid"
                },
                password: {
                    required: "Password tidak boleh kosong",
                    minlength: "Password minimal 5 karakter"
                }
            },
            errorElement: 'span',
            errorClass: 'text-red-500 text-xs mt-1 block',
            submitHandler: function(form) {
                handleLogin(form);
            }
        });

        function handleLogin(form) {
            let formData = new FormData(form);

            Swal.fire({
                title: "Sedang Memverifikasi...",
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                type: 'POST',
                url: loginApi,
                data: formData,
                processData: false,
                contentType: false,
                success: function(res) {
                    Swal.fire({
                        icon: "success",
                        title: "Berhasil",
                        text: res.data.message,
                        timer: 1000,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = res.data.redirect;
                    });
                },
                error: function(xhr) {
                    Swal.close();

                    // Ambil response JSON
                    let response = xhr.responseJSON;
                    let errorMessage = response && response.message ? response.message : "Terjadi kesalahan sistem";

                    if (xhr.status === 422) {
                        // Error validasi form (Laravel Validation)
                        let errors = response.errors;
                        let listError = "";
                        $.each(errors, function(key, val) {
                            listError += val[0] + "<br>";
                        });
                        Swal.fire("Gagal Validasi", listError, "error");
                    }
                    else if (xhr.status === 404 || xhr.status === 400 || xhr.status === 403) {
                        // Menangani: Email tidak ditemukan (404), Password salah (400), Akun non-aktif (403)
                        Swal.fire("Gagal Login", errorMessage, "warning");
                    }
                    else {
                        Swal.fire("Error " + xhr.status, "Internal Server Error", "error");
                    }
                }
            });
        }
    });
</script>
</body>
