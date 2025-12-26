<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h2 class="text-2xl font-bold mb-2">{{ $quiz->title }}</h2>
                <p class="text-gray-600 mb-6">{{ $quiz->description }}</p>

                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Previous Attempts -->
                @if($attempts->count() > 0)
                    <div class="mb-6 p-4 bg-blue-50 rounded-lg">
                        <h3 class="font-semibold mb-2">Riwayat Percobaan Anda:</h3>
                        @if($bestAttempt)
                            <p class="text-sm mb-2">Skor Terbaik: <strong>{{ $bestAttempt->score }}%</strong> 
                                {!! $bestAttempt->passed ? '<span class="text-green-600">✅ LULUS</span>' : '<span class="text-red-600">❌ Belum Lulus</span>' !!}
                            </p>
                        @endif
                        <p class="text-sm text-gray-600">Total Percobaan: {{ $attempts->count() }}</p>
                    </div>
                @endif

                <!-- Quiz Form -->
                <form action="{{ route('quiz.submit', $quiz) }}" method="POST">
                    @csrf
                    
                    <div class="space-y-6">
                        @foreach($quiz->questions as $question)
                            <div class="border rounded-lg p-4">
                                <p class="font-medium mb-3">{{ $loop->iteration }}. {{ $question->question }}</p>
                                
                                <div class="space-y-2">
                                    @foreach($question->options as $option)
                                        <label class="flex items-center p-2 hover:bg-gray-50 rounded cursor-pointer">
                                            <input type="radio" name="answers[{{ $question->id }}]" value="{{ $option->id }}" required class="mr-3">
                                            <span>{{ $option->option_text }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-6 flex gap-4">
                        <button type="submit" class="btn-primary">Submit Jawaban</button>
                        <a href="{{ route('dashboard') }}" class="btn-secondary">Kembali</a>
                    </div>

                    <p class="text-sm text-gray-500 mt-4">
                        💡 Nilai minimal untuk lulus: <strong>{{ $quiz->passing_score }}%</strong>
                    </p>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
