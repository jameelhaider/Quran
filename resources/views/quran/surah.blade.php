@extends('layouts.app')

@section('title', 'Surahs')

@section('content')
    <section class="page-head">
        <div class="container">
            <h1 class="page-title">Surahs</h1>
            <p class="page-sub">
                All {{ $stats['total'] }} chapters of the Quran, {{ number_format($stats['ayahs']) }} ayahs,
                {{ $stats['sajdahs'] }} sajdah ayahs. Search by name, number, or manzil, or filter by where it was revealed.
            </p>

            <div class="surah-toolbar">
                <div class="surah-search">
                    <svg class="surah-search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <circle cx="11" cy="11" r="7"></circle>
                        <path d="m20 20-3.5-3.5"></path>
                    </svg>
                    <input id="surahSearch" type="search" class="form-control"
                        placeholder="Search surah name, number, or manzil" autocomplete="off" aria-label="Search surahs">
                </div>

                <div class="surah-filters" role="group" aria-label="Filter by revelation">
                    <button type="button" class="lang-chip active" data-filter="all" aria-pressed="true">All <span
                            class="chip-count">{{ $stats['total'] }}</span></button>
                    <button type="button" class="lang-chip" data-filter="meccan" aria-pressed="false">Meccan <span
                            class="chip-count">{{ $stats['meccan'] }}</span></button>
                    <button type="button" class="lang-chip" data-filter="medinan" aria-pressed="false">Medinan <span
                            class="chip-count">{{ $stats['medinan'] }}</span></button>
                </div>
            </div>
        </div>
    </section>

    <section class="container">
        <p class="surah-result-count" id="surahCount" aria-live="polite">Showing {{ $stats['total'] }} of
            {{ $stats['total'] }} surahs</p>

        <div class="surah-grid" id="surahGrid">
            @foreach ($surahs as $surah)
                <a href="{{ url('/surahs/' . $surah->number) }}" class="surah-card" style="--i: {{ $loop->index % 12 }}"
                    data-type="{{ $surah->revelation }}"
                    data-search="{{ strtolower($surah->number . ' manzil ' . ($surah->manzil_number ?? '') . ' ' . $surah->name_english . ' ' . $surah->name_urdu) }} {{ $surah->name_arabic }}"
                    @if ($surah->description) title="{{ $surah->description }}" @endif>

                    <span class="surah-card-no">{{ $surah->number }}</span>

                    <span class="surah-card-body">
                        <span class="surah-card-en d-block">{{ $surah->name_english }}</span>
                        @if ($surah->name_urdu)
                            <span class="surah-card-sub lang-ur d-block">{{ $surah->name_urdu }}</span>
                        @endif

                        <span class="surah-card-meta">
                            <span
                                class="badge {{ $surah->revelation === 'meccan' ? 'badge-soft' : 'badge-gold' }}">{{ ucfirst($surah->revelation) }}</span>
                            <span class="badge badge-soft">{{ $surah->total_ayahs }} ayahs</span>

                            @if ($surah->first_juz)
                                <span class="badge badge-soft">
                                    Juz
                                    {{ $surah->first_juz }}{{ $surah->last_juz > $surah->first_juz ? '–' . $surah->last_juz : '' }}
                                </span>
                            @endif

                            @if ($surah->manzil_number)
                                <span class="badge badge-soft">Manzil {{ $surah->manzil_number }}</span>
                            @endif

                            @if ($surah->start_page)
                                <span class="badge badge-soft">Page {{ $surah->start_page }}</span>
                            @endif

                            @if ($surah->sajdah_count)
                                <span
                                    class="badge badge-gold">Sajdah{{ $surah->sajdah_count > 1 ? ' ×' . $surah->sajdah_count : '' }}</span>
                            @endif
                        </span>
                    </span>

                    <span class="surah-card-ar lang-ar">{{ $surah->name_arabic }}</span>
                </a>
            @endforeach
        </div>

        <div class="surah-empty" id="surahEmpty" hidden>
            <div class="surah-empty-mark">؟</div>
            <p class="mb-1 fw-semibold" id="surahEmptyText">No surah found</p>
            <p class="mb-3">Try a different name, a surah number, a manzil, or clear the filter.</p>
            <button type="button" class="btn btn-outline-primary" id="surahReset">Clear search and filter</button>
        </div>
    </section>

    <script>
        (function() {
            var grid = document.getElementById('surahGrid');
            var cards = Array.prototype.slice.call(grid.querySelectorAll('.surah-card'));
            var input = document.getElementById('surahSearch');
            var chips = document.querySelectorAll('[data-filter]');
            var count = document.getElementById('surahCount');
            var empty = document.getElementById('surahEmpty');
            var emptyT = document.getElementById('surahEmptyText');
            var reset = document.getElementById('surahReset');
            var state = {
                q: '',
                type: 'all'
            };

            /* ---- entrance animation: reveal cards as they scroll into view ---- */
            if ('IntersectionObserver' in window) {
                grid.classList.add('reveal-ready');
                var io = new IntersectionObserver(function(entries) {
                    entries.forEach(function(e) {
                        if (e.isIntersecting) {
                            e.target.classList.add('is-in');
                            io.unobserve(e.target);
                        }
                    });
                }, {
                    rootMargin: '0px 0px -40px 0px',
                    threshold: 0.05
                });
                cards.forEach(function(c) {
                    io.observe(c);
                });
            }

            /* ---- search + filter ---- */
            function apply() {
                var q = state.q.trim().toLowerCase();
                var shown = 0;

                cards.forEach(function(c) {
                    var okType = state.type === 'all' || c.dataset.type === state.type;
                    var okText = !q || c.dataset.search.indexOf(q) !== -1;
                    var show = okType && okText;
                    c.hidden = !show;
                    if (show) {
                        shown++;
                        c.classList.add('is-in');
                    }
                });

                count.textContent = 'Showing ' + shown + ' of ' + cards.length + ' surahs';
                empty.hidden = shown !== 0;
                emptyT.textContent = q ? 'No surah found for “' + state.q.trim() + '”' : 'No surah found';
            }

            input.addEventListener('input', function() {
                state.q = input.value;
                apply();
            });
            input.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    input.value = '';
                    state.q = '';
                    apply();
                }
            });

            chips.forEach(function(chip) {
                chip.addEventListener('click', function() {
                    state.type = chip.dataset.filter;
                    chips.forEach(function(c) {
                        var on = c === chip;
                        c.classList.toggle('active', on);
                        c.setAttribute('aria-pressed', on ? 'true' : 'false');
                    });
                    apply();
                });
            });

            reset.addEventListener('click', function() {
                input.value = '';
                state = {
                    q: '',
                    type: 'all'
                };
                chips.forEach(function(c) {
                    var on = c.dataset.filter === 'all';
                    c.classList.toggle('active', on);
                    c.setAttribute('aria-pressed', on ? 'true' : 'false');
                });
                apply();
                input.focus();
            });
        })();
    </script>
@endsection
