@extends('layouts.admin')

@section('title', 'Edit credential')
@section('eyebrow', 'content / credentials / edit')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.qualifications.index') }}" class="font-mono text-[9px] uppercase tracking-[0.16em] text-slate-500 transition-colors hover:text-matrix">← credentials</a>
        <h2 class="mt-2 text-2xl font-semibold tracking-tight text-slate-100">Edit “{{ $qualification->title }}”</h2>
    </div>

    <form method="POST" action="{{ route('admin.qualifications.update', $qualification) }}">
        @csrf
        @method('PUT')
        @include('admin.qualifications._form', ['qualification' => $qualification])
    </form>
@endsection
