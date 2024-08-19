@extends('Layouts.index')
@section('content')
<div class="container">
        <div class="row">
            <h1>Ranking Preferensi</h1>
            <table class="table">
                <thead>
                    <tr>
                    <th scope="col">Gambar</th>
                    <th scope="col">Nama Kendaraan</th>
                        <th scope="col">Brand</th>
                        <th scope="col">Toko</th>
                         @foreach($dinamis_kriteria as $data)
                        <th scope="col">{{$data->kriteria->nama_kriteria}}</th>
                        @endforeach
                        <th>Nilai</th>
                        <th>Rank</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($nilai_preferensi["sepeda motor listrik"] as $a => $data)
                    <tr>
                        @foreach($data_sepeda->where('id', $data["id"]) as $a2 => $data2)
                        <td scope="row"><img src="{{asset('storage/'.$data2->image)}}" width="100px"  height="100px" alt=""></td>
                        <td>{{$data2->nama_sepeda}}</td>
                        <td>{{$data2->brand->nama_brand}}</td>
                        <td>{{$data2->toko->nama_toko}}</td>
                        @foreach($sepeda->where('alternatif_id',$data2->id) as $a3 => $data3)
                        @if($data3->kriteria->nama_kriteria == "kecepatan" )
                                <td>{{number_format($data3->value,0,",",".")}} KM/h </td> 
                                @elseif($data3->kriteria->nama_kriteria == "jarak tempuh")
                                <td>{{number_format($data3->value,0,",",".")}} KM </td> 
                                @elseif($data3->kriteria->nama_kriteria == "harga" || $data3->kriteria->nama_kriteria == "biaya cas")
                                <td>RP. {{number_format($data3->value,0,",",".")}} </td>
                                @else
                                <td>{{number_format($data3->value,0,",",".")}} </td>
                                @endif
                        @endforeach
                        @endforeach
                        <td>{{number_format($data["Result"],3)}}</td>
                        <td>{{$data["Rank"]}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
</div>

@endsection