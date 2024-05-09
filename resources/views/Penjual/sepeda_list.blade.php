@extends('Layouts.index')
@section('content')
<div class="container-fluid">
  <div class="row">
  @if($data_sepeda->count()==0)
    <h1>Data Kosong</h1>
    <a href="{{route('sepeda_penjual.create')}}"><button type="button" class="btn btn-primary">Tambah Data</button></a>
  @endif
    @foreach($data_sepeda as $data)
    <div class="col-2">
        <div class="card" style="width: 18rem;">
          <img src="{{asset('images.png')}}" class="card-img-top" alt="...">
          <div class="card-body">
            <h5 class="card-title">{{$data->nama_sepeda}}</h5>
            @foreach($data_alternatif->where("alternatif_id",$data->id) as $collect)
            <p class="card-text" >{{$collect->kriteria->nama_kriteria}} : {{$collect->value}} <br></p>
            @endforeach
          </div>
          <a href="{{route('sepeda_penjual.edit',$data->id)}}" class="btn btn-success">Edit</a>
        </div>
    </div>
    @endforeach
  </div>
</div>
@endsection