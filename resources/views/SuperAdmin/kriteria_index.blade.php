@extends('Layouts.index')
@section('content')
<div class="container">
    <h1>List Kriteria</h1>
    <div class="row">
        <div class="col-10">

        </div>
        <div class="col-2">
            <a href="{{route('kriteria.create')}}"><button type="button" class="btn btn-primary">Tambah Data</button></a>
            <br><br>
        </div>

<table class="table">
  <thead>
    <tr>
      <th>No</th>
      <th>Nama Kriteria</th>
      <th>Type Kriteria</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
    <tr>
    @foreach($index as $data)
      <th scope="row">{{$data->id}}</th>
      <td>{{$data->nama_kriteria}}</td>
      <td>{{$data->type}}</td>
      <td>
      <form action="{{ route('kriteria.destroy', $data->id) }}" method="POST">
    @csrf
    @method('DELETE')
    <a href="{{route('kriteria.edit',$data->id)}}" class="btn btn-success">Edit</a>
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