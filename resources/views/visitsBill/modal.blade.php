<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="paymentModalLabel">Detail Pembayaran</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p><strong>Nama Pasien:</strong> <span id="patientName"></span></p>
          <p><strong>Jenis Kunjungan:</strong> <span id="visitType"></span></p>
          <p><strong>Tanggal Kunjungan:</strong> <span id="visitDate"></span></p>

          <h6>Tindakan:</h6>
          <ul id="treatmentsList"></ul>

          <h6>Resep Obat:</h6>
          <ul id="prescriptionsList"></ul>

          <h5><strong>Total Pembayaran:</strong> <span id="totalBill"></span></h5>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
          <button type="button" class="btn btn-primary" id="btnBayar">Bayar</button>
        </div>
      </div>
    </div>
  </div>
