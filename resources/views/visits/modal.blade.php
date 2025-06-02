<input type="hidden" id="id">

<div class="modal fade" id="addVisitsButton" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered1 modal-simple modal-add-new-cc">
    <div class="modal-content p-3 p-md-5">
      <div class="modal-body p-md-0">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="text-center mb-4">
          <h3 class="mb-2 pb-1 title">Tambah Kunjungan Baru</h3>
        </div>
        <form id="addNewCCForm" class="row g-4" onsubmit="return false">

            <div class="col-12">
                <div class="form-floating form-floating-outline">
                    <input id="name" name="patientsName" class="form-control credit-card-mask" type="text"
                    placeholder="Nama Pasien" />
                    <div class="invalid-feedback"></div>
                    <label for="modalAddCard">Nama</label>
                </div>
            </div>

            <div class="col-12">
            <div class="form-floating form-floating-outline">
                <input id="nik" name="patientsNik" class="form-control credit-card-mask" type="number"
                placeholder="No NIK" />
                <div class="invalid-feedback"></div>
                <label for="modalAddCard">NIK</label>
            </div>
            </div>

            <div class="col-12">
                <div class="form-floating form-floating-outline">
                    <input id="birth_date" name="patientsBirthDate" class="form-control" type="date"
                        placeholder="Tanggal Lahir" />
                    <div class="invalid-feedback"></div>
                    <label for="modalAddCard">Tanggal Lahir</label>
                </div>
            </div>

            <div class="col-12">
                <div class="form-floating form-floating-outline">
                    <p class="invalid-feedback"></p>
                    <select id="gender" class="form-control">
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                    <div class="invalid-feedback"></div>
                    <label for="modalAddCard">Jenis Kelamin</label>
                </div>
            </div>

            <div class="col-12">
                <div class="form-floating form-floating-outline">
                    <textarea id="address" name="patientsAddress" class="form-control"
                        placeholder="Alamat" style="height: 100px;"></textarea>
                    <div class="invalid-feedback"></div>
                    <label for="modalAddCard">Alamat</label>
                </div>
            </div>

            <div class="col-12">
                <div class="form-floating form-floating-outline">
                    <p class="invalid-feedback"></p>
                    <select id="region" name="patientsRegion" class="form-control">
                    <option value="">Pilih Wilayah</option>
                    @foreach($regionsData as $region)
                        <option value="{{ $region->id }}">{{ $region->name }}</option>
                    @endforeach
                </select>
                    <div class="invalid-feedback"></div>
                    <label for="modalAddCard">Wilayah</label>
                </div>
            </div>

            <div class="col-12">
                <div class="form-floating form-floating-outline">
                    <input id="phone" name="patientsPhone" class="form-control" type="number"
                    placeholder="gunakan 08" maxlength="12" />
                    <div class="invalid-feedback"></div>
                    <label for="modalAddCard">Nomor Telepon</label>
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
