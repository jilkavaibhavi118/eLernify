@props([
    'name' => 'lecture_id',
    'label' => null,
    'selected' => null,
    'selectedText' => '',
    'placeholder' => 'Select Item',
    'required' => false,
    'url' => null,
])

<div class="form-group">
    <label for="{{ $name }}">
        @if ($label)
            {{ $label }}
        @elseif (str_contains($name, 'category'))
            Category
        @elseif (str_contains($name, 'lecture'))
            Lecture
        @else
            {{ ucfirst(str_replace('_', ' ', $name)) }}
        @endif
        @if ($required)
            <span class="text-danger">*</span>
        @endif
    </label>
    <select name="{{ $name }}" id="{{ $name }}"
        class="form-control select2-ajax @error($name) is-invalid @enderror" style="width: 100%;">
        @if ($selected && $selectedText)
            <option value="{{ $selected }}" selected>{{ $selectedText }}</option>
        @endif
    </select>
    @error($name)
        <div class="text-danger mt-1" style="font-size: 0.875rem;">{{ $message }}</div>
    @enderror
</div>

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"
        rel="stylesheet" />
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#{{ $name }}').select2({
                theme: 'bootstrap-5',
                placeholder: '{{ $placeholder }}',
                allowClear: true,
                ajax: {
                    url: '{{ $url ?? route('backend.lectures.search') }}',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            q: params.term,
                            page: params.page || 1
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data.results,
                            pagination: {
                                more: data.pagination.more
                            }
                        };
                    },
                    cache: true
                },
                minimumInputLength: 0
            });
        });
    </script>
@endpush
