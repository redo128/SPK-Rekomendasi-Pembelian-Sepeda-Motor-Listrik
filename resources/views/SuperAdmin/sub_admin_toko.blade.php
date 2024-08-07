@extends('Layouts.index')
@section('content')
<div class="container">
    <h1>List User</h1>
    <div class="row">
        <div class="col-10">

        </div>
        <div class="col-2">
            <!-- <a href="{{route('sepeda_sa.create')}}"><button type="button" class="btn btn-primary">Tambah Data</button></a> -->
            <br><br>
        </div>

<table class="table">
  <thead>
    <tr>  
      <th scope="col">Name</th>
      <th scope="col">Email</th>
      <th scope="col">Role</th>
      <th scope="col">Admin Toko</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
    @foreach($user as $data)
    <tr>
      <td>{{$data->name}}</td>
      <td>{{$data->email}}</td>
      <td>{{$data->role}}</td>
      <td>{{$data->toko->nama_toko}}</td>
      <td>
      <form action="{{ route('SuperAdmin.sub.admin.delete', $data->id) }}" method="POST">
    @csrf
    @method('DELETE')
    <a href="{{route('SuperAdmin.sub.admin.edit',$data->id)}}" class="btn btn-success">Edit</a>
    <a href="{{route('SuperAdmin.sub.admin.edit.password',$data->id)}}" class="btn btn-warning">Change Password</a>
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