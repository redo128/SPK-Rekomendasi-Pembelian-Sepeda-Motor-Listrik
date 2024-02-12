@extends('Layouts.index')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-8">
<div class="card">
            <div class="card-body">
              <h5 class="card-title">General Form Elements</h5>
              <!-- General Form Elements -->
              <form method="POST" action="{{route('brand.update',$data->id)}}">
              @method('PUT')
                @csrf
                <div class="row mb-3">
                  <label for="inputText" class="col-sm-2 col-form-label">Nama Brand</label>
                  <div class="col-sm-10">
                    <input type="text" name="nama_brand" class="form-control" value="{{$data->nama_brand}}">
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