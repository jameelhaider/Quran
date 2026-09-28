@extends('layouts.app')

@section('title', 'Quran')

@section('content')

<div class="quran-page">

    {{-- ============ HERO ============ --}}
    <div class="quran-hero">
        <div class="quran-hero__pattern"></div>
        <div class="container position-relative py-5">
            <div class="text-center text-white" data-aos="fade-up">
                <h1 class="quran-hero__arabic">القرآن الكريم</h1>
                <h3 class="quran-hero__sub">The Holy Quran</h3>
                <p class="quran-hero__desc mx-auto">
                    Complete Quran with Surahs, Juz, Ayahs and translations —
                    read the way that suits you.
                </p>

                <div class="row justify-content-center mt-4 g-3">
                    <div class="col-6 col-md-3">
                        <div class="quran-stat">
                            <h2>{{ $quran->surahs->count() }}</h2>
                            <small>Surahs</small>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="quran-stat">
                            <h2>{{ $quran->juzs->count() }}</h2>
                            <small>Juz</small>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="quran-stat">
                            <h2>6236</h2>
                            <small>Ayaat</small>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="quran-stat">
                            <h2>7</h2>
                            <small>Manzil</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <svg class="quran-hero__wave" viewBox="0 0 1440 90" preserveAspectRatio="none">
            <path d="M0,32 C240,80 480,0 720,24 C960,48 1200,88 1440,40 L1440,100 L0,100 Z"></path>
        </svg>
    </div>

    <div class="container quran-body">

        {{-- ============ CONTROL BAR ============ --}}
        <div class="quran-controls card border-0 shadow-sm rounded-4 mb-4" data-aos="fade-up">
            <div class="card-body p-4">
                <div class="row g-3 align-items-center">

                    <div class="col-lg-4 col-md-6">
                        <label class="quran-label">Browse by</label>
                        <select id="viewMode" class="form-select quran-select">
                            <option value="juz" selected>Juz-wise (1 – 30)</option>
                            <option value="surah">Surah-wise (1 – 114)</option>
                            <option value="manzil">Manzil-wise (1 – 7)</option>
                        </select>
                    </div>

                    <div class="col-lg-5 col-md-6">
                        <label class="quran-label">Search</label>
                        <div class="quran-search">
                            <i class="bi bi-search"></i>
                            <input type="text" id="quranSearch" class="form-control"
                                   placeholder="Search surah name, number or juz...">
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-12">
                        <label class="quran-label d-none d-lg-block">&nbsp;</label>
                        <div class="btn-group w-100 quran-toggle" role="group">
                            <button type="button" class="btn active" data-layout="grid">
                                <i class="bi bi-grid-3x3-gap-fill"></i>
                            </button>
                            <button type="button" class="btn" data-layout="list">
                                <i class="bi bi-list-ul"></i>
                            </button>
                        </div>
                    </div>

                </div>

                {{-- Revelation-type filter chips (only visible in "revelation" mode) --}}
                <div id="revelationChips" class="quran-chips mt-3 d-none">
                    <button class="chip active" data-rev="all">All</button>
                    <button class="chip" data-rev="makki">Makki</button>
                    <button class="chip" data-rev="madani">Madani</button>
                </div>
            </div>
        </div>

        {{-- ============ JUZ VIEW (default) ============ --}}
        <div id="view-juz" class="quran-view">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h4 class="quran-section-title"><i class="bi bi-bookmark-star-fill me-2"></i>Juz 1 – 30</h4>
                <span class="quran-count">{{ $quran->juzs->count() }} parts</span>
            </div>

            <div class="row g-3" id="juzGrid">
                @foreach($quran->juzs as $juz)
                    <div class="col-lg-3 col-md-4 col-6 quran-item" data-search="juz {{ $juz->number }}">
                        <a href="" class="text-decoration-none">
                            <div class="quran-card quran-card--juz">
                                <div class="quran-card__badge">{{ $juz->number }}</div>
                                <h5>Juz {{ $juz->number }}</h5>
                                <small class="text-muted">Part {{ $juz->number }} of 30</small>
                                <div class="quran-card__arrow"><i class="bi bi-arrow-left"></i></div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- ============ SURAH VIEW ============ --}}
        <div id="view-surah" class="quran-view d-none">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h4 class="quran-section-title"><i class="bi bi-book-half me-2"></i>Surahs</h4>
                <span class="quran-count">{{ $quran->surahs->count() }} chapters</span>
            </div>

            <div class="row g-3" id="surahGrid">
                @foreach($quran->surahs as $surah)
                    <div class="col-lg-4 col-md-6 quran-item"
                         data-search="{{ strtolower($surah->name_english) }} {{ $surah->number }}"
                         data-rev="{{ strtolower($surah->revelation_type ?? 'makki') }}">
                        <a href="{{ route('quran.surah', $surah) }}" class="text-decoration-none">
                            <div class="quran-card quran-card--surah">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <span class="quran-num">{{ $surah->number }}</span>
                                        <h5 class="mt-3">{{ $surah->name_english }}</h5>
                                        <small class="text-muted">{{ $surah->total_ayahs }} Ayahs</small>
                                    </div>
                                    <h3 class="quran-arabic">{{ $surah->name_arabic }}</h3>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- ============ MANZIL VIEW ============ --}}
        <div id="view-manzil" class="quran-view d-none">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h4 class="quran-section-title"><i class="bi bi-collection-fill me-2"></i>Manzil</h4>
                <span class="quran-count">7 sections</span>
            </div>
            <div class="row g-3">
                @for($m = 1; $m <= 7; $m++)
                    <div class="col-lg-3 col-md-4 col-6 quran-item" data-search="manzil {{ $m }}">
                        <a href="" class="text-decoration-none">
                            <div class="quran-card quran-card--manzil">
                                <div class="quran-card__badge">{{ $m }}</div>
                                <h5>Manzil {{ $m }}</h5>
                                <small class="text-muted">Weekly portion {{ $m }}</small>
                            </div>
                        </a>
                    </div>
                @endfor
            </div>
        </div>

        {{-- ============ RUKU VIEW (placeholder listing) ============ --}}
        <div id="view-ruku" class="quran-view d-none">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h4 class="quran-section-title"><i class="bi bi-diagram-3-fill me-2"></i>Ruku</h4>
            </div>
            <div class="quran-empty">
                <i class="bi bi-hourglass-split"></i>
                <p>Ruku-wise browsing will appear here once ruku data is linked to a route.</p>
            </div>
        </div>

        {{-- ============ BOOKMARKS VIEW ============ --}}
        <div id="view-bookmarks" class="quran-view d-none">
            <div class="quran-empty" id="bookmarkEmpty">
                <i class="bi bi-bookmark-heart"></i>
                <p>No bookmarks yet. Open any Surah or Juz and save your place to continue reading later.</p>
            </div>
            <div class="row g-3" id="bookmarkGrid"></div>
        </div>

        {{-- ============ NO RESULTS ============ --}}
        <div id="noResults" class="quran-empty d-none">
            <i class="bi bi-emoji-frown"></i>
            <p>No results match your search.</p>
        </div>

    </div>
</div>

{{-- ============ STYLES ============ --}}
<style>
    :root{
        --quran-primary:#0f6e5c;
        --quran-primary-dark:#0a4f42;
        --quran-gold:#c9a24b;
        --quran-bg:#f6f8f7;
        --quran-card:#ffffff;
        --quran-text:#16221f;
        --quran-muted:#6b7a76;
        --quran-radius:1.1rem;
    }

    .quran-page{ background:var(--quran-bg); }

    /* ---------- Hero ---------- */
    .quran-hero{
        position:relative;
        overflow:hidden;
        background:linear-gradient(135deg,var(--quran-primary-dark) 0%,var(--quran-primary) 55%,#12876f 100%);
        padding-bottom:2.5rem;
    }
    .quran-hero__pattern{
        position:absolute; inset:0;
        opacity:.12;
        background-image:
            radial-gradient(circle at 20% 20%, #fff 0, transparent 2px),
            radial-gradient(circle at 80% 40%, #fff 0, transparent 2px),
            radial-gradient(circle at 50% 80%, #fff 0, transparent 2px),
            radial-gradient(circle at 10% 70%, #fff 0, transparent 2px),
            radial-gradient(circle at 90% 90%, #fff 0, transparent 2px);
        background-size:140px 140px;
        animation:drift 30s linear infinite;
    }
    @keyframes drift{ from{ background-position:0 0;} to{ background-position:400px 200px;} }

    .quran-hero__arabic{
        font-family:'Amiri Quran','Amiri','Traditional Arabic',serif;
        font-size:clamp(2.2rem,5vw,3.4rem);
        font-weight:700;
        text-shadow:0 4px 18px rgba(0,0,0,.25);
        letter-spacing:1px;
    }
    .quran-hero__sub{ opacity:.95; font-weight:500; letter-spacing:.5px; }
    .quran-hero__desc{ max-width:560px; opacity:.85; }

    .quran-stat{
        background:rgba(255,255,255,.12);
        backdrop-filter:blur(6px);
        border:1px solid rgba(255,255,255,.18);
        border-radius:1rem;
        padding:1rem .5rem;
        transition:transform .25s ease, background .25s ease;
    }
    .quran-stat:hover{ transform:translateY(-4px); background:rgba(255,255,255,.2); }
    .quran-stat h2{ font-weight:800; margin-bottom:.1rem; color:#fff; }
    .quran-stat small{ color:rgba(255,255,255,.85); letter-spacing:.5px; text-transform:uppercase; font-size:.72rem; }

    .quran-hero__wave{ display:block; width:100%; height:60px; }
    .quran-hero__wave path{ fill:var(--quran-bg); }

    .quran-body{ margin-top:-1.2rem; position:relative; z-index:2; padding-bottom:4rem; }

    /* ---------- Controls ---------- */
    .quran-controls{ background:var(--quran-card); }
    .quran-label{
        font-size:.72rem; font-weight:700; text-transform:uppercase;
        letter-spacing:.6px; color:var(--quran-muted); margin-bottom:.35rem; display:block;
    }
    .quran-select, .quran-search input{
        border-radius:.8rem !important;
        border:1px solid #e3e8e6;
        padding:.65rem 1rem;
    }
    .quran-select:focus, .quran-search input:focus{
        border-color:var(--quran-primary);
        box-shadow:0 0 0 .2rem rgba(15,110,92,.15);
    }
    .quran-search{ position:relative; }
    .quran-search i{
        position:absolute; left:1rem; top:50%; transform:translateY(-50%);
        color:var(--quran-muted);
    }
    .quran-search input{ padding-left:2.4rem; }

    .quran-toggle .btn{
        border:1px solid #e3e8e6;
        color:var(--quran-muted);
        background:#fff;
    }
    .quran-toggle .btn.active{
        background:var(--quran-primary);
        border-color:var(--quran-primary);
        color:#fff;
    }

    .quran-chips{ display:flex; gap:.5rem; flex-wrap:wrap; }
    .chip{
        border:1px solid #e3e8e6; background:#fff; color:var(--quran-muted);
        border-radius:2rem; padding:.35rem 1rem; font-size:.82rem; font-weight:600;
        transition:all .2s ease;
    }
    .chip.active, .chip:hover{ background:var(--quran-primary); border-color:var(--quran-primary); color:#fff; }

    /* ---------- Section headers ---------- */
    .quran-section-title{ font-weight:700; color:var(--quran-text); margin:0; }
    .quran-count{ font-size:.82rem; color:var(--quran-muted); font-weight:600; }

    /* ---------- Cards ---------- */
    .quran-card{
        background:var(--quran-card);
        border-radius:var(--quran-radius);
        box-shadow:0 2px 10px rgba(16,40,34,.06);
        padding:1.2rem;
        height:100%;
        position:relative;
        overflow:hidden;
        transition:transform .25s ease, box-shadow .25s ease, border-color .25s ease;
        border:1px solid transparent;
        opacity:0;
        animation:cardIn .5s ease forwards;
        animation-delay:var(--d,0s);
    }
    @keyframes cardIn{
        from{ opacity:0; transform:translateY(14px); }
        to{ opacity:1; transform:translateY(0); }
    }
    .quran-card:hover{
        transform:translateY(-6px);
        box-shadow:0 14px 30px rgba(15,110,92,.16);
        border-color:rgba(15,110,92,.25);
    }
    .quran-card::before{
        content:"";
        position:absolute; top:0; left:0; height:4px; width:100%;
        background:linear-gradient(90deg,var(--quran-primary),var(--quran-gold));
        transform:scaleX(0); transform-origin:left;
        transition:transform .3s ease;
    }
    .quran-card:hover::before{ transform:scaleX(1); }

    .quran-card h5{ color:var(--quran-text); font-weight:700; margin-bottom:.15rem; }
    .quran-card small{ color:var(--quran-muted); }

    .quran-card__badge{
        width:42px; height:42px; border-radius:12px;
        background:linear-gradient(135deg,var(--quran-primary),var(--quran-primary-dark));
        color:#fff; display:flex; align-items:center; justify-content:center;
        font-weight:700; margin-bottom:.75rem;
    }
    .quran-num{
        display:inline-block; background:rgba(15,110,92,.1); color:var(--quran-primary);
        font-weight:700; font-size:.8rem; padding:.2rem .55rem; border-radius:.5rem;
    }
    .quran-arabic{ color:var(--quran-primary-dark); font-family:'Amiri','Traditional Arabic',serif; }
    .quran-card__arrow{
        position:absolute; bottom:1rem; right:1rem;
        color:var(--quran-gold); opacity:0; transform:translateX(-6px);
        transition:all .25s ease;
    }
    .quran-card:hover .quran-card__arrow{ opacity:1; transform:translateX(0); }

    /* list layout */
    .quran-view.list-layout .quran-item{ flex:0 0 100%; max-width:100%; }
    .quran-view.list-layout .quran-card{ display:flex; align-items:center; gap:1rem; }
    .quran-view.list-layout .quran-card h5{ margin-bottom:0; }

    .quran-item{ transition:opacity .2s ease; }
    .quran-item.is-hidden{ display:none !important; }

    .quran-empty{
        text-align:center; padding:3.5rem 1rem; color:var(--quran-muted);
    }
    .quran-empty i{ font-size:2.4rem; color:var(--quran-gold); display:block; margin-bottom:.75rem; }

    @media (max-width:576px){
        .quran-hero__arabic{ font-size:2rem; }
    }
</style>

{{-- ============ FONTS / ICONS (add once in layout if not already present) ============ --}}
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Amiri:wght@400;700&family=Amiri+Quran&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

{{-- ============ SCRIPT ============ --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const viewMode      = document.getElementById('viewMode');
    const search         = document.getElementById('quranSearch');
    const views          = document.querySelectorAll('.quran-view');
    const revChips       = document.getElementById('revelationChips');
    const noResults      = document.getElementById('noResults');
    const layoutButtons  = document.querySelectorAll('.quran-toggle .btn');

    let activeRevelation = 'all';

    function showView(key) {
        views.forEach(v => v.classList.add('d-none'));
        const target = document.getElementById('view-' + key);
        if (target) target.classList.remove('d-none');
        revChips.classList.toggle('d-none', key !== 'revelation');
        noResults.classList.add('d-none');
        applyFilters();
        // restart card-entry animation on the newly shown view
        if (target) {
            target.querySelectorAll('.quran-card').forEach(c => {
                c.style.animation = 'none';
                void c.offsetWidth;
                c.style.animation = '';
            });
        }
    }

    function applyFilters() {
        const activeView = document.querySelector('.quran-view:not(.d-none)');
        if (!activeView) return;
        const term = search.value.trim().toLowerCase();
        let visibleCount = 0;

        activeView.querySelectorAll('.quran-item').forEach(item => {
            const text = (item.dataset.search || '').toLowerCase();
            const rev  = item.dataset.rev;
            const matchesTerm = term === '' || text.includes(term);
            const matchesRev  = activeRevelation === 'all' || !rev || rev === activeRevelation;
            const visible = matchesTerm && matchesRev;
            item.classList.toggle('is-hidden', !visible);
            if (visible) visibleCount++;
        });

        noResults.classList.toggle('d-none', visibleCount !== 0);
    }

    viewMode.addEventListener('change', e => showView(e.target.value));
    search.addEventListener('input', applyFilters);

    revChips.querySelectorAll('.chip').forEach(chip => {
        chip.addEventListener('click', () => {
            revChips.querySelectorAll('.chip').forEach(c => c.classList.remove('active'));
            chip.classList.add('active');
            activeRevelation = chip.dataset.rev;
            applyFilters();
        });
    });

    layoutButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            layoutButtons.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            const layout = btn.dataset.layout;
            views.forEach(v => v.classList.toggle('list-layout', layout === 'list'));
        });
    });

    // ---- simple localStorage bookmarks (optional, safe no-op if unused) ----
    try {
        const stored = JSON.parse(localStorage.getItem('quran_bookmarks') || '[]');
        const grid = document.getElementById('bookmarkGrid');
        const empty = document.getElementById('bookmarkEmpty');
        if (stored.length && grid) {
            empty.classList.add('d-none');
            grid.innerHTML = stored.map(b => `
                <div class="col-lg-4 col-md-6 quran-item">
                    <a href="${b.url}" class="text-decoration-none">
                        <div class="quran-card">
                            <h5>${b.title}</h5>
                            <small class="text-muted">${b.subtitle || 'Continue reading'}</small>
                        </div>
                    </a>
                </div>`).join('');
        }
    } catch (e) { /* localStorage unavailable — ignore */ }

    // default state
    showView('juz');
});
</script>

@endsection
