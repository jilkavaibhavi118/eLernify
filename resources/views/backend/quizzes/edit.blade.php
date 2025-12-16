@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Edit Quiz</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('backend.quizzes.update', $quiz->id) }}" method="POST" id="quizForm">
                        @csrf
                        @method('PUT')
                        @include('backend.quizzes.form', ['quiz' => $quiz])
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
