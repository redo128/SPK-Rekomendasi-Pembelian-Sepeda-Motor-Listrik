@extends('Layouts.index')
@section('content')

<!-- Default Table -->
<h1>Hasil Pencarian</h1>
<br>
@if($nilai=="kosong")
<H3>Data tidak  ditemukan</H3>
@elseif($nilai!="kosong")
  @if(count($items) != 1)
            <table class="table table-hover" id="contentDiv" >
              <thead>
                <tr>
                  <th scope="col">Nama Sepeda</th>
                  <th scope="col">Tipe</th>
                  <th scope="col">Toko</th>
                  <th scope="col">Merek</th>
                  @foreach($kriteria_all as $data)
                  <th scope="col">{{$data->nama_kriteria}}</th>
                  @endforeach
                </tr>
              </thead>
              <tbody>
                @foreach($items as $angka => $data)
                <tr>
                    @foreach($sepeda_all->where('id',$data["id"]) as $angka2 => $data2)
                    <td scope="row">{{$data2->nama_sepeda}}</td>
                    <td scope="row">{{$data2->tipe}}</td>
                    <td scope="row">{{$data2->toko->nama_toko}}</td>
                    <td scope="row">{{$data2->brand->nama_brand}}</td>
                    @endforeach
                    @foreach($kriteria_all as $data3)
                    <td scope="row">{{$data[$data3->nama_kriteria]}}</td>
                    @endforeach
                </tr>
                @endforeach
              </tbody>
            </table>
            <h1>Rank</h1>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Nama Sepeda</th>
                        <th scope="col">Tipe</th>
                        <th scope="col">Toko</th>
                        <th scope="col">Merek</th>
                        @foreach($kriteria_all as $data)
                        <th scope="col">{{$data->nama_kriteria}}</th>
                        @endforeach
                        <th>Nilai</th>
                        <th>Rank</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($nilai_preferensi as $a => $data)
                    <tr>
                    @foreach($sepeda_all->where('id',$data["id"]) as $angka2 => $data2)
                  <td scope="row">{{$data2->nama_sepeda}}</td>
                  <td scope="row">{{$data2->tipe}}</td>
                  <td scope="row">{{$data2->toko->nama_toko}}</td>
                  <td scope="row">{{$data2->brand->nama_brand}}</td>
                  @endforeach
                  @foreach($kriteria_all as $kriteria_index => $data_kriteria)
                  <td scope="row">{{$items[$a][$data_kriteria->nama_kriteria]}}</td>
                  @endforeach
                        <td>{{$data["Result"]}}</td>
                        <td>{{$data["Rank"]}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @elseif(count($items) == 1)
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Nama Sepeda</th>
                        <th scope="col">Tipe</th>
                        <th scope="col">Toko</th>
                        <th scope="col">Merek</th>
                        @foreach($kriteria_all as $data)
                        <th scope="col">{{$data->nama_kriteria}}</th>
                        @endforeach
                        <th>Nilai</th>
                        <th>Rank</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $a => $data)
                    <tr>
                    @foreach($sepeda_all->where('id',$data["id"]) as $angka2 => $data2)
                  <td scope="row">{{$data2->nama_sepeda}}</td>
                  <td scope="row">{{$data2->tipe}}</td>
                  <td scope="row">{{$data2->toko->nama_toko}}</td>
                  <td scope="row">{{$data2->brand->nama_brand}}</td>
                  @endforeach
                  @foreach($kriteria_all as $kriteria_index => $data_kriteria)
                  <td scope="row">{{$items[$a][$data_kriteria->nama_kriteria]}}</td>
                  @endforeach
                        <td>1</td>
                        <td>1</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
@endif
@endsection