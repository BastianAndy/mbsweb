@extends('layouts.admin_main')

@section('content')

<!-- Main content -->
<div class="content-wrapper" style="margin-top:10px; max-height:800px !important;">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card card-warning card-outline">
          <!-- form start -->
          <form method="POST" action="/bo_cs_de_nasabah/cari" role="search">
          @csrf
            <div class="card-body">
              <div class="row form-group">
                <div class="col-lg-3 col-sm-12">
                  <label for="idnasabah1">Id Nasabah</label> 
                </div>             
                <div class="col-lg-5 col-sm-12">
                  <input type="text" class="form-control" id="idnasabah1" name="idnasabah1" placeholder="Masukkan ID Nasabah">
                </div>
              </div>
              <div class="row form-group">
                <div class="col-lg-3 col-sm-12">
                  <label for="namanasabah1">Nama Nasabah</label>
                </div>             
                <div class="col-lg-5 col-sm-12">
                  <input type="text" class="form-control" id="namanasabah1" name="namanasabah1" placeholder="Masukkan Nama Nasabah">
                </div>
              </div>
              <div class="row form-group">
                <div class="col-lg-3 col-sm-12">
                  <label for="jenisnasabah1">Jenis Nasabah</label>
                </div>             
                <div class="col-lg-5 col-sm-12">
                  <input type="text" class="form-control" id="jenisnasabah1" name="jenisnasabah1" placeholder="Masukkan Jenis Nasabah">
                </div>
              </div>
              <div class="row form-group">
                <div class="col-3"></div>
                <div class="col-3">
                  <button type="submit" class="btn btn-warning"><i class="fa fa-search" style="color:white"></i></button>
                </div>
              </div>
            </div>
            <!-- /.card-body -->
          </form>
        </div>
        <!-- /.card -->
        <div class="card">
          <div class="card-header">
            <div class="col-lg-3 col-sm-3" style="float:right;">
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-add-nasabah" style="float: right;">
                <i class="fa fa-plus"></i>
              </button>
            </div>
            <h3 class="card-title">Data Nasabah</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="example1" class="table table-bordered table-hover">
              <thead>
              <tr>
                <th>No</th>
                <th>Nasabah ID</th>
                <th>Nama Nasabah</th>
                <th>Alamat</th>
                <th>TTL</th>
                <th>Jenis Kelamin</th>
                <th>Ibu Kandung</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
              </thead>
              <tbody>
                @foreach($nasabahs as $index => $nasabah)
                  @if($nasabah->Black_List==0)
                    @php ($status='Aktif')
                  @elseif($nasabah->Black_List==1)
                    @php ($status='Blokir')
                  @else
                    @php ($status='Tidak Aktif')
                  @endif
                  @if($nasabah->tgllahir==NULL)
                    @php ($tgllahir='')
                  @else
                    @php ($tgllahir=$nasabah->tgllahir->format('d/m/Y'))
                  @endif
                <tr>
                  <td>{{ $index+1 }}</td>
                  <td>{{ strtoupper($nasabah->nasabah_id) }}</td>
                  <td>{{ $nasabah->nama_nasabah }}</td>
                  <td>{{ strtoupper($nasabah->alamat.' '.$nasabah->kelurahan.' '.$nasabah->kecamatan) }}</td>
                  <td>{{ $nasabah->tempatlahir.', '.$tgllahir }}</td>
                  <td>{{ $nasabah->jenis_kelamin }}</td>
                  <td>{{ $nasabah->ibu_kandung }}</td>
                  <td>{{ $status }}</td>
                  <td>
                    <!-- <form action="#" method="post">
                       <button type="submit" class="btn btn-block bg-gradient-gray btn-sm">
                        Action
                       <i class="right fas fa-angle-down"></i>
                       </button>
                    </form> -->
                    <a class="dropdown-toggle btn btn-block bg-gradient-primary btn-sm" data-toggle="dropdown" href="#">
                      Action <span class="caret"></span>
                    </a>
                    <div class="dropdown-menu">
                      <form action="/adm_nasabah_detail" method="post" style="margin-bottom: 0;">
                          <button type="submit" tabindex="-1" class="dropdown-item">
                            Detail
                          </button>
                          <input type="hidden" name="inputIdTransaction" value="{{ $nasabah->nasabah_id }}" class="form-control">
                          @csrf
                      </form>
                      <a href="#" tabindex="-1" class="dropdown-item" data-toggle="modal" data-target="#modal-edit-transaction">
                          Edit
                      </a>
                      <form action="/adm_transaction" method="post"  style="margin-bottom: 0;" onclick="return confirm('Apakah anda yakin akan menghapus data ini?')">
                          <button type="submit" tabindex="-1" class="dropdown-item">
                            Delete
                          </button>
                          <input type="hidden" name="inputIdTransaction" value="{{ $nasabah->nasabah_id }}" class="form-control">
                          <input type="hidden" name="_method" value="DELETE"/>
                          @csrf
                      </form>
                    </div>
                  </td>
                </tr>
                @endforeach
              </tbody>
              <tfoot>
              <tr>
                <th>No</th>
                <th>Nasabah ID</th>
                <th>Nama Nasabah</th>
                <th>Alamat</th>
                <th>TTL</th>
                <th>Jenis Kelamin</th>
                <th>Ibu Kandung</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
              </tfoot>
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
  <div class="modal fade" id="modal-edit-transaction">
    <div class="modal-dialog modal-xl">
      <form action="/adm_transaction" method="post" enctype="multipart/form-data">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Edit Transaction</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <div class="row">
                <div class="col-lg-4 col-sm-12">
                  <label for="inputTransactionNo">Transaction No</label>
                  <input type="text" name="inputTransactionNo" readonly class="form-control">
                </div>
                <div class="col-lg-4 col-sm-12">
                  <label for="inputResi">Resi No</label>
                  <input type="text" name="inputResi" readonly class="form-control">
                </div>
                <div class="col-lg-4 col-sm-12">
                  <label for="inputCustomerName">Customer Name</label>
                  <input type="text" name="inputCustomerName" readonly class="form-control">
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-lg-3 col-sm-12">
                <label for="inputDate">Date</label>
                  <div class="input-group date" id="inputDate3" data-target-input="nearest">
                      <input type="text" name="inputDate3" class="form-control datetimepicker-input" data-target="#inputDate3"/>
                      <div class="input-group-append" data-target="#inputDate3" data-toggle="datetimepicker">
                          <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                      </div>
                  </div>
                </div>
                <div class="col-lg-3 col-sm-12">
                  <label for="inputFromCity">From City</label>
                  <input type="text" name="inputFromCity" class="form-control">
                </div>
                <div class="col-lg-3 col-sm-12">
                  <label for="inputToCity">To City</label>
                  <input type="text" name="inputToCity" class="form-control">
                </div>
                <div class="col-lg-3 col-sm-12">
                <label for="inputPelayaran">Vessel</label>
                  <select class="form-control" name="inputPelayaran">
                    <option value="#" selected="true" disabled="disabled">--- Select Vessel ---</option>
                    <?php /*@foreach($pelayarans as $pelayaran)
                    <option value="{{ $pelayaran->id }}">{{ $pelayaran->code_pelayaran.' - '.$pelayaran->name_pelayaran.', '.$pelayaran->alias }}</option>
                    @endforeach*/?>
                  </select>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-lg-9 col-sm-12"></div>
                <div class="col-lg-3 col-sm-12">
                  <label for="inputStatus">Status</label>
                  <select class="form-control" name="inputStatus">
                    <option value="#" selected="true" disabled="disabled">--- Select Status ---</option>
                    <option value="0">Process</option>
                    <option value="1">Success</option>
                    <option value="9">Canceled</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="form-group">
              <input type="hidden" name="inputIdTransaction" class="form-control">
              <input type="hidden" name="_method" value="PUT"/>
            </div>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Update</button>
          </div>
        </div>
        <!-- /.modal-content -->
      @csrf
    </form>
    </div>
    <!-- /.modal-dialog -->
  </div>
  <div class="modal fade" id="modal-add-transaction">
    <div class="modal-dialog modal-xl">
      <form action="/adm_transaction" method="post" enctype="multipart/form-data">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Add Transaction</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <div class="row">
                <div class="col-lg-4 col-sm-12">
                  <label for="inputTransactionNo">Transaction No</label>
                  <input type="text" name="inputTransactionNo" readonly class="form-control">
                </div>
                <div class="col-lg-4 col-sm-12">
                  <label for="inputResi">Resi No</label>
                  <input type="text" name="inputResi" readonly class="form-control">
                </div>
                <div class="col-lg-4 col-sm-12">
                  <label for="inputCustomerName">Customer Name</label>
                  <input type="text" name="inputCustomerName" readonly class="form-control">
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-lg-3 col-sm-12">
                <label for="inputDate">Date</label>
                  <div class="input-group date" id="inputDate3" data-target-input="nearest">
                      <input type="text" name="inputDate3" class="form-control datetimepicker-input" data-target="#inputDate3"/>
                      <div class="input-group-append" data-target="#inputDate3" data-toggle="datetimepicker">
                          <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                      </div>
                  </div>
                </div>
                <div class="col-lg-3 col-sm-12">
                  <label for="inputFromCity">From City</label>
                  <input type="text" name="inputFromCity" class="form-control">
                </div>
                <div class="col-lg-3 col-sm-12">
                  <label for="inputToCity">To City</label>
                  <input type="text" name="inputToCity" class="form-control">
                </div>
                <div class="col-lg-3 col-sm-12">
                <label for="inputPelayaran">Vessel</label>
                  <select class="form-control" name="inputPelayaran">
                    <option value="#" selected="true" disabled="disabled">--- Select Vessel ---</option>
                    <?php /*@foreach($pelayarans as $pelayaran)
                    <option value="{{ $pelayaran->id }}">{{ $pelayaran->code_pelayaran.' - '.$pelayaran->name_pelayaran.', '.$pelayaran->alias }}</option>
                    @endforeach*/?>
                  </select>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-lg-9 col-sm-12"></div>
                <div class="col-lg-3 col-sm-12">
                  <label for="inputStatus">Status</label>
                  <select class="form-control" name="inputStatus">
                    <option value="#" selected="true" disabled="disabled">--- Select Status ---</option>
                    <option value="0">Process</option>
                    <option value="1">Success</option>
                    <option value="9">Canceled</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save</button>
          </div>
        </div>
        <!-- /.modal-content -->
      @csrf
    </form>
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->
</div>
<!-- /.content -->
@endsection
