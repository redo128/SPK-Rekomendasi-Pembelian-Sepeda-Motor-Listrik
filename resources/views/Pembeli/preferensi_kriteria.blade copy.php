@extends('Layouts.index')
@section('content')
<div class="container">
    <div class="card">
        <form class="form" method="get" action="{{ route('perhitungan.preferensi.value') }}">
            <div class="card-body">
              <h5 class="card-title">Preferensi Kriteria</h5>
              @foreach($data as $index => $d)
                  <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">{{$d->nama_kriteria}}</label>
                    <div class="col-sm-10">
                      <select id="kriteria-dropdown" name="kriteria[{{$d->id}}]" class="form-select" aria-label="Default select example">
                        <option value="">Pilih Isi Kriteria</option>
                        @foreach($data_rating->where('kriteria_id',$d->id) as $index => $dat)
                        <option value="{{$dat->id}}">{{number_format($dat->min_rating,0,",",".")}} - {{number_format($dat->max_rating,0,",",".")}}</option>
                        @endforeach
                      </select>
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
@endsection