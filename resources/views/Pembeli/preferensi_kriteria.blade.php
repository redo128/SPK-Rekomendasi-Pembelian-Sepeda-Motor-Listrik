@extends('Layouts.index')
@section('content')
<div class="container">
    <div class="card">
        <form class="form" method="get" action="{{ route('perhitungan.preferensi.value') }}">
            <div class="card-body">
              <h5 class="card-title">Preferensi Kriteria</h5>
              <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Tipe Sepeda</label>
                    <div class="col-sm-10">
                      <select id="kriteria" name="kriteria" class="form-select" aria-label="Default select example" required>
                        <option value="">Pilih Tipe</option>
                        <option value="sepeda listrik">Sepeda Listrik</option>
                        <option value="sepeda motor listrik">Sepeda Motor Listrik</option>
                      </select>
                    </div>
                  </div>
              @foreach($data as $index => $d)
                  <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">{{$d->nama_kriteria}}</label>
                    <div class="col-sm-10">
                      <select id="{{$d->id}}" name="data[{{$d->id}}]" class="form-control"></select>
                    </div>
                  </div>
              @endforeach
                  <div class="row mb-3">
                      <label class="col-sm-2 col-form-label">Urutan Data</label>
                        <div class="col-sm-5">
                        <select id="kriteria-dropdown" name="kriteria_order" class="form-select" aria-label="Default select example">
                            <option value="">Pilih Kriteria</option>
                            @foreach($data as $index => $d)
                            <option value="{{$d->nama_kriteria}}">{{$d->nama_kriteria}}</option>
                            @endforeach
                        </select>
                          <!-- <button type="submit" class="btn btn-primary"> <a href="">Next</a></button> -->
                        </div>
                        <div class="col-sm-5">
                        <select id="kriteria-dropdown" name="order" class="form-select" aria-label="Default select example">
                            <option value="ASC">Terendah - Tertinggi</option>          
                            <option value="DESC">Tertinggi - Terendah</option>
                        </select>
                          <!-- <button type="submit" class="btn btn-primary"> <a href="">Next</a></button> -->
                        </div>
                  </div>
                  <div class="row mb-3">
                      <label class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-10">
                        <button type="submit" class="btn btn-primary mb-1">Cari Preferensi Sepeda</button>
                          <!-- <button type="submit" class="btn btn-primary"> <a href="">Next</a></button> -->
                        </div>
                  </div>
                </div>
              </form>
              </div>
            </div>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#kriteria').on('change', function () {
                var kriteria_tipe = this.value;
                $("#1").html('');
                $("#2").html('');
                $("#3").html('');
                $.ajax({
                    url: "{{url('api/kriteria')}}",
                    type: "POST",
                    data: {
                      kriteria_tipe: kriteria_tipe,
                        _token: '{{csrf_token()}}'
                    },
                    dataType: 'json',
                    success: function (result) {
                      var kecepatanOptions = '<option value="null">-- Select Preferensi --</option>';
                      $.each(result.kecepatan, function (key, value) {
                          kecepatanOptions += '<option value="' + value.id + '">' + value.min_rating +' - '+value.max_rating+ '</option>';
                      });

                      var jaraktempuhOptions = '<option value="null">-- Select Preferensi --</option>';
                      $.each(result["jarak tempuh"], function (key, value) {
                          jaraktempuhOptions += '<option value="' + value.id + '">' + value.min_rating +' - '+value.max_rating+ '</option>';
                      });

                      var hargaOptions = '<option value="null">-- Select Preferensi --</option>';
                      $.each(result["harga"], function (key, value) {
                          hargaOptions += '<option value="' + value.id + '">' + new Intl.NumberFormat(["ban", "id"]).format(value.min_rating) +' - '+ new Intl.NumberFormat(["ban", "id"]).format(value.max_rating)+ '</option>';
                      });
                        
                        $('#1').html(kecepatanOptions);
                        $('#2').html(jaraktempuhOptions);
                        $('#3').html(hargaOptions);
                    }
                });
            });
        });
    </script>
@endsection