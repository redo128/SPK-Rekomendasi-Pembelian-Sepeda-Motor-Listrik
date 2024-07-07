@extends('Layouts.index')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-10">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Add Sepeda</h5>
                <!-- General Form Elements -->
                    <form method="POST" action="{{route('sepeda_penjual.update',$data->id)}}">
                    @method('PUT')
                        @csrf
                        <div class="row">
                            <label for="inputText" class="col-sm-3 col-form-label">Nama Sepeda Listrik</label>
                            <div class="col-sm-8">
                                <input type="text" value="{{$data->nama_sepeda}}" name="nama_sepeda" class="form-control">
                            </div>
                            <label for="inputText" class="col-sm-3"> Tipe Sepeda</label>
                                <div class="col-sm-8">
                                    <select name="tipe" class="form-select" required>
                                        <option value="" selected>Open this select menu</option>
                                        <option value="sepeda listrik" {{$data->tipe=="sepeda listrik"?'selected':''}}>Sepeda Listrik</option>
                                        <option value="sepeda motor listrik" {{$data->tipe=="sepeda motor listrik"?'selected':''}}>Sepeda Motor Listrik</option>
                                    </select>
                                </div>
                            <label for="inputText" class="col-sm-3"> Brand </label>
                                <div class="col-sm-8">
                                    <select name="brand_id" class="form-select" required>
                                        <option value="" selected>Open this select menu</option>
                                        @foreach($brand as $oop)
                                        <option value="{{$oop->id}}" {{$oop->id==$data->brand_id?'selected':''}}>{{$oop->nama_brand}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                @foreach($value as $index => $value_alternatif)
                            <label for="inputText" class="col-sm-3 col-form-label">{{$value_alternatif->kriteria->nama_kriteria}}</label>
                                <div class="col-sm-8">
                                    <input type="text" value="{{$value_alternatif->value}}" name="kriteria[{{$value_alternatif->kriteria->nama_kriteria}}]"  id="{{$value_alternatif->kriteria->nama_kriteria}}" class="form-control">
                                </div>
                                @endforeach            
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