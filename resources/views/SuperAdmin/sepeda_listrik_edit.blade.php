@extends('Layouts.index')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-10">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Edit Data Sepeda</h5>
                <!-- General Form Elements -->
                    <form method="POST" action="{{route('sepeda_sa.update',$data->id)}}"  enctype="multipart/form-data">
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
                            <label for="inputText" class="col-sm-3"> Toko </label>
                                <div class="col-sm-8">
                                    <select name="toko_id" class="form-select" required>
                                        <option value="" selected>Open this select menu</option>
                                        @foreach($toko as $oop)
                                        <option value="{{$oop->id}}" {{$oop->id==$data->toko_id?'selected':''}}>{{$oop->nama_toko}}</option>
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
                        <div class="row mb-3">
                <label for="inputText" class="col-sm-3 col-form-label">Image</label>
                <div class="col-sm-8">
                    <input class="form-control" type="file" name="image" >
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
        <script>
         var tanpa_rupiah = document.getElementById('harga');
    tanpa_rupiah.addEventListener('keyup', function(e)
    {
        tanpa_rupiah.value = formatRupiah(this.value);
    });
    
    /* Dengan Rupiah */
    var dengan_rupiah = document.getElementById('dengan-rupiah');
    dengan_rupiah.addEventListener('keyup', function(e)
    {
        dengan_rupiah.value = formatRupiah(this.value, 'Rp. ');
    });
    
    /* Fungsi */
    function formatRupiah(angka, prefix)
    {
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split    = number_string.split(','),
            sisa     = split[0].length % 3,
            rupiah     = split[0].substr(0, sisa),
            ribuan     = split[0].substr(sisa).match(/\d{3}/gi);
            
        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }
        
        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }
    </script>
@endsection