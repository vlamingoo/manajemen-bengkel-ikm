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
                
                {{-- Total Sparepart & Total Biaya Servis --}}
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-money-bill-wave"></i> Total Biaya
                        </h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered mb-0">
                            <tr>
                                <th width="70%">Total Sparepart:</th>
                                <td>
                                    <input type="text" id="totalSparepart" class="form-control-plaintext font-weight-bold" value="Rp 0" readonly>
                                </td>
                            </tr>
                            <tr>
                                <th>Total Biaya Jasa:</th>
                                <td>
                                    <input type="text" id="totalBiayaJasaDisplay" class="form-control-plaintext font-weight-bold" value="Rp 0" readonly>
                                </td>
                            </tr>
                            <tr class="bg-light">
                                <th style="font-size: 18px;">TOTAL BIAYA SERVIS:</th>
                                <td>
                                    <input type="text" id="totalBiayaServis" class="form-control-plaintext font-weight-bold text-success" value="Rp 0" readonly style="font-size: 20px;">
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Biaya Servis --}}
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-calculator"></i> Biaya Servis
                </h3>
            </div>
            <div class="card-body">
                <div class="row">
                    {{-- 1. Biaya Jasa (Dropdown) --}}
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>1. Biaya Jasa <span class="text-danger">*</span></label>
                            <select name="jenis_servis_id" id="jenis_servis" class="form-control @error('jenis_servis_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Jenis Servis --</option>
                                @foreach($jenisServis as $servis)
                                    <option 
                                        value="{{ $servis['id'] }}"
                                        data-tarif="{{ $servis['tarif'] }}"
                                        data-satuan="{{ $servis['satuan'] }}"
                                    >
                                        {{ $servis['nama'] }} (Rp {{ number_format($servis['tarif'], 0, ',', '.') }}/{{ $servis['satuan'] }})
                                    </option>
                                @endforeach
                            </select>
                            @error('jenis_servis_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    {{-- 2. Waktu Pengerjaan (Input Manual) --}}
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>2. Waktu Pengerjaan <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" 
                                    name="waktu_pengerjaan" 
                                    id="waktu_pengerjaan" 
                                    class="form-control @error('waktu_pengerjaan') is-invalid @enderror" 
                                    value="{{ old('waktu_pengerjaan', 1) }}"
                                    min="0.5" 
                                    step="0.5"
                                    placeholder="Contoh: 2"
                                    required>
                                <div class="input-group-append">
                                    <span class="input-group-text" id="satuan_waktu">-</span>
                                </div>
                            </div>
                            <small class="form-text text-muted" id="hint_waktu">
                                Pilih jenis servis terlebih dahulu
                            </small>
                            @error('waktu_pengerjaan')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    {{-- 3. Total Biaya Jasa (Auto Calculate) --}}
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>3. Total Biaya Jasa</label>
                            <input type="text"
                                name="biaya_jasa"
                                id="biaya_jasa"
                                class="form-control font-weight-bold"
                                value="Rp 0"
                                readonly
                                style="background-color: #ffffffff; font-size: 18px; color: #5f5d5dff;"
                                required>
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle"></i> Auto-calculate
                            </small>
                        </div>
                    </div>
                </div>

                {{-- Info Formula --}}
                <div class="alert alert-info mb-0" id="formula_box" style="display: none;">
                    <i class="fas fa-calculator"></i> 
                    <strong>Formula:</strong> 
                    <span id="formula_text"></span>
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
    
    // Data jenis servis dari config
    let jenisServisData = @json($jenisServis);

    // ========== BIAYA JASA CALCULATION - FIXED ==========

let biayaJasaNumeric = 0; // Variable untuk menyimpan nilai numerik biaya jasa

// Saat pilih jenis servis
$('#jenis_servis').change(function() {
    let selected = $(this).find(':selected');
    let tarif = selected.data('tarif') || 0;
    let satuan = selected.data('satuan') || '';
    
    if(satuan) {
        $('#satuan_waktu').text(satuan);
        $('#hint_waktu').text(`Contoh: 1, 2, 3 ${satuan} (bisa desimal: 1.5, 2.5)`);
        hitungBiayaJasa();
        $('#formula_box').show();
    } else {
        $('#satuan_waktu').text('-');
        $('#hint_waktu').text('Pilih jenis servis terlebih dahulu');
        biayaJasaNumeric = 0;
        $('#biaya_jasa').val('Rp 0');
        $('#formula_box').hide();
        hitungTotalBiayaServis();
    }
});

// Saat input waktu pengerjaan
$('#waktu_pengerjaan').on('input', function() {
    hitungBiayaJasa();
});

// Fungsi hitung biaya jasa
function hitungBiayaJasa() {
    let selected = $('#jenis_servis').find(':selected');
    let tarif = selected.data('tarif') || 0;
    let satuan = selected.data('satuan') || 'jam';
    let waktu = parseFloat($('#waktu_pengerjaan').val()) || 0;
    
    // Simpan nilai numerik
    biayaJasaNumeric = tarif * waktu;
    
    // Update tampilan (dengan format Rupiah)
    $('#biaya_jasa').val('Rp ' + formatRupiah(biayaJasaNumeric));
    $('#totalBiayaJasaDisplay').val('Rp ' + formatRupiah(biayaJasaNumeric));
    
    // Update formula text
    $('#formula_text').html(
        'Rp ' + formatRupiah(tarif) + ' × ' + waktu + ' ' + satuan + 
        ' = <strong>Rp ' + formatRupiah(biayaJasaNumeric) + '</strong>'
    );
    
    // Hitung total biaya servis
    hitungTotalBiayaServis();
}

// Fungsi hitung total biaya servis (biaya jasa + sparepart)
function hitungTotalBiayaServis() {
    let totalSparepart = 0;
    
    // Hitung total sparepart
    $('.subtotal-display').each(function() {
        let val = $(this).val().replace('Rp ', '').replace(/\./g, '');
        totalSparepart += parseFloat(val) || 0;
    });
    
    // Gunakan variable numerik langsung (tidak perlu parsing lagi)
    let totalBiayaServis = totalSparepart + biayaJasaNumeric;
    
    // Update display
    $('#totalSparepart').val('Rp ' + formatRupiah(totalSparepart));
    $('#totalBiayaServis').val('Rp ' + formatRupiah(totalBiayaServis));
}

// ========== SPAREPART MANAGEMENT ==========

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
    
    if (sparepartData.length === 0) {
        alert('Tidak ada data sparepart! Silakan tambah sparepart terlebih dahulu.');
        return;
    }
    
    sparepartData.forEach(function(sp) {
        let disabled = '';
        let badge = '';
        
        // LOGIKA SAFETY STOCK KONSISTEN
        if (sp.stok === 0) {
            disabled = 'disabled';
            badge = ' ❌ STOK HABIS';
        } else if (sp.stok <= 3) {
            disabled = 'disabled';
            badge = ' 🔴 URGENT - SEGERA RESTOCK (Stok: ' + sp.stok + ')';
        } else if (sp.stok <= 7) {
            badge = ' 🟠 KRITIS (Stok: ' + sp.stok + ')';
        } else if (sp.stok <= 15) {
            badge = ' 🟡 MENIPIS (Stok: ' + sp.stok + ')';
        } else {
            badge = ' ✅ (Stok: ' + sp.stok + ')';
        }
        
        options += `<option value="${sp.id}" data-harga="${sp.harga}" data-stok="${sp.stok}" ${disabled}>${sp.nama_sparepart}${badge}</option>`;
    });

    let newRow = `
        <tr data-row="${rowIndex}">
            <td>
                <select name="sparepart_id[]" class="form-control sparepart-select" data-row="${rowIndex}" required>
                    ${options}
                </select>
            </td>
            <td>
                <input type="text" class="form-control harga-input" data-row="${rowIndex}" readonly>
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
    
    hitungTotalBiayaServis();
});

// Update harga saat sparepart dipilih
$(document).on('change', '.sparepart-select', function() {
    let row = $(this).data('row');
    let harga = parseFloat($(this).find(':selected').data('harga')) || 0;
    let stok = parseInt($(this).find(':selected').data('stok')) || 0;
    
    // Set max qty sesuai stok tersedia
    $(`.qty-input[data-row="${row}"]`).attr('max', stok);
    
    // Tampilkan harga dengan format Rupiah
    $(`.harga-input[data-row="${row}"]`).val('Rp ' + formatRupiah(harga)).data('harga', harga);
    hitungSubtotal(row);
});

// Update subtotal saat qty berubah
$(document).on('input', '.qty-input', function() {
    let row = $(this).data('row');
    let stok = parseInt($(`.sparepart-select[data-row="${row}"]`).find(':selected').data('stok')) || 0;
    let qty = parseInt($(this).val()) || 0;
    
    // Validasi qty tidak melebihi stok
    if (qty > stok) {
        alert(`Qty tidak boleh melebihi stok tersedia (${stok})`);
        $(this).val(stok);
    }
    
    hitungSubtotal(row);
});

function hitungSubtotal(row) {
    let harga = parseFloat($(`.harga-input[data-row="${row}"]`).data('harga')) || 0;
    let qty = parseFloat($(`.qty-input[data-row="${row}"]`).val()) || 0;
    let subtotal = harga * qty;
    
    $(`.subtotal-display[data-row="${row}"]`).val('Rp ' + formatRupiah(subtotal));
    hitungTotalBiayaServis();
}

function formatRupiah(angka) {
    return Math.round(angka).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

// Konversi sebelum submit: ubah format Rupiah ke numeric
$('form').on('submit', function() {
    // Konversi biaya_jasa dari format Rupiah ke numeric
    $('#biaya_jasa').val(biayaJasaNumeric);
    
    // Validasi minimal
    if (biayaJasaNumeric <= 0) {
        alert('Biaya jasa harus lebih dari 0!');
        return false;
    }
    
    return true;
});
</script>
@stop