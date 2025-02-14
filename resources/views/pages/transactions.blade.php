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
                     <table id="example1" class="table table-bordered table-striped">
                        <thead>
                           <tr>
                              <th>#</th>
                              <th>Transaction ID</th>
                              <th>Transaction Date</th>
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
                              <th>Transaction ID</th>
                              <th>Transaction Date</th>
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

<div class="modal fade" id="transactionModal">
  <div class="modal-dialog modal-xl">
     <div class="modal-content">
         <div class="overlay" id="checkoutLoadingOverlay" style="display: none;">
            <i class="fas fa-2x fa-sync fa-spin"></i>
         </div>
        <div class="modal-header">
           <h4 class="modal-title">Transaction Details</h4>
           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
           </button>
        </div>
        <div class="modal-body">
           <!-- Main content -->
           <div class="invoice p-3 mb-3">
              <!-- title row -->
              <div class="row">
                 <div class="col-12">
                    <h4>
                       <i class="fas fa-globe"></i> AdminLTE, Inc.
                       <small class="float-right" id="transactionDate"></small>
                    </h4>
                 </div>
                 <!-- /.col -->
              </div>
              <!-- info row -->
              <div class="row invoice-info">
                 <div class="col-sm-4 invoice-col">
                    From
                    <address>
                       <strong>Admin, Inc.</strong><br>
                       795 Folsom Ave, Suite 600<br>
                       San Francisco, CA 94107<br>
                       Phone: (804) 123-5432<br>
                       Email: info@almasaeedstudio.com
                    </address>
                 </div>
                 <!-- /.col -->
                 <div class="col-sm-4 invoice-col">
                    <b>Payment Status: </b><b id="paymentStatusBadgeModal"></b><br>
                    <b>Order ID:</b> <text id="transactionNumber"></text><br>
                    <b>Payment Due:</b> <text id="transactionDue"></text><br>
                    <b>Customer:</b> <text id="transactionCustomer"></text><br>
                 </div>
                 <!-- /.col -->
              </div>
              <!-- /.row -->
              <!-- Table row -->
              <div class="row">
                 <div class="col-12 table-responsive">
                    <table class="table table-striped">
                       <thead>
                          <tr>
                             <th>Qty</th>
                             <th>Product</th>
                             <th>Price</th>
                             <th>Subtotal</th>
                          </tr>
                       </thead>
                       <tbody id="transactionDetailTable"></tbody>
                    </table>
                 </div>
                 <!-- /.col -->
              </div>
              <!-- /.row -->
               <div class="row mt-3">
                 <div class="col-12">
                     <button type="button" class="btn btn-primary ml-2 mb-2" onclick="showPaymentHistory()" id="showPaymentHistoryButton">
                       <i class="fas fa-history"></i> Show Payment History
                     </button>
                 </div>
                 <!-- /.col -->
               </div>
               <!-- Payment History -->
              <div class="row mt-3" id="paymentHistorySection" style="display: none;">
                  <div class="col-12 table-responsive">
                    <table class="table table-striped">
                       <thead>
                          <tr>
                             <th>Payment Date</th>
                             <th>Payment</th>
                             <th>Change</th>
                             <th>Payment Method</th>
                             <th>Status</th>
                             <th>Note</th>
                          </tr>
                       </thead>
                       <tbody id="paymentHistoryTable"></tbody>
                    </table>
                 </div>
                 <!-- /.col -->
              </div>
              <!-- /.row -->
              <div class="row mt-3">
                  <div class="col-12">
                     <button type="button" class="btn btn-success ml-2 mb-2" onclick="payNow()" id="payNowButton">
                        <i class="fas fa-hand-holding-usd"></i> Pay Now
                  </div>
                  <!-- /.col -->
               </div>
               <div class="row" id="payNowSection">
                  <!-- Payment Details Column -->
                  <div class="col-12">
                    <p class="lead">Payment Details</p>
                    <div class="table-responsive">
                      <table class="table">
                        <tr>
                          <th style="width:50%">Total Remaining Amount:</th>
                          <td id="totalRemainingAmount">Rp. 0</td>
                        </tr>
                        <tr>
                          <th>Payment:</th>
                          <td>
                            <input type="number" id="paymentAmount" class="form-control" placeholder="Enter payment">
                          </td>
                        </tr>
                        <tr>
                          <th>Change:</th>
                          <td id="changeAmount"></td>
                        </tr>
                        <tr>
                          <th>Payment Method:</th>
                          <td>
                            <div class="form-check">
                              <input class="form-check-input" type="radio" name="paymentMethod" id="paymentCash" value="cash" checked>
                              <label class="form-check-label" for="paymentCash">Cash</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="radio" name="paymentMethod" id="paymentEwallet" value="ewallet">
                              <label class="form-check-label" for="paymentEwallet">E-Wallet</label>
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <th>Notes:</th>
                          <td>
                            <input type="text" id="paymentNotes" class="form-control" placeholder="Enter notes">
                          </td>
                        </tr>
                      </table>
                    </div>
                  </div>
                </div>
                <div class="row mt-2" id="paymentAction">
                  <div class="col-12 d-flex justify-content-end">
                    <button type="button" class="btn btn-secondary mr-2" onclick="cancelPayment()">Cancel</button>
                    <button type="button" class="btn btn-success" onclick="submitPayment()">Confirm</button>
                  </div>
                </div>
           </div>
           <!-- /.invoice -->
        </div>
        <div class="modal-footer justify-content-between">
           <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
           <button type="button" class="btn btn-primary" onclick="printTransaction()"><i class="fas fa-print"></i> Print
           </button>
        </div>
     </div>
     <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<iframe id="transactionViewer" style="width: 100%; height: 500px;" hidden></iframe>

<script>
  const transacionTable = document.getElementById('transactionTable')
  const transactionModal = document.getElementById('transactionModal')
  const transactionDetailTable = document.getElementById('transactionDetailTable')
  const payNowButton = document.getElementById('payNowButton')
  const payNowSection = document.getElementById('payNowSection')
  const paymentAction = document.getElementById('paymentAction')
  const paymentHistorySection = document.getElementById('paymentHistorySection')
  const showPaymentHistoryButton = document.getElementById('showPaymentHistoryButton')
  const paymentHistoryTable = document.getElementById('paymentHistoryTable')
  
  let currentTransactionData = null
  let changeGlobal = 0

  async function fetchTransaction() {
    const res = await fetch('api/transaction')
    const data = await res.json()
    transactionTable.innerHTML = data.data.map((trs, index) => {
        let paymentStatus = getPaymentStatusBadge(trs.payment_status)
        let payNowButtonHtml = ''

         if(trs.payment_status === 'unpaid' || trs.payment_status === 'pending') {
            payNowButtonHtml = `<button class="btn btn-success btn-sm ml-2" onclick="viewTransaction(${trs.id})">
               <i class="fas fa-hand-holding-usd"></i> Pay Now
            </button>`
         }

        return `
          <tr>
              <td>${index + 1}</td>
              <td>${trs.transaction_number}</td>
              <td>${trs.transaction_date}</td>
              <td>${trs.customer && trs.customer.name ? trs.customer.name : '-'}</td>
              <td>${formatCurrency(trs.total_amount)}</td>
              <td>
                  ${paymentStatus} ${payNowButtonHtml}
               </td>
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

  async function viewTransaction(id) {

    $('#transactionModal').modal('show')
    paymentHistorySection.style.display = "none"
    showPaymentHistoryButton.innerHTML = '<i class="fas fa-history"></i> Show Payment History'
    currentTransactionData = null

      try {

        const res = await fetch('api/show-detail/' + id)
        const { status, data } = await res.json()
        console.log(data);


        if(status === 'success') {
          currentTransactionData = data
            
          document.getElementById('transactionDate').textContent = `Transaction Date: ${data.transaction_date}`
          document.getElementById('transactionNumber').textContent = data.transaction_number
          document.getElementById('transactionDue').textContent = data.due_date || '-'
          document.getElementById('transactionCustomer').textContent = data.customer ? data.customer.name : '-'

          const paymentStatusBadge = getPaymentStatusBadge(data.payment_status)
          document.getElementById('paymentStatusBadgeModal').innerHTML = paymentStatusBadge

          transactionDetailTable.innerHTML = data.transaction_details.map((trs, index) => {
            return `
                <tr>
                    <td>${trs.quantity}</td>
                    <td>${trs.product.name}</td>
                    <td>${formatCurrency(trs.price)}</td>
                    <td>${formatCurrency(trs.subtotal)}</td>
                </tr>
              `;
          }).join('');

          const totalAmount = formatCurrency(data.total_amount)

          transactionDetailTable.innerHTML += `
            <tr>
              <td colspan="3" class="text-right"><strong>Total Amount</strong></td>
              <td><strong>${totalAmount}</strong></td>
            </tr>
          `;

          payNowButton.style.display = "none"
          payNowSection.style.display = "none"
          paymentAction.style.display = "none"

          if(data.payment_status === 'unpaid' || data.payment_status === 'pending') {
            payNowButton.style.display = 'block'
          }

        } else {
          alert('Failed to fetch transaction details')
        }
      } catch (error) {
        console.error('Error fetching transaction details:', error)
        alert('An error occurred while fetching transaction details.')
      }

  }

  function showPaymentHistory() {


    if(currentTransactionData && currentTransactionData.payment){

      paymentHistoryTable.innerHTML = currentTransactionData.payment.map((pay, index) => {
        const paymentStatus = getPaymentStatusBadge(pay.status)
        return `
          <tr>
              <td>${pay.payment_date}</td>
              <td>${formatCurrency(pay.payment)}</td>
              <td>${formatCurrency(pay.change)}</td>
              <td>${pay.payment_method || '-'}</td>
              <td>${paymentStatus || '-'}</td>
              <td>${pay.note || '-'}</td>
          </tr>
        `;
      }).join('')
    }

    if(paymentHistorySection.style.display === 'none') {
        paymentHistorySection.style.display = 'block'
        showPaymentHistoryButton.innerHTML = '<i class="fas fa-history"></i> Hide Payment History'
    } else {
        paymentHistorySection.style.display = 'none'
        showPaymentHistoryButton.innerHTML = '<i class="fas fa-history"></i> Show Payment History'
    }
  }

  function payNow(){
   $('#payNowSection').show()
   $('#paymentAction').show()
   document.getElementById('paymentCash').checked = true
   document.getElementById('paymentNotes').value = ''

   const paymentAmount = document.getElementById('paymentAmount');
   const totalRemainingAmountElement = document.getElementById('totalRemainingAmount')

   const totalPayment = currentTransactionData.payment.reduce((sum, pay) => sum + parseFloat(pay.payment || 0), 0)

   const totalRemainingAmount = currentTransactionData.total_amount - totalPayment

   totalRemainingAmountElement.textContent = formatCurrency(totalRemainingAmount)

   const paymentInput = document.getElementById('paymentAmount')
   const changeAmountElement = document.getElementById('changeAmount')

   paymentInput.value = ''
   changeAmountElement.textContent = formatCurrency(0)

   paymentInput.addEventListener('input', function() {
      const payment = parseInt(paymentInput.value)
      const change = payment - totalRemainingAmount
      changeGlobal = change
      changeAmountElement.innerHTML = formatCurrency(change)
   })
  }

   async function submitPayment(){
      const paymentAmount = document.getElementById('paymentAmount').value
      const changeAmount = changeGlobal
      const paymentMethod = document.querySelector('input[name="paymentMethod"]:checked').value
      const paymentNotes = document.getElementById('paymentNotes').value || ''
   
      if(paymentAmount <= 0) {
         alert('Payment amount must be greater than 0')
         return
      }

      const now = new Date()
      const formattedDate = now.toISOString().slice(0, 10)
      const formattedTime = now.toLocaleTimeString('id-ID', {
         hour: '2-digit',
         minute: '2-digit',
         second: '2-digit',
         hour12: false
      })
      
      const paymentDate = `${formattedDate} ${formattedTime}`
   
      const data = {
         payment_date: paymentDate,
         payment_method: paymentMethod,
         payment: paymentAmount,
         change: changeAmount,
         note: paymentNotes
      }

      // console.log(data)
   
      try {
         const res = await fetch('api/pay/' + currentTransactionData.id, {
            method: 'POST',
            headers: {
               'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
         })

         const updatedTransaction = await fetch('api/show-detail/' + currentTransactionData.id)
            .then((res) => res.json())
            .then((data) => data.data);

         currentTransactionData = updatedTransaction
         showPaymentHistory()
         fetchTransaction()
         viewTransaction(currentTransactionData.id)

         paymentHistorySection.style.display = 'block'
         showPaymentHistoryButton.innerHTML = '<i class="fas fa-history"></i> Hide Payment History'

         $('#payNowSection').hide()
         $('#paymentAction').hide()
   
         console.log('Payment submitted:', res)
      } catch (error) {
         console.error('Error submitting payment:', error)
      }
   }

   async function printTransaction() {
      const overlay = document.getElementById('checkoutLoadingOverlay')
      overlay.style.display = 'flex'
      const transactionResponse = await fetch('api/payment-history/' + currentTransactionData.id, {
         method: 'POST',
         headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/pdf',
         },
      })

      if (!transactionResponse.ok) {
         throw new Error(`Failed to fetch invoice: ${transactionResponse.statusText}`)
      }

      const blob = await transactionResponse.blob()
      const url = window.URL.createObjectURL(blob)

      const iframe = document.getElementById('transactionViewer')
      iframe.src = url

      iframe.onload = () => {
         iframe.focus()
         iframe.contentWindow.print()
         window.URL.revokeObjectURL(url)
      }

      iframe.addEventListener('load', () => {
         window.URL.revokeObjectURL(url)
      })

      overlay.style.display = 'none'
      
   }

  function cancelPayment(){
    $('#payNowSection').hide()
    $('#paymentAction').hide()
  }


  fetchTransaction()
</script>
@endsection