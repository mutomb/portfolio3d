@extends('layouts.admin')

@section('title', 'Edit review')
@section('eyebrow', 'content / reviews / edit')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.reviews.index') }}" class="font-mono text-[9px] uppercase tracking-[0.16em] text-slate-500 transition-colors hover:text-matrix">← reviews</a>
        <h2 class="mt-2 text-2xl font-semibold tracking-tight text-slate-100">Edit review from {{ $review->client_name }}</h2>
    </div>

    <form method="POST" action="{{ route('admin.reviews.update', $review) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('admin.reviews._form', ['review' => $review])
    </form>
@endsection
