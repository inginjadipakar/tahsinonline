<x-split-layout image="images/quran-study-real.png">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Daftar Tahsinku</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-2">Mulai perjalanan belajar Al-Qur'an Anda hari ini.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" id="registerForm" class="space-y-6">
        @csrf

        {{-- Hidden Inputs for Package & Program --}}
        @if(request('package') && request('program'))
            <input type="hidden" name="selected_package" value="{{ request('package') }}">
            <input type="hidden" name="selected_program" value="{{ request('program') }}">
            
            <div class="bg-gradient-to-br from-islamic-emerald/5 to-islamic-gold/5 dark:from-islamic-emerald/10 dark:to-islamic-gold/10 border border-islamic-emerald/20 dark:border-islamic-gold/20 rounded-2xl p-5 flex items-center gap-5">
                <div class="w-14 h-14 bg-white dark:bg-islamic-navy rounded-2xl flex items-center justify-center shadow-sm text-3xl ring-1 ring-gray-100 dark:ring-gray-700">
                    {{ request('program') == 'iqra' ? '📖' : '🎯' }}
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-islamic-emerald dark:text-islamic-gold mb-1">Pilihan Anda</p>
                    <h3 class="font-bold text-gray-900 dark:text-white text-lg leading-tight">
                        Paket {{ ucfirst(request('package')) }}
                    </h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Program {{ ucfirst(request('program')) }}</p>
                </div>
            </div>
        @endif

        <!-- Class Selection -->
        <div>
            <x-input-label for="tahsin_class_id" value="Pilih Kelas Tahsin" />
            
            @if(request('class_id'))
                @php
                    $selectedClass = $classes->firstWhere('id', request('class_id'));
                @endphp
                <div class="mt-2 p-4 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-islamic-emerald/10 flex items-center justify-center text-islamic-emerald">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <p class="font-bold text-gray-900 dark:text-white">{{ $selectedClass->name }}</p>
                            <p class="text-xs text-gray-500">Kelas Terpilih</p>
                        </div>
                    </div>
                    <a href="{{ route('register') }}" class="text-sm text-islamic-emerald hover:underline">Ubah</a>
                </div>
                <input type="hidden" name="tahsin_class_id" id="tahsin_class_id" value="{{ request('class_id') }}">
                
                <!-- Hidden select for JS compatibility -->
                <select id="hidden_class_select" style="display: none;">
                    <option value="{{ $selectedClass->id }}" data-is-child="{{ str_contains(strtolower($selectedClass->name), 'anak') ? '1' : '0' }}" selected></option>
                </select>
            @else
                <div class="mt-2 relative">
                    <select id="tahsin_class_id" name="tahsin_class_id" required
                            class="block w-full pl-4 pr-10 py-3 text-base border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 focus:outline-none focus:ring-2 focus:ring-islamic-emerald focus:border-islamic-emerald sm:text-sm rounded-xl transition-shadow shadow-sm">
                        <option value="">-- Pilih Kelas yang Sesuai --</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}" 
                                    data-is-child="{{ str_contains(strtolower($class->name), 'anak') ? '1' : '0' }}"
                                    {{ old('tahsin_class_id') == $class->id ? 'selected' : '' }}>
                                {{ $class->name }}
                            </option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </div>
                </div>
                <x-input-error :messages="$errors->get('tahsin_class_id')" class="mt-2" />
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-2 flex items-center gap-1">
                    <svg class="w-4 h-4 text-islamic-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Pilih kelas sesuai usia peserta
                </p>
            @endif
        </div>

        <!-- For Child Classes - Parent Info -->
        <div id="child-form" style="display: none;" class="space-y-6 animate-fade-in-down">
            <div class="relative">
                <div class="absolute inset-0 flex items-center" aria-hidden="true">
                    <div class="w-full border-t border-gray-200 dark:border-gray-700"></div>
                </div>
                <div class="relative flex justify-start">
                    <span class="pr-3 bg-white dark:bg-islamic-navy text-sm font-medium text-islamic-emerald dark:text-islamic-gold">
                        Data Orang Tua/Wali
                    </span>
                </div>
            </div>
            
            <div class="grid grid-cols-1 gap-6">
                <div>
                    <x-input-label for="parent_name" value="Nama Orang Tua/Wali *" />
                    <x-text-input id="parent_name" class="block mt-2 w-full py-3 rounded-xl" type="text" name="parent_name" 
                                  :value="old('parent_name')" placeholder="Nama lengkap orang tua" />
                    <x-input-error :messages="$errors->get('parent_name')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="phone_child" value="No HP Orang Tua (untuk login) *" />
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <span class="text-gray-500 font-bold border-r border-gray-300 pr-2 mr-1">+62</span>
                        </div>
                        <x-text-input id="phone_child" class="block mt-2 w-full py-3 pl-16 rounded-xl" type="text" name="phone" 
                                      :value="old('phone')" placeholder="8123456789" />
                    </div>
                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="child_name" value="Nama Anak (Peserta) *" />
                    <x-text-input id="child_name" class="block mt-2 w-full py-3 rounded-xl" type="text" name="child_name" 
                                  :value="old('child_name')" placeholder="Nama lengkap anak" />
                    <x-input-error :messages="$errors->get('child_name')" class="mt-2" />
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="child_age" value="Usia Anak *" />
                        <x-text-input id="child_age" class="block mt-2 w-full py-3 rounded-xl" type="number" name="age" 
                                      :value="old('age')" min="3" max="17" placeholder="7" />
                        <x-input-error :messages="$errors->get('age')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="child_gender" value="Jenis Kelamin *" />
                        <select id="child_gender" name="gender"
                                class="block mt-2 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-islamic-emerald focus:ring-islamic-emerald rounded-xl shadow-sm py-3">
                            <option value="">-- Pilih --</option>
                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                    </div>
                </div>

                <div>
                    <x-input-label for="occupation_child" value="Pekerjaan Orang Tua *" />
                    <x-text-input id="occupation_child" class="block mt-2 w-full py-3 rounded-xl" type="text" name="occupation" 
                                  :value="old('occupation')" placeholder="Wiraswasta, PNS, dll" />
                    <x-input-error :messages="$errors->get('occupation')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="address_child" value="Alamat Domisili *" />
                    <textarea id="address_child" name="address" rows="3"
                              placeholder="Jl. Contoh No. 123, Kota"
                              class="block mt-2 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-islamic-emerald focus:ring-islamic-emerald rounded-xl shadow-sm">{{ old('address') }}</textarea>
                    <x-input-error :messages="$errors->get('address')" class="mt-2" />
                </div>
            </div>
        </div>

        <!-- For Adult Classes - Personal Info -->
        <div id="adult-form" style="display: none;" class="space-y-6 animate-fade-in-down">
            <div class="relative">
                <div class="absolute inset-0 flex items-center" aria-hidden="true">
                    <div class="w-full border-t border-gray-200 dark:border-gray-700"></div>
                </div>
                <div class="relative flex justify-start">
                    <span class="pr-3 bg-white dark:bg-islamic-navy text-sm font-medium text-islamic-emerald dark:text-islamic-gold">
                        Data Pribadi
                    </span>
                </div>
            </div>
            
            <div class="grid grid-cols-1 gap-6">
                <div>
                    <x-input-label for="name" value="Nama Lengkap *" />
                    <x-text-input id="name" class="block mt-2 w-full py-3 rounded-xl" type="text" name="name" 
                                  :value="old('name')" placeholder="Nama lengkap Anda" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="phone_adult" value="No HP (untuk login) *" />
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <span class="text-gray-500 font-bold border-r border-gray-300 pr-2 mr-1">+62</span>
                        </div>
                        <x-text-input id="phone_adult" class="block mt-2 w-full py-3 pl-16 rounded-xl" type="text" name="phone" 
                                      :value="old('phone')" placeholder="8123456789" />
                    </div>
                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="age_adult" value="Usia *" />
                        <x-text-input id="age_adult" class="block mt-2 w-full py-3 rounded-xl" type="number" name="age" 
                                      :value="old('age')" min="18" max="100" placeholder="25" />
                        <x-input-error :messages="$errors->get('age')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="gender_adult" value="Jenis Kelamin *" />
                        <select id="gender_adult" name="gender"
                                class="block mt-2 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-islamic-emerald focus:ring-islamic-emerald rounded-xl shadow-sm py-3">
                            <option value="">-- Pilih --</option>
                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                    </div>
                </div>

                <div>
                    <x-input-label for="occupation_adult" value="Pekerjaan *" />
                    <x-text-input id="occupation_adult" class="block mt-2 w-full py-3 rounded-xl" type="text" name="occupation" 
                                  :value="old('occupation')" placeholder="Pekerjaan Anda" />
                    <x-input-error :messages="$errors->get('occupation')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="address_adult" value="Alamat Domisili *" />
                    <textarea id="address_adult" name="address" rows="3"
                              placeholder="Jl. Contoh No. 123, Kota"
                              class="block mt-2 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-islamic-emerald focus:ring-islamic-emerald rounded-xl shadow-sm">{{ old('address') }}</textarea>
                    <x-input-error :messages="$errors->get('address')" class="mt-2" />
                </div>
            </div>
        </div>

        <!-- Password Fields -->
        <div id="password-section" style="display: none;" class="space-y-6 animate-fade-in-down">
            <div class="relative">
                <div class="absolute inset-0 flex items-center" aria-hidden="true">
                    <div class="w-full border-t border-gray-200 dark:border-gray-700"></div>
                </div>
                <div class="relative flex justify-start">
                    <span class="pr-3 bg-white dark:bg-islamic-navy text-sm font-medium text-islamic-emerald dark:text-islamic-gold">
                        Keamanan Akun
                    </span>
                </div>
            </div>
            
            <div class="grid grid-cols-1 gap-6">
                <div>
                    <x-password-input 
                        id="password" 
                        name="password" 
                        label="Password" 
                        placeholder="Minimal 8 karakter"
                        :showStrengthMeter="true"
                    />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div>
                    <x-password-input 
                        id="password_confirmation" 
                        name="password_confirmation" 
                        label="Konfirmasi Password" 
                        placeholder="Ketik ulang password"
                        autocomplete="new-password"
                    />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>
            </div>
        </div>

        <div class="pt-4 border-t border-gray-100 dark:border-gray-800 flex flex-col-reverse sm:flex-row items-center justify-between gap-4">
            <a class="text-sm text-gray-600 dark:text-gray-400 hover:text-islamic-emerald dark:hover:text-islamic-gold transition-colors" 
               href="{{ route('login') }}">
                Sudah punya akun? <span class="font-semibold underline">Masuk</span>
            </a>

            <x-primary-button id="submitBtn" style="display: none;" class="w-full sm:w-auto justify-center py-3 px-8 text-base rounded-xl shadow-lg shadow-islamic-emerald/20 hover:shadow-islamic-emerald/30 transition-all transform hover:-translate-y-0.5">
                Daftar Sekarang
                <svg class="w-5 h-5 ml-2 -mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                </svg>
            </x-primary-button>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const classSelect = document.getElementById('tahsin_class_id');
            const hiddenClassSelect = document.getElementById('hidden_class_select');
            const childForm = document.getElementById('child-form');
            const adultForm = document.getElementById('adult-form');
            const passwordSection = document.getElementById('password-section');
            const submitBtn = document.getElementById('submitBtn');

            function toggleForms() {
                let isChild = false;
                let hasSelection = false;

                // Check if we have a hidden input (pre-selected via URL) or a dropdown
                if (classSelect.tagName === 'INPUT') {
                    // Pre-selected mode
                    const selectedOption = hiddenClassSelect.options[0];
                    isChild = selectedOption.getAttribute('data-is-child') === '1';
                    hasSelection = true;
                } else {
                    // Dropdown mode
                    const selectedOption = classSelect.options[classSelect.selectedIndex];
                    if (selectedOption && selectedOption.value) {
                        isChild = selectedOption.getAttribute('data-is-child') === '1';
                        hasSelection = true;
                    }
                }

                // Show/hide forms with animation
                childForm.style.display = (hasSelection && isChild) ? 'block' : 'none';
                adultForm.style.display = (hasSelection && !isChild) ? 'block' : 'none';
                passwordSection.style.display = hasSelection ? 'block' : 'none';
                submitBtn.style.display = hasSelection ? 'inline-flex' : 'none';

                // Enable/disable fields to prevent duplicate submissions
                const childInputs = childForm.querySelectorAll('input, select, textarea');
                const adultInputs = adultForm.querySelectorAll('input, select, textarea');

                childInputs.forEach(input => {
                    if (hasSelection && isChild) {
                        input.removeAttribute('disabled');
                    } else {
                        input.setAttribute('disabled', 'disabled');
                        input.value = '';
                    }
                });

                adultInputs.forEach(input => {
                    if (hasSelection && !isChild) {
                        input.removeAttribute('disabled');
                    } else {
                        input.setAttribute('disabled', 'disabled');
                        input.value = '';
                    }
                });
            }

            // Listen for class selection changes if it's a select element
            if (classSelect.tagName === 'SELECT') {
                classSelect.addEventListener('change', toggleForms);
            }

            // Check on page load (for validation errors with old values)
            toggleForms();
        });
    </script>
</x-split-layout>
