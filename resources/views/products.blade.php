@extends('layouts.template')
@section('content')
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <div class="container-fluid">
         <div class="row mb-2">
            <div class="col-sm-6">
               <h1>Products</h1>
            </div>
            <div class="col-sm-6">
               <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active">Products</li>
               </ol>
            </div>
         </div>
      </div>
   </section>
   <!-- Main content -->
   <section class="content">
      <div class="container-fluid">
         <div class="row">
            <div class="col-12">
               <div class="card">
                  <div class="card-header">
                     <div class="row">
                        <div class="ml-auto">
                           <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-add">Add New Entry</button>
                        </div>
                     </div>
                  </div>
                  <div class="card-body">
                     <table id="example1" class="table table-bordered table-striped">
                        <thead>
                           <tr>
                              <th>#</th>
                              <th>Photo</th>
                              <th>Category</th>
                              <th>Name</th>
                              <th>Price</th>
                              <th>Desc</th>
                              <th>Actions</th>
                           </tr>
                        </thead>
                        <tbody>
                           @foreach($product as $item)
                           <tr>
                              <td>{{$loop->iteration}}</td>
                              <td><img height="100" width="100" src="{{$item->foto}}"></td>
                              <td>@if ($item->category)
                                 {{ $item->category->name }}
                                 @else
                                 Category not available
                                 @endif
                              </td>
                              <td>{{$item->name}}</td>
                              <td>Rp. {{$item->price}}</td>
                              <td>{{$item->desc}}</td>
                              <td>
                                 <button type="button" class="btn btn-white editBtn" data-toggle="modal" data-id="{{ $item->id }}" data-name="{{ $item->name }}" data-toggle="modal" data-target="#modal-edit"><i class="fas fa-pen"></i></button>
                                 <button type="button" class="btn btn-white deleteBtn" data-toggle="modal" data-id="{{ $item->id }}" data-toggle="modal" data-target="#modal-delete"><i class="fas fa-trash"></i></button>
                              </td>
                           </tr>
                           @endforeach
                        </tbody>
                        <tfoot>
                           <tr>
                              <th>#</th>
                              <th>Photo</th>
                              <th>Category</th>
                              <th>Name</th>
                              <th>Price</th>
                              <th>Desc</th>
                              <th>Actions</th>
                           </tr>
                        </tfoot>
                     </table>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>
</div>

<div class="modal fade" id="modal-add">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title">Add New Product</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form method="POST" id="addForm" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
               <div class="form-group">
                  <label for="category_id">Category:</label>
                  <select class="form-control" id="category_id" name="category_id">
                     @foreach($category as $item)
                     <option value="{{$item->id}}">{{$item->name}}</option>
                     @endforeach
                  </select>
               </div>
               <div class="form-group">
                  <label for="name">Name:</label>
                  <input type="text" class="form-control" id="name" name="name" placeholder="Enter name">
               </div>
               <div class="form-group">
                  <label for="price">Price:</label>
                  <input type="number" class="form-control" id="price" name="price" placeholder="Enter price">
               </div>
               <div class="form-group">
                  <label for="desc">Description:</label>
                  <textarea class="form-control" id="desc" name="desc" placeholder="Enter description"></textarea>
               </div>
               <div class="form-group">
                  <label for="foto">Photo:</label>
                  <input type="file" class="form-control-file" id="foto" name="foto">
               </div>
            </div>
            <div class="modal-footer justify-content-between">
               <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
               <button type="submit" class="btn btn-primary addBtn">Save changes</button>
            </div>
         </form>
      </div>
   </div>
</div>

<div class="modal fade" id="modal-edit">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title">Edit Data</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form method="POST" id="editForm" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" id="edit_id" name="id">
            <div class="modal-body">
               <div class="form-group">
                  <label for="category_id">Category:</label>
                  <select class="form-control" id="category_id" name="category_id">
                     @foreach($category as $item)
                     <option value="{{$item->id}}">{{$item->name}}</option>
                     @endforeach
                  </select>
               </div>
               <div class="form-group">
                  <label for="edit_name">Name:</label>
                  <input type="text" class="form-control" id="edit_name" name="name">
               </div>
               <div class="form-group">
                  <label for="edit_price">Price:</label>
                  <input type="number" class="form-control" id="edit_price" name="price">
               </div>
               <div class="form-group">
                  <label for="edit_desc">Desc:</label>
                  <textarea class="form-control" id="edit_desc" name="desc"></textarea>
               </div>
               <div class="form-group">
                  <label for="edit_foto">Photo:</label>
                  <input type="file" class="form-control" id="edit_foto" name="foto">
               </div>
            </div>
            <div class="modal-footer justify-content-between">
               <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
               <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
         </form>
      </div>
   </div>
</div>

<div class="modal fade" id="modal-delete">
   <div class="modal-dialog">
      <div class="modal-content bg-danger">
         <div class="modal-header">
            <h4 class="modal-title">Delete Data</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <p>Are you sure want to delete?</p>
         </div>
         <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-outline-light deleteConfirmBtn">Save changes</button>
         </div>
      </div>
   </div>
</div>

<script src="{{ asset('admins/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('admins/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<script>
   $(document).ready(function() {

      var Toast = Swal.mixin({
         toast: true,
         position: 'top-end',
         showConfirmButton: false,
         timer: 3000
      });

      $('#addForm').submit(function(e) {
         e.preventDefault();
         var formData = new FormData(this);

         $.ajax({
            url: '{{ route("products.store") }}',
            method: 'POST',
            headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function() {
               $('.addBtn').prop('disabled', true);
            },
            complete: function() {
               $('.addBtn').prop('disabled', false);
            },
            success: function(data) {
               if (data.success == true) {
                  Toast.fire({
                     icon: 'success',
                     title: data.msg
                  });
                  $('#modal-add').modal('hide');
                  location.reload();
               } else {
                  Toast.fire({
                     icon: 'error',
                     title: "Error! " + data.msg
                  });
               }
            },
            error: function(xhr, textStatus, errorThrown) {
               var errorMessage = "An error occurred: " + xhr.statusText;
               console.log(xhr.responseJSON);
               Toast.fire({
                  icon: 'error',
                  title: errorMessage
               });
            }
         });
         return false;
      });

      $('.editBtn').on('click', function() {
         var id = $(this).data('id');
         var name = $(this).data('name');
         var price = $(this).data('price');
         var desc = $(this).data('desc');
         var foto = $(this).data('foto');

         $('#edit_id').val(id);
         $('#edit_name').val(name);
         $('#edit_price').val(price);
         $('#edit_desc').val(desc);
         $('#edit_foto').val(foto);

         $('#modal-edit').modal('show');
      });

      $('#editForm').submit(function(e) {
         e.preventDefault();
         var id = $('#edit_id').val();
         var formData = $(this).serialize();
         $.ajax({
            url: '/products/' + id,
            method: 'PUT',
            data: formData,
            headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Pastikan CSRF token disertakan
            },
            beforeSend: function() {
               $('.editBtn').prop('disabled', true);
            },
            complete: function() {
               $('.editBtn').prop('disabled', false);
            },
            success: function(data) {
               if (data.success == true) {
                  Toast.fire({
                     icon: 'success',
                     title: data.msg
                  });
                  $('#modal-edit').modal('hide');
                  location.reload();
               } else {
                  Toast.fire({
                     icon: 'error',
                     title: "Error! " + data.msg
                  });
               }
            },
            error: function(xhr, textStatus, errorThrown) {
               var errorMessage = "An error occurred: " + xhr.statusText;
               Toast.fire({
                  icon: 'error',
                  title: errorMessage
               });
            }
         });
         return false;
      });

      $('.deleteBtn').on('click', function() {
         var id = $(this).data('id'); // Dapatkan id dari atribut data-id
         $('#modal-delete').data('id', id); // Simpan id di data modal
         $('#modal-delete').modal('show'); // Tampilkan modal delete
      });

      $('.deleteConfirmBtn').on('click', function() {
         var id = $('#modal-delete').data('id'); // Ambil id dari data modal
         $.ajax({
            url: '/products/' + id, // Gunakan id dalam URL
            method: 'DELETE',
            headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Pastikan CSRF token disertakan
            },
            success: function(data) {
               if (data.success == true) {
                  Swal.fire({
                     icon: 'success',
                     title: data.msg
                  });
                  $('#modal-delete').modal('hide');
                  location.reload();
               } else {
                  Swal.fire({
                     icon: 'error',
                     title: "Error! " + data.msg
                  });
               }
            },
            error: function(xhr, textStatus, errorThrown) {
               var errorMessage = "An error occurred: " + xhr.statusText;
               Swal.fire({
                  icon: 'error',
                  title: errorMessage
               });
            }
         });
      });
   });
</script>
@endsection