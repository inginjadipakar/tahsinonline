<x-auth-modern-layout>
    <div class="sm:mx-auto sm:w-full sm:max-w-md text-center mb-6">
        {{-- Logo --}}
        <a href="/" class="inline-flex items-center gap-2 mb-2">
            <span class="text-4xl font-bold tracking-tight text-gray-900 dark:text-white drop-shadow-sm">
                Tahsin<span class="text-islamic-emerald">ku</span>
            </span>
        </a>
        
        <h2 class="text-2xl font-bold tracking-tight text-gray-800 dark:text-gray-100">
            Sign in
        </h2>
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-300 font-medium">
            Masuk untuk mulai belajar Al-Qur'an
        </p>
    </div>

    <div class="sm:mx-auto sm:w-full sm:max-w-[400px]">
        
        {{-- Milky Glass Card --}}
        <div class="bg-white/70 dark:bg-islamic-navy/70 backdrop-blur-xl rounded-3xl shadow-2xl p-8 border border-white/40 dark:border-white/10 relative overflow-hidden">
            
            {{-- Shine Effect --}}
            <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-br from-white/40 to-transparent pointer-events-none"></div>

            {{-- Session Status --}}
            @if (session('status'))
                <div class="mb-6 bg-emerald-50/80 border border-emerald-200 rounded-lg p-4 relative z-10">
                    <p class="text-emerald-700 text-sm font-medium">{{ session('status') }}</p>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5 relative z-10" x-data="{ showPassword: false }">
                @csrf

                {{-- Phone Number Input --}}
                <div>
                    <label for="phone" class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-1.5 ml-1">Nomor HP</label>
                    <div class="relative">
                        <input id="phone" type="text" name="phone" value="{{ old('phone') }}" 
                               class="block w-full px-4 py-3 rounded-xl bg-white/80 dark:bg-islamic-navy-dark/80 border border-gray-200 dark:border-gray-600 focus:border-islamic-emerald focus:ring-1 focus:ring-islamic-emerald text-gray-900 dark:text-white placeholder-gray-400 transition-all font-medium" 
                               placeholder="Contoh: 08123456789" 
                               required autofocus autocomplete="username">
                    </div>
                    @error('phone')
                        <p class="mt-2 text-xs text-red-500 font-medium ml-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password Input --}}
                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-1.5 ml-1">Password</label>
                    <div class="relative">
                        <input id="password" 
                               :type="showPassword ? 'text' : 'password'" 
                               name="password" 
                               class="block w-full px-4 py-3 rounded-xl bg-white/80 dark:bg-islamic-navy-dark/80 border border-gray-200 dark:border-gray-600 focus:border-islamic-emerald focus:ring-1 focus:ring-islamic-emerald text-gray-900 dark:text-white placeholder-gray-400 transition-all font-medium" 
                               placeholder="Masukkan password" 
                               required autocomplete="current-password">
                        
                        <button type="button" 
                                @click="showPassword = !showPassword"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 transition-colors">
                            <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <svg x-show="showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-2 text-xs text-red-500 font-medium ml-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember_me" name="remember" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-islamic-emerald focus:ring-islamic-emerald">
                        <label for="remember_me" class="ml-2 block text-sm text-gray-600 dark:text-gray-300 font-medium">
                            Ingat saya
                        </label>
                    </div>

                    @if (Route::has('password.request'))
                        <div class="text-sm">
                            <a href="{{ route('password.request') }}" class="font-medium text-islamic-emerald hover:text-islamic-emerald-dark transition-colors">
                                Lupa password?
                            </a>
                        </div>
                    @endif
                </div>

                <div>
                    <button type="submit" class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl shadow-lg shadow-emerald-500/20 text-sm font-bold text-white bg-gradient-to-r from-islamic-emerald to-teal-500 hover:from-islamic-emerald-dark hover:to-teal-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-islamic-emerald transition-all transform hover:-translate-y-0.5 active:translate-y-0">
                        MASUK
                    </button>
                </div>
            </form>
        </div>
        
        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600 dark:text-gray-400 font-medium">
                Belum punya akun? 
                <a href="{{ url('/#pricing') }}" class="font-bold text-islamic-emerald hover:text-islamic-emerald-dark transition-colors">
                    Daftar Sekarang
                </a>
            </p>
        </div>
    </div>
</x-auth-modern-layout>
