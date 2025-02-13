@extends('layouts.template')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <div class="container-fluid">
         <div class="row mb-2">
            <div class="col-sm-6">
               <h1>Customers</h1>
            </div>
            <div class="col-sm-6">
               <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active">Customers</li>
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
                     <table id="example2" class="table table-bordered table-hover">
                        <thead>
                           <tr>
                              <th>#</th>
                              <th>Name</th>
                              <th>Actions</th>
                           </tr>
                        </thead>
                        <tbody id='customerTable'></tbody>
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

<div class="modal fade" id="customerModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="modalLabel">Add Customer</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
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
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" onclick="saveCustomer()">Save changes</button>
         </div>
      </div>
   </div>
</div>


<script>
   const customerTable = document.getElementById('customerTable')
   const customerModal = document.getElementById('customerModal')

   async function fetchCustomer(){
      const res = await fetch('api/customer');
      const data = await res.json();
      customerTable.innerHTML = data.data.map((cms, index) => `
        <tr>
          <td>${index + 1}</td>
          <td>${cms.name}</td>
          <td>
            <a class="btn btn-info btn-sm" onclick="showEditModal(${cms.id}, '${cms.name}')"><i class="fas fa-pencil-alt"></i> 
               Edit</a>
            <a class="btn btn-danger btn-sm" onclick="deleteCustomer(${cms.id})"><i class="fas fa-trash"></i> 
               Delete</a>
          </td>
        </tr>
      `).join('');
   }

   function showAddModal(){
      $('#customerModal').modal('show');
      document.getElementById('modalLabel').textContent = 'Add Customer'
      document.getElementById('customerForm').reset()
      document.getElementById('customerId').value = ''
   }

   function showEditModal(id, name) {
      $('#customerModal').modal('show');
      document.getElementById('modalLabel').textContent = 'Edit Customer'
      document.getElementById('customerId').value = id
      document.getElementById('customerName').value = name
   }

   async function saveCustomer() {
      const id = document.getElementById('customerId').value
      const name = document.getElementById('customerName').value

      const payload = { id, name}
      const method = id ? 'PUT' : 'POST'
      const url = id ? `/api/edit-customer/${id}` : `/api/add-customer`

      await fetch(url, {
         method,
         headers: { 'Content-Type': 'application/json' },
         body: JSON.stringify(payload),
      });

      $('#customerModal').modal('hide');
      fetchCustomer();
   }

   
   async function deleteCustomer(id) {
      const result = await Swal.fire({
         title: 'Are you sure?',
         text: "This action cannot be undone.",
         icon: 'warning',
         showCancelButton: true,
         confirmButtonText: 'Yes, delete it!',
         cancelButtonText: 'Cancel',
         reverseButtons: true
      });

      if (result.isConfirmed) {
         try {
            const res = await fetch(`api/delete-customer/${id}`, { method: 'DELETE' });

            if (res.ok) {
               Swal.fire(
                  'Deleted!',
                  'Your customer has been deleted.',
                  'success'
               );
               fetchCustomer();
            } else {
               const errorData = await res.json();
               Swal.fire(
                  'Error!',
                  `Failed to delete customer: ${JSON.stringify(errorData)}`,
                  'error'
               );
            }
         } catch (error) {
            console.error('Unexpected Error:', error);
            Swal.fire(
               'Error!',
               'An unexpected error occurred.',
               'error'
            );
         }
      }
   }

   fetchCustomer()

</script>
@endsection