@extends('layouts.template')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Point of Sale System</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Point of Sale System</li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main Content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Product List</h3>
                        </div>
                        <div class="card-body">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Category</th>
                                        <th>Name</th>
                                        <th>Price</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="productTable">
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Category</th>
                                        <th>Name</th>
                                        <th>Price</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Cart -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Shopping Cart</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Product Name</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Subtotal</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="cart">
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="3" class="text-right">Total</th>
                                        <th colspan="2" id="totalPrice">Rp 0</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="card-footer d-flex justify-content-between">
                          <button class="btn btn-secondary" onclick="refresh()">
                            <i class="fas fa-sync"></i> Refresh
                          </button>
                          <button class="btn btn-success ml-auto" onclick="checkout()">
                            <i class="fas fa-arrow-circle-right"></i> Checkout!
                          </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<div class="modal fade" id="productModal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="modalLabel">Product Details</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <!-- Image Section -->
            <div class="col-md-5 text-center">
              <img id="productImage" src="" alt="Product Image" class="img-fluid img-thumbnail" style="max-height: 300px; object-fit: cover;">
            </div>
            <!-- Details Section -->
            <div class="col-md-7">
              <h5 id="productName" class="font-weight-bold"></h5>
              <p><strong>Category:</strong> <span id="productCategory"></span></p>
              <p><strong>Price:</strong> <span id="productPrice"></span></p>
              <p><strong>Description:</strong></p>
              <p id="productDescription"></p>
            </div>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="checkoutModal">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Checkout Payment</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
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
                  <small class="float-right">Date: 2/10/2014</small>
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
                <b>Invoice #007612</b><br>
                <br>
                <b>Order ID:</b> 4F3S8J<br>
                <b>Payment Due:</b> 2/22/2014<br>
                <b>Customer:</b> 
                <div style="display: inline-flex; align-items: center; margin-left: 10px;">
                  <select class="form-control select2bs4" id="customerSelect" style="width: 150px; height: 35px;" required>
                  </select>
                  <button type="button" class="btn btn-success ml-2" onclick="showAddCustomerInput()" style="margin-left: 10px;">
                      <i class="fas fa-user-plus"></i> Add 
                  </button>
                </div>
              </div>
              <div class="col-sm-4" id="addCustomerInput" style="display: none;">
                <div style="display: flex; flex-direction: column; gap: 8px;">
                    <b>Add New Customer</b>
                    <input type="text" id="customerName" class="form-control" placeholder="Enter new customer name" style="width: 200px;">
                     <div style="display: flex; gap: 5px;">
                         <button type="button" class="btn btn-success btn-sm" onclick="saveCustomer()">Save</button>
                          <button type="button" class="btn btn-secondary btn-sm" onclick="hideAddCustomerInput()">Cancel</button>
                    </div>
                </div>
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
                  <tbody id="checkoutCartTable"></tbody>
                </table>
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->

            <div class="row">
              <!-- accepted payments column -->
              <div class="col-6">
                <p class="lead">Pay Now?</p>
                <div class="form-group">
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="payNowOption" id="payNowYes" value="paid" checked>
                    <label class="form-check-label" for="payNowYes">Yes</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="payNowOption" id="payNowNo" value="unpaid">
                    <label class="form-check-label" for="payNowNo">No</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="payNowOption" id="payNowHalf" value="pending">
                    <label class="form-check-label" for="payNowHalf">Half</label>
                  </div>
                </div>

                <p class="lead">Payment Methods</p>
                <div class="form-group">
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="paymentMethod" id="paymentCash" value="cash" checked>
                    <label class="form-check-label" for="paymentCash">Cash</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="paymentMethod" id="paymentEwallet" value="ewallet">
                    <label class="form-check-label" for="paymentEwallet">E-Wallet</label>
                  </div>
                </div>
              </div>
              <!-- /.col -->
              <div class="col-6">
                <p class="lead">Payment Details</p>
                <div class="table-responsive">
                  <table class="table">
                    <tr>
                      <th style="width:50%">Total Amount:</th>
                      <td id="totalAmount">Rp. 0</td>
                    </tr>
                    <tr>
                      <th>Payment:</th>
                      <td>
                        <input type="number" id="paymentAmount" class="form-control" placeholder="Enter payment">
                      </td>
                    </tr>
                    <tr id="dueDateRow" style="display: none;">
                      <th>Due Date:</th>
                      <td>
                        <input type="date" id="dueDate" class="form-control">
                      </td>
                    </tr>
                    <tr>
                      <th>Change:</th>
                      <td id="changeAmount"></td>
                    </tr>
                    <th>Notes:</th>
                      <td>
                        <input type="text" id="paymentNotes" class="form-control" placeholder="Enter notes">
                    </td>
                  </table>
                </div>
              </div>              
              <!-- /.col -->
            </div>
            <!-- /.row -->
          </div>
          <!-- /.invoice -->
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-success" onclick="sendCheckoutData()"><i class="far fa-credit-card"></i> Submit
            Payment
          </button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade" id="customerModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
     <div class="modal-content">
        <div class="modal-header">
           <h5 class="modal-title" id="modalLabel">Add Customer</h5>
           <button type="button" class="close" onclick="hideCustomerModal()" aria-label="Close">
              <span aria-hidden="true">&times;</span>
           </button>
        </div>
        <div class="modal-body">
           <form id="customerForm">
              <input type="hidden" id="customerId">
              <div class="form-group">
                 <label for="customerName">Name</label>
                 <input type="text" class="form-control" id="customerName" required>
              </div>
           </form>
        </div>
        <div class="modal-footer">
           <button type="button" class="btn btn-secondary" onclick="hideCustomerModal()">Close</button>
           <button type="button" class="btn btn-primary" onclick="saveCustomer()">Save changes</button>
        </div>
     </div>
  </div>
</div>
  
  
<script>
  const productTable = document.getElementById('productTable')
  const productModal = document.getElementById('productModal')
  const checkoutModal = document.getElementById('checkoutModal')
  const customerModal = document.getElementById('customerModal')
  const customerSelect = document.getElementById('customerSelect')
  
  let customers = []
  let categories = []
  let cart = []
  let isCheckoutModalActive = false
  let isAddCustomerInputActive = false

  async function fetchCustomers() {
    const res = await fetch('api/customer')
    const data = await res.json()
    customerSelect.innerHTML = `
    <option value="" selected>-</option>
      ${data.data.map(cms => `
        <option value="${cms.id}">${cms.name}</option>
      `).join('')}
    `;
  }

  function showAddCustomerInput() {
    document.getElementById('addCustomerInput').style.display = 'block'
    isAddCustomerInputActive = true
  }

  function hideAddCustomerInput() {
    document.getElementById('addCustomerInput').style.display = 'none'
    isAddCustomerInputActive = false
  }

  async function saveCustomer() {
      const id = document.getElementById('customerId').value
      const name = document.getElementById('customerName').value

      const payload = { id, name }
      const url = '/api/add-customer'

      await fetch(url, {
         method: 'POST',
         headers: { 'Content-Type': 'application/json' },
         body: JSON.stringify(payload),
      });
      hideAddCustomerInput()
      fetchCustomers()
 }

  async function fetchCategories() {
    const res = await fetch('api/category')
    const data = await res.json()
    categories = data.data
  }

  function getCategoryNameById(id) {
    const category = categories.find(cat => cat.id === id)
    return category ? category.name : 'Category not available'
  }

  async function fetchProduct(){
    const res = await fetch('api/product');
    const data = await res.json();
    productTable.innerHTML = data.data.map((prd, index) => {
    const formattedPrice = new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR'
    }).format(prd.price)

    return `
        <tr>
        <td>${index + 1}</td>
        <td>${prd.category && prd.category.name ? prd.category.name : 'Kategori Tidak Tersedia'}</td>
        <td>${prd.name}</td>
        <td>${formattedPrice}</td>
        <td>
            <button class="btn btn-warning btn-sm" onclick="showProduct(${prd.id}, '${prd.category && prd.category.name}', '${prd.name}', ${prd.price}, '${prd.description}', '${prd.image}')"><i class="fas fa-eye"></i></button>
            <button class="btn btn-primary btn-sm" onclick="addToCart(${prd.id}, '${prd.name}', ${prd.price})"><i class="fas fa-cart-plus"></i></button>
        </td>
        </tr>
    `;
    }).join('');
  }

  function showProduct(id, categoryName, name, price, description, image) {
    $('#productModal').modal('show')
    document.getElementById('modalLabel').textContent = 'Product Details'
    document.getElementById('productName').textContent = name
    document.getElementById('productCategory').textContent = categoryName || 'Category not available'
    document.getElementById('productPrice').textContent = new Intl.NumberFormat('id-ID', {
      style: 'currency',
      currency: 'IDR',
    }).format(price)
    document.getElementById('productDescription').textContent = description || 'No description available'
    document.getElementById('productImage').src = image || 'path/to/default-image.jpg'
  }

  function addToCart(id, name, price) {
    const existingProduct = cart.find(item => item.id === id);
    if (existingProduct) {
      existingProduct.quantity += 1
      existingProduct.subtotal = existingProduct.quantity * existingProduct.price
    } else {
      cart.push({
        id,
        name,
        price,
        quantity: 1,
        subtotal: price
      })
    }
    renderCart();
  }

  function renderCart() {
    const cartTable = document.getElementById('cart')
    cartTable.innerHTML = cart.map((item, index) => `
        <tr>
            <td>${item.name}</td>
            <td>${formatCurrency(item.price)}</td>
            <td>
                <input type="number" value="${item.quantity}" min="1" class="form-control" 
                    onchange="updateQuantity(${index}, this.value)">
            </td>
            <td>${formatCurrency(item.subtotal)}</td>
            <td>
                <button class="btn btn-danger btn-sm" onclick="removeFromCart(${index})">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        </tr>
    `).join('')

    const totalPrice = cart.reduce((total, item) => total + item.subtotal, 0)
    document.getElementById('totalPrice').textContent = formatCurrency(totalPrice)
  }

  function removeFromCart(index) {
      cart.splice(index, 1)
      renderCart()
  }

  function updateQuantity(index, quantity) {
      quantity = parseInt(quantity)
      if (quantity > 0) {
          cart[index].quantity = quantity
          cart[index].subtotal = cart[index].quantity * cart[index].price
          renderCart()
      }
  }

  function refresh() {
    cart = []
    renderCart()
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

  function checkout(){
    $('#checkoutModal').modal('show')
    fetchCustomers()
    const checkoutCartTable = document.getElementById('checkoutCartTable')
    const totalAmount = cart.reduce((total, item) => total + item.subtotal, 0)
    const totalAmountElement = document.getElementById('totalAmount')
    const paymentInput = document.getElementById('paymentAmount')
    const changeAmountElement = document.getElementById('changeAmount')
    const paymentMethods = document.querySelectorAll('input[name="paymentMethod"]')
    const dueDateRow = document.getElementById('dueDateRow')
    let currentPayNowOption = 'paid'


    checkoutCartTable.innerHTML = cart.map(item => `
        <tr>
          <td>${item.quantity}</td>
          <td>${item.name}</td>
          <td>${formatCurrency(item.price)}</td>
          <td>${formatCurrency(item.subtotal)}</td>
        </tr>
    `).join('');

    checkoutCartTable.innerHTML += `
        <tr>
          <td colspan="3" class="text-right"><strong>Total Amount</strong></td>
          <td><strong>${formatCurrency(totalAmount)}</strong></td>
        </tr>
    `;

    totalAmountElement.textContent = formatCurrency(totalAmount)

    paymentInput.value = ''
    changeAmountElement.textContent = formatCurrency(0)

    document.getElementById('payNowYes').checked = true;
    document.getElementById('paymentCash').checked = true;

    paymentMethods.forEach(method => {
      method.disabled = false
    })

    document.querySelectorAll('input[name="payNowOption"]').forEach(option => {
      option.addEventListener('change', (event) => {
        if (event.target.checked) {
          currentPayNowOption = event.target.value
          if (event.target.value === 'paid') {
            document.getElementById('paymentCash').checked = true
            paymentMethods.forEach(method => method.disabled = false)
            paymentInput.disabled = false
            const payment = parseFloat(paymentInput.value.replace(',', '.')) || 0
            const change = Math.max(0, payment - totalAmount)
            changeAmountElement.textContent = formatCurrency(change)
            if (paymentInput.value > totalAmount) {
              paymentInput.dispatchEvent(new Event('input'))
            }
            dueDateRow.style.display = 'none'
          } else if (event.target.value === 'unpaid') {
            paymentMethods.forEach(method => {
              method.checked = false
              method.disabled = true
            })
            paymentInput.disabled = true
            paymentInput.value = 0
            const change = 0 - totalAmount
            changeAmountElement.innerHTML = formatCurrency(change)
            dueDateRow.style.display = 'table-row'
          } else if (event.target.value === 'pending') {
            document.getElementById('paymentCash').checked = true
            paymentMethods.forEach(method => method.disabled = false)
            paymentInput.disabled = false
            dueDateRow.style.display = 'table-row'
            paymentInput.dispatchEvent(new Event('input'))
          }
        }
      })
    })

    paymentInput.addEventListener('input', () => {
        const rawValue = paymentInput.value.replace(/[^\d.-]/g, '')
        const payment = parseFloat(rawValue) || 0
        let change = Number(payment - totalAmount)
        if (currentPayNowOption === 'paid' && change < 0) {
          change = 0;
        }
        changeAmountElement.innerHTML = formatCurrency(change)
    })

    $('#checkoutModal').on('hidden.bs.modal', function () {
        document.getElementById('payNowYes').checked = true
        document.getElementById('paymentCash').checked = true
        paymentMethods.forEach(method => {
           method.checked = false;
           method.disabled = false;
        })
        paymentInput.value = ''
        paymentInput.disabled = false
        changeAmountElement.textContent = formatCurrency(0)
        currentPayNowOption = 'paid'
        dueDateRow.style.display = 'none'
        document.getElementById('dueDate').value = ''
     });

    $('#checkoutModal').modal('show')
  }

  async function sendCheckoutData() {
    const customer = parseInt(document.getElementById('customerSelect').value, 10);
    const payNowOption = document.querySelector('input[name="payNowOption"]:checked').value
    const paymentMethod = document.querySelector('input[name="paymentMethod"]:checked')?.value || null
    const paymentAmount = parseFloat(document.getElementById('paymentAmount').value) || 0
    const totalPrice = cart.reduce((total, item) => total + item.subtotal, 0)
    let dueDate = document.getElementById('dueDate')?.value || null

    if (payNowOption === 'paid') {
      if(paymentAmount < totalPrice){
        Swal.fire({
          icon: 'info',
          title: 'Insufficient funds!'
        })
          return
      }
    } else if (payNowOption === 'unpaid') {
      if (!dueDate) {
        Swal.fire({
            icon: 'error',
            title: 'Please enter a due date.'
        });
        return;
      }

      if (!customer) {
        Swal.fire({
            icon: 'error',
            title: 'Please select a customer.'
        });
        return;
      }

    } else if (payNowOption === 'pending') {
      if(paymentAmount === 0){
        Swal.fire({
          icon: 'error',
          title: 'Please enter a correct payment amount!'
        })
          return
      } else if (paymentAmount > totalPrice){
        Swal.fire({
          icon: 'info',
          title: 'Please change to yes option if you want to pay in full'
        })
          return
      }

      if (!dueDate) {
        Swal.fire({
            icon: 'error',
            title: 'Please enter due date if payment is not fully paid.'
        })
        return
      }

      if (!customer) {
        Swal.fire({
            icon: 'error',
            title: 'Please select a customer.'
        })
        return
      }
    }

    const now = new Date()
    const formattedDate = now.toISOString().slice(0, 10)
    const formattedTime = now.toLocaleTimeString('id-ID', {
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit',
        hour12: false
    })
    
    const transactionDate = `${formattedDate} ${formattedTime}`;

    const checkoutData = {
        transaction_date: transactionDate,
        payment_status: payNowOption,
        payment_method: payNowOption === 'no' ? null : paymentMethod,
        cart: cart.map(item => ({
            product_id: item.id,
            price: item.price,
            quantity: item.quantity
        })),
        payment: paymentAmount,
        due_date: dueDate,
        note: document.getElementById('paymentNotes')?.value || '',
        customer_id: customer
    }

    console.log(checkoutData)

    const result = await Swal.fire({
      title: 'Confirm Checkout',
      text: 'Are you sure you want to proceed with this checkout?',
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Yes, proceed!',
      cancelButtonText: 'Cancel',
      reverseButtons: true
    })

    if(result.isConfirmed){
      try {
        const response = await fetch('api/checkout', {
          method: 'POST',
          headers: {
              'Content-Type': 'application/json',
              'Accept': 'application/json'
          },
          body: JSON.stringify(checkoutData)
        })
        
        if (!response.ok) {
          const errorData = await response.json()
          throw new Error(`Failed to checkout: ${JSON.stringify(errorData)}`);
        }
    
        const data = await response.json()
        if (data.status === 'success') {
            Swal.fire(
              'Success!',
              'Checkout completed successfully.',
              'success'
            );
            console.log(data.data)
            cart = []
            renderCart();
            $('#checkoutModal').modal('hide');
        } else {
            Swal.fire(
              'Error!',
              `Checkout failed: ${data.message || 'Unknown error'}`,
              'error'
            )
        }
      } catch (error) {
          console.error('Error during checkout:', error);
          Swal.fire(
              'Error!',
              `An error occurred during checkout: ${error.message}`,
              'error'
          )
      }
      $('#checkoutModal').modal('hide')
    }
    $('#checkoutModal').modal('hide')

  }

  function showCustomerModal() {
    if (isCheckoutModalActive) {
      $('#checkoutModal').modal('hide');
        $('body').css('overflow', 'auto');
    }
    $('#customerModal').modal('show');
        $('body').css('overflow', 'hidden');
  }

  function hideCustomerModal() {
    $('#customerModal').modal('hide');
    $('body').css('overflow', 'auto');
    if (isCheckoutModalActive) {
      $('#checkoutModal').modal('show');
    }
  }
  
  fetchProduct()
</script>
@endsection