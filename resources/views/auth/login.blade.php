<x-auth-modern-layout>
    <div class="sm:mx-auto sm:w-full sm:max-w-md text-center mb-10">
        {{-- Logo --}}
        <a href="/" class="inline-flex items-center gap-2 mb-6">
            <span class="text-4xl font-bold tracking-tight text-white">
                Tahsin<span class="text-islamic-emerald">ku</span>
            </span>
        </a>
        
        <h2 class="text-3xl font-bold tracking-tight text-white">
            Sign in
        </h2>
        <p class="mt-2 text-sm text-gray-400">
            Masuk untuk mulai belajar Al-Qur'an
        </p>
    </div>

    <div class="sm:mx-auto sm:w-full sm:max-w-[400px]">
        
        {{-- Session Status --}}
        @if (session('status'))
            <div class="mb-6 bg-emerald-500/10 border border-emerald-500/50 rounded-lg p-4">
                <p class="text-emerald-400 text-sm font-medium">{{ session('status') }}</p>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-5" x-data="{ showPassword: false }">
            @csrf

            {{-- Phone Number Input --}}
            <div>
                <label for="phone" class="sr-only">Nomor HP</label>
                <div class="relative">
                    <input id="phone" type="text" name="phone" value="{{ old('phone') }}" 
                           class="glass-input block w-full px-4 py-3.5 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-emerald-500 transition-all sm:text-sm" 
                           placeholder="Nomor HP" 
                           required autofocus autocomplete="username">
                </div>
                @error('phone')
                    <p class="mt-2 text-xs text-red-400">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password Input --}}
            <div>
                <label for="password" class="sr-only">Password</label>
                <div class="relative">
                    <input id="password" 
                           :type="showPassword ? 'text' : 'password'" 
                           name="password" 
                           class="glass-input block w-full px-4 py-3.5 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-emerald-500 transition-all sm:text-sm" 
                           placeholder="Password" 
                           required autocomplete="current-password">
                    
                    <button type="button" 
                            @click="showPassword = !showPassword"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-300 transition-colors">
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
                    <p class="mt-2 text-xs text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember_me" name="remember" type="checkbox" class="h-4 w-4 rounded border-gray-600 bg-gray-700/50 text-emerald-500 focus:ring-emerald-500 focus:ring-offset-gray-900">
                    <label for="remember_me" class="ml-2 block text-sm text-gray-400">
                        Remember me
                    </label>
                </div>

                @if (Route::has('password.request'))
                    <div class="text-sm">
                        <a href="{{ route('password.request') }}" class="font-medium text-gray-400 hover:text-emerald-400 transition-colors">
                            Forgot password?
                        </a>
                    </div>
                @endif
            </div>

            <div>
                <button type="submit" class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 focus:ring-offset-gray-900 transition-all transform hover:scale-[1.02]">
                    Login
                </button>
            </div>
        </form>
        
        <script>
            // Simple animation for form elements
            document.addEventListener('DOMContentLoaded', () => {
                const form = document.querySelector('form');
                form.classList.add('opacity-0', 'translate-y-4');
                setTimeout(() => {
                    form.classList.remove('opacity-0', 'translate-y-4');
                    form.classList.add('opacity-100', 'translate-y-0', 'transition-all', 'duration-700', 'ease-out');
                }, 100);
            });
        </script>
    </div>
</x-auth-modern-layout>
