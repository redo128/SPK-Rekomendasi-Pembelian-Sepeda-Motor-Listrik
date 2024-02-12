@extends('Layouts.index')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-8">
<div class="card">
            <div class="card-body">
              <h5 class="card-title">General Form Elements</h5>
              <!-- General Form Elements -->
              <form method="POST" action="{{route('toko.update',$data->id)}}">
              @method('PUT')
                @csrf
                <div class="row mb-3">
                  <label for="inputText" class="col-sm-2 col-form-label">Nama Toko</label>
                  <div class="col-sm-10">
                    <input type="text" name="nama_toko" class="form-control" value="{{$data->nama_toko}}">
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="inputText" class="col-sm-2 col-form-label">Alamat Toko</label>
                  <div class="col-sm-10">
                    <input type="text" name="alamat_toko" class="form-control" value="{{$data->alamat}}">
                  </div>
                </div>
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