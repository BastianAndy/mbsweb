@extends('layouts.admin_main')
<script>
  var msg = '{{Session::get('alert')}}';
  var exist = '{{Session::has('alert')}}';
  if(exist){
    alert(msg);
  }
</script>

@section('content')
<!-- Main content -->
<div class="content-wrapper" style="margin-top:10px; max-height:800px !important;">
  <h3 style="margin-left:20px">Laporan Transaksi Tabungan</h3>
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card card-warning card-outline">
          <!-- form start -->
          <form method="POST" action="/bo_tb_rpt_caritransaksi" role="search">
          @csrf
            <div class="card-body">
              <div class="row form-group">
                <div class="mx-auto col-md-3 col-sm-12">
                  <label for="inputDate1">Tanggal Transaksi 1</label>
                  <div class="input-group date" id="idtglnominatif1" data-target-input="nearest">
                    <input type="text" name="tgl_trans1" class="form-control datetimepicker-input" data-target="#idtglnominatif1"/>
                      <div class="input-group-append" data-target="#idtglnominatif1" data-toggle="datetimepicker">
                      <div class="input-group-text">
                          <i class="fa fa-calendar"></i>
                      </div>
                      </div>
                  </div>
                </div>
                <div class="mx-auto col-md-3 col-sm-12">
                  <label for="inputDate1">Tanggal Transaksi 2</label>
                  <div class="input-group date" id="idtglnominatif2" data-target-input="nearest">
                    <input type="text" name="tgl_trans2" class="form-control datetimepicker-input" data-target="#idtglnominatif2"/>
                      <div class="input-group-append" data-target="#idtglnominatif2" data-toggle="datetimepicker">
                      <div class="input-group-text">
                          <i class="fa fa-calendar"></i>
                      </div>
                      </div>
                  </div>
                </div>
              </div>
              <div class="row form-group">
                <div class="col-4" style="margin-left:450px">
                  <button type="submit" class="btn btn-lg btn-warning"><i class="fa fa-search" style="color:white">Cari</i></button>
                </div>
              </div>
            </div>
            <!-- /.card-body -->
          </form>
        </div>
        <!-- /.card -->
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Data Yang Sudah Tercatat</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="example1" class="display" width="100">
              <thead>
              <tr>
                <th>No</th>
                <th>Trans_id</th>
                <th>Kuitansi</th>
                <th>TOB</th>
                <th>No Rekening</th>
                <th>Nama Nasabah</th>
                <th>Jumlah</th>
                <th>Kode Transaksi</th>
                <th>My Kode Trans</th>
              </tr>
              </thead>
              @if(is_null(Auth::user())==false)
              @if(Auth::user()->privilege=='admin')
              <tbody>
              @php($index=0)
              @foreach($tabtran as $values)
              @php($index++)
                <tr>
                  <td>{{ $index}}</td>
                  <td>{{ strtoupper($values->TABTRANS_ID) }}</td>
                  <td>{{ $values->KUITANSI }}</td>
                  <td>{{ $values->TOB}}</td>
                  <td>{{ $values->NO_REKENING}}</td>
                  <td>{{ $values->nasabah[0]->nama_nasabah}}</td>
                  <td>{{ $values->SALDO_TRANS}}</td>
                  <td>{{ $values->KODE_TRANS}}</td>
                  <td>{{ $values->MY_KODE_TRANS}}</td>
                </tr>
              @endforeach
              </tbody>
                @endif
              @else
              <h3>Sesi Anda Telah Habis, Silahkan Login Ulang</h3>
              @endif

            </table>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div>
  
</div>
<!-- /.content -->
@endsection
