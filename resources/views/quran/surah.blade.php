@extends('layouts.app')
@section('title', 'Quran')
@section('content')

<div class="container">
@foreach ($surahs as $surah)
<div class="card p-2">
    <h1>{{ $surah->name_arabic }}</h1>
</div>
@endforeach
</div>

@endsection
