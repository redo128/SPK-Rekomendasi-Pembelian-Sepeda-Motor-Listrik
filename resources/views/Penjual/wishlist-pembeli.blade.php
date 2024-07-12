@extends('Layouts.index')
@section('content')
<h1>Wishlist Terbanyak</h1>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Gambar Sepeda</th>
                        <th scope="col">Nama Sepeda</th>
                        <th scope="col">Tipe</th>
                        <th scope="col">Merek</th>
                        @foreach($kriteria_all as $data)
                        <th scope="col">{{$data->nama_kriteria}}</th>
                        @endforeach
                        <th>Sebanyak</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($filter as $a => $data)
                    <tr>
                    @foreach($data_sepeda->where('id',$data["id"]) as $angka2 => $data2)
                    <th scope="row"><img src="{{asset('storage/'.$data2->image)}}" class="img-thumbnail" style="width:100px" alt=""></th>
                  <td scope="row">{{$data2->nama_sepeda}}</td>
                  <td scope="row">{{$data2->tipe}}</td>
                  <td scope="row">{{$data2->brand->nama_brand}}</td>
                  @foreach($kriteria_all as $kriteria_index => $data_kriteria)
                  @if($data_kriteria->nama_kriteria == "kecepatan" )
                    <td>{{number_format($data_sepeda_value->where('alternatif_id',$data2->id)->where('kriteria_id',$data_kriteria->id)->first()->value,0,",",".")}} KM/h </td>
                    @elseif($data_kriteria->nama_kriteria == "jarak tempuh")
                    <td>{{number_format($data_sepeda_value->where('alternatif_id',$data2->id)->where('kriteria_id',$data_kriteria->id)->first()->value,0,",",".")}} KM </td>
                    @elseif($data_kriteria->nama_kriteria == "harga")
                    <td>RP. {{number_format($data_sepeda_value->where('alternatif_id',$data2->id)->where('kriteria_id',$data_kriteria->id)->first()->value,0,",",".")}} </td>
                    @endif
                  @endforeach
                  @endforeach
                  <td>{{$data["value"]}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
@endsection