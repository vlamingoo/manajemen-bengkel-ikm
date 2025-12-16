@extends('adminlte::page')

@section('title', 'Tambah Transaksi Servis')

@section('content_header')
    <h1>Tambah Transaksi Servis</h1>
@stop

@section('content')
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('transactions.store') }}" method="POST">
        @csrf
        
        {{-- Data Transaksi --}}
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Data Transaksi</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Kode Transaksi</label>
                            <input type="text" class="form-control" value="{{ $kodeTransaksi }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Tanggal Servis <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_servis" class="form-control @error('tanggal_servis') is-invalid @enderror" 
                                   value="{{ old('tanggal_servis', date('Y-m-d')) }}" required>
                            @error('tanggal_servis')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Data Pelanggan & Kendaraan --}}
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Data Pelanggan & Kendaraan</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Pelanggan <span class="text-danger">*</span></label>
                            <select name="customer_id" id="customer_id" class="form-control @error('customer_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Pelanggan --</option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                        {{ $customer->nama }} - {{ $customer->no_telp }}
                                    </option>
                                @endforeach
                            </select>
                            @error('customer_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Kendaraan <span class="text-danger">*</span></label>
                            <select name="vehicle_id" id="vehicle_id" class="form-control @error('vehicle_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Pelanggan Dulu --</option>
                            </select>
                            @error('vehicle_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Keluhan & Tindakan --}}
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Keluhan & Tindakan</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label>Keluhan <span class="text-danger">*</span></label>
                    <textarea name="keluhan" class="form-control @error('keluhan') is-invalid @enderror" 
                              rows="3" placeholder="Masukkan keluhan pelanggan..." required>{{ old('keluhan') }}</textarea>
                    @error('keluhan')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Tindakan/Perbaikan</label>
                    <textarea name="tindakan" class="form-control" rows="3" 
                              placeholder="Masukkan tindakan yang dilakukan...">{{ old('tindakan') }}</textarea>
                </div>

                <div class="form-group">
                    <label>Keterangan Tambahan</label>
                    <textarea name="keterangan" class="form-control" rows="2" 
                              placeholder="Keterangan lain (opsional)">{{ old('keterangan') }}</textarea>
                </div>
            </div>
        </div>

        {{-- Sparepart yang Digunakan --}}
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Sparepart yang Digunakan</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-success btn-sm" id="addSparepart">
                        <i class="fas fa-plus"></i> Tambah Sparepart
                    </button>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered" id="sparepartTable">
                    <thead>
                        <tr>
                            <th width="40%">Sparepart</th>
                            <th width="15%">Harga</th>
                            <th width="15%">Qty</th>
                            <th width="20%">Subtotal</th>
                            <th width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="sparepartBody">
                        <tr>
                            <td colspan="5" class="text-center text-muted">Belum ada sparepart dipilih</td>
                        </tr>
                    </tbody>
                </table>
                
                <div class="mt-3">
                    <div class="row">
                        <div class="col-md-8 text-right">
                            <strong>Total Sparepart:</strong>
                        </div>
                        <div class="col-md-4">
                            <input type="text" id="totalSparepart" class="form-control" value="Rp 0" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Biaya --}}
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Biaya Servis</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Biaya Jasa <span class="text-danger">*</span></label>
                            <input type="number" name="biaya_jasa" id="biaya_jasa" 
                                   class="form-control @error('biaya_jasa') is-invalid @enderror" 
                                   value="{{ old('biaya_jasa', 0) }}" min="0" step="1000" required>
                            @error('biaya_jasa')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Total Biaya</label>
                            <input type="text" id="totalBiaya" class="form-control font-weight-bold text-success" 
                                   value="Rp 0" readonly style="font-size: 18px;">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tombol Aksi --}}
        <div class="card">
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan Transaksi
                </button>
                <a href="{{ route('transactions.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </form>
@stop

@section('js')
<script>
    let sparepartData = @json($spareparts);
    let rowIndex = 0;

    // Load vehicles saat customer dipilih
    $('#customer_id').change(function() {
        let customerId = $(this).val();
        $('#vehicle_id').html('<option value="">Loading...</option>');
        
        if(customerId) {
            $.get('/get-vehicles/' + customerId, function(data) {
                let options = '<option value="">-- Pilih Kendaraan --</option>';
                data.forEach(function(vehicle) {
                    options += `<option value="${vehicle.id}">${vehicle.merk} ${vehicle.model} - ${vehicle.no_plat}</option>`;
                });
                $('#vehicle_id').html(options);
            });
        } else {
            $('#vehicle_id').html('<option value="">-- Pilih Pelanggan Dulu --</option>');
        }
    });

    // Tambah baris sparepart
    $('#addSparepart').click(function() {
        let options = '<option value="">-- Pilih Sparepart --</option>';
        sparepartData.forEach(function(sp) {
            options += `<option value="${sp.id}" data-harga="${sp.harga}">${sp.nama_sparepart} (Stok: ${sp.stok})</option>`;
        });

        let newRow = `
            <tr data-row="${rowIndex}">
                <td>
                    <select name="sparepart_id[]" class="form-control sparepart-select" data-row="${rowIndex}" required>
                        ${options}
                    </select>
                </td>
                <td>
                    <input type="number" class="form-control harga-input" data-row="${rowIndex}" readonly>
                </td>
                <td>
                    <input type="number" name="qty[]" class="form-control qty-input" data-row="${rowIndex}" min="1" value="1" required>
                </td>
                <td>
                    <input type="text" class="form-control subtotal-display" data-row="${rowIndex}" readonly>
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm remove-sparepart">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
        `;

        if($('#sparepartBody tr td[colspan]').length) {
            $('#sparepartBody').html(newRow);
        } else {
            $('#sparepartBody').append(newRow);
        }

        rowIndex++;
    });

    // Hapus baris sparepart
    $(document).on('click', '.remove-sparepart', function() {
        $(this).closest('tr').remove();
        
        if($('#sparepartBody tr').length === 0) {
            $('#sparepartBody').html('<tr><td colspan="5" class="text-center text-muted">Belum ada sparepart dipilih</td></tr>');
        }
        
        hitungTotal();
    });

    // Update harga saat sparepart dipilih
    $(document).on('change', '.sparepart-select', function() {
        let row = $(this).data('row');
        let harga = $(this).find(':selected').data('harga') || 0;
        $(`.harga-input[data-row="${row}"]`).val(harga);
        hitungSubtotal(row);
    });

    // Update subtotal saat qty berubah
    $(document).on('input', '.qty-input', function() {
        let row = $(this).data('row');
        hitungSubtotal(row);
    });

    // Update total saat biaya jasa berubah
    $('#biaya_jasa').on('input', function() {
        hitungTotal();
    });

    function hitungSubtotal(row) {
        let harga = parseFloat($(`.harga-input[data-row="${row}"]`).val()) || 0;
        let qty = parseFloat($(`.qty-input[data-row="${row}"]`).val()) || 0;
        let subtotal = harga * qty;
        
        $(`.subtotal-display[data-row="${row}"]`).val('Rp ' + formatRupiah(subtotal));
        hitungTotal();
    }

    function hitungTotal() {
        let totalSparepart = 0;
        
        $('.subtotal-display').each(function() {
            let val = $(this).val().replace('Rp ', '').replace(/\./g, '');
            totalSparepart += parseFloat(val) || 0;
        });

        let biayaJasa = parseFloat($('#biaya_jasa').val()) || 0;
        let totalBiaya = totalSparepart + biayaJasa;

        $('#totalSparepart').val('Rp ' + formatRupiah(totalSparepart));
        $('#totalBiaya').val('Rp ' + formatRupiah(totalBiaya));
    }

    function formatRupiah(angka) {
        return angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }
</script>
@stop