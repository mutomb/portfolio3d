@extends('layouts.admin')

@section('title', 'New review')
@section('eyebrow', 'content / reviews / create')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.reviews.index') }}" class="font-mono text-[9px] uppercase tracking-[0.16em] text-slate-500 transition-colors hover:text-matrix">← reviews</a>
        <h2 class="mt-2 text-2xl font-semibold tracking-tight text-slate-100">Add a review</h2>
    </div>

    <form method="POST" action="{{ route('admin.reviews.store') }}" enctype="multipart/form-data">
        @csrf
        @include('admin.reviews._form', ['review' => null])
    </form>
@endsection
