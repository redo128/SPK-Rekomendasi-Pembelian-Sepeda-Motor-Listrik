@extends('Layouts.index')
@section('content')
<div class="container" style="background-color: white;">
    <h1>Profil Toko</h1>
    <div class="row">
    <div class="col-6">
    <img src="{{asset('storage/'.$data->image)}}" class="img-thumbnail img-fluid" style="width: 500px;" alt="">
    </div>
    <div class="col-6">
    <h1>Nama Toko : {{$data->nama_toko}}</h1>
    <h1>Alamat : {{$data->alamat}}</h1>
    </div>
</div>
</div>
@endsection