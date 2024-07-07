@extends('Layouts.index')
@section('content')
<h1 style="text-align: center;">Highlight Point </h1>
<div class="row" style="background-color: white;">
    <div class="col-3">
    <img class="img-fluid" src="{{asset('baterai.jpg')}}" alt="Responsive image" width="200">
    </div>
    <div class="col">
    <h2>Apa Itu Battery pada sepeda listrik?</h2>
    <p>Fungsi baterai pada motor konvensional hanya digunakan untuk memberikan suplai ke sistem elektrikal. Sementara di motor listrik, baterai menjadi sumber utama daya atau sebagai penggerak
    </p>
    <p>Baterai Motor Listrik yang umum dijumpai ada 2 jenis yaitu <i>Sealed Lead Acid</i> (SLA) dan Lithium </p>
    </div>
    <div class="col-3">
    <img class="img-fluid" src="{{asset('litium.webp')}}" alt="Responsive image" width="">
    </div>
</div>
<div class="row" style="background-color: white;">
    <div class="col">
        <br>
        <p><strong>Baterai Jenis Sealed Lead Acid (SLA)</strong></p>
        <p>Baterai Jenis SLA jauh lebih murah dan lebih berat. Biasanya motor-motor listrik menggunakan konfigurashi rangkaian seri untuk baterai jenis SLA</p>
        <p>Baterai Jenis SLA dikenal tangguh, kuat, dan tahan lama. Ditambah dengan harganya yang murah, baterai jenis ini digemari produsen sebagai sumber daya pada motor listrik</p>
    </div>
    <div class="col">
        <br>
        <p><strong>Baterai Jenis Lithium</strong></p>
        <p>Lithium berbentuk silindrikal ( tabung ) dan berukuran kecil. Satu unit baterai jenis ini biasanya digunakan untuk senter </p>
        <p>Pada motor listrik, baterai lithium menggunakan konfigurashi rangkaian paralel, dimana satu rangkaian bisa mengandung puluhan hingga ratusan baterau</p>
        <p>Baterai jenis ini diminati karena kualitasnya dan umu dijumpai pada motor listrik menengah ke atas</p>
        <p>Baterai lithium juga lebih bagus dan lebih kompak dibandingkan baterai SLA. Umur pemakaiannya panjang dan bisa menyimpan daya listrik lebih banyak. Baterai jenis juga digunakan pdaa aproduk Tesla</p>
    </div>
</div>
@endsection