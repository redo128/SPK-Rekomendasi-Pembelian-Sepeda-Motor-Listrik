@extends('Layouts.index')
@section('content')
<div class="container">
    <div class="card">
        <form class="form" method="get" action="{{ route('preferensi.value') }}">
            <div class="card-body">
              <h5 class="card-title">General Form Elements</h5>
                  <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Select Kriteria</label>
                    <div class="col-sm-10">
                      <select id="kriteria-dropdown" name="kriteria_id" required class="form-select" aria-label="Default select example">
                        <option value="">Open this select menu</option>
                        <option value="brand">Brand</option>
                        @foreach($data as $dat)
                        <option value="{{$dat->id}}">{{$dat->nama_kriteria}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                    <div class="form-group mb-3">
                      <label for="value-dropdown">Choose Value<i style="color:red">*</i></label>
                      <select id="value-dropdown" name="value_dropdown_id" class="form-control" required> </select>
                    </div>
                  <div class="row mb-3">
                      <label class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-10">
                        <button type="submit" class="btn btn-primary mb-1">Cari Preferensi</button>
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
                  $("#kriteria-dropdown").on("change", function () {
                    var value = this.value;
                    if (value === 'brand'){
                    $("#value-dropdown").html("");
                    $.ajax({
                      url: "{{url('api/value-brand-dropdown')}}",
                      type: "POST",
                      data: {
                        brand_name: value,
                        _token: "{{csrf_token()}}",
                      },
                      dataType: "json",
                      success: function (result) {
                        $("#value-dropdown").html(
                          '<option value="">-- Select Sub Location --</option>'
                        );
                        $.each(result, function (key, value) {
                          $("#value-dropdown").append(
                            '<option value="' +
                              value.id +
                              '">' +
                              value.nama_brand +
                              "</option>"
                          );
                        });
                      },
                    });
                  }else{
                      // $('#value-dropdown').empty();
                      // $('#value-dropdown').append('<option value="88">88</option>');
                      // $('#value-dropdown').append('<option value="99">99</option>');
                      $("#value-dropdown").html("");
                    $.ajax({
                      url: "{{url('api/value-kriteria-dropdown')}}",
                      type: "POST",
                      data: {
                        kriteria_id: value,
                        _token: "{{csrf_token()}}",
                      },
                      dataType: "json",
                      success: function (result) {
                        $("#value-dropdown").html(
                          '<option value="">-- Select Range Harga--</option>'
                        );
                        $.each(result, function (key, value) {
                          $("#value-dropdown").append(
                            '<option value="' +
                              value.id +
                              '">' +
                              value.min_rating +
                              '-'+
                              value.max_rating +
                              "</option>"
                          );
                        });
                      },
                    });
                    }
                  });
              });
        </script>
@endsection