@extends('Layouts.index')
@section('content')
<div class="container">
      <h1>List Kriteria Rating</h1>
      <div class="row">
          <div class="col-10">
          </div>
          <div class="col-2">
              <a href="{{route('SuperAdmin.bobot_create')}}"><button type="button" class="btn btn-primary">Tambah Data</button></a>
              <br><br>
          </div>

          <table class="table">
            <thead>
              <tr>  
                <th scope="col">Kriteria Nama</th>
                <th scope="col">Min Rating</th>
                <th scope="col">Max Rating</th>
                <th scope="col">Value</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($index as $data)
              <tr>
                <td>{{$data->kriteria->nama_kriteria}}</td>
                <td>{{number_format($data->min_rating,0,",",".")}}</td>
                <td>{{number_format($data->max_rating,0,",",".")}}</td>
                <td>{{$data->value}}</td>
                <td>
                <form action="{{ route('SuperAdmin.bobot_edit', $data->id) }}" method="POST">
              @csrf
              @method('DELETE')
              <a href="{{route('SuperAdmin.bobot_delete',$data->id)}}" class="btn btn-success">Edit</a>
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