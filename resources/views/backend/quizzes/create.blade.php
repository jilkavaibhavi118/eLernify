@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Create New Quiz</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('backend.quizzes.store') }}" method="POST" id="crudForm">
                        @csrf
                        @include('backend.quizzes.form', ['quiz' => null])
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
