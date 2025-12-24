<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.users.index') }}" class="text-gray-500 hover:text-gray-700">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <h2 class="font-bold text-2xl text-gray-900 leading-tight">Tambah User Baru</h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ old('name') }}" required class="w-full border-gray-300 rounded-lg focus:ring-islamic-emerald focus:border-islamic-emerald">
                            @error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">No. HP</label>
                            <input type="text" name="phone" value="{{ old('phone') }}" required class="w-full border-gray-300 rounded-lg focus:ring-islamic-emerald focus:border-islamic-emerald" placeholder="08xxxxxxxxxx">
                            @error('phone')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                            <select name="role" required class="w-full border-gray-300 rounded-lg focus:ring-islamic-emerald focus:border-islamic-emerald">
                                <option value="">Pilih Role</option>
                                <option value="student" {{ old('role') === 'student' ? 'selected' : '' }}>Siswa</option>
                                <option value="teacher" {{ old('role') === 'teacher' ? 'selected' : '' }}>Guru</option>
                                <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                            @error('role')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Gender</label>
                            <select name="gender" class="w-full border-gray-300 rounded-lg focus:ring-islamic-emerald focus:border-islamic-emerald">
                                <option value="">Pilih Gender</option>
                                <option value="male" {{ old('gender') === 'male' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="female" {{ old('gender') === 'female' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                            <input type="password" name="password" required class="w-full border-gray-300 rounded-lg focus:ring-islamic-emerald focus:border-islamic-emerald">
                            @error('password')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" required class="w-full border-gray-300 rounded-lg focus:ring-islamic-emerald focus:border-islamic-emerald">
                        </div>
                    </div>

                    <div class="flex gap-3 mt-6">
                        <a href="{{ route('admin.users.index') }}" class="flex-1 px-4 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium text-center transition-colors">
                            Batal
                        </a>
                        <button type="submit" class="flex-1 px-4 py-2.5 bg-islamic-emerald text-white rounded-lg hover:bg-islamic-emerald-dark font-medium transition-colors">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
