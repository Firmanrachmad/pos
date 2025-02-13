@extends('layouts.template')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <div class="container-fluid">
         <div class="row mb-2">
            <div class="col-sm-6">
               <h1>Payment Histories</h1>
            </div>
            <div class="col-sm-6">
               <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active">Payment Histories</li>
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
                    <h3 class="card-title">List of Payments</h3>
                 </div>
                  <div class="card-body">
                     <table id="example1" class="table table-bordered table-striped">
                        <thead>
                           <tr>
                              <th>#</th>
                              <th>Payment Date</th>
                              <th>Customer Name</th>
                              <th>Payment Method</th>
                              <th>Amount</th>
                              <th>Change</th>
                              <th>Transaction Status</th>
                              <th>Transaction ID</th>
                              <th>Notes</th>
                           </tr>
                        </thead>
                        <tbody id='paymentTable'></tbody>
                        <tfoot>
                           <tr>
                              <th>#</th>
                              <th>Payment Date</th>
                              <th>Customer Name</th>
                              <th>Payment Method</th>
                              <th>Amount</th>
                              <th>Change</th>
                              <th>Transaction Status</th>
                              <th>Transaction ID</th>
                              <th>Notes</th>
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

<script>
   const paymentTable = document.getElementById('paymentTable')

   async function fetchPayment(){
      const res = await fetch('api/payment');
      const data = await res.json();
      paymentTable.innerHTML = data.data.map((pym, index) => `
        <tr>
          <td>${index + 1}</td>
          <td>${pym.payment_date}</td>
          <td>${pym.transaction.customer ? pym.transaction.customer.name : '-'}</td>
          <td>${pym.payment_method || '-'}</td>
          <td>${formatCurrency(pym.payment)}</td>
          <td>${formatCurrency(pym.change)}</td>
          <td>${getPaymentStatusBadge(pym.status)}</td>
          <td>${pym.transaction.transaction_number}</td>
          <td>${pym.note || '-'}</td>
        </tr>
      `).join('');
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

   fetchPayment()

</script>
@endsection