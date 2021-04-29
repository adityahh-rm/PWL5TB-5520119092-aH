@extends('adminlte::page')

@section('title', 'X Managing')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('X Managing') }}</div>
                <div class="card-body">
                    <button class="btn btn-primary float-right" data-toggle="modal" data-target="#tambahBukuModal">
                        <i class="fa fa-plus"></i>
                        Tambah Data
                    </button>
                    <!-- Button Print PDF -->
                    <a href="{{ route('admin.print.books') }}" target="_blank" class="btn btn-secondary">
                        <i class="fa fa-print"></i>
                        Cetak PDF
                    </a>
                    <!-- Export File -->
                    <div class="btn-group" roles="group" aria-label="Basic example">
                        <a href="{{ route('admin.book.export') }}" class="btn btn-info" target="_blank">
                            Export
                        </a>
                        <!-- Import File -->
                        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#importDataModal">
                            Import
                        </button>
                    </div> 
                    <hr/>
                    <table id="table-data" class="table table-borderer">
                        <thead>
                            <tr>
                                <th>NO</th>
                                <th>JUDUL</th>
                                <th>PENULIS</th>
                                <th>TAHUN</th>
                                <th>PENERBIT</th>
                                <th>COVER</th>
                                <th>AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no=1; @endphp
                            @foreach($books as $book)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $book->judul }}</td>
                                    <td>{{ $book->penulis }}</td>
                                    <td>{{ $book->tahun }}</td>
                                    <td>{{ $book->penerbit }}</td>
                                    <td>
                                        @if($book->cover !== null)
                                            <img src="{{ asset('storage/cover_buku/'.$book->cover) }}" width="100px"/>
                                        @else
                                            [ Gambar tidak Tersedia ]
                                        @endif
                                    </td> 

                                    <!-- Button - Modifikasi Data -->
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <button type="button" id="btn-edit-buku" class="btn btn-success" 
                                                data-toggle="modal" data-target="#editBukuModal" data-id="{{ $book->id }}">
                                                Edit
                                            </button>
                                            <!-- Deleting button for modal -->
                                            <button type="button" id="btn-delete-buku" class="btn btn-danger" data-toggle="modal" 
                                                data-target="#deleteBukuModal" data-id="{{ $book->id }}" 
                                                data-cover="{{ $book->cover }}">
                                                Delete
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- M O D A L -->
<!-- Proses Input Data x -->
<div  class="modal fade" id="tambahBukuModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog"> <!-- exampleModalLabel -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahBukuModal">
                    Tambah Data Buku
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"> &times; </span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('admin.book.submit') }}" enctype="multipart/form-data">
                    @csrf 
                        <div class="form-group">
                            <label for="judul">Judul Buku</label>
                            <input type="text" class="form-control" name="judul" id="judul" required/>
                        </div>
                        <div class="form-group">
                            <label for="penulis">Penulis</label>
                            <input type="text" class="form-control" name="penulis" id="penulis" required/>
                        </div> 
                        <div class="form-group">
                            <label for="tahun">Tahun</label>
                            <input type="year" class="form-control" name="tahun" id="tahun" required/>
                        </div> 
                        <div class="form-group">
                            <label for="penerbit">Penerbit</label>
                            <input type="text" class="form-control" name="penerbit" id="penerbit" required/>
                        </div>    
                        <div class="form-group">
                            <label for="cover">Cover</label>
                            <input type="file" class="form-control" name="cover" id="cover"/>
                        </div>         
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="submit"  value="submit" class="btn btn-primary">Kirim</button>
                </form>
            </div>     
        </div>
    </div>
</div>

<!-- Update/Edit Data -->
<div class="modal fade" id="editBukuModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <!-- exampleModalLabel -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editBukuModal">Update Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('admin.book.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH') 
                        <!-- form yg dikirimkan sesuai dengan route::patch -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit-judul">Judul Buku</label>
                                    <!-- edit-.... ditulis untuk menghindari adanya duplikasi -->
                                    <input type="text" class="form-control" name="judul" id="edit-judul" required/>
                                </div>
                                <div class="form-group">
                                    <label for="edit-penulis">Penulis</label>
                                    <input type="text" class="form-control" name="penulis" id="edit-penulis" required/>
                                </div>
                                <div class="form-group">
                                    <label for="edit-tahun">Tahun</label>
                                    <input type="year" class="form-control" name="tahun" id="edit-tahun" required/>
                                </div>
                                <div class="form-group">
                                    <label for="edit-penerbit">Penerbit</label>
                                    <input type="text" class="form-control" name="penerbit" id="edit-penerbit" required/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" id="image-area"></div>
                                <div class="form-group">
                                    <label for="edit-cover">Cover</label>
                                    <input type="file" class="form-control" name="cover" id="edit-cover"/>
                                </div>
                            </div>
                        </div>
            </div>
            <div class="modal-footer">
                <!-- hidden --]> memerlukan id untuk mengubah data-nya -->
                <input type="hidden" name="id" id="edit-id"/>
                <input type="hidden" name="old_cover" id="edit-old-cover"/> <!-- menghapus cover yang terdulu -->
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Deleting Data -->
<div class="modal fade" id="deleteBukuModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog"> <!-- exampleModalLabel-->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteBukuModal">
                    Deleting Data
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you Sure you want to Delete it??
                <form method="post" action="{{ route('admin.book.delete') }}" enctype="multipart/form-data">
                    @csrf
                    @method('DELETE')
            </div>
            <div class="modal-footer">
                <input type="hidden" name="id" id="delete-id"/>
                <input type="hidden" name="old_cover" id="delete-old-cover"/>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    Close
                </button>
                <button type="submit" class="btn btn-danger">
                    Delete
                </button>

                </form>
            </div>
        </div>
    </div>
</div>

<!-- MODAL IMPORT DATA -->
<div class="modal fade" id="importDataModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('admin.book.import') }}" enctype="multipart/form-data">
                @csrf
                @method('POST')
                <div class="modal-header">
                    <h5 class="modal-title" id="importDataModal">Import Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- form post import -->
                    <div class="form-group">
                        <label for="cover">Upload File</label>
                        <input type="file" class="form-control" name="file"/>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Import Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop

@section('js')
    <script>
        $(function(){
            // JS UPDATING X
            $(document).on('click', '#btn-edit-buku', function(){
                let id = $(this).data('id');

                $('#image-area').empty();

                $.ajax({
                    type: "get",
                    url: baseurl+'/admin/ajaxadmin/dataBuku/'+id,
                    dataType: 'json',
                    success: function(res){
                        $('#edit-judul').val(res.judul);
                        $('#edit-penerbit').val(res.penerbit);
                        $('#edit-penulis').val(res.penulis);
                        $('#edit-tahun').val(res.tahun);
                        $('#edit-id').val(res.id);
                        $('#edit-old-cover').val(res.cover);

                        if(res.cover !== null){
                            $('#image-area').append( //reset image cover
                                "<img src='"+baseurl+"/storage/cover_buku/"+res.cover+"' width='200px'/>"
                            );
                        } else {
                            $('#image-area').append('[Gambar Tidak Tersedia]');
                        }
                    },
                });
            });

             // JS DELETING X
            $(document).on('click', '#btn-delete-buku', function(){
                let id = $(this).data('id');
                let cover = $(this).data('cover');

                $('#delete-id').val(id);
                $('#delete-old-cover').val(cover);
            });
        });

    </script>
@stop