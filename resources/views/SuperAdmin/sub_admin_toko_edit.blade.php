@extends('Layouts.index')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-10">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Edit Data User</h5>
                <!-- General Form Elements -->
                    <form method="POST" action="{{route('SuperAdmin.sub.admin.update',$data->id)}}">
                    @method('PUT')
                        @csrf
                        <div class="row">
                            <label for="inputText" class="col-sm-3 col-form-label">Nama User</label>
                            <div class="col-sm-8">
                                <input type="text" value="{{$data->name}}" name="name" class="form-control">
                            </div>
                            <label for="inputText" class="col-sm-3 col-form-label">Email User</label>
                            <div class="col-sm-8">
                                <input type="email" value="{{$data->email}}" name="email" class="form-control">
                            </div>
                            <label for="inputText" class="col-sm-3"> Role User</label>
                                <div class="col-sm-8">
                                    <select name="role" class="form-select" required>
                                        <option value="superadmin" {{$data->role=="superadmin"?'selected':''}}>Super Admin</option>
                                        <option value="penjual" {{$data->role=="penjual"?'selected':''}}>penjual</option>
                                        <option value="pembeli" {{$data->role=="pembeli"?'selected':''}}>pembeli</option>
                                    </select>
                                </div>              
                            <label for="inputText" class="col-sm-3"> Admin Toko</label>
                                <div class="col-sm-8">
                                    <select name="toko_id" class="form-select" required>
                                      @foreach($toko as $d)
                                      <option value="{{$d->id}}" {{$data->toko_id==$d->id?'selected':''}}>{{$d->nama_toko}}</option>
                                      @endforeach
                                    </select>
                                </div>              
                        </div>
                        <br><br>
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">Submit Form</button>
                            </div>
                    </form><!-- End General Form Elements -->
                </div>
          </div>

        </div>
        </div>
    </div>
        </div>
@endsection