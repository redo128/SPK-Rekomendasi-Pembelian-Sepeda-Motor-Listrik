@extends('Layouts.index')
@section('content')
<h5 class="card-title">Default Table</h5>

<!-- Default Table -->
<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Name Kriteria</th>
      <th scope="col">Position</th>
      <th scope="col">Age</th>
      <th scope="col">Start Date</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">1</th>
      <td>Brandon Jacob</td>
      <td>Designer</td>
      <td>28</td>
      <td>2016-05-25</td>
    </tr>
  </tbody>
</table>
@endsection