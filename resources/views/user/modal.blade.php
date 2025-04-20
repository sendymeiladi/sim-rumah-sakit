<input type="hidden" id="id" name="id_residential">

<div class="modal fade" id="addUserButton" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered1 modal-simple modal-add-new-cc">
    <div class="modal-content p-3 p-md-5">
      <div class="modal-body p-md-0">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="text-center mb-4">
          <h3 class="mb-2 pb-1 title">Tambah User Baru</h3>
        </div>
        <form id="addNewCCForm" class="row g-4" onsubmit="return false">
          <div class="col-12">
              <div class="form-floating form-floating-outline">
                <input id="name" name="name" class="form-control credit-card-mask" type="text"
                  placeholder="Nama" />
                <div class="invalid-feedback"></div>
                <label for="modalAddCard">Nama</label>
              </div>
          </div>
          <div class="col-12">
              <div class="form-floating form-floating-outline">
                <p class="invalid-feedback"></p>
                <input id="username" name="username" class="form-control credit-card-mask" type="text"
                  placeholder="Username" />
                <div class="invalid-feedback"></div>
                <label for="modalAddCard">Username</label>
              </div>
          </div>

          <div class="col-12">
            <div class="form-floating form-floating-outline">
              <p class="invalid-feedback"></p>
              <input id="password" name="password" class="form-control credit-card-mask" type="password"
                placeholder="Password" />
              <div class="invalid-feedback"></div>
              <label for="modalAddCard">Password</label>
            </div>
        </div>

        <div class="col-12">
            <div class="form-floating form-floating-outline">
                <p class="invalid-feedback"></p>
                <select id="role" class="form-control">
                    <option value="">Pilih Role</option>
                    <option value="Admin">Admin</option>
                    <option value="Petugas">Petugas pendaftaran</option>
                    <option value="Dokter">Dokter</option>
                    <option value="Kasir">Kasir</option>
                </select>
                <div class="invalid-feedback"></div>
                <label for="modalAddCard">Role</label>
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
