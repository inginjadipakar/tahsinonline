<x-guest-layout>
    <div class="mb-6 text-center">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Daftar Tahsinku</h1>
        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">Mulai perjalanan belajar Al-Qur'an Anda</p>
    </div>

    <form method="POST" action="{{ route('register') }}" id="registerForm">
        @csrf

        {{-- Hidden Inputs for Package & Program --}}
        @if(request('package') && request('program'))
            <input type="hidden" name="selected_package" value="{{ request('package') }}">
            <input type="hidden" name="selected_program" value="{{ request('program') }}">
            
            <div class="mb-6 bg-islamic-emerald/10 dark:bg-islamic-gold/10 border border-islamic-emerald/20 dark:border-islamic-gold/20 rounded-xl p-4 flex items-center gap-4">
                <div class="w-12 h-12 bg-white dark:bg-islamic-navy rounded-full flex items-center justify-center shadow-sm text-2xl">
                    {{ request('program') == 'iqra' ? '📖' : '🎯' }}
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Mendaftar untuk:</p>
                    <h3 class="font-bold text-gray-900 dark:text-white text-lg">
                        Paket {{ ucfirst(request('package')) }} - Program {{ ucfirst(request('program')) }}
                    </h3>
                </div>
            </div>
        @endif

        <!-- Class Selection -->
        <div class="mb-6 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
            <x-input-label for="tahsin_class_id" value="Pilih Kelas Tahsin" class="text-blue-800 dark:text-blue-300 font-semibold" />
            <select id="tahsin_class_id" name="tahsin_class_id" required
                    class="mt-2 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-red-500 dark:focus:border-red-600 focus:ring-red-500 dark:focus:ring-red-600 rounded-md shadow-sm">
                <option value="">-- Pilih Kelas --</option>
                @foreach($classes as $class)
                    <option value="{{ $class->id }}" 
                            data-is-child="{{ str_contains(strtolower($class->name), 'anak') ? '1' : '0' }}"
                            {{ old('tahsin_class_id') == $class->id ? 'selected' : '' }}>
                        {{ $class->name }}
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('tahsin_class_id')" class="mt-2" />
            <p class="text-xs text-blue-600 dark:text-blue-400 mt-2">💡 Pilih kelas yang sesuai dengan usia dan kebutuhan Anda</p>
        </div>

        <!-- For Child Classes - Parent Info -->
        <div id="child-form" style="display: none;">
            <h3 class="font-semibold text-gray-700 dark:text-gray-300 mb-3 flex items-center">
                <svg class="w-5 h-5 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                Data Orang Tua/Wali
            </h3>
            
            <div class="space-y-4">
                <div>
                    <x-input-label for="parent_name" value="Nama Orang Tua/Wali *" />
                    <x-text-input id="parent_name" class="block mt-1 w-full" type="text" name="parent_name" 
                                  :value="old('parent_name')" placeholder="Nama lengkap orang tua" />
                    <x-input-error :messages="$errors->get('parent_name')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="phone_child" value="No HP Orang Tua (untuk login) *" />
                    <x-text-input id="phone_child" class="block mt-1 w-full" type="text" name="phone" 
                                  :value="old('phone')" placeholder="08123456789" />
                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                    <p class="text-xs text-gray-500 mt-1">📱 Nomor ini akan digunakan untuk login</p>
                </div>

                <div>
                    <x-input-label for="child_name" value="Nama Anak (Peserta) *" />
                    <x-text-input id="child_name" class="block mt-1 w-full" type="text" name="child_name" 
                                  :value="old('child_name')" placeholder="Nama anak" />
                    <x-input-error :messages="$errors->get('child_name')" class="mt-2" />
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="child_age" value="Usia Anak *" />
                        <x-text-input id="child_age" class="block mt-1 w-full" type="number" name="age" 
                                      :value="old('age')" min="3" max="17" placeholder="7" />
                        <x-input-error :messages="$errors->get('age')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="child_gender" value="Jenis Kelamin *" />
                        <select id="child_gender" name="gender"
                                class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-red-500 focus:ring-red-500 rounded-md shadow-sm">
                            <option value="">-- Pilih --</option>
                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                    </div>
                </div>

                <div>
                    <x-input-label for="occupation_child" value="Pekerjaan Orang Tua *" />
                    <x-text-input id="occupation_child" class="block mt-1 w-full" type="text" name="occupation" 
                                  :value="old('occupation')" placeholder="Wiraswasta, PNS, dll" />
                    <x-input-error :messages="$errors->get('occupation')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="address_child" value="Alamat Domisili *" />
                    <textarea id="address_child" name="address" rows="2"
                              placeholder="Jl. Contoh No. 123, Kota"
                              class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-red-500 focus:ring-red-500 rounded-md shadow-sm">{{ old('address') }}</textarea>
                    <x-input-error :messages="$errors->get('address')" class="mt-2" />
                </div>
            </div>
        </div>

        <!-- For Adult Classes - Personal Info -->
        <div id="adult-form" style="display: none;">
            <h3 class="font-semibold text-gray-700 dark:text-gray-300 mb-3 flex items-center">
                <svg class="w-5 h-5 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                Data Pribadi
            </h3>
            
            <div class="space-y-4">
                <div>
                    <x-input-label for="name" value="Nama Lengkap *" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" 
                                  :value="old('name')" placeholder="Nama lengkap Anda" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="phone_adult" value="No HP (untuk login) *" />
                    <x-text-input id="phone_adult" class="block mt-1 w-full" type="text" name="phone" 
                                  :value="old('phone')" placeholder="08123456789" />
                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                    <p class="text-xs text-gray-500 mt-1">📱 Nomor ini akan digunakan untuk login</p>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="age_adult" value="Usia *" />
                        <x-text-input id="age_adult" class="block mt-1 w-full" type="number" name="age" 
                                      :value="old('age')" min="18" max="100" placeholder="25" />
                        <x-input-error :messages="$errors->get('age')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="gender_adult" value="Jenis Kelamin *" />
                        <select id="gender_adult" name="gender"
                                class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-red-500 focus:ring-red-500 rounded-md shadow-sm">
                            <option value="">-- Pilih --</option>
                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                    </div>
                </div>

                <div>
                    <x-input-label for="occupation_adult" value="Pekerjaan *" />
                    <x-text-input id="occupation_adult" class="block mt-1 w-full" type="text" name="occupation" 
                                  :value="old('occupation')" placeholder="Pekerjaan Anda" />
                    <x-input-error :messages="$errors->get('occupation')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="address_adult" value="Alamat Domisili *" />
                    <textarea id="address_adult" name="address" rows="2"
                              placeholder="Jl. Contoh No. 123, Kota"
                              class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-red-500 focus:ring-red-500 rounded-md shadow-sm">{{ old('address') }}</textarea>
                    <x-input-error :messages="$errors->get('address')" class="mt-2" />
                </div>
            </div>
        </div>

        <!-- Password Fields -->
        <div id="password-section" style="display: none;">
            <h3 class="font-semibold text-gray-700 dark:text-gray-300 mb-3 mt-6 flex items-center">
                <svg class="w-5 h-5 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
                Keamanan Akun
            </h3>
            
            <div class="space-y-4">
                <div>
                    <x-input-label for="password" value="Password *" />
                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" 
                                  placeholder="Minimal 8 karakter" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="password_confirmation" value="Konfirmasi Password *" />
                    <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" 
                                  name="password_confirmation" placeholder="Ketik ulang password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>
            </div>
        </div>

        <div class="flex items-center justify-between mt-6">
            <a class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500" 
               href="{{ route('login') }}">
                Sudah punya akun?
            </a>

            <x-primary-button id="submitBtn" style="display: none;">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Daftar Sekarang
            </x-primary-button>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const classSelect = document.getElementById('tahsin_class_id');
            const childForm = document.getElementById('child-form');
            const adultForm = document.getElementById('adult-form');
            const passwordSection = document.getElementById('password-section');
            const submitBtn = document.getElementById('submitBtn');

            function toggleForms() {
                const selectedOption = classSelect.options[classSelect.selectedIndex];
                const isChild = selectedOption.getAttribute('data-is-child') === '1';
                const hasSelection = classSelect.value !== '';

                // Show/hide forms
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

            // Listen for class selection changes
            classSelect.addEventListener('change', toggleForms);

            // Check on page load (for validation errors with old values)
            toggleForms();
        });
    </script>
</x-guest-layout>
