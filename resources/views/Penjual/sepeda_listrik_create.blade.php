@extends('Layouts.index')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-10">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Add Sepeda</h5>
                <!-- General Form Elements -->
                    <form method="POST" action="{{route('sepeda_penjual.store')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <label for="inputText" class="col-sm-3 col-form-label">Nama Sepeda Listrik</label>
                            <div class="col-sm-8">
                                <input type="text" name="nama_sepeda" class="form-control" required>
                            </div>
                            <label for="inputText" class="col-sm-3"> Tipe Sepeda</label>
                                <div class="col-sm-8">
                                    <select name="tipe" class="form-select" required>
                                        <option value="" selected>Open this select menu</option>
                                        <option value="sepeda listrik">Sepeda Listrik</option>
                                        <option value="sepeda motor listrik">Sepeda Motor Listrik</option>
                                    </select>
                                </div>
                            <label for="inputText" class="col-sm-3"> Brand </label>
                                <div class="col-sm-8">
                                    <select name="brand_id" class="form-select" required>
                                        <option value="" selected>Open this select menu</option>
                                        @foreach($brand as $data)
                                        <option value="{{$data->id}}">{{$data->nama_brand}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <!-- <label for="inputText" class="col-sm-3 col-form-label">Harga</label>
                            <div class="col-sm-8">
                                <div class="row">
                                    <div class="col-sm-1">Rp.</div>
                                    <div class="col-sm-11"><input type="text" name="harga" id="harga" class="form-control"></div>
                                </div>
                                
                            </div>
                                <label for="inputText" class="col-sm-3 col-form-label">Kecepatan</label>
                            <div class="col-sm-8">
                                <input type="number" min="0" name="kecepatan" class="form-control">
                            </div>
                                <label for="inputText" class="col-sm-3 col-form-label">jarak tempuh</label>
                            <div class="col-sm-8">
                                <input type="number" min="0" name="jarak tempuh" class="form-control">
                            </div>
                                <label for="inputText" class="col-sm-3 col-form-label">Maksimal Beban</label>
                            <div class="col-sm-8">
                                <input type="number" min="0" name="maksimal beban" max="200" class="form-control">
                            </div> -->
                            @foreach($kriteria as $data)
                            <label for="inputText" class="col-sm-3 col-form-label">{{$data->nama_kriteria}}</label>
                            <div class="col-sm-8">
                                @if($data->nama_kriteria == "harga")
                                <input type="text" min="0" name="value[{{$data->nama_kriteria}}]" id="{{$data->nama_kriteria}}" class="form-control">
                                @else
                                <input type="number" min="0" name="value[{{$data->nama_kriteria}}]" id="{{$data->nama_kriteria}}" class="form-control">
                                @endif
                            </div>
                            @endforeach
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