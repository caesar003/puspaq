<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta charset="utf-8">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/lib/bootstrap.min.css')?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/lib/dataTables.bootstrap5.min.css')?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/fontawesome-free-5.12.0-web/css/all.min.css')?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/home.css')?>">
    <title>Beranda</title>
  </head>
  <body>

    <nav class="navbar navbar-expand navbar-dark bg-dark">
      <div class="container-fluid">
        <a class="navbar-brand" href="#"><img src="<?php echo base_url('assets/images/logo.png')?>" width="45px"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <!-- <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="#">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Link</a>
            </li> -->
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <?php echo $this->session->userdata('name')?>
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="<?php echo site_url('login/logout')?>"><i class="fas fa-sign-out-alt"></i>Keluar</a></li>
                <!-- <li><a class="dropdown-item" href="#">Another action</a></li> -->
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="<?php echo site_url('user')?>"><i class="fas fa-key"></i> Ubah sandi</a></li>
              </ul>
            </li>

          </ul>

        </div>
      </div>
    </nav>
    <div class="container mt-2">
      <div class="row">
        <div class="col-4">
          <h4>Tambah antrian
              <small class="float-end"><button title="Tambah pasien" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPatientModal">
              <i class="fas fa-plus"></i>
              </button>
              </small>
          </h4>

          <form id="addQueueForm" class="mb-3">
            <div class="mb-3">
              <label for="queueID">NIK</label>
              <input type="text" class="form-control form-control-sm" id="queueID">
            </div>
            <div class="mb-3">
              <label for="queueDest">Tujuan</label>
              <select class="form-select form-select-sm" id="queueDest">
                <option value="">Pilih</option>
                <option value="kia">KIA</option>
                <option value="mtbs">MTBS</option>
                <option value="bp">BP</option>
                <option value="gigidanmulut">Gigi dan mulut</option>
                <option value="persalinan">Persalinan</option>
              </select>
            </div>

            <div class="mb-3">
              <label for="queueNumber">Nomor antrian</label>
              <input class="form-control form-control-sm" id="queueNumber">
            </div>

            <button type="submit" class="btn btn-warning"><i class="fas fa-plus"></i> Tambah</button>
          </form>
          <div id="queueInfo">

          </div>

        </div>
        <div class="col-8">
          <div class="bd-example">
            <nav>
              <div class="nav nav-tabs mb-3" id="nav-tab" role="tablist">
                <a class="nav-link active" id="nav-queue-tab" data-bs-toggle="tab" href="#nav-queue" role="tab" aria-controls="nav-queue" aria-selected="true">Antrian</a>
                <a class="nav-link" id="nav-patients-tab" data-bs-toggle="tab" href="#nav-patients" role="tab" aria-controls="nav-patients" aria-selected="false">Pasien</a>
              </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
              <div class="tab-pane fade active show" id="nav-queue" role="tabpanel" aria-labelledby="nav-queue-tab">
                <div class="row mb-2">
                  <div class="col-4">Antrian tanggal:</div>
                  <div class="col-8"><input type="date" class="form-control" id="queueDate" value="<?php echo Date("Y-m-d")?>"></div>
                </div>
                <h1 class="text-center fw-bold display-1" id="queueTotal"></h1>
                <div class="border d-flex justify-content-around text-center mb-3" id="queueDests">
                </div>

                <div class="row" id="queueList">

                </div>
              </div>
              <div class="tab-pane fade pt-3" id="nav-patients" role="tabpanel" aria-labelledby="nav-patients-tab">
                <table class="table table-striped table-bordered" id="patientList">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Nama</th>
                      <th>NIK</th>
                      <th>No RM</th>
                      <th>No JKN</th>
                      <th>Alamat</th>
                      <th>Telepon</th>
                      <!-- <th>Riwayat Penyakit</th>
                      <th>Alergi</th>
                      <th>Diagnosa</th>
                      <th>Obat</th> -->
                      <th>Tindakan</th>
                    </tr>
                  </thead>
                </table>
              </div>

            </div>
          </div>

        </div>
      </div>
    </div>
    <!-- ADD PATIENT -->
    <form id="addPatientForm">
      <div class="modal fade" id="addPatientModal" tabindex="-1" aria-labelledby="addPatientModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="addPatientModalLabel">Tambah  Pasien</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-6">
                  <div class="mb-2">
                    <label for="regName">Nama</label>
                    <div class="input-group">
                      <span class="input-group-text"><i class="fas fa-user"></i></span>
                      <input type="text" class="form-control form-control-sm" id="regName">
                    </div>
                  </div>

                  <div class="mb-2">
                    <label for="regCID">NIK</label>
                    <div class="input-group">
                      <span class="input-group-text"><i class="fas fa-id-badge"></i></span>
                      <input type="text" class="form-control form-control-sm" id="regCID">
                    </div>
                  </div>

                  <div class="mb-2">
                    <label for="regRM">No RM</label>
                    <div class="input-group">
                      <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                      <input type="text" class="form-control form-control-sm" id="regRM">
                    </div>
                  </div>

                  <div class="mb-2">
                    <label for="regJKN">No JKN</label>
                    <div class="input-group">
                      <span class="input-group-text"><i class="fas fa-id-card-alt"></i></span>
                      <input type="text" class="form-control form-control-sm" id="regJKN">
                    </div>
                  </div>

                  <div class="mb-2">
                    <label for="regAddress">Alamat</label>
                    <div class="input-group">
                      <span class="input-group-text"><i class="fas fa-home"></i></span>
                      <input type="text" class="form-control form-control-sm" id="regAddress">
                    </div>
                  </div>
                  <div class="mb-2">
                    <label for="regPhone">Telepon</label>
                    <div class="input-group">
                      <span class="input-group-text"><i class="fas fa-phone"></i></span>
                      <input type="text" class="form-control form-control-sm" id="regPhone">
                    </div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="mb-2">
                    <label for="regDisHistory">Riwayat penyakit</label>
                    <div class="input-group">
                      <span class="input-group-text"><i class="fas fa-history"></i></span>
                      <input type="text" class="form-control form-control-sm" id="regDisHistory">
                    </div>
                  </div>

                  <div class="mb-2">
                    <label for="regAllergic">Alergi</label>
                    <div class="input-group">
                      <span class="input-group-text"><i class="fas fa-allergies"></i></span>
                      <input type="text" class="form-control form-control-sm" id="regAllergic">
                    </div>

                  </div>

                  <div class="mb-2">
                    <label for="regDiag">Diagnosa</label>
                    <div class="input-group">
                      <span class="input-group-text"><i class="fas fa-microscope"></i></span>
                      <input type="text" class="form-control form-control-sm" id="regDiag">
                    </div>
                  </div>
                  <div class="mb-2">
                    <label for="regMed">Obat</label>
                    <div class="input-group">
                      <span class="input-group-text"><i class="fas fa-capsules"></i></span>
                      <input type="text" class="form-control form-control-sm" id="regMed">
                    </div>
                  </div>
                  <div class="form-check mb-3">
                    <input type="checkbox" class="form-check-input" id="addToList">
                    <label class="form-check-label" for="addToList">Tambahkan ke daftar antrian</label>
                  </div>

                  <div class="mb-3 is-hidden" id="regAddQueueC">
                    <label for="regAddQueue">Tujuan</label>
                    <select class="form-select form-select-sm" id="regAddQueue">
                      <option value="">Pilih tujuan</option>
                      <option value="kia">KIA</option>
                      <option value="mtbs">MTBS</option>
                      <option value="bp">BP</option>
                      <option value="gigidanmulut">Gigi dan mulut</option>
                      <option value="persalinan">Persalinan</option>
                    </select>
                  </div>
                </div>
              </div>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"> </i> Batal</button>
              <button type="submit" class="btn btn-primary"><i class="fas fa-check"></i> Simpan</button>
            </div>
          </div>
        </div>

      </div>
    </form>
    <!-- UPDATE PATIENT -->
    <form id="updatePatientForm">
      <div class="modal fade" id="updatePatientModal" tabindex="-1" aria-labelledby="updatePatientModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="updatePatientModalLabel">Ubah informasi</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-6">
                  <div class="mb-2">
                    <label for="updateName">Nama</label>
                    <div class="input-group">
                      <span class="input-group-text"><i class="fas fa-user"></i></span>
                      <input type="text" class="form-control form-control-sm" id="updateName">
                    </div>
                  </div>

                  <div class="mb-2">
                    <label for="updateCID">NIK</label>
                    <div class="input-group">
                      <span class="input-group-text"><i class="fas fa-id-badge"></i></span>
                      <input type="text" class="form-control form-control-sm" id="updateCID">
                    </div>
                  </div>

                  <div class="mb-2">
                    <label for="updateRM">No RM</label>
                    <div class="input-group">
                      <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                      <input type="text" class="form-control form-control-sm" id="updateRM">
                    </div>
                  </div>

                  <div class="mb-2">
                    <label for="updateJKN">No JKN</label>
                    <div class="input-group">
                      <span class="input-group-text"><i class="fas fa-id-card-alt"></i></span>
                      <input type="text" class="form-control form-control-sm" id="updateJKN">
                    </div>
                  </div>

                  <div class="mb-2">
                    <label for="updateAddress">Alamat</label>
                    <div class="input-group">
                      <span class="input-group-text"><i class="fas fa-home"></i></span>
                      <input type="text" class="form-control form-control-sm" id="updateAddress">
                    </div>
                  </div>
                  <div class="mb-2">
                    <label for="updatePhone">Telepon</label>
                    <div class="input-group">
                      <span class="input-group-text"><i class="fas fa-phone"></i></span>
                      <input type="text" class="form-control form-control-sm" id="updatePhone">
                    </div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="mb-2">
                    <label for="updateDisHistory">Riwayat penyakit</label>
                    <div class="input-group">
                      <span class="input-group-text"><i class="fas fa-history"></i></span>
                      <input type="text" class="form-control form-control-sm" id="updateDisHistory">
                    </div>
                  </div>

                  <div class="mb-2">
                    <label for="updateAllergic">Alergi</label>
                    <div class="input-group">
                      <span class="input-group-text"><i class="fas fa-allergies"></i></span>
                      <input type="text" class="form-control form-control-sm" id="updateAllergic">
                    </div>
                  </div>

                  <div class="mb-2">
                    <label for="updateDiag">Diagnosa</label>
                    <div class="input-group">
                      <span class="input-group-text"><i class="fas fa-microscope"></i></span>
                      <input type="text" class="form-control form-control-sm" id="updateDiag">
                    </div>
                  </div>
                  <div class="mb-2">
                    <label for="updateMed">Obat</label>
                    <div class="input-group">
                      <span class="input-group-text"><i class="fas fa-capsules"></i></span>
                      <input type="text" class="form-control form-control-sm" id="updateMed">
                    </div>
                  </div>


                </div>
              </div>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"> </i> Batal</button>
              <button type="submit" class="btn btn-primary"><i class="fas fa-check"></i> Simpan perubahan</button>
            </div>
          </div>
        </div>
      </div>
    </form>
    <!-- VIEW PATIENT -->
    <div class="modal fade" id="viewPatientModal" tabindex="-1" aria-labelledby="viewPatientModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="viewPatientModalLabel"></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body row">
            <div class="col-6" id="viewPatientInfo">

            </div>
            <div class="col-6">
              <h6>Riwayat kunjungan</h6>
              <ul class="list-unstyled" id="vHist"></ul>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"></i> Tutup</button>
          </div>
        </div>
      </div>
    </div>
    <!-- DELETE PATIENT -->
    <form id="deletePatientForm">
      <div class="modal fade" id="deletePatientModal" tabindex="-1" aria-labelledby="deletePatientModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="deletePatientModalLabel">Apakah anda yakin?</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <p class="text-white bg-warning p-3">Tindakan ini dapat mengakibatkan kehilangan data secara permanen!</p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-arrow-left"></i> Batal</button>
              <button type="submit" class="btn btn-danger"> <i class="fas fa-trash"></i> Hapus</button>
            </div>
          </div>
        </div>
      </div>
    </form>
    <!-- UPDATE QUEUE -->
    <form id="updateQueueForm">
      <div class="modal fade" id="updateQueueModal" tabindex="-1" aria-labelledby="editQueueModalLabel" aria-hidden="true">

        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="updateQueueModalLabel">Ubah data</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class="mb-3">
                <label for="updateQueueID">NIK</label>
                <input type="text" class="form-control form-control-sm" id="updateQueueID" readonly>
              </div>
              <div class="mb-3">
                <label for="updateQueueDest">Tujuan</label>
                <select class="form-select form-select-sm" id="updateQueueDest">
                  <option value="">Pilih</option>
                  <option value="kia">KIA</option>
                  <option value="mtbs">MTBS</option>
                  <option value="bp">BP</option>
                  <option value="gigidanmulut">Gigi dan mulut</option>
                  <option value="persalinan">Persalinan</option>
                </select>
              </div>
              <div class="mb-3">
                <input type="text" class="form-control form-control-sm" id="updateQueuNumber">
              </div>
              <!-- <p class="">Anda akan menghapus <span id="qtdname"></span> dari daftar antrian</p> -->
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-arrow-left"></i> Batal</button>
              <button type="submit" class="btn btn-warning"><i class="fas fa-check"></i> Perbarui</button>
            </div>
          </div>
        </div>
      </div>
    </form>
    <!-- DELETE QUEUE -->
    <form id="deleteQueueForm">
      <div class="modal fade" id="deleteQueueModal" tabindex="-1" aria-labelledby="deleteQueueModalLabel" aria-hidden="true">

        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="deleteQueueModalLabel">Anda yakin?</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" >
              <p class="">Hapus dari daftar antrian?</p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-arrow-left"></i> Batal</button>
              <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i> Hapus</button>
            </div>
          </div>
        </div>
      </div>
    </form>

    <script type="text/javascript" src="<?php echo base_url('assets/js/lib/jquery-3.5.1.min.js') ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/lib/popper.min.js')?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/lib/bootstrap.min.js')?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/lib/jquery.dataTables.min.js')?>"> </script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/lib/dataTables.bootstrap5.min.js')?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/lib/clipboard.js')?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/helpers.js')?>"></script>
    <script type="text/javascript">
      "use strict";
      const U = "<?php echo site_url()?>";
      const B = "<?php echo base_url()?>";
      const Uname = "<?php echo $this->session->userdata('name')?>";
      const Oid = "<?php echo $this->session->userdata('id')?>";
      const State = {
        Patient: {
          toDelete: {id: null},
          toUpdate: {id: null},
          list: [],
        },
        Queue: {
          toDelete: {id: null},
          toUpdate: {id: null},
          toDelete: {id: null},
          list: [],
          total: 0,
          current: 0,
          dest: [
            {id: 1, label: "KIA", value: "kia", current: 0, total: 0},
            {id: 2, label: "MTBS", value: "mtbs", current: 0, total: 0},
            {id: 3, label: "BP", value: "bp", current: 0, total: 0},
            {id: 4, label: "Gigi dan mulut", value: "gigidanmulut", current: 0, total: 0},
            {id: 5, label: "Persalinan", value: "persalinan", current: 0, total: 0},
          ],
          destPEls: [
            $('#KIAq'),
            $('#MTBSq'),
            $('#BPq'),
            $('#Gigimulutq'),
            $('#Persalinanq')
          ],
        },
      };


      const df = new Dateformat();
    </script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/script.js')?>"></script>
  </body>
</html>
