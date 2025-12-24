<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.users.index') }}" class="text-gray-500 hover:text-gray-700">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <h2 class="font-bold text-2xl text-gray-900 leading-tight">Edit User: {{ $user->name }}</h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <form action="{{ route('admin.users.update', $user) }}" method="POST" enctype="multipart/form-data" x-data="{ name: '{{ old('name', $user->name) }}', photoPreview: null }">
                    @csrf
                    @method('PUT')
                    
                    <div class="space-y-4">
                        {{-- Photo Upload --}}
                        <div class="flex items-center gap-6 mb-6">
                            <input type="file" id="photo" class="hidden" name="photo" x-ref="photo" accept="image/*"
                                x-on:change="
                                    const reader = new FileReader();
                                    reader.onload = (e) => { photoPreview = e.target.result; };
                                    reader.readAsDataURL($refs.photo.files[0]);
                                " />

                            <div class="relative group cursor-pointer" x-on:click.prevent="$refs.photo.click()">
                                <div x-show="!photoPreview" class="h-20 w-20 rounded-full overflow-hidden border-2 border-gray-200 group-hover:border-emerald-500 transition-colors bg-gray-50 flex items-center justify-center">
                                    @if($user->profile_photo_path)
                                        <img src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="{{ $user->name }}" class="h-full w-full object-cover">
                                    @else
                                        <span class="text-xl font-bold text-gray-400 uppercase" x-text="name ? name.charAt(0) : '?'"></span>
                                    @endif
                                </div>
                                <div x-show="photoPreview" style="display: none;" class="h-20 w-20 rounded-full overflow-hidden border-2 border-emerald-500">
                                    <span class="block h-full w-full bg-cover bg-no-repeat bg-center" x-bind:style="'background-image: url(\'' + photoPreview + '\');'"></span>
                                </div>
                                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 rounded-full transition-all flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white opacity-0 group-hover:opacity-100" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-gray-900">Foto Profil</h3>
                                <button type="button" class="text-xs font-semibold text-emerald-600 hover:text-emerald-500" x-on:click.prevent="$refs.photo.click()">Ubah Foto</button>
                                @error('photo')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                            <input type="text" name="name" x-model="name" required class="w-full border-gray-300 rounded-lg focus:ring-islamic-emerald focus:border-islamic-emerald">
                            @error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">No. HP</label>
                            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" required class="w-full border-gray-300 rounded-lg focus:ring-islamic-emerald focus:border-islamic-emerald">
                            @error('phone')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                            <select name="role" required class="w-full border-gray-300 rounded-lg focus:ring-islamic-emerald focus:border-islamic-emerald">
                                <option value="student" {{ old('role', $user->role) === 'student' ? 'selected' : '' }}>Siswa</option>
                                <option value="teacher" {{ old('role', $user->role) === 'teacher' ? 'selected' : '' }}>Guru</option>
                                <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                            @error('role')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Gender</label>
                            <select name="gender" class="w-full border-gray-300 rounded-lg focus:ring-islamic-emerald focus:border-islamic-emerald">
                                <option value="">Pilih Gender</option>
                                <option value="male" {{ old('gender', $user->gender) === 'male' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="female" {{ old('gender', $user->gender) === 'female' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>

                        <div class="pt-4 border-t border-gray-200">
                            <p class="text-sm text-gray-500 mb-4">Kosongkan password jika tidak ingin mengubah</p>
                            
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
                                    <input type="password" name="password" class="w-full border-gray-300 rounded-lg focus:ring-islamic-emerald focus:border-islamic-emerald">
                                    @error('password')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                                    <input type="password" name="password_confirmation" class="w-full border-gray-300 rounded-lg focus:ring-islamic-emerald focus:border-islamic-emerald">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex gap-3 mt-6">
                        <a href="{{ route('admin.users.index') }}" class="flex-1 px-4 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium text-center transition-colors">
                            Batal
                        </a>
                        <button type="submit" class="flex-1 px-4 py-2.5 bg-islamic-emerald text-white rounded-lg hover:bg-islamic-emerald-dark font-medium transition-colors">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
