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
    <tr>
    @foreach($index as $angka=> $data)
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
  </tbody>
</table>
</div>
</div>
@endsection