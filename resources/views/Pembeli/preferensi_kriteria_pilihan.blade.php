@extends('Layouts.index')
@section('content')
<div class="container-fluid">
  <div class="row">
  @if($data_sepeda->count()==0)
    <h1>Data Kosong</h1>
  @endif
    @foreach($temp_value_id as $index => $data)
    <div class="col-2">
        <form method="POST" action="{{route('pembeli.custom.store',$data->alternatif_id)}}">
        @csrf
        <div class="card" style="width: 18rem;">
          <img src="{{asset('images.png')}}" class="card-img-top" alt="...">
          <div class="card-body">
            <h5 class="card-title">{{$data_sepeda->where("id", $data->alternatif_id)->first()->nama_sepeda}}</h5>
            @foreach($data_alternatif->where("alternatif_id",$data->alternatif_id) as $collect)
            <p class="card-text" >{{$collect->kriteria->nama_kriteria}} : {{$collect->value}} <br></p>
            @endforeach
            @if($data_katalog->where("alternatif_id",$data->alternatif_id)->where("user_id",auth()->user()->id)->first()==null)
              <button type="submit" class="btn btn-primary" title="Tambah Data">Tambah ke List</button>
            @else
            <button type="submit" class="btn btn-primary"  disabled>Telah ditambahkan</button>
            @endif
          </div>
        </div>
      </form>
    </div>
    @endforeach
  </div>
</div>
@endsection