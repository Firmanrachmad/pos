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
                           <button type="button" class="btn btn-success" onclick="showAddModal()">Add New Entry</button>
                        </div>
                     </div>
                  </div>
                  <div class="card-body">
                     <table id="example1" class="table table-bordered table-striped">
                        <thead>
                           <tr>
                              <th>#</th>
                              <th>Category</th>
                              <th>Name</th>
                              <th>Price</th>
                              <th>Description</th>
                              <th>Photo</th>
                              <th>Actions</th>
                           </tr>
                        </thead>
                        <tbody id='productTable'></tbody>
                        <tfoot>
                           <tr>
                              <th>#</th>
                              <th>Category</th>
                              <th>Name</th>
                              <th>Price</th>
                              <th>Description</th>
                              <th>Photo</th>
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

<div class="modal fade" id="productModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="modalLabel">Add Product</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <form id="productForm">
               <input type="hidden" id="productId">
               <div class="mb-3">
                   <label for="productCategory" class="form-label">Category</label>
                   <select class="form-control" id="productCategory" required></select>
               </div>
               <div class="form-group">
                  <label for="productName">Name</label>
                  <input type="text" class="form-control" id="productName" required>
               </div>
               <div class="mb-3">
                   <label for="productPrice" class="form-label">Price</label>
                   <input type="number" inputmode="numeric" class="form-control" id="productPrice" required>
               </div>
               <div class="mb-3">
                   <label for="productDesc" class="form-label">Description</label>
                   <input type="textarea" class="form-control" id="productDesc" required>
               </div>
               <div class="mb-3">
                   <label for="productPhoto" class="form-label">Photo</label>
                   <input type="file" class="form-control" id="productPhoto" required>
               </div>
            </form>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" onclick="saveProduct()">Save changes</button>
         </div>
      </div>
   </div>
</div>


<script>
   const productTable = document.getElementById('productTable')
   const productModal = document.getElementById('productModal')
   const productCategory = document.getElementById('productCategory')

   async function fetchCategories() {
    const res = await fetch('api/category');
    const data = await res.json();
    productCategory.innerHTML = data.data.map(cat => `
        <option value="${cat.id}">${cat.name}</option>
      `).join('');
   }    

   async function fetchProduct(){
      const res = await fetch('api/product');
      const data = await res.json();
      productTable.innerHTML = data.data.map(prd => `
        <tr>
          <td>${prd.id}</td>
          <td>${prd.category && prd.category.name ? prd.category.name : 'Kategori Tidak Tersedia'}</td>
          <td>${prd.name}</td>
          <td>${prd.price}</td>
          <td>${prd.desc}</td>
          <td><img height="100" width="100" src="${prd.foto}" alt="${prd.name}"></td>
          <td>
            <a class="btn btn-info btn-sm" onclick="showEditModal(${prd.id},  ${prd.category && prd.category.id ? prd.category.id : null}, '${prd.name}', ${prd.price}, '${prd.desc}')"><i class="fas fa-pencil-alt"></i>Edit</a>
            <a class="btn btn-danger btn-sm" onclick="deleteProduct(${prd.id})"><i class="fas fa-trash"></i>Delete</a>
          </td>
        </tr>
      `).join('');
   }

   function showAddModal(){
      $('#productModal').modal('show');
      document.getElementById('modalLabel').textContent = 'Add Product'
      document.getElementById('productForm').reset()
      document.getElementById('productId').value = ''
   }

   function showEditModal(id, categoryId, name, price, desc) {
      $('#productModal').modal('show');
      document.getElementById('modalLabel').textContent = 'Edit Product'
      document.getElementById('productId').value = id
      document.getElementById('productCategory').value = categoryId ?? ''
      document.getElementById('productName').value = name
      document.getElementById('productPrice').value = price
      document.getElementById('productDesc').value = desc
   }

   async function saveProduct(){
      const id = document.getElementById('productId').value
      const category = document.getElementById('productCategory').value
      const name = document.getElementById('productName').value
      const price = document.getElementById('productPrice').value
      const desc = document.getElementById('productDesc').value
      const foto = document.getElementById('productPhoto').files[0]

      const formData = new FormData()
      formData.append('name', name)
      formData.append('price', price)
      formData.append('desc', desc)
      formData.append('category_id', category)
      
      if (foto) {
         formData.append('foto', foto)
      }

      const method = id ? 'PUT' : 'POST'
      const url = id ? `api/edit-product/${id}` : `api/add-product`

         await fetch(url, {
            method,
            body: formData
         })

      $('#productModal').modal('hide');
      fetchProduct()
   }

   async function deleteProduct(id) {
      await fetch(`api/delete-product/${id}`, { method : 'DELETE' })
      fetchProduct()
   }
   fetchCategories()
   fetchProduct()

</script>
@endsection