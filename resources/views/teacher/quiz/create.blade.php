<x-layouts.teacher>
    <div class="p-6">
        <div class="max-w-4xl mx-auto">
            <h2 class="text-2xl font-bold mb-6">Buat Quiz untuk: {{ $lesson->title }}</h2>

            <form action="{{ route('teacher.quiz.store') }}" method="POST" x-data="quizBuilder()">
                @csrf
                <input type="hidden" name="lesson_id" value="{{ $lesson->id }}">

                <!-- Quiz Info -->
                <div class="bg-white rounded-lg shadow-sm border p-6 mb-4">
                    <h3 class="font-semibold mb-4">Informasi Quiz</h3>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">Judul Quiz</label>
                        <input type="text" name="title" required class="w-full rounded-md border-gray-300">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">Deskripsi (Opsional)</label>
                        <textarea name="description" rows="2" class="w-full rounded-md border-gray-300"></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">Nilai Minimal Lulus (%)</label>
                        <input type="number" name="passing_score" value="70" min="0" max="100" required class="w-full rounded-md border-gray-300">
                    </div>
                </div>

                <!-- Questions -->
                <div class="bg-white rounded-lg shadow-sm border p-6 mb-4">
                    <h3 class="font-semibold mb-4">Pertanyaan</h3>

                    <template x-for="(question, qIndex) in questions" :key="qIndex">
                        <div class="border rounded-lg p-4 mb-4 bg-gray-50">
                            <div class="flex justify-between items-center mb-3">
                                <h4 class="font-medium">Pertanyaan <span x-text="qIndex + 1"></span></h4>
                                <button type="button" @click="removeQuestion(qIndex)" class="text-red-600 text-sm">Hapus</button>
                            </div>

                            <div class="mb-3">
                                <input type="text" :name="'questions[' + qIndex + '][question]'" x-model="question.question" placeholder="Tulis pertanyaan..." required class="w-full rounded-md border-gray-300">
                            </div>

                            <p class="text-sm font-medium mb-2">Pilihan Jawaban:</p>
                            <template x-for="(option, oIndex) in question.options" :key="oIndex">
                                <div class="flex items-center gap-2 mb-2">
                                    <input type="radio" :name="'questions[' + qIndex + '][correct_option]'" :value="oIndex" x-model="question.correct" required>
                                    <input type="text" :name="'questions[' + qIndex + '][options][' + oIndex + '][text]'" x-model="option.text" placeholder="Pilihan" required class="flex-1 rounded-md border-gray-300">
                                    <button type="button" @click="removeOption(qIndex, oIndex)" class="text-red-600 text-sm">×</button>
                                </div>
                            </template>
                            <button type="button" @click="addOption(qIndex)" class="text-blue-600 text-sm mt-2">+ Tambah Pilihan</button>
                        </div>
                    </template>

                    <button type="button" @click="addQuestion()" class="btn-secondary">+ Tambah Pertanyaan</button>
                </div>

                <div class="flex gap-4">
                    <button type="submit" class="btn-primary">Simpan Quiz</button>
                    <a href="{{ route('teacher.lessons.index') }}" class="btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>

    <script>
    function quizBuilder() {
        return {
            questions: [{
                question: '',
                options: [{text: ''}, {text: ''}],
                correct: 0
            }],
            addQuestion() {
                this.questions.push({
                    question: '',
                    options: [{text: ''}, {text: ''}],
                    correct: 0
                });
            },
            removeQuestion(index) {
                if (this.questions.length > 1) {
                    this.questions.splice(index, 1);
                }
            },
            addOption(qIndex) {
                this.questions[qIndex].options.push({text: ''});
            },
            removeOption(qIndex, oIndex) {
                if (this.questions[qIndex].options.length > 2) {
                    this.questions[qIndex].options.splice(oIndex, 1);
                }
            }
        }
    }
    </script>
</x-layouts.teacher>
