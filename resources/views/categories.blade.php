@extends('layouts.template')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <div class="container-fluid">
         <div class="row mb-2">
            <div class="col-sm-6">
               <h1>Categories</h1>
            </div>
            <div class="col-sm-6">
               <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active">Categories</li>
               </ol>
            </div>
         </div>
      </div>
      <!-- /.container-fluid -->
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
                           <!-- <button type="button" class="btn btn-primary swalDefaultSuccess">Test</button> -->
                        </div>
                     </div>
                  </div>
                  <div class="card-body">
                     <table id="example2" class="table table-bordered table-hover">
                        <thead>
                           <tr>
                              <th>#</th>
                              <th>Name</th>
                              <th>Actions</th>
                           </tr>
                        </thead>
                        <tbody>
                           @foreach($category as $item)
                           <tr>
                              <td>{{$loop->iteration}}</td>
                              <td>{{$item->name}}</td>
                              <td><button type="button" class="btn btn-white" data-toggle="modal" data-target="#modal-edit"><i class="fas fa-pen"></i></button><button type="button" class="btn btn-white" data-toggle="modal" data-target="#modal-delete"><i class="fas fa-trash"></i></button></td>
                           </tr>
                           @endforeach
                        </tbody>
                        <tfoot>
                           <tr>
                              <th>#</th>
                              <th>Name</th>
                              <th>Actions</th>
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
      <!-- /.container-fluid -->
   </section>
   <!-- /.content -->
</div>
<!-- /.container-fluid -->
</section>
<!-- /.content -->
<div class="modal fade" id="modal-add">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title">Add New Entry</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form id="addForm">
            <!-- Tambahkan form di sini -->
            <div class="modal-body">
               <div class="form-group">
                  <label for="name">Name:</label>
                  <input type="text" class="form-control" id="name" name="name" placeholder="Enter name">
               </div>
               <!-- Tambahkan input field lain jika diperlukan -->
            </div>
            <div class="modal-footer justify-content-between">
               <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
               <button type="submit" class="btn btn-primary addBtn">Save changes</button>
            </div>
         </form>
      </div>
      <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<div class="modal fade" id="modal-edit">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title">Edit Data</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <p>Modal Edit&hellip;</p>
         </div>
         <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
         </div>
      </div>
      <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
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
            <button type="submit" class="btn btn-outline-light">Save changes</button>
         </div>
      </div>
      <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<!-- jQuery -->
<script src="{{ asset('admins/plugins/jquery/jquery.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('admins/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<script>
   $(document).ready(function(){
      var Toast = Swal.mixin({
         toast: true,
         position: 'top-end',
         showConfirmButton: false,
         timer: 3000
      });
      $('#addForm').submit(function(e){
         e.preventDefault();
         let formData = $(this).serialize();
         $.ajax({
            url:'',
            data:formData,
            contentType: false,
            processData: false,
            beforeSend: function(){
               $('.addBtn').prop('disabled', true);
            },
            complete: function(){
               $('.addBtn').prop('disabled', false);
            },
            success: function(data){
               if(data.success == true){
                  Toast.fire({
                     icon: 'success',
                     title: data.msg
                  });
                  $('#addModal').modal('hide');
               } else {
                  Toast.fire({
                     icon: 'error',
                     title: "Error!" + data.msg
                  });
               }
            },
            error: function(xhr, textStatus, errorThrown){
               var errorMessage = "An error occurred: " + xhr.statusText;
               Toast.fire({
                  icon: 'error',
                  title: errorMessage
               });
            }
         });
         return false;
      });
   });
</script>
@endsection