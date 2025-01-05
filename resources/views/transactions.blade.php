@extends('layouts.template')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <div class="container-fluid">
         <div class="row mb-2">
            <div class="col-sm-6">
               <h1>Transactions</h1>
            </div>
            <div class="col-sm-6">
               <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active">Transactions</li>
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
                     <h3 class="card-title">List of Transactions</h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                     <table id="example2" class="table table-bordered table-hover">
                        <thead>
                           <tr>
                              <th>#</th>
                              <th>Transaction Number</th>
                              <th>Customer Name</th>
                              <th>Total Amount</th>
                              <th>Payment Status</th>
                              <th>Action</th>
                           </tr>
                        </thead>
                        <tbody id="transactionTable"></tbody>
                        <tfoot>
                           <tr>
                              <th>#</th>
                              <th>Transaction Number</th>
                              <th>Customer Name</th>
                              <th>Total Amount</th>
                              <th>Payment Status</th>
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
<script>
   const transacionTable = document.getElementById('transactionTable')

   async function fetchTransaction() {
      const res = await fetch('api/transaction')
      const data = await res.json()
      transactionTable.innerHTML = data.data.map((trs, index) => {
         const paymentStatus = getPaymentStatusBadge(trs.payment_status);

         return `
            <tr>
               <td>${index + 1}</td>
               <td>${trs.transaction_number}</td>
               <td>${trs.customer && trs.customer.name ? trs.customer.name : '-'}</td>
               <td>${formatCurrency(trs.total_amount)}</td>
               <td>${paymentStatus}</td>
               <td>
                  <button class="btn btn-primary btn-sm" onclick="viewTransaction(${trs.id})">
                     <i class="fas fa-eye"></i>
                  </button>
               </td>
            </tr>
         `;
      }).join('');
   }

   function getPaymentStatusBadge(status) {
      switch (status) {
         case 'paid':
            return `<span class="badge badge-success"><i class="fas fa-check-circle"></i> PAID</span>`;
         case 'unpaid':
            return `<span class="badge badge-danger"><i class="fas fa-times-circle"></i> UNPAID</span>`;
         case 'pending':
            return `<span class="badge badge-warning"><i class="fas fa-clock"></i> PENDING</span>`;
      }
   }

   function formatCurrency(amount) {
    const formattedAmount = new Intl.NumberFormat('id-ID', { 
        style: 'currency', 
        currency: 'IDR' 
    }).format(amount);

    if (amount < 0) {
        return `<span style="color: red;">${formattedAmount}</span>`;
    }
    return formattedAmount;
   }

   fetchTransaction()
</script>
@endsection