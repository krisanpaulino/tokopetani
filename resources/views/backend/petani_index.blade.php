@extends('template.admin')
@section('content')
<div class="breadcrumbs">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Petani</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="{{route('dashboard')}}">Dashboard</a></li>
                            <li class="active">Petani</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col text-right">
                <a href="{{ route('petani.tambah') }}" class="btn btn-primary mb-4">Tambah</a>

            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <strong class="card-title">Petani</strong>
                    </div>
                    <div class="card-body">
                        <table id="bootstrap-data-table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Alamat</th>
                                    <th>Tempat Lahir</th>
                                    <th>Tanggal Lahir</th>
                                    <th>HP</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($petani as $r)
                                <tr>
                                    <td>{{ $r->petani_nama }}</td>
                                    <td>{{ $r->user->username }}</td>
                                    <td>{{ $r->petani_jk }}</td>
                                    <td>{{ $r->petani_alamat }}</td>
                                    <td>{{ $r->petani_tempatlahir }}</td>
                                    <td>{{ $r->petani_tgllahir }}</td>
                                    <td>{{ $r->petani_hp }}</td>
                                    <td>
                                        <a class="btn btn-link btn-sm" href="{{ route('petani.detail', $r->petani_id) }}"><i class="fa fa-eye"></i>&nbsp; Detail</a>
                                        <a class="btn btn-link btn-sm" href="{{ route('petani.edit', $r->petani_id) }}"><i class="fa fa-pencil-square-o"></i>&nbsp; Edit</a>
                                        <a class="btn btn-link btn-sm" href="{{ route('admin.produk-petani', $r->petani_id) }}"><i class="ti-bag"></i>&nbsp; Lihat Produk</a>
                                        <a class="btn btn-link btn-sm text-danger" href="javascriptt:;" data-id="{{ $r->petani_id }}" data-toggle="modal" data-target="#hapus"><i class="ti-trash"></i>&nbsp; Hapus</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


        </div>
    </div><!-- .animated -->
    <div class="modal fade" id="hapus" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mediumModalLabel">Hapus petani</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('petani.delete')}}" method="post">
                @csrf
                <input type="hidden" name="petani_id" id="kodeitemhapus" value="">
                <div class="modal-body">
                    <p>
                        Yakin ingin menghapus petani ?
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Confirm</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div><!-- .content -->
@endsection
@section('scripts')
    <script>
         $('#hapus').on('show.bs.modal', function(event) {
            var kode = $(event.relatedTarget).data('id');
            $(this).find('#kodeitemhapus').attr("value", kode);
        });
    </script>
@endsection
