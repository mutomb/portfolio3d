@extends('layouts.admin')

@section('title', 'New credential')
@section('eyebrow', 'content / credentials / create')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.qualifications.index') }}" class="font-mono text-[9px] uppercase tracking-[0.16em] text-slate-500 transition-colors hover:text-matrix">← credentials</a>
        <h2 class="mt-2 text-2xl font-semibold tracking-tight text-slate-100">Add a credential</h2>
    </div>

    <form method="POST" action="{{ route('admin.qualifications.store') }}">
        @csrf
        @include('admin.qualifications._form', ['qualification' => null])
    </form>
@endsection
