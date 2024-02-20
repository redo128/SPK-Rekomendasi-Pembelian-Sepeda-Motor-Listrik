@extends('Layouts.index')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-8">
<div class="card">
            <div class="card-body">
              <h5 class="card-title">General Form Elements</h5>
              <!-- General Form Elements -->
              <form method="POST" action="{{route('kriteriaperbandingan.update',$find)}}">
              @method('PUT')
                @csrf
                <table class="table">
                    <thead>
                      <tr>
                        <th></th>
                        @foreach($index as $angka => $data)
                      <th scope="col">{{$data->nama_kriteria}}</th>
                        @endforeach
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th>{{$find->nama_kriteria }}</th>
                      @foreach($index as $angka => $data)
                <th scope="row">
                  <input type="text" name="rating[{{$find->id}}][{{$data->id}}]" class="form-control" value="">
                </th>
                @endforeach
              </tr>
                    </tbody>
                </table>
                  <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary">Submit Form</button>
                  </div>
              </form><!-- End General Form Elements -->
            </div>
          </div>

        </div>
        </div>
    </div>
@endsection