@extends('layouts.app')

@section('title', ($site['site_name'] ?? 'Portfolio3d').' — '.($site['owner_title'] ?? 'Software Developer & Data Analyst'))

@section('content')
    @include('partials.home.hero')
    @include('partials.home.about')
    @include('partials.home.stack')
    @include('partials.home.projects')
    @include('partials.home.analytics')
    @include('partials.home.services')
    @include('partials.home.experience')
    @include('partials.home.reviews')
    @include('partials.home.contact')
@endsection
