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
                           <button type="button" class="btn btn-success" onclick="showAddModal()">Add New Entry</button>
                        </div>
                     </div>
                  </div>
                  <div class="card-body">
                     <table id="example1" class="table table-bordered table-striped">
                        <thead>
                           <tr>
                              <th>#</th>
                              <th>Name</th>
                              <th>Actions</th>
                           </tr>
                        </thead>
                        <tbody id='categoryTable'></tbody>
                        <tfoot>
                           <tr>
                              <th>#</th>
                              <th>Name</th>
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

<div class="modal fade" id="categoryModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="modalLabel">Add Category</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <form id="categoryForm">
               <input type="hidden" id="categoryId">
               <div class="form-group">
                  <label for="categoryName">Name</label>
                  <input type="text" class="form-control" id="categoryName" required>
               </div>
            </form>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" onclick="saveCategory()">Save changes</button>
         </div>
      </div>
   </div>
</div>


<script>
   const categoryTable = document.getElementById('categoryTable')
   const categoryModal = document.getElementById('categoryModal')

   async function fetchCategory(){
      const res = await fetch('api/category');
      const data = await res.json();
      categoryTable.innerHTML = data.data.map(ctg => `
        <tr>
          <td>${ctg.id}</td>
          <td>${ctg.name}</td>
          <td>
            <a class="btn btn-info btn-sm" onclick="showEditModal(${ctg.id}, '${ctg.name}')"><i class="fas fa-pencil-alt"></i>Edit</a>
            <a class="btn btn-danger btn-sm" onclick="deleteCategory(${ctg.id})"><i class="fas fa-trash"></i>Delete</a>
          </td>
        </tr>
      `).join('');
   }

   function showAddModal(){
      $('#categoryModal').modal('show');
      document.getElementById('modalLabel').textContent = 'Add Category'
      document.getElementById('categoryForm').reset()
      document.getElementById('categoryId').value = ''
   }

   function showEditModal(id, name) {
      $('#categoryModal').modal('show');
      document.getElementById('modalLabel').textContent = 'Edit Category'
      document.getElementById('categoryId').value = id
      document.getElementById('categoryName').value = name
   }

   async function saveCategory(){
      const id = document.getElementById('categoryId').value
      const name = document.getElementById('categoryName').value

      const payload = { id, name }
      const method = id ? 'PUT' : 'POST'
      const url = id ? `api/edit-category/${id}` : `api/add-category`

         await fetch(url, {
            method,
            headers: { 'Content-Type' : 'application/json'},
            body: JSON.stringify(payload)
         })

      $('#categoryModal').modal('hide');
      fetchCategory()
   }

   async function deleteCategory(id) {
      await fetch(`api/delete-category/${id}`, {method:'DELETE'})
      fetchCategory()
   }

   fetchCategory()

</script>
@endsection