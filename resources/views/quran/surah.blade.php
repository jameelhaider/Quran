@extends('layouts.app')


@section('title',$surah->name_english)


@section('content')


<link href="https://fonts.googleapis.com/css2?family=Amiri+Quran&family=Amiri:wght@400;700&display=swap" rel="stylesheet">


<style>


.quran-page{

    background:
    linear-gradient(
        135deg,
        #fafafa,
        #ffffff
    );

    min-height:100vh;

}



.surah-header{

    background:white;

    border-radius:30px;

    box-shadow:
    0 20px 50px rgba(0,0,0,.08);

}



.arabic-text{


    font-family:'Amiri Quran','Amiri',serif;


    font-size:48px;


    line-height:2.3;


    direction:rtl;


    color:#222;



}



.ayah-card{


    background:white;


    border-radius:35px;


    padding:50px 35px;


    box-shadow:

    0 20px 60px rgba(0,0,0,.08);



    animation:

    fadeSlide .5s ease;



}



@keyframes fadeSlide{


from{

opacity:0;

transform:translateX(50px);

}


to{

opacity:1;

transform:translateX(0);

}


}



.ayah-number{


width:45px;

height:45px;

border-radius:50%;

background:#e43a12;

color:white;

display:flex;

align-items:center;

justify-content:center;

margin:auto;

font-weight:bold;


}



.carousel-control-prev-icon,
.carousel-control-next-icon{


background-color:#e43a12;

border-radius:50%;

padding:20px;


}



@media(max-width:768px){


.arabic-text{

font-size:34px;

line-height:2;

}


.ayah-card{

padding:30px 15px;

}


}


</style>





<div class="quran-page py-5">


<div class="container">



<!-- Header -->


<div class="surah-header p-5 text-center mb-5">


<h1 class="fw-bold">

{{ $surah->name_arabic }}

</h1>


<h2>

{{ $surah->name_english }}

</h2>



<div class="mt-3">


<span class="badge bg-dark">

{{ ucfirst($surah->revelation_type) }}

</span>


<span class="badge bg-secondary">

{{ $surah->total_ayahs }} Ayahs

</span>


</div>



</div>





<!-- Ayah Slider -->


<div id="ayahSlider"
class="carousel slide"
data-bs-ride="false">



<div class="carousel-inner">



@foreach($surah->ayahs as $key=>$ayah)



<div class="carousel-item
{{ $key==0?'active':'' }}">



<div class="ayah-card text-center">



<div class="ayah-number mb-4">

{{ $ayah->ayah_number }}

</div>



<div class="arabic-text">


{{ $ayah->arabic_text }}



</div>





@if($ayah->transliteration)


<hr>


<p class="text-muted fs-5">


{{ $ayah->transliteration }}


</p>


@endif






@if($ayah->translations->count())


<hr>


@foreach($ayah->translations as $translation)


<p class="fs-5">


<strong>

{{ $translation->language->name }}

</strong>


<br>


{{ $translation->translation }}


</p>


@endforeach



@endif




</div>


</div>


@endforeach



</div>





<!-- Controls -->


<button class="carousel-control-prev"
type="button"
data-bs-target="#ayahSlider"
data-bs-slide="prev">


<span class="carousel-control-prev-icon"></span>


</button>



<button class="carousel-control-next"
type="button"
data-bs-target="#ayahSlider"
data-bs-slide="next">


<span class="carousel-control-next-icon"></span>


</button>



</div>



</div>


</div>




@endsection
