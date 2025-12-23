<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Informasi Profil') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Perbarui informasi profil dan data pribadi Anda.") }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

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
