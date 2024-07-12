@extends('Layouts.index')
@section('content')
<section class="section dashboard">
      <div class="row">
        <!-- Left side columns -->
            <!-- Sales Card -->
            <div class="col-xxl-4 col-md-6">
              <div class="card info-card sales-card">
                <div class="card-body">
                  <h5 class="card-title">Sepeda Motor Listrik <span> <br> Total</span></h5>
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-cart"></i>
                    </div>
                    <div class="ps-3">
                      <h6>{{$data_sepeda}}</h6>
                      <span class="text-success small pt-1 fw-bold"><a href="{{route('sepeda_sa.index')}}">See Detail >>></a></span>
                    </div>
                  </div>
                </div>
              </div>
            </div><!-- End Sales Card -->

            <!-- Brand -->
            <div class="col-xxl-4 col-md-6">
              <div class="card info-card revenue-card">
                <div class="card-body">
                  <h5 class="card-title">Brand<span> <br> Total</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-currency-dollar"></i>
                    </div>
                    <div class="ps-3">
                      <h6>{{$data_brand}}</h6>
                      <span class="text-success small pt-1 fw-bold"><a href="">Total</a></span>

                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Revenue Card -->

            <!-- Customers Card -->
            <div class="col-xxl-4 col-xl-12">

              <div class="card info-card customers-card">
                <div class="card-body">
                  <h5 class="card-title">Toko <span><br> total</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-people"></i>
                    </div>
                    <div class="ps-3">
                      <h6>{{$data_toko}}</h6>
                      <!-- <span class="text-success small pt-1 fw-bold"><a href="">See Detail >>></a></span> -->
                      <span class="text-success small pt-1 fw-bold"><a href="">Totala></span>

                    </div>
                  </div>

            </div><!-- End Customers Card -->
        </div>
        </div>
      </div>
      <div class="col" style="overflow-x:auto;">
        <h2>Last Updated</h2>
        <table class="table table-hover" id="contentDiv" >
              <thead>
                <tr>
                  <th scope="col">Nama Sepeda</th>
                  <th scope="col">Tipe</th>
                  <th scope="col">Toko</th>
                  <th scope="col">Merek</th>
                  @foreach($kriteria_all as $data)
                  <th scope="col">{{$data->nama_kriteria}}</th>
                  @endforeach
                </tr>
              </thead>
              <tbody>
                @foreach($sepeda_lastest as $angka => $data)
                <tr>
                    <td scope="row">{{$data->nama_sepeda}}</td>
                    <td scope="row">{{$data->tipe}}</td>
                    <td><a href="{{route('toko.show',$data->toko->id)}}">{{$data->toko->nama_toko}}</a></td> 
                    <td scope="row">{{$data->brand->nama_brand}}</td>
                    @foreach($kriteria_all as $data2)
                    <td scope="row">{{number_format($sepeda_value->where('alternatif_id',$data->id)->where('kriteria_id',$data2->id)->first()->value,0,",",".")}}</td>
                    @endforeach
                </tr>
                @endforeach
              </tbody>
            </table>
      </div>
      <!-- ROW EXIT -->
    </section>
@endsection