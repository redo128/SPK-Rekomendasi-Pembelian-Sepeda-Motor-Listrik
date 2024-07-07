@extends('Layouts.index')
@section('content')
<div class="container">
    <h1>Perhitungan</h1>
        <div class="row">
            
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col"></th>
                            @foreach($index as $data)
                        <th scope="col">{{$data->nama_kriteria}}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        @foreach($index as $angka=> $data)
                        <th scope="row">{{$data->nama_kriteria}}</th>
                        @foreach($simpan["kriteria-".$angka] as $data2)
                        <td>{{$data2}}</td>
                        @endforeach
                    </tr>
                @endforeach
                <tr>
                    <th scope="row">Total per Kolom</th>
                    @foreach($total_per_kolom as $temp)
                    <td>{{$temp}}</td>
                    @endforeach
                </tr>
                </tbody>
            </table>
            <br><br>
            <table class="table">
                <thead>
                    <tr>
                    <th scope="col"></th>
                        @foreach($index as $data)
                    <th scope="col">{{$data->nama_kriteria}}</th>
                    @endforeach
                    <th scope="col">|</th>
                    <th scope="col">Jumlah</th>
                    <th scope="col">Eigen Vektor</th>
                    <th scope="col">Matriks X EV</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($index as $angka=> $data)
                    <tr>
                        <th scope="row">{{$data->nama_kriteria}}</th>
                        @foreach($simpan_normalisasi["kriteria-".$angka] as $data2)
                        <td>{{round($data2,2)}}</td>
                        @endforeach
                        <td>|</td>
                        <td>{{round($total_per_row_normalisasi["Row".$angka],2)}}</td>
                        <td>{{round($average_per_row_normalisasi["Row".$angka],2)}}</td>
                        <td>{{round($MatrixXEv["Row".$angka],2)}}</td>
                    </tr>
                @endforeach
                <tr>
                    <th scope="row">Total per Kolom</th>
                    @foreach($total_per_kolom_normalisasi as $temp)
                    <td>{{$temp}}</td>
                    @endforeach
                </tr>
                </tbody>
            </table>
            <br><br>
            <table class="table">
                <thead>
                    <tr>
                    <th scope="col">n</th>
                    @foreach($ri as $data)
                    <th>{{$data[0]}}</th>
                    @endforeach
                    </tr>
                    <tr>
                    <th scope="col">RI</th>
                    @foreach($ri as $data)
                    <th>{{$data[0]}}</th>
                    @endforeach
                    </tr>
                </thead>
            </table>
            <br><br>
            <table class="table">
                <thead>
                    <tr>
                    <th>N</th>
                    <td>{{$n}}</td>
                    </tr>
                    <tr>
                    <th>N max</th>
                    <td>{{$nMax}}</td>
                    </tr>
                    <tr>
                    <th>CI</th>
                    <td>{{$CI_Konsisten}}</td>
                    </tr>
                    <tr>
                    <th>RI</th>
                    <td>{{$RI_Konsisten[0]}}</td>
                    </tr>
                    <tr>
                    <th>CR</th>
                    <td>{{$CR_Konsisten}}</td>
                    </tr>

                </thead>
            </table>
            <br><br>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col"></th>
                        <th scope="col">Nama Kendaraan</th>
                        <th scope="col">Brand</th>
                        <th scope="col">Toko</th>
                         @foreach($index as $data)
                        <th scope="col">{{$data->nama_kriteria}}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($data_sepeda->where('tipe' ,"==", "sepeda motor listrik") as $data)
                    <tr>
                        <th scope="row">{{$data->id}}</th>
                        <td>{{$data->nama_sepeda}}</td>
                        <td>{{$data->brand->nama_brand}}</td>
                        <td>{{$data->toko->nama_toko}}</td>
                        @foreach($sepeda->where('alternatif_id',$data->id) as $data2)
                        <td>{{number_format($data2->value,0,",",".")}}</td>
                        @endforeach
                    </tr>
                    @endforeach
                    <tr>
                        <th>Bobot</th>
                        <td></td>
                        <td></td>
                        <td></td>
                        @foreach($average_per_row_normalisasi as $angka=> $data)
                        <td>{{round($data,3)}}</td>
                        @endforeach
                    </tr>
                </tbody>
            </table>
            <br><br>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col"></th>
                        <th scope="col">Nama Kendaraan</th>
                        <th scope="col">Brand</th>
                        <th scope="col">Toko</th>
                         @foreach($index as $data)
                        <th scope="col">{{$data->nama_kriteria}}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($data_sepeda->where("tipe","==","sepeda motor listrik") as $a => $data)
                    <tr>
                        <th scope="row">{{$data->id}}</th>
                        <td>{{$data->nama_sepeda}}</td>
                        <td>{{$data->brand->nama_brand}}</td>
                        <td>{{$data->toko->nama_toko}}</td>
                        @foreach($index as $data2)
                        <td>{{$sepeda_normalisasi[$a][$data2->nama_kriteria]}}</td>
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <br><br>
            <h2>R Normalisasi</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Pembagi</th>
                        <td scope="col"></td>
                        <td scope="col"></td>
                        @foreach($index as $data)
                        <td scope="col">{{$data->nama_kriteria}}</td>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                @foreach($sepeda_terbobot_x["sepeda motor listrik"] as $a => $data)
                    <tr>
                        <th scope="col">X</th>
                        <td scope="col"></td>
                        <td scope="col"></td>
                        @foreach($index as $a2 => $data2)
                            <td>{{$data[$data2->nama_kriteria]}}</td>
                        @endforeach
                    </tr>
                @endforeach
                <tr>
                        <th>Bobot</th>
                        <td></td>
                        <td></td>
                        @foreach($total_terbobot_x["sepeda motor listrik"] as $angka=> $data)
                        <td>{{round($data,3)}}</td>
                        @endforeach
                    </tr>
                </tbody>
            </table>
            <h2>R Normalisasi 2s</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Pembagi</th>
                        <td scope="col"></td>
                        <td scope="col"></td>
                        @foreach($index as $data)
                        <td scope="col">{{$data->nama_kriteria}}</td>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                @foreach($sepeda_terbobot_x_2["sepeda motor listrik"] as $a => $data)
                    <tr>
                        <th scope="col">X</th>
                        <td scope="col"></td>
                        <td scope="col"></td>
                            @foreach($index as $a2 => $data2)
                            <td>{{round($data[$data2->nama_kriteria],3)}}</td>
                            @endforeach
                    </tr>
                        @endforeach
                </tbody>
            </table>
            <br><br>
            <h2>Y Normalisasi</h2>
            <table class="table">
                <thead>
                    <tr>
                        <td scope="col"></td>
                        <td scope="col"></td>
                        <td scope="col"></td>
                    </tr>
                </thead>
                <tbody>
                @foreach($sepeda_terbobot_y["sepeda motor listrik"] as $a => $data)
                    <tr>
                        <th scope="col">Y</th>
                        <td scope="col"></td>
                        <td scope="col"></td>
                        @foreach($index as $a2 => $data2)
                        <td>{{round($data[$data2->nama_kriteria],3)}}</td>
                        @endforeach
                    </tr>
                        @endforeach
                </tbody>
            </table>
            <br><br>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">A+</th>
                        @foreach($tahap_3_Solusi_Ideal_Positif["sepeda motor listrik"] as $a => $data)
                        <td>{{$data}}</td>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                <tr>
                        <th scope="col">A-</th>
                        @foreach($tahap_3_Solusi_Ideal_Negatif["sepeda motor listrik"] as $a => $data)
                        <td>{{$data}}</td>
                        @endforeach
                    </tr>
                </tbody>
            </table>
            <br><br>
            Jarak Antara Nilai Terbobot
            <table class="table">
                <thead>
                    <tr>
                        <th>D1+</th>
                        <th>D2+</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data_sepeda->where('tipe' ,"==", "sepeda motor listrik") as $angka => $data)
                    <tr>
                        <td>{{$nilai_D_positif["sepeda motor listrik"][$angka]}}</td>
                        <td>{{$nilai_D_negatif["sepeda motor listrik"][$angka]}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <br><br>
            <h1>Rank</h1>
            <table class="table">
                <thead>
                    <tr>
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
                    @foreach($nilai_preferensi["sepeda motor listrik"] as $a => $data)
                    <tr>
                        @foreach($data_sepeda->where('id', $data["id"]) as $a2 => $data2)
                        <td>{{$data2->nama_sepeda}}</td>
                        <td>{{$data2->brand->nama_brand}}</td>
                        <td>{{$data2->toko->nama_toko}}</td>
                        @foreach($sepeda->where('alternatif_id',$data2->id) as $a3 => $data3)
                        <td>{{number_format($data3->value,0,",",".")}}</td>
                        @endforeach
                        @endforeach
                        <td>{{$data["Result"]}}</td>
                        <td>{{$data["Rank"]}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
</div>

@endsection