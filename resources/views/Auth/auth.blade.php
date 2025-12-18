@extends('layoutUi.base')

@section('content')
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
        <form method="POST" action="" class="space-y-4">
            @csrf

            {{-- Email --}}
            <div>
                <label class="text-sm font-medium text-gray-700">
                    Email
                </label>
                <input
                    type="email"
                    name="email"
                    required
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
                    required
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
                class="w-full py-2 rounded-lg font-semibold text-white
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
            <a href="#" class="font-semibold text-primary hover:underline">
                Daftar
            </a>
        </p>
    </div>
</div>
@endsection
