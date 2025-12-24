<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Informasi Profil') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Perbarui informasi profil dan data pribadi Anda.") }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        {{-- Profile Photo --}}
        <div x-data="{ photoName: null, photoPreview: null }" class="flex items-center gap-6 mb-6">
            <!-- Profile Photo File Input -->
            <input type="file" id="photo" class="hidden"
                   name="photo"
                   x-ref="photo"
                   accept="image/*"
                   x-on:change="
                        photoName = $refs.photo.files[0].name;
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            photoPreview = e.target.result;
                        };
                        reader.readAsDataURL($refs.photo.files[0]);
                   " />

            <!-- Current Profile Photo -->
            <div class="relative group cursor-pointer" x-on:click.prevent="$refs.photo.click()">
                <div x-show="!photoPreview" class="h-24 w-24 rounded-full overflow-hidden border-2 border-gray-200 group-hover:border-emerald-500 transition-colors">
                    @php
                        $hasPhoto = !empty($user->profile_photo_path) && \Illuminate\Support\Facades\Storage::disk('public')->exists($user->profile_photo_path);
                    @endphp
                    @if($hasPhoto)
                        <img src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="{{ $user->name }}" class="h-full w-full object-cover">
                    @else
                        <div class="h-full w-full bg-emerald-100 flex items-center justify-center text-emerald-600 text-3xl font-bold">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                    @endif
                </div>

                <!-- New Profile Photo Preview -->
                <div x-show="photoPreview" style="display: none;" class="h-24 w-24 rounded-full overflow-hidden border-2 border-emerald-500">
                    <span class="block h-full w-full bg-cover bg-no-repeat bg-center"
                          x-bind:style="'background-image: url(\'' + photoPreview + '\');'">
                    </span>
                </div>
                
                <!-- Overlay on Hover -->
                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 rounded-full transition-all flex items-center justify-center">
                    <svg class="w-8 h-8 text-white opacity-0 group-hover:opacity-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
            </div>

            <div class="flex-1">
                <h3 class="text-lg font-bold text-gray-900">{{ $user->name }}</h3>
                <button type="button" class="text-sm font-semibold text-emerald-600 hover:text-emerald-500 focus:outline-none" x-on:click.prevent="$refs.photo.click()">
                    {{ __('Ubah Foto Profil') }}
                </button>
                <x-input-error class="mt-2" :messages="$errors->get('photo')" />
            </div>
        </div>

        {{-- Nama Lengkap --}}
        <div>
            <x-input-label for="name" :value="__('Nama Lengkap')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        {{-- No HP --}}
        <div>
            <x-input-label for="phone" :value="__('No HP (untuk login)')" />
            <div class="mt-1 flex">
                <span class="inline-flex items-center px-3 text-sm text-gray-500 bg-gray-100 border border-r-0 border-gray-300 rounded-l-md dark:bg-gray-700 dark:text-gray-400 dark:border-gray-600">
                    +62
                </span>
                <x-text-input id="phone" name="phone" type="text" class="block w-full rounded-l-none" :value="old('phone', ltrim($user->phone, '62'))" required autocomplete="tel" />
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('phone')" />
        </div>

        {{-- Usia & Jenis Kelamin --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <x-input-label for="age" :value="__('Usia')" />
                <x-text-input id="age" name="age" type="number" min="5" max="100" class="mt-1 block w-full" :value="old('age', $user->age)" />
                <x-input-error class="mt-2" :messages="$errors->get('age')" />
            </div>

            <div>
                <x-input-label for="gender" :value="__('Jenis Kelamin')" />
                <select id="gender" name="gender" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-islamic-emerald dark:focus:border-islamic-emerald focus:ring-islamic-emerald dark:focus:ring-islamic-emerald rounded-md shadow-sm">
                    <option value="">-- Pilih --</option>
                    <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Perempuan</option>
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('gender')" />
            </div>
        </div>

        {{-- Pekerjaan --}}
        <div>
            <x-input-label for="occupation" :value="__('Pekerjaan')" />
            <x-text-input id="occupation" name="occupation" type="text" class="mt-1 block w-full" :value="old('occupation', $user->occupation)" placeholder="Contoh: Karyawan Swasta, PNS, Mahasiswa, dll" />
            <x-input-error class="mt-2" :messages="$errors->get('occupation')" />
        </div>

        {{-- Alamat Domisili --}}
        <div>
            <x-input-label for="address" :value="__('Alamat Domisili')" />
            <textarea id="address" name="address" rows="3" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-islamic-emerald dark:focus:border-islamic-emerald focus:ring-islamic-emerald dark:focus:ring-islamic-emerald rounded-md shadow-sm" placeholder="Jl. Contoh No. 123, Kota">{{ old('address', $user->address) }}</textarea>
            <x-input-error class="mt-2" :messages="$errors->get('address')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Simpan') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Tersimpan.') }}</p>
            @endif
        </div>
    </form>
</section>
