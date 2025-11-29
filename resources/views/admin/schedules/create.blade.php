<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Jadwal Kelas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('admin.schedules.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label for="tahsin_class_id" class="block text-sm font-medium text-gray-700">Kelas</label>
                            <select name="tahsin_class_id" id="tahsin_class_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                <option value="">Pilih Kelas</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}" {{ old('tahsin_class_id') == $class->id ? 'selected' : '' }}>
                                        {{ $class->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('tahsin_class_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="day_of_week" class="block text-sm font-medium text-gray-700">Hari</label>
                            <select name="day_of_week" id="day_of_week" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                <option value="">Pilih Hari</option>
                                <option value="senin" {{ old('day_of_week') == 'senin' ? 'selected' : '' }}>Senin</option>
                                <option value="selasa" {{ old('day_of_week') == 'selasa' ? 'selected' : '' }}>Selasa</option>
                                <option value="rabu" {{ old('day_of_week') == 'rabu' ? 'selected' : '' }}>Rabu</option>
                                <option value="kamis" {{ old('day_of_week') == 'kamis' ? 'selected' : '' }}>Kamis</option>
                                <option value="jumat" {{ old('day_of_week') == 'jumat' ? 'selected' : '' }}>Jumat</option>
                                <option value="sabtu" {{ old('day_of_week') == 'sabtu' ? 'selected' : '' }}>Sabtu</option>
                                <option value="minggu" {{ old('day_of_week') == 'minggu' ? 'selected' : '' }}>Minggu</option>
                            </select>
                            @error('day_of_week')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="time_start" class="block text-sm font-medium text-gray-700">Jam Mulai</label>
                                <input type="time" name="time_start" id="time_start" value="{{ old('time_start') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                @error('time_start')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="time_end" class="block text-sm font-medium text-gray-700">Jam Selesai</label>
                                <input type="time" name="time_end" id="time_end" value="{{ old('time_end') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                @error('time_end')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="week_start_date" class="block text-sm font-medium text-gray-700">Minggu Mulai (Opsional)</label>
                            <input type="date" name="week_start_date" id="week_start_date" value="{{ old('week_start_date', now()->startOfWeek()->format('Y-m-d')) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <p class="mt-1 text-sm text-gray-500">Kosongkan untuk menggunakan minggu ini</p>
                            @error('week_start_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="notes" class="block text-sm font-medium text-gray-700">Catatan (Opsional)</label>
                            <textarea name="notes" id="notes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('notes') }}</textarea>
                            @error('notes')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end gap-4">
                            <a href="{{ route('admin.schedules.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                                Batal
                            </a>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Simpan Jadwal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
