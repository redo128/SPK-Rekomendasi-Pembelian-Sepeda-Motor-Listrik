@extends('Layouts.index')
@section('content')
<h5 class="card-title">List Favorit</h5>

<!-- Default Table -->
<table class="table">
  <thead>
    <tr>
      <th scope="col">No</th>
      <th scope="col">Nama Sepeda</th>
      <th scope="col">Tipe</th>
      <th scope="col">Toko</th>
      <th scope="col">Merek</th>
      @foreach($spek as $data)
      <th scope="col">{{$data->nama_kriteria}}</th>
      @endforeach
    </tr>
  </thead>
  <tbody>
    @foreach($data_sepeda as $angka => $data)
    <tr>
        <th scope="row">{{$angka}}</th>
        @foreach($data_sepeda_all->where('id',$data->alternatif_id) as $angka2 => $data2)
        <td scope="row">{{$data2->nama_sepeda}}</td>
        <td scope="row">{{$data2->tipe}}</td>
        <td scope="row">{{$data2->toko->nama_toko}}</td>
        <td scope="row">{{$data2->brand->nama_brand}}</td>
        @endforeach
        @foreach($data_alternatif->where('alternatif_id',$data->alternatif_id) as $data3)
        <td scope="row">{{$data3->value}}</td>
        @endforeach
    </tr>
    @endforeach
  </tbody>
</table>
@endsection