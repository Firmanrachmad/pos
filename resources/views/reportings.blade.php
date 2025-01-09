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
                                  <label for="reportType">Jenis Laporan</label>
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
                                  <label for="dateRange">Rentang Tanggal</label>
                                  <input type="text" class="form-control daterange" id="dateRange" name="dateRange" placeholder="Select Date Range" required>
                              </div>
                          </div>
                        </div>

                        <div class="row">
                            <!-- Status Pembayaran -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="paymentStatus">Status Pembayaran</label>
                                    <div class="d-flex">
                                        <div class="form-check mr-3">
                                            <input class="form-check-input" type="checkbox" id="statusPaid" value="paid">
                                            <label class="form-check-label" for="statusPaid">Paid</label>
                                        </div>
                                        <div class="form-check mr-3">
                                            <input class="form-check-input" type="checkbox" id="statusPending" value="pending">
                                            <label class="form-check-label" for="statusPending">Pending</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="statusUnpaid" value="unpaid">
                                            <label class="form-check-label" for="statusUnpaid">Unpaid</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Pelanggan -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="customer">Pilih Pelanggan</label>
                                    <select class="form-control" id="customer" name="customer" style="width: 100%;">
                                        <option value="all">Semua Pelanggan</option>
                                        <option value="1">Adi</option>
                                        <option value="2">Abid</option>
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
@endsection
