<input type="hidden" id="id">

<div class="modal fade" id="prescriptionModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
      <form id="prescriptionForm">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Tambah Resep</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <input type="hidden" name="visit_id" id="visit_id">

            <div id="medicine-container">
            </div>
            <button type="button" class="btn btn-sm btn-secondary" id="addMedicineRow">+ Tambah Obat</button>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
        </div>
      </form>
    </div>
  </div>
