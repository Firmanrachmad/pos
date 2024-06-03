@extends('layouts.template')
@section('content')
<!-- Content Wrapper. Contains page content -->
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
      </div><!-- /.container-fluid -->
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
                              @endif</td>
                              <td>{{$item->name}}</td>
                              <td>{{$item->price}}</td>
                              <td>{{$item->desc}}</td>
                              <td><button type="button" class="btn btn-white" data-toggle="modal" data-target="#modal-edit"><i class="fas fa-pen"></i></button><button type="button" class="btn btn-white" data-toggle="modal" data-target="#modal-delete"><i class="fas fa-trash"></i></button></td>
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
         <div class="modal-body">
            <p>Modal Add&hellip;</p>
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
              <button type="button" class="btn btn-outline-light">Save changes</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
@endsection