@extends('Layouts.index')
@section('content')
<div class="container">
    <h1>Perhitungan</h1>
        <div class="row">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Gambar</th>
                        <th scope="col">Nama Kendaraan</th>
                        <th scope="col">Brand</th>
                        <th scope="col">Toko</th>
                         @foreach($index as $data)
                        <th scope="col">{{$data->nama_kriteria}}</th>
                        @endforeach
                        <th>Nilai</th>
                        <th>Rank</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data_sepeda as $angka => $data)
                    <tr>
                        <th scope="row">{{$angka}}</th>
                        @php
                        $gambar=$data_sepeda_all->where("id",$data->alternatif_id)->first()->image;
                        @endphp
                        <th scope="row"><img src="{{asset($gambar)}}" width="100" height="100" alt=""></th>
                        <td>{{$data_sepeda_all->where("id",$data->alternatif_id)->first()->nama_sepeda}}</td>
                        <td>{{$data_sepeda_all->where("id",$data->alternatif_id)->first()->brand->nama_brand}}</td>
                        <td>{{$data_sepeda_all->where("id",$data->alternatif_id)->first()->toko->nama_toko}}</td>
                        @foreach($sepeda->where('alternatif_id',$data->id) as $data2)
                        <td>{{number_format($data2->value,0,",",".")}}</td>
                        @endforeach
                        <td>{{$nilai_preferensi[$angka]["Result"]}}</td>
                        <td>{{$nilai_preferensi[$angka]["Rank"]}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <br><br>
        </div>
</div>
@endsection