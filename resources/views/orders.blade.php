@extends('layouts.template')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <div class="container-fluid">
         <div class="row mb-2">
            <div class="col-sm-6">
               <h1>Orders</h1>
            </div>
            <div class="col-sm-6">
               <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active">Orders</li>
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
                     <h3 class="card-title">DataTable with default features</h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                     <table id="example1" class="table table-bordered table-striped">
                        <thead>
                           <tr>
                              <th>#</th>
                              <th>Order Number</th>
                              <th>Total Amount</th>
                              <th>Notes</th>
                              <th>Time</th>
                              <th>Action</th>
                           </tr>
                        </thead>
                        <tbody>
                          @foreach($order as $item)
                           <tr>
                              <td>{{$loop->iteration}}</td>
                              <td>{{$item->order_number}}</td>
                              <td>{{$item->total_amount}}</td>
                              <td>{{$item->notes}}</td>
                              <td>{{$item->created_at}}</td>
                              <td><button type="button" class="btn btn-white" data-toggle="modal" data-target="#modal-edit"><i class="fas fa-print"></i></td>
                           </tr>
                          @endforeach
                        </tbody>
                        <tfoot>
                           <tr>
                              <th>#</th>
                              <th>Order Number</th>
                              <th>Total Amount</th>
                              <th>Notes</th>
                              <th>Time</th>
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
      <!-- /.container-fluid -->
   </section>
   <!-- /.content -->
</div>
<!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection