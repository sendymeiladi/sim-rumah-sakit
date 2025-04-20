<input type="hidden" id="id">

<div class="modal fade" id="addVisitTreatmentButton" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered1 modal-simple modal-add-new-cc">
    <div class="modal-content p-3 p-md-5">
      <div class="modal-body p-md-0">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="text-center mb-4">
          <h3 class="mb-2 pb-1 title">Buat Tindakan</h3>
        </div>
        <form id="addNewCCForm" class="row g-4" onsubmit="return false">

            <div class="col-12">
                <div class="form-floating form-floating-outline">
                    <p class="invalid-feedback"></p>
                    <select id="name" name="VisitTreatmentName" class="form-control" disabled>
                    <option value="">Pilih Pasien</option>
                    @foreach($patientsData as $patient)
                        <option value="{{ $patient->id }}">{{ $patient->name }}</option>
                    @endforeach
                </select>
                    <div class="invalid-feedback"></div>
                    <label for="modalAddCard">Nama</label>
                </div>
            </div>

            <div class="col-12">
                <div class="form-floating form-floating-outline">
                    <input id="visit_date" name="VisitTreatmentVisitDate" class="form-control" type="datetime-local"
                        placeholder="Waktu Kunjungan" disabled/>
                    <div class="invalid-feedback"></div>
                    <label for="modalAddCard">Waktur</label>
                </div>
            </div>

            <div class="col-12">
                <div class="form-floating form-floating-outline">
                    <p class="invalid-feedback"></p>
                    <select id="visit_type" class="form-control" disabled>
                        <option value="">Pilih Jenis Kunjungan</option>
                        <option value="baru">Baru</option>
                        <option value="lama">Lama</option>
                    </select>
                    <div class="invalid-feedback"></div>
                    <label for="modalAddCard">Jenis Kunjungan</label>
                </div>
            </div>

            <div class="col-12">
                <div class="form-floating form-floating-outline">
                    <p class="invalid-feedback"></p>
                    <select id="treatment" name="VisitTreatmentTreatment" class="form-control">
                    <option value="">Pilih Tindakan</option>
                    @foreach($treatmentsData as $treatment)
                        <option value="{{ $treatment->id }}">{{ $treatment->name }}</option>
                    @endforeach
                </select>
                    <div class="invalid-feedback"></div>
                    <label for="modalAddCard">Tindakan</label>
                </div>
            </div>

          <div class="col-12 text-center">
            <button type="submit" id="submit-button" class="btn btn-danger me-sm-3 me-1">Submit</button>
            <button type="reset" class="btn btn-outline-secondary btn-reset" data-bs-dismiss="modal" aria-label="Close">
              Cancel
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
