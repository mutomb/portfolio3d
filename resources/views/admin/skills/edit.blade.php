@extends('layouts.admin')

@section('title', 'Edit skill')
@section('eyebrow', 'content / skills / edit')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.skills.index') }}" class="font-mono text-[9px] uppercase tracking-[0.16em] text-slate-500 transition-colors hover:text-matrix">← skills</a>
        <h2 class="mt-2 text-2xl font-semibold tracking-tight text-slate-100">Edit “{{ $skill->name }}”</h2>
    </div>

    <form method="POST" action="{{ route('admin.skills.update', $skill) }}">
        @csrf
        @method('PUT')
        @include('admin.skills._form', ['skill' => $skill])
    </form>
@endsection
