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
                            <div class="card-tools">
                                <input type="text" id="searchProduct" class="form-control" placeholder="Search Product...">
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-striped">
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
                        <div class="card-footer text-right">
                            <button class="btn btn-success" id="checkout">Checkout</button>
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
  
  
<script>
    const productTable = document.getElementById('productTable')
    const productModal = document.getElementById('productModal')

    let categories = []
    let cart = []

    async function fetchCategories() {
        const res = await fetch('api/category');
        const data = await res.json();
        categories = data.data;
    }

    function getCategoryNameById(id) {
    const category = categories.find(cat => cat.id === id);
    return category ? category.name : 'Category not available';
}

    async function fetchProduct(){
        const res = await fetch('api/product');
        const data = await res.json();
        productTable.innerHTML = data.data.map((prd, index) => {
        const formattedPrice = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR'
        }).format(prd.price);

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
        $('#productModal').modal('show');
        document.getElementById('modalLabel').textContent = 'Product Details';
        document.getElementById('productName').textContent = name;
        document.getElementById('productCategory').textContent = categoryName || 'Category not available';
        document.getElementById('productPrice').textContent = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
        }).format(price);
        document.getElementById('productDescription').textContent = description || 'No description available';
        document.getElementById('productImage').src = image || 'path/to/default-image.jpg';
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
        `).join('');

        const totalPrice = cart.reduce((total, item) => total + item.subtotal, 0);
        document.getElementById('totalPrice').textContent = formatCurrency(totalPrice);
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

    function formatCurrency(amount) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
        }).format(amount);
    }

    fetchProduct()
</script>
@endsection