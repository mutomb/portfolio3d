@extends('layouts.admin')

@section('title', 'New skill')
@section('eyebrow', 'content / skills / create')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.skills.index') }}" class="font-mono text-[9px] uppercase tracking-[0.16em] text-slate-500 transition-colors hover:text-matrix">← skills</a>
        <h2 class="mt-2 text-2xl font-semibold tracking-tight text-slate-100">Add a skill</h2>
    </div>

    <form method="POST" action="{{ route('admin.skills.store') }}">
        @csrf
        @include('admin.skills._form', ['skill' => null])
    </form>
@endsection
