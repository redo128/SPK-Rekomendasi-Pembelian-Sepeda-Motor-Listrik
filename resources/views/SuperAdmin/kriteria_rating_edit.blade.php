@extends('Layouts.index')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-8">
<div class="card">
            <div class="card-body">
              <h5 class="card-title">Edit Form</h5>
              <!-- General Form Elements -->
              <form method="POST" action="{{route('SuperAdmin.bobot_update',$data->id)}}">
              @method('PUT')
                @csrf
                <label for="inputText" class="col-sm-3"> Kriteria</label>
                                <div class="col-sm-8">
                                    <select name="kriteria_id" class="form-select" required>
                                        @foreach($kriteria as $index => $d)
                                        <option value="{{$d->id}}" {{$d->id==$data->kriteria_id ? 'selected':''}}>{{$d->nama_kriteria}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <label for="inputText" class="col-sm-3"> Range Kriteria</label>
                                <div class="row">
                                    <div class="col">
                                        <input type="number" name="min_rating" class="form-control" value="{{$data->min_rating}}" placeholder="Min Rating" aria-label="Min Rating">
                                    </div>
                                    <div class="col">
                                        <input type="number" name="max_rating" class="form-control" value="{{$data->max_rating}}" placeholder="Max Rating" aria-label="Max Rating">
                                    </div>
                                </div>
                                <label for="inputText" class="col-sm-3">Value</label>
                                <input type="number" name="value" class="form-control" value="{{$data->value}}" min=0 max=5>
                  <div class="col-sm-10">
                    <br>
                    <button type="submit" class="btn btn-primary">Submit Form</button>
                  </div>
              </form><!-- End General Form Elements -->
            </div>
          </div>

        </div>
        </div>
    </div>
    
@endsection