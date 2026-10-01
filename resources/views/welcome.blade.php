@extends('layouts.app')
@section('title', 'Quran')
@section('content')
<section class="hero-quran">
    <div class="container">
        <div class="hero-bismillah">بِسْمِ ٱللَّهِ ٱلرَّحْمَٰنِ ٱلرَّحِيمِ</div>
        <h1 class="hero-title">Read the Quran in your own language</h1>
        <p class="hero-lead">
            Translations in many languages, with several translators for each language,
            so you can read and compare side by side.
        </p>
        <div class="hero-actions">
            {{-- Replace with your named routes --}}
            <a href="{{ url('/surahs') }}" class="btn btn-primary btn-lg px-4">Start reading</a>
            <a href="{{ url('/surahs/1') }}" class="btn btn-outline-primary btn-lg px-4">Browse translations</a>
        </div>

        <div class="hero-langs" aria-label="Available translation languages">
            <span class="lang-chip lang-ar-ui">العربية</span>
            <span class="lang-chip lang-ur">اردو</span>
            <span class="lang-chip lang-en">English</span>
            <span class="lang-chip lang-fr">Français</span>
            <span class="lang-chip lang-bn">বাংলা</span>
            <span class="lang-chip lang-fa">فارسی</span>
            <span class="lang-chip lang-tr">Türkçe</span>
            <span class="lang-chip lang-id">Bahasa Indonesia</span>
            <span class="lang-chip lang-hi">हिन्दी</span>
            <span class="lang-chip lang-ru">Русский</span>
            <span class="lang-chip lang-es">Español</span>
            <span class="lang-chip lang-zh">中文</span>
        </div>

        <div class="hero-stats">
            <div class="hero-stat">
                <span class="hero-stat-num">{{ number_format($totalsurahs) }}</span>
                <span class="hero-stat-label">Surahs</span>
            </div>
            <div class="hero-stat">
                <span class="hero-stat-num">{{ number_format($totalAyahs) }}</span>
                <span class="hero-stat-label">Ayahs</span>
            </div>
            <div class="hero-stat">
                <span class="hero-stat-num">{{ number_format($totalJuzs) }}</span>
                <span class="hero-stat-label">Juz</span>
            </div>
            <div class="hero-stat">
                <span class="hero-stat-num">{{ number_format($totalManzils) }}</span>
                <span class="hero-stat-label">Manzils</span>
            </div>
        </div>

    </div>
</section>

@endsection
