@extends('Layouts.index')
@section('content')
<div class="container">
    <h1>List Brand</h1>
    <div class="row">
        <div class="col-10">

        </div>
        <div class="col-2">
            <a href="{{route('sepeda_sa.create')}}"><button type="button" class="btn btn-primary">Tambah Data</button></a>
            <br><br>
        </div>

<table class="table">
  <thead>
    <tr>  
      <th scope="col">No</th>
      <th scope="col">Nama Kendaraan</th>
      <th scope="col">Tipe</th>
      <th scope="col">Toko</th>
      <th scope="col">Brand</th>
      @foreach($kriteria as $a)
      <th scope="col">{{$a->nama_kriteria}}</th>
      @endforeach
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
    @foreach($index as $data)
    <tr>
      <th scope="row">{{$data->id}}</th>
      <td>{{$data->nama_sepeda}}</td>
      <td>{{$data->brand->nama_brand}}</td>
      <td>{{$data->toko->nama_toko}}</td>
      @foreach($sepeda->where('alternatif_id',$data->id) as $data2)
      <td>{{$data2->value}}</td>
      @endforeach
      <td>
      <form action="{{ route('sepeda_sa.destroy', $data->id) }}" method="POST">
    @csrf
    @method('DELETE')
    <a href="{{route('sepeda_sa.edit',$data->id)}}" class="btn btn-success">Edit</a>
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