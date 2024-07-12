@extends('Layouts.index')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-10">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Edit Data User</h5>
                <!-- General Form Elements -->
                    <form method="POST" action="{{route('SuperAdmin.sub.admin.update.password',$data->id)}}">
                    @method('PUT')
                        @csrf
                        <div class="row">
                            <label for="inputText" class="col-sm-3 col-form-label">Password Baru</label>
                            <div class="col-sm-8">
                                <input type="text" name="password" class="form-control">
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