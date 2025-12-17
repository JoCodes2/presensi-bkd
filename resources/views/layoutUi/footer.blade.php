        <div
            class="fixed bottom-0 left-0 right-0 max-w-md mx-auto bg-white border-t border-light py-3 px-5 flex justify-between shadow-lg">
            <a href="#" class="flex flex-col items-center text-primary">
                <i class="fas fa-home text-lg mb-1"></i>
                <span class="text-xs font-medium">HOME</span>
            </a>
            {{-- <a href="#" class="flex flex-col items-center text-gray-500">
                <i class="fas fa-file-alt text-lg mb-1"></i>
                <span class="text-xs font-medium">IZIN</span>
            </a> --}}
            <a href="#" class="flex flex-col items-center text-gray-500">
                <i class="fas fa-fingerprint text-lg mb-1"></i>
                <span class="text-xs font-medium">ABSEN</span>
            </a>
            {{-- <a href="#" class="flex flex-col items-center text-gray-500">
                <i class="fas fa-history text-lg mb-1"></i>
                <span class="text-xs font-medium">HISTORY</span>
            </a> --}}
            <a href="{{ url('/profile') }}" class="flex flex-col items-center text-gray-500">
                <i class="fas fa-user text-lg mb-1"></i>
                <span class="text-xs font-medium">PROFILE</span>
            </a>
        </div>
