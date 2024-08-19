@extends('Layouts.index')
@section('content')
<div class="row">
        <h1>Custom Bobot Kriteria</h1>
        <div class="col-3">
            <label for="">Bobot Terkecil Kriteria :</label>
        </div>
        <div class="col-4">
        <form method="POST" action="{{route('dinamis-bobot.store')}}">
        @csrf
        <div class="d-flex">
            <select name="setup_kriteria" class="form-select me-4" aria-label="Default select example">
                <option selected>Open this select menu</option>
                @foreach($dinamis_kriteria as $index => $data)
                <option value="{{$data->kriteria_id}}" {{$data->kriteria_id == $bobot_kriteria_terkecil->kriteria_id ? 'selected' : ''}} >{{$data->kriteria->nama_kriteria}}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
        </div>
</div>
<div class="row mt-3">
    <H1>Table Bobot Perbandingan</H1>
    <div class="col">
    <form method="POST" action="{{route('dinamis-bobot.update',$user->id)}}">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col"></th>
                        @foreach($urutan_kriteria_static as $data)
                            @foreach($dinamis_kriteria->where('kriteria_id',$data) as $data2)
                                <th scope="col">{{$data2->kriteria->nama_kriteria}}</th>
                            @endforeach
                        @endforeach
                </tr>
            </thead>
            <tbody>
            @method('PUT')
            @csrf
                @foreach($urutan_kriteria_static as $angka=> $data)
                    <tr>
                        @foreach($dinamis_kriteria->where('kriteria_id',$data) as $angka2 => $data2)
                            <th scope="col">{{$data2->kriteria->nama_kriteria}}</th>
                        @endforeach
                        @foreach($perbandingan_bobot->where('kriteria_1',$data) as $angka3 => $data2)
                    
                        <td><input type="number" name="table[{{$data}}][{{$data2->kriteria_2}}]" class="form-control border border-primary" min=0 step="0.01" max=9 value="{{$data2->rating}}" required title="Please enter a valid email address"></td>
                    
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
        <div class="col-10">
            <button type="submit" class="btn btn-primary">Submit Form</button>
        </div>
    </form>
</div>
@endsection