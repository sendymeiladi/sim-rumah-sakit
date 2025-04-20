<input type="hidden" id="id">

<div class="modal fade" id="addEmployeesButton" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered1 modal-simple modal-add-new-cc">
    <div class="modal-content p-3 p-md-5">
      <div class="modal-body p-md-0">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="text-center mb-4">
          <h3 class="mb-2 pb-1 title">Tambah Karyawan Baru</h3>
        </div>
        <form id="addNewCCForm" class="row g-4" onsubmit="return false">
          <div class="col-12">
            <div class="form-floating form-floating-outline">
              <input id="nip" name="employeesNip" class="form-control credit-card-mask" type="number"
                placeholder="No NIP" />
              <div class="invalid-feedback"></div>
              <label for="modalAddCard">NIP</label>
            </div>
         </div>

          <div class="col-12">
              <div class="form-floating form-floating-outline">
                <input id="name" name="employeesName" class="form-control credit-card-mask" type="text"
                  placeholder="Nama Karyawan" />
                <div class="invalid-feedback"></div>
                <label for="modalAddCard">Nama</label>
              </div>
          </div>

        <div class="col-12">
            <div class="form-floating form-floating-outline">
                <p class="invalid-feedback"></p>
                <select id="position" class="form-control">
                    <option value="">Pilih Posisi</option>
                    <option value="Dokter">Dokter</option>
                    <option value="Perawat">Perawat</option>
                    <option value="Apoteker">Apoteker</option>
                    <option value="Kasir">Kasir</option>
                    <option value="Petugas">Petugas</option>
                </select>
                <div class="invalid-feedback"></div>
                <label for="modalAddCard">Posisi</label>
            </div>
        </div>

        <div class="col-12">
            <div class="form-floating form-floating-outline">
                <input id="joined_date" name="employeesjoinedDate" class="form-control" type="date"
                    placeholder="Tanggal Masuk" />
                <div class="invalid-feedback"></div>
                <label for="modalAddCard">Tanggal Masuk</label>
            </div>
        </div>

            <div class="col-12">
                <div class="form-floating form-floating-outline">
                    <input id="phone" name="employeesPhone" class="form-control" type="tel"
                    placeholder="Nomor Telepon" />
                    <div class="invalid-feedback"></div>
                    <label for="modalAddCard">Nomor Telepon</label>
                </div>
            </div>

            <div class="col-12">
                <div class="form-floating form-floating-outline">
                    <textarea id="address" name="employeesAddress" class="form-control"
                        placeholder="Alamat" style="height: 100px;"></textarea>
                    <div class="invalid-feedback"></div>
                    <label for="modalAddCard">Alamat</label>
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
