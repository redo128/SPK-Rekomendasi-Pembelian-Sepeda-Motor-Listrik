@extends('Layouts.index')
@section('content')
<div class="container">
    <h1>List Toko</h1>
    <div class="row">
        <div class="col-10">

        </div>
        <div class="col-2">
            <a href="{{route('toko.create')}}"><button type="button" class="btn btn-primary">Tambah Data</button></a>
            <br><br>
        </div>

<table class="table">
  <thead>
    <tr>
      <th scope="col">No</th>
      <th scope="col">Gambar Toko</th>
      <th scope="col">Nama Toko</th>
      <th scope="col">Alamat Toko</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
    <tr>
    @foreach($index as $data)
      <th scope="row">{{$data->id}}</th>
      <th scope="row"><img src="{{asset('storage/'.$data->image)}}" class="img-thumbnail" style="width:100px" alt=""></th>
      <td>{{$data->nama_toko}}</td>
      <td>{{$data->alamat}}</td>
      <td>
      <form action="{{ route('toko.destroy', $data->id) }}" method="POST">
    @csrf
    @method('DELETE')
    <a href="{{route('toko.edit',$data->id)}}" class="btn btn-success">Edit</a>
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