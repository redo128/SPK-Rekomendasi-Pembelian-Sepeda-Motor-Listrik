@extends('Layouts.index')
@section('content')
<div class="container-fluid">
  <div class="row">
  @if($data_sepeda->count()==0)
    <h1>Data Kosong</h1>
  @endif
    @foreach($data_sepeda as $data)
    <div class="col-2">
        <form method="POST" action="{{route('pembeli.custom.sepeda.listrik.store',['data' => $data->id])}}">
        @csrf
        <div class="card-body" style="width: 18rem;">
          <img src="{{asset('storage/'.$data->image)}}" class="card-img-top" width="100px"  height="100px" alt="...">
          <div class="card-body">
            <h5 class="card-title">{{$data->nama_sepeda}}</h5>
            <p class="card-text">Toko: <td><a href="{{route('toko.show',$data->toko->id)}}">{{$data->toko->nama_toko}}</a></td> </p>
            <p class="card-text">Merk : {{$data->brand->nama_brand}}</p>
            @foreach($data_alternatif->where("alternatif_id",$data->id) as $collect)
              @if($collect->kriteria->nama_kriteria == "kecepatan" )
              <p class="card-text" >{{$collect->kriteria->nama_kriteria}} : {{number_format($collect->value,0,",",".")}} KM/h <br></p>
              @elseif($collect->kriteria->nama_kriteria == "jarak tempuh")
              <p class="card-text" >{{$collect->kriteria->nama_kriteria}} : {{number_format($collect->value,0,",",".")}} KM <br></p>
              @elseif($collect->kriteria->nama_kriteria == "harga")
              <p class="card-text" >{{$collect->kriteria->nama_kriteria}} : RP. {{number_format($collect->value,0,",",".")}} <br></p>
              @endif
            @endforeach
            @if($data_katalog->where("alternatif_id",$data->id)->where("user_id",auth()->user()->id)->first()==null)
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