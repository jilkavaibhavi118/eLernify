<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="title">Quiz Title <span class="text-danger">*</span></label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $quiz->title ?? '') }}"
                required>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="duration">Duration (minutes) <span class="text-danger">*</span></label>
            <input type="number" name="duration" class="form-control"
                value="{{ old('duration', $quiz->duration ?? '') }}" min="1" required>
        </div>
    </div>
    <div class="col-md-12 mt-3">
        <div class="form-group">
            <label for="instructions">Instructions</label>
            <textarea name="instructions" class="form-control" rows="3">{{ old('instructions', $quiz->instructions ?? '') }}</textarea>
        </div>
    </div>
    <div class="col-md-12 mt-3">
        <x-select2_ajax name="lecture_id" :selected="old('lecture_id', $quiz->lecture_id ?? null)" :selectedText="$quiz->lecture->title ?? ''" :required="true" />
    </div>
</div>

<hr class="my-4">

<div class="d-flex justify-content-between align-items-center mb-3">
    <h6>Questions</h6>
    <button type="button" class="btn btn-success btn-sm" id="addQuestion">
        <i class="fa fa-plus"></i> Add Question
    </button>
</div>

<div id="questionsContainer">
    @if ($quiz && $quiz->questions->count() > 0)
        @foreach ($quiz->questions as $index => $question)
            <div class="question-block card mb-3" data-index="{{ $index }}">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="mb-0">Question {{ $index + 1 }}</h6>
                        <button type="button" class="btn btn-danger btn-sm remove-question">Remove</button>
                    </div>

                    <div class="form-group">
                        <label>Question Text <span class="text-danger">*</span></label>
                        <textarea name="questions[{{ $index }}][question_text]" class="form-control" rows="2" required>{{ $question->question_text }}</textarea>
                    </div>

                    <div class="form-group mt-2">
                        <label>Explanation (shown after answer)</label>
                        <textarea name="questions[{{ $index }}][explanation]" class="form-control" rows="2">{{ $question->explanation }}</textarea>
                    </div>

                    <div class="row mt-3">
                        @foreach ($question->options as $optIndex => $option)
                            <div class="col-md-6 mb-2">
                                <div class="input-group">
                                    <div class="input-group-text">
                                        <input type="radio" name="questions[{{ $index }}][correct_option]"
                                            value="{{ $optIndex }}" {{ $option->is_correct ? 'checked' : '' }}
                                            required>
                                    </div>
                                    <input type="text"
                                        name="questions[{{ $index }}][options][{{ $optIndex }}][option_text]"
                                        class="form-control" placeholder="Option {{ $optIndex + 1 }}"
                                        value="{{ $option->option_text }}" required>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</div>

<div class="mt-4">
    <button type="submit" class="btn btn-primary">{{ $quiz ? 'Update Quiz' : 'Create Quiz' }}</button>
    <a href="{{ route('backend.quizzes.index') }}" class="btn btn-secondary">Back</a>
</div>

@push('scripts')
    <script>
        let questionIndex = {{ $quiz && $quiz->questions->count() > 0 ? $quiz->questions->count() : 0 }};

        function getQuestionTemplate(index) {
            return `
        <div class="question-block card mb-3" data-index="${index}">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="mb-0">Question ${index + 1}</h6>
                    <button type="button" class="btn btn-danger btn-sm remove-question">Remove</button>
                </div>
                
                <div class="form-group">
                    <label>Question Text <span class="text-danger">*</span></label>
                    <textarea name="questions[${index}][question_text]" class="form-control" rows="2" required></textarea>
                </div>

                <div class="form-group mt-2">
                    <label>Explanation (shown after answer)</label>
                    <textarea name="questions[${index}][explanation]" class="form-control" rows="2"></textarea>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6 mb-2">
                        <div class="input-group">
                            <div class="input-group-text">
                                <input type="radio" name="questions[${index}][correct_option]" value="0" required>
                            </div>
                            <input type="text" name="questions[${index}][options][0][option_text]" class="form-control" placeholder="Option 1" required>
                        </div>
                    </div>
                    <div class="col-md-6 mb-2">
                        <div class="input-group">
                            <div class="input-group-text">
                                <input type="radio" name="questions[${index}][correct_option]" value="1" required>
                            </div>
                            <input type="text" name="questions[${index}][options][1][option_text]" class="form-control" placeholder="Option 2" required>
                        </div>
                    </div>
                    <div class="col-md-6 mb-2">
                        <div class="input-group">
                            <div class="input-group-text">
                                <input type="radio" name="questions[${index}][correct_option]" value="2" required>
                            </div>
                            <input type="text" name="questions[${index}][options][2][option_text]" class="form-control" placeholder="Option 3" required>
                        </div>
                    </div>
                    <div class="col-md-6 mb-2">
                        <div class="input-group">
                            <div class="input-group-text">
                                <input type="radio" name="questions[${index}][correct_option]" value="3" required>
                            </div>
                            <input type="text" name="questions[${index}][options][3][option_text]" class="form-control" placeholder="Option 4" required>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;
        }

        $(document).ready(function() {
            // Add question
            $('#addQuestion').click(function() {
                $('#questionsContainer').append(getQuestionTemplate(questionIndex));
                questionIndex++;
                updateQuestionNumbers();
            });

            // Remove question
            $(document).on('click', '.remove-question', function() {
                $(this).closest('.question-block').remove();
                updateQuestionNumbers();
            });

            // Update question numbers
            function updateQuestionNumbers() {
                $('.question-block').each(function(index) {
                    $(this).find('h6').text('Question ' + (index + 1));
                });
            }

            // Form submission
            $('#quizForm').submit(function(e) {
                e.preventDefault();

                if ($('.question-block').length === 0) {
                    Swal.fire('Error', 'Please add at least one question', 'error');
                    return;
                }

                let formData = new FormData(this);

                $.ajax({
                    url: $(this).attr('action'),
                    method: $(this).attr('method') || 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        Swal.fire('Success', response.success, 'success').then(() => {
                            window.location.href = response.url;
                        });
                    },
                    error: function(xhr) {
                        let errors = xhr.responseJSON?.errors || {};
                        let errorMsg = Object.values(errors).flat().join('<br>');
                        Swal.fire('Error', errorMsg || 'Something went wrong', 'error');
                    }
                });
            });
        });
    </script>
@endpush
