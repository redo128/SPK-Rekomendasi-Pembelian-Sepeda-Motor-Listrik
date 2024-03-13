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
                    @foreach($data_sepeda as $data)
                    <tr>
                        <th scope="row">{{$data->id}}</th>
                        <td>{{$data->nama_sepeda}}</td>
                        <td>{{$data->brand->nama_brand}}</td>
                        <td>{{$data->toko->nama_toko}}</td>
                        @foreach($sepeda->where('alternatif_id',$data->id) as $data2)
                        <td>{{$data2->value}}</td>
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
                        <th scope="col">Pembagi</th>
                        <td scope="col"></td>
                        <td scope="col"></td>
                        @foreach($tahap_2_pembagi as $data)
                        <td scope="col">{{round($data,3)}}</td>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                @foreach($data_sepeda as $a => $data)
                    <tr>
                        <th scope="col">X</th>
                        <td scope="col"></td>
                        <td scope="col"></td>

                        @foreach($tahap_2_R["Kolom".$a] as $a2 => $data2)
                        <td>{{round($data2,3)}}</td>
                        @endforeach
                    </tr>
                        @endforeach
                </tbody>
            </table>
            <br><br>
            <table class="table">
                <thead>
                    <tr>
                        <td scope="col"></td>
                        <td scope="col"></td>
                        <td scope="col"></td>
                    </tr>
                </thead>
                <tbody>
                @foreach($data_sepeda as $a => $data)
                    <tr>
                        <th scope="col">Y</th>
                        <td scope="col"></td>
                        <td scope="col"></td>
                        <td scope="col"></td>
                        <td scope="col"></td>
                        <td scope="col"></td>
                        @foreach($tahap_2_Y["Kolom".$a] as $a2 => $data2)
                        <td>{{round($data2,3)}}</td>
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
                        @foreach($tahap_3_Solusi_Ideal_Positif as $a => $data)
                        <td>{{$data}}</td>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                <tr>
                        <th scope="col">A-</th>
                        @foreach($tahap_3_Solusi_Ideal_Negatif as $a => $data)
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
                    @foreach($data_sepeda as $angka => $data)
                    <tr>
                        <td>{{$nilai_D_positif["Row".$angka]}}</td>
                        <td>{{$nilai_D_negatif["Row".$angka]}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <br><br>
            <h1>Rank</h1>
            <table class="table">
                <thead>
                    <tr>
                        <th></th>
                        <th>Nilai</th>
                        <th>Rank</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($nilai_preferensi as $a => $data)
                    <tr>
                        <th>V{{$a}}</th>
                        <td>{{$data["Result"]}}</td>
                        <td>{{$data["Rank"]}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
</div>
@endsection