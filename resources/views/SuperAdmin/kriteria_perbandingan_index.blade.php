@extends('Layouts.index')
@section('content')
<div class="container">
    <h1>List Brand</h1>
    <div class="row">
        <div class="col-10">

        </div>
        <div class="col-2">
            <a href="{{route('kriteriaperbandingan.create')}}"><button type="button" class="btn btn-primary">Tambah Data</button></a>
            <br><br>
        </div>

<table class="table">
  <thead>
    <tr>
      <th scope="col"></th>
        @foreach($index as $data)
      <th scope="col">{{$data->nama_kriteria}}</th>
      @endforeach
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
    @foreach($index as $angka=> $data)
    <tr>
      <th scope="row">{{$data->nama_kriteria}}</th>
      @foreach($simpan["kriteria-".$angka] as $data2)
      <td>{{$data2}}</td>
      @endforeach
      <td>
      <form action="{{ route('kriteriaperbandingan.destroy', $data->id) }}" method="POST">
    @csrf
    @method('DELETE')
    <a href="{{route('kriteriaperbandingan.edit',$data->id)}}" class="btn btn-success">Edit</a>
    <button class="btn btn-danger" type="submit">Delete</button>
  </form>
  </td>
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
    @foreach($ri as $index => $data)
    <th>{{$data[0]}}</th>

    @endforeach
  </tr>
  <tr>
    <th scope="col">RI</th>
    @foreach($ri as $index => $data)
    <th>{{$data[0]}}</th>

    @endforeach
  </tr>
  </thead>
</table>
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
</div>
</div>
@endsection