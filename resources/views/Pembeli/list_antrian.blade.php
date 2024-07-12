@extends('Layouts.index')
@section('content')
<div class="row">
  <div class="col-4">
    <h5 class="card-title">List Favorit</h5>
  </div>
  <div class="col-6">

  </div>
  <div class="col-2">
  <!-- <a href="{{route('perhitungan_pembeli',auth()->user()->id)}}"><button type="button" class="btn btn-primary">Ranking Sepeda</button></a> -->
    </div>
</div>

<!-- Default Table -->
<table class="table">
  <thead>
    <tr>
      <th scope="col">No</th>
      <th scope="col">Gambar </th>
      <th scope="col">Nama Sepeda</th>
      <th scope="col">Tipe</th>
      <th scope="col">Toko</th>
      <th scope="col">Merek</th>
      @foreach($spek as $data)
      <th scope="col">{{$data->nama_kriteria}}</th>
      @endforeach
      <th scope="col">delete</th>
    </tr>
  </thead>
  <tbody>
    @foreach($data_sepeda as $angka => $data)
    <tr>
        <th scope="row">{{$angka}}</th>
        @foreach($data_sepeda_all->where('id',$data->alternatif_id) as $angka2 => $data2)
        <td scope="row"><img src="{{asset('storage/'.$data2->image)}}" width="100px"  height="100px" alt=""></td>
        <td scope="row">{{$data2->nama_sepeda}}</td>
        <td scope="row">{{$data2->tipe}}</td>
        <td scope="row"><a href="{{route('toko.show',$data2->toko->id)}}">{{$data2->toko->nama_toko}}</a></td>
        <td scope="row">{{$data2->brand->nama_brand}}</td>
        @endforeach
        @foreach($data_alternatif->where('alternatif_id',$data->alternatif_id) as $data3)
        @if($data3->kriteria->nama_kriteria == "kecepatan" )
                                <td>{{number_format($data3->value,0,",",".")}} KM </td> 
                                @elseif($data3->kriteria->nama_kriteria == "jarak tempuh")
                                <td>{{number_format($data3->value,0,",",".")}} KM </td> 
                                @elseif($data3->kriteria->nama_kriteria == "harga")
                                <td>RP. {{number_format($data3->value,0,",",".")}} </td>
                                @endif
        @endforeach
        <td scope="row">
        <form action="{{ route('list_antrian_delete', $data->id) }}" method="POST">
        @csrf
        @method('DELETE')
        <button class="btn btn-danger" type="submit">Delete</button>
      </form>
        </td>
    </tr>
    @endforeach
  </tbody>
</table>
@endsection