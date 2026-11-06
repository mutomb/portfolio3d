@extends('layouts.admin')

@section('title', 'New service')
@section('eyebrow', 'content / services / create')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.services.index') }}" class="font-mono text-[9px] uppercase tracking-[0.16em] text-slate-500 transition-colors hover:text-matrix">← services</a>
        <h2 class="mt-2 text-2xl font-semibold tracking-tight text-slate-100">Add a service</h2>
    </div>

    <form method="POST" action="{{ route('admin.services.store') }}">
        @csrf
        @include('admin.services._form', ['service' => null])
    </form>
@endsection
