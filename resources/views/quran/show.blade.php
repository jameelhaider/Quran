@extends('layouts.app')

@section('title', $surah->name_english . ' | ' . $surah->name_arabic)

@section('content')

    @php
        $sizeOptions = [
            'x-small' => 'X-Small',
            'small' => 'Small',
            'normal' => 'Normal',
            'large' => 'Large',
            'x-large' => 'X-Large',
        ];
        $speedOptions = ['0.5', '0.75', '1', '1.25', '1.5', '2', '2.5', '3', '4', '4.5', '5'];
    @endphp
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Amiri+Quran&family=Lateef&family=Noto+Naskh+Arabic&family=Scheherazade+New:wght@400;700&display=swap"
        rel="stylesheet">


    <div class="sr" id="surahPage">

        {{-- ===== Compact header: prev | title | next, then one pill strip ===== --}}
        <header class="sr-head">
            <div class="sr-bar">
                @if ($prevNumber)
                    <a class="sr-nav__btn" href="{{ route('surahs.show', $prevNumber) }}" rel="prev"
                        aria-label="Previous surah">
                        <span aria-hidden="true">&larr;</span><span class="sr-nav__txt">Previous</span>
                    </a>
                @else
                    <span></span>
                @endif

                <div class="sr-title">
                    <h1 class="sr-title__ar lang-arabic" dir="rtl">{{ $surah->name_arabic }}</h1>
                    <p class="sr-title__en mt-3">{{ $surah->number }}. {{ $surah->name_english }}</p>
                </div>

                @if ($nextNumber)
                    <a class="sr-nav__btn" href="{{ route('surahs.show', $nextNumber) }}" rel="next"
                        aria-label="Next surah">
                        <span class="sr-nav__txt">Next</span><span aria-hidden="true">&rarr;</span>
                    </a>
                @else
                    <span></span>
                @endif
            </div>

            @if ($surah->description)
                <p class="sr-desc" title="{{ $surah->description }}">{{ $surah->description }}</p>
            @endif

            <div class="sr-strip">
                <a class="sr-nav__index" href="{{ url('/surahs') }}">&#9776; All surahs</a>
                <dl class="sr-facts">
                    <div>
                        <dt>Revealed</dt>
                        <dd>{{ $details['revelation'] }}</dd>
                    </div>
                    <div>
                        <dt>Ayahs</dt>
                        <dd>{{ $details['total_ayahs'] }}</dd>
                    </div>
                    <div>
                        <dt>Juz</dt>
                        <dd>{{ $details['juz'] }}</dd>
                    </div>
                    <div>
                        <dt>Hizb</dt>
                        <dd>{{ $details['hizb'] }}</dd>
                    </div>
                    <div>
                        <dt>Manzil</dt>
                        <dd>{{ $details['manzil'] ?: '—' }}</dd>
                    </div>
                    <div>
                        <dt>Pages</dt>
                        <dd>{{ $details['pages'] }}</dd>
                    </div>
                    <div>
                        <dt>Sajdah</dt>
                        <dd>
                            @if ($details['sajdah_count'])
                                @foreach ($sajdahAyahs as $n)
                                    <button type="button" class="sr-chip" data-jump="{{ $n }}">Ayah
                                        {{ $n }}</button>
                                @endforeach
                            @else
                                None
                            @endif
                        </dd>
                    </div>
                </dl>
            </div>
        </header>

        {{-- ===== Filters (sticky on large screens only) ===== --}}
        <section class="sr-tools" aria-label="Reading options">
            <div class="sr-tools__row">
                <label class="sr-field">
                    <span>Language</span>
                    <select id="langSelect" class="form-select">
                        @foreach ($languages as $l)
                            <option value="{{ $l['id'] }}" @selected($l['id'] === $lang['id'])>{{ $l['name'] }}</option>
                        @endforeach
                    </select>
                </label>

                <label class="sr-field">
                    <span>Translator</span>
                    <select id="translatorSelect" class="form-select">
                        @foreach ($lang['translators'] as $t)
                            <option value="{{ $t['id'] }}" @selected($t['id'] === $translator['id'])>
                                {{ $t['name'] }}{{ $t['has_data'] ? '' : ' (no translations yet)' }}</option>
                        @endforeach
                    </select>
                </label>

                <div class="sr-field sr-field--jump">
                    <span>Jump to ayah</span>
                    <div class="sr-jump">
                        <input id="jumpInput" type="number" class="form-control" min="1"
                            max="{{ $details['total_ayahs'] }}" placeholder="1–{{ $details['total_ayahs'] }}"
                            inputmode="numeric" aria-label="Ayah number">
                        <button id="jumpBtn" type="button" class="sr-btn">Go</button>
                    </div>
                </div>

                {{-- large screens only: toggles the extra options below --}}
                <label class="sr-opt-btn" for="srOptToggle">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" aria-hidden="true">
                        <circle cx="12" cy="12" r="3" />
                        <path
                            d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 1 1-4 0v-.09a1.65 1.65 0 0 0-1-1.51 1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 1 1 0-4h.09a1.65 1.65 0 0 0 1.51-1 1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33h0a1.65 1.65 0 0 0 1-1.51V3a2 2 0 1 1 4 0v.09a1.65 1.65 0 0 0 1 1.51h0a1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82v0a1.65 1.65 0 0 0 1.51 1H21a2 2 0 1 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z" />
                    </svg>
                    Options
                </label>
            </div>

            <input type="checkbox" id="srOptToggle" class="sr-opt-input" aria-label="Show more options">

            <div class="sr-more">
                <div class="sr-field">
                    <span>Auto scroll</span>
                    <div class="sr-auto">
                        <label class="form-check form-switch m-0">
                            <input class="form-check-input" type="checkbox" id="autoScrollToggle" role="switch">
                            <span class="form-check-label">Enable</span>
                        </label>
                        <select id="autoScrollSpeed" class="form-select form-select-sm" aria-label="Auto scroll speed">
                            @foreach ($speedOptions as $sp)
                                <option value="{{ $sp }}" @selected($sp === '1')>{{ $sp }}x
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="sr-switches">
                    <label class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="toggleTranslit" checked>
                        <span class="form-check-label">Transliteration</span>
                    </label>
                    <label class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="toggleTranslation" checked>
                        <span class="form-check-label">Translation</span>
                    </label>
                </div>




                {{-- font + sizes --}}
                <div class="sr-appearance">
                    <label class="sr-field">
                        <span>Arabic font</span>
                        <select id="arFontSelect" class="form-select" aria-label="Arabic font">
                            <option value="default" selected>Quranic font (Default)</option>
                            {{-- <option value="amiri">Amiri Quran</option> --}}
                            <option value="scheherazade">Scheherazade New</option>
                            <option value="naskh">Noto Naskh Arabic</option>
                            <option value="lateef">Lateef</option>
                        </select>
                    </label>

                    <label class="sr-field">
                        <span>Ayah size</span>
                        <select id="arSizeSelect" class="form-select" aria-label="Ayah font size">
                            @foreach ($sizeOptions as $val => $label)
                                <option value="{{ $val }}" @selected($val === 'normal')>{{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </label>

                    <label class="sr-field">
                        <span>Translation size</span>
                        <select id="tlSizeSelect" class="form-select" aria-label="Translation font size">
                            @foreach ($sizeOptions as $val => $label)
                                <option value="{{ $val }}" @selected($val === 'normal')>{{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </label>

                    <label class="sr-field">
                        <span>Transliteration size</span>
                        <select id="tiSizeSelect" class="form-select" aria-label="Transliteration font size">
                            @foreach ($sizeOptions as $val => $label)
                                <option value="{{ $val }}" @selected($val === 'normal')>{{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </label>
                </div>
            </div>
        </section>

        {{-- ===== Bismillah ===== --}}
        @if ($showBismillah)
            <section class="sr-bismillah">
                <p class="sr-bismillah__ar lang-arabic" dir="rtl">{{ $bismillah }}</p>
                @if ($bismillahTranslation)
                    <p class="sr-bismillah__tl {{ $lang['class'] }}" dir="{{ $lang['rtl'] ? 'rtl' : 'ltr' }}"
                        id="bismillahTranslation">{!! $bismillahTranslation !!}</p>
                @else
                    <p class="sr-bismillah__tl" id="bismillahTranslation" hidden></p>
                @endif
            </section>
        @endif

        {{-- ===== Ayahs ===== --}}
        <main class="sr-ayahs" id="ayahList">
            @foreach ($ayahs as $ayah)
                <article class="ay {{ $ayah->is_sajdah ? 'ay--sajdah' : '' }}" id="ayah-{{ $ayah->ayah_number }}"
                    data-ayah="{{ $ayah->ayah_number }}">
                    <header class="ay__head">
                        <span class="ay__num"
                            title="Surah {{ $surah->number }}, ayah {{ $ayah->ayah_number }}">{{ $ayah->ayah_number }}</span>
                        @if ($ayah->is_sajdah)
                            <span class="ay__sajdah">&#1757; Sajdah</span>
                        @endif
                        <span class="ay__meta">Juz {{ $ayah->juz_number }} &middot; Hizb {{ $ayah->hizb_number }}
                            &middot; Page {{ $ayah->page_number }}</span>
                    </header>

                    <p class="ay__ar lang-arabic" dir="rtl">{{ $ayah->arabic_text }}</p>
                    @if ($ayah->transliteration)
                        <p class="ay__translit lang-english">{!! $ayah->transliteration !!}</p>
                    @endif
                    <div class="ay__tl {{ $lang['class'] }} {{ $ayah->translation ? '' : 'is-missing' }}"
                        dir="{{ $lang['rtl'] ? 'rtl' : 'ltr' }}" data-translation>
                        @if ($ayah->translation)
                            {!! $ayah->translation !!}
                        @else
                            No translation available for this translator.
                        @endif
                    </div>



                </article>
            @endforeach
        </main>

        <button type="button" id="autoScrollStop" class="sr-autofab" hidden>Stop auto scroll</button>

        {{-- ===== Bottom prev/next ===== --}}
        <footer class="sr-nav--bottom">
            @if ($prevNumber)
                <a class="sr-nav__btn" href="{{ route('surahs.show', $prevNumber) }}" rel="prev">
                    <span aria-hidden="true">&larr;</span> Previous surah
                </a>
            @else
                <span></span>
            @endif
            @if ($nextNumber)
                <a class="sr-nav__btn" href="{{ route('surahs.show', $nextNumber) }}" rel="next">
                    Next surah <span aria-hidden="true">&rarr;</span>
                </a>
            @else
                <span></span>
            @endif
        </footer>
    </div>

    <script>
        window.QURAN_PAGE = @json($config);
    </script>

    <script src="{{ asset('customjs/surahshow.js') }}"></script>

@endsection
