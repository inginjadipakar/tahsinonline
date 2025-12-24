<x-auth-modern-layout>
    <div class="sm:mx-auto sm:w-full sm:max-w-[450px]">
        
        {{-- Milky Glass Card (Consolidated) --}}
        <div class="bg-white/90 dark:bg-islamic-navy/90 backdrop-blur-xl rounded-3xl shadow-2xl overflow-hidden border border-white/50 dark:border-white/10 ring-1 ring-black/5 mx-4 sm:mx-0">
            
            {{-- Decorative Top Bar --}}
            <div class="h-2 bg-gradient-to-r from-islamic-emerald to-teal-500 w-full"></div>

            <div class="p-8 sm:p-10">
                {{-- Logo Section --}}
                <div class="text-center mb-8">
                    <a href="/" class="inline-flex items-center gap-2 mb-3">
                        <span class="text-4xl font-bold tracking-tight text-gray-900 dark:text-white drop-shadow-sm">
                            Tahsin<span class="text-islamic-emerald">ku</span>
                        </span>
                    </a>
                    <h2 class="text-xl font-semibold text-gray-600 dark:text-gray-300">
                        Masuk ke Akun Anda
                    </h2>
                </div>

                {{-- Session Status --}}
                @if (session('status'))
                    <div class="mb-6 bg-emerald-50 border border-emerald-200 rounded-xl p-4 flex items-center gap-3">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-emerald-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <p class="text-sm font-medium text-emerald-800">{{ session('status') }}</p>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-6" x-data="{ showPassword: false }">
                    @csrf

                    {{-- Phone Number Input --}}
                    <div>
                        <label for="phone" class="block text-sm font-bold text-gray-700 dark:text-gray-200 mb-2">Nomor WhatsApp</label>
                        <div class="relative">
                            <input id="phone" type="text" name="phone" value="{{ old('phone') }}" 
                                   class="block w-full px-4 py-3.5 rounded-xl bg-gray-50 dark:bg-islamic-navy-dark border border-gray-200 dark:border-gray-600 focus:bg-white focus:border-islamic-emerald focus:ring-2 focus:ring-islamic-emerald/20 text-gray-900 dark:text-white placeholder-gray-400 transition-all font-medium text-base shadow-sm" 
                                   placeholder="08123456789" 
                                   required autofocus autocomplete="username">
                        </div>
                        @error('phone')
                            <p class="mt-2 text-sm text-red-500 font-medium flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Password Input --}}
                    <div>
                        <label for="password" class="block text-sm font-bold text-gray-700 dark:text-gray-200 mb-2">Password Login</label>
                        <div class="relative">
                            <input id="password" 
                                   :type="showPassword ? 'text' : 'password'" 
                                   name="password" 
                                   class="block w-full px-4 py-3.5 rounded-xl bg-gray-50 dark:bg-islamic-navy-dark border border-gray-200 dark:border-gray-600 focus:bg-white focus:border-islamic-emerald focus:ring-2 focus:ring-islamic-emerald/20 text-gray-900 dark:text-white placeholder-gray-400 transition-all font-medium text-base shadow-sm" 
                                   placeholder="••••••••" 
                                   required autocomplete="current-password">
                            
                            <button type="button" 
                                    @click="showPassword = !showPassword"
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 transition-colors p-2">
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
                            <p class="mt-2 text-sm text-red-500 font-medium ml-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember_me" name="remember" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-islamic-emerald focus:ring-islamic-emerald cursor-pointer">
                            <label for="remember_me" class="ml-2 block text-sm text-gray-600 dark:text-gray-300 font-medium cursor-pointer select-none">
                                Ingat saya
                            </label>
                        </div>

                        @if (Route::has('password.request'))
                            <div class="text-sm">
                                <a href="{{ route('password.request') }}" class="font-semibold text-islamic-emerald hover:text-teal-600 transition-colors">
                                    Lupa password?
                                </a>
                            </div>
                        @endif
                    </div>

                    <button type="submit" class="w-full flex justify-center py-4 px-4 border border-transparent rounded-xl shadow-lg shadow-emerald-500/20 text-base font-bold text-white bg-gradient-to-r from-islamic-emerald to-teal-600 hover:from-islamic-emerald-dark hover:to-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-islamic-emerald transition-all transform hover:-translate-y-0.5 active:translate-y-0">
                        MASUK SEKARANG
                    </button>
                </form>

                {{-- Footer Link --}}
                <div class="mt-8 pt-6 border-t border-gray-100 dark:border-white/10 text-center">
                    <p class="text-gray-600 dark:text-gray-400 font-medium">
                        Belum punya akun? 
                        <a href="{{ url('/#pricing') }}" class="font-bold text-islamic-emerald hover:text-teal-600 transition-colors inline-flex items-center gap-1 group">
                            Daftar Sekarang
                            <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                    </p>
                </div>
            </div>
        </div>
        
        {{-- Copyright --}}
        <div class="mt-8 text-center">
            <p class="text-xs text-slate-500 font-medium opacity-80 backdrop-blur-sm inline-block px-3 py-1 rounded-full bg-white/30">
                &copy; {{ date('Y') }} TahsinOnline. All rights reserved.
            </p>
        </div>
    </div>
</x-auth-modern-layout>
