@extends('Layouts.index')
@section('content')
<div class="container">
    <h1> Dinamis Kriteria</h1>
    @if($status == "kosong")
    <form method="POST" action="{{route('dinamis-kriteria.store')}}">
    @csrf
    <h2>use first time ? press Button below</h2>
    <button type="submit" class="btn btn-primary">Create Fitur</button>
    </form>
    @else
    <form method="POST" action="{{route('dinamis-kriteria.update',$user->id)}}" enctype="multipart/form-data">
        @method('PUT')
            @csrf
        <div class="row">
            @foreach($dinamis_pembeli as $id => $data)
            <div class="col-8">
                <p style="background-color: white; ">{{$data->kriteria->nama_kriteria}}</p>
            </div>
            <div class="col-4">
                <select name="dinamis_kriteria[{{$data->kriteria->nama_kriteria}}]" class="form-select">
                <option value="" selected>Open this select menu</option>
                <option value="tidak dipilih" {{$data->status == "tidak dipilih" ? 'selected' : ''}}>Tidak Dipilih</option>
                <option value="dipilih" {{$data->status == "dipilih" ? 'selected' : ''}}>Dipilih</option>
                </select>
            </div>
            @endforeach
            <br>
            <button type="submit" class="btn btn-primary">Submit Form</button>
        </div>
    </form>
    </div>
    @endif
</div>
@endsection