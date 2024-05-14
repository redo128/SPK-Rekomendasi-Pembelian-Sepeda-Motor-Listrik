@extends('Layouts.index')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-8">
<div class="card">
            <div class="card-body">
              <h5 class="card-title">General Form Elements</h5>
              <!-- General Form Elements -->
              <form method="POST" action="{{route('SuperAdmin.bobot_store')}}">
                @csrf
                <label for="inputText" class="col-sm-3"> Kriteria</label>
                                <div class="col-sm-8">
                                    <select name="kriteria_id" class="form-select" required>
                                        <option value="">Select Kriteria</option>
                                        @foreach($kriteria as $index => $d)
                                        <option value="{{$d->id}}">{{$d->nama_kriteria}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <label for="inputText" class="col-sm-3"> Range Kriteria</label>
                                <div class="row">
                                    <div class="col">
                                        <input type="number" name="min_rating" class="form-control"  placeholder="Min Rating" required aria-label="Min Rating">
                                    </div>
                                    <div class="col">
                                        <input type="number" name="max_rating" class="form-control"  placeholder="Max Rating" required aria-label="Max Rating">
                                    </div>
                                </div>
                                <label for="inputText" class="col-sm-3">Value</label>
                                <input type="number" name="value" class="form-control" min=0 max=5>
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