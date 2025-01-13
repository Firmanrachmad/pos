@extends('layouts.template')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
       <div class="container-fluid">
          <div class="row mb-2">
             <div class="col-sm-6">
                <h1>Reporting</h1>
             </div>
             <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                   <li class="breadcrumb-item"><a href="#">Home</a></li>
                   <li class="breadcrumb-item active">Reporting</li>
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
                        <h3 class="card-title">Filtering Options</h3>
                   </div>
                   <div class="card-body">
                    <form id="reportingForm">
                        <div class="row">
                            <!-- Format Output -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Format Output</label>
                                    <div class="d-flex">
                                        <div class="form-check mr-3">
                                            <input class="form-check-input" type="radio" name="format" id="formatCsv" value="csv">
                                            <label class="form-check-label" for="formatCsv">.csv</label>
                                        </div>
                                        <div class="form-check mr-3">
                                            <input class="form-check-input" type="radio" name="format" id="formatXlsx" value="xlsx">
                                            <label class="form-check-label" for="formatXlsx">.xlsx</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="format" id="formatPdf" value="pdf">
                                            <label class="form-check-label" for="formatPdf">.pdf</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                          <!-- Jenis Laporan -->
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label for="reportType">Report Type</label>
                                  <select class="form-control" id="reportType" name="reportType" required>
                                      <option value="transactions">Laporan Transaksi</option>
                                      <option value="payments">Laporan Pembayaran</option>
                                      <option value="receivables">Laporan Piutang</option>
                                      <option value="sales_per_customer">Penjualan per Pelanggan</option>
                                      <option value="revenue">Pendapatan Harian/Bulanan</option>
                                  </select>
                              </div>
                          </div>

                          <!-- Rentang Tanggal -->
                          <div class="col-md-6">
                              <div class="form-group">
                                <label>Date range</label>
                                <div class="input-group">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text">
                                      <i class="far fa-calendar-alt"></i>
                                    </span>
                                  </div>
                                  <input type="text" class="form-control float-right" id="dateRange">
                                </div>
                                <!-- /.input group -->
                              </div>
                              <!-- /.form group -->
                          </div>
                        </div>

                        <div class="row">
                            <!-- Status Pembayaran -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="paymentStatus">Transaction Status</label>
                                    <div class="d-flex">
                                        <div class="form-check mr-3">
                                            <input class="form-check-input" type="checkbox" name="payStatus" id="statusPaid" value="paid">
                                            <label class="form-check-label" for="statusPaid">Paid</label>
                                        </div>
                                        <div class="form-check mr-3">
                                            <input class="form-check-input" type="checkbox" name="payStatus" id="statusPending" value="pending">
                                            <label class="form-check-label" for="statusPending">Pending</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="payStatus" id="statusUnpaid" value="unpaid">
                                            <label class="form-check-label" for="statusUnpaid">Unpaid</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Pelanggan -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="customer">Select Customer</label>
                                    <select class="form-control select2bs4" id="customerSelect" tyle="width: 100%;">
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                   </div>
                   <div class="card-footer d-flex justify-content-between">
                    <button class="btn btn-secondary" type="reset" onclick="refresh()">
                      <i class="fas fa-sync"></i> Refresh
                    </button>
                    <button class="btn btn-primary ml-auto" onclick="generateReport()">
                      <i class="fas fa-download"></i> Generate Report
                    </button>
                  </div>
                </div>
             </div>
          </div>
       </div>
    </section>
 </div>
 <script>
    $(function () {
        $('#dateRange').daterangepicker()
    });

    const refresh = () => {
        $('#reportingForm').trigger('reset')
    }

    async function fetchCustomers() {
        try {
            const res = await fetch('api/customer')
            if (!res.ok) throw new Error('Failed to fetch customers')
            const response = await res.json()

            const customers = response.data || response
            document.getElementById('customerSelect').innerHTML = `
                <option value="all" selected>All Customers</option>
                ${customers.map(customer => `
                    <option value="${customer.id}">${customer.name}</option>
                `).join('')}
            `;

            $('.select2bs4').select2({
                theme: 'bootstrap4',
            });
        } catch (error) {
            console.error('Error fetching customers:', error)
            toastr.error('Failed to load customers.')
        }
    }


    async function generateReport() {
        const format = $('input[name="format"]:checked').val();
        const reportType = $('#reportType').val();
        const dateRange = $('#dateRange').val();
        const paymentStatus = $('input[name="payStatus"]:checked').map(function () {
            return $(this).val();
        }).get();
        const customer = document.getElementById('customerSelect').value

        const data = {
            format,
            reportType,
            dateRange,
            paymentStatus,
            customer,
        }

        console.log(data)

        if (format === undefined || reportType === undefined || dateRange === undefined || paymentStatus.length === 0) {
            toastr.error('Please fill all the fields');
            return;
        }

        const response = await fetch('/api/report', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        });

        if (response.ok) {
            const blob = await response.blob();
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `report.${format}`;
            a.click();
            window.URL.revokeObjectURL(url);
        } else {
            const error = await response.json();
            console.error('Error generating report:', error);
            toastr.error('Failed to generate report.');
        }
    }

    fetchCustomers()




 </script>
@endsection
