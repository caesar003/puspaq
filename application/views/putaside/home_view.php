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
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="#">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Link</a>
            </li>
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

          <form id="addQueue" class="mb-3">
            <div class="mb-3">
              <label for="queueID">NIK</label>
              <input type="text" class="form-control form-control-sm" id="queueID">
            </div>
            <div class="mb-3">
              <label for="">Tujuan</label>
              <select class="form-select form-select-sm" id="queueDest">
                <option value="">Pilih</option>
                <option value="kia">KIA</option>
                <option value="mtbs">MTBS</option>
                <option value="bp">BP</option>
                <option value="gigidanmulut">Gigi dan mulut</option>
                <option value="persalinan">Persalinan</option>
              </select>
            </div>

            <button type="submit" class="btn btn-warning"><i class="fas fa-plus"></i> Tambah</button>
          </form>
          <div class="">
            <h4>Daftar Antrian</h4>
            <ul class="list-group" id="queueList">
            </ul>
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
                <div class="row">
                  <div class="col-4">Filter</div>
                  <div class="col-8">
                    <select class="form-select" id="destFilterSelect">

                      <option value="">Pilih</option>
                      <option value="kia">KIA</option>
                      <option value="mtbs">MTBS</option>
                      <option value="bp">BP</option>
                      <option value="gigidanmulut">Gigi dan mulut</option>
                      <option value="persalinan">Persalinan</option>
                    </select>
                  </div>
                </div>
                <div class="row">
                  <div id="queueDisplay" class="col-10">
                    <!-- 12/<small>18</small> -->
                  </div>
                  <div class="col-2 d-flex align-items-center">
                    <button title="Mulai" type="button" class="btn btn-primary btn-lg start-queue is-hidden"><i class="fas fa-play"></i></button>
                    <button title="Berikutnya" type="button" class="btn btn-info btn-lg next-queue is-hidden"><i class="fas fa-chevron-right"></i></button>
                    <button title="Selesai" type="button" class="btn btn-warning btn-lg finish-queue is-hidden"> <i class="fas fa-stop"></i></button>
                  </div>
                </div>
                <div class="d-flex justify-content-around text-center">
                  <div id="KIAq"> </div>
                  <div id="MTBSq"> </div>
                  <div id="BPq"> </div>
                  <div id="Gigimulutq"> </div>
                  <div id="Persalinanq"> </div>
                </div>

                <div class="mt-2 row" id="patientInfo">

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
                    <label for="">Nama</label>
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

    <form id="editPatientForm">
      <div class="modal fade" id="editPatientModal" tabindex="-1" aria-labelledby="editPatientModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="editPatientModalLabel">Ubah informasi</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-6">
                  <div class="mb-2">
                    <label for="">Nama</label>
                    <div class="input-group">
                      <span class="input-group-text"><i class="fas fa-user"></i></span>
                      <input type="text" class="form-control form-control-sm" id="editName">
                    </div>
                  </div>

                  <div class="mb-2">
                    <label for="">NIK</label>
                    <div class="input-group">
                      <span class="input-group-text"><i class="fas fa-id-badge"></i></span>
                      <input type="text" class="form-control form-control-sm" id="editCID">
                    </div>
                  </div>

                  <div class="mb-2">
                    <label for="">No RM</label>
                    <div class="input-group">
                      <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                      <input type="text" class="form-control form-control-sm" id="editRM">
                    </div>
                  </div>

                  <div class="mb-2">
                    <label for="">No JKN</label>
                    <div class="input-group">
                      <span class="input-group-text"><i class="fas fa-id-card-alt"></i></span>
                      <input type="text" class="form-control form-control-sm" id="editJKN">
                    </div>
                  </div>

                  <div class="mb-2">
                    <label for="address">Alamat</label>
                    <div class="input-group">
                      <span class="input-group-text"><i class="fas fa-home"></i></span>
                      <input type="text" class="form-control form-control-sm" id="editAddress">
                    </div>
                  </div>
                  <div class="mb-2">
                    <label for="phone">Telepon</label>
                    <div class="input-group">
                      <span class="input-group-text"><i class="fas fa-phone"></i></span>
                      <input type="text" class="form-control form-control-sm" id="editPhone">
                    </div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="mb-2">
                    <label for="">Riwayat penyakit</label>
                    <div class="input-group">
                      <span class="input-group-text"><i class="fas fa-history"></i></span>
                      <input type="text" class="form-control form-control-sm" id="editDisHistory">
                    </div>
                  </div>



                  <div class="mb-2">
                    <label for="">Alergi</label>
                    <div class="input-group">
                      <span class="input-group-text"><i class="fas fa-allergies"></i></span>
                      <input type="text" class="form-control form-control-sm" id="editAllergic">
                    </div>
                  </div>

                  <div class="mb-2">
                    <label for="">Diagnosa</label>
                    <div class="input-group">
                      <span class="input-group-text"><i class="fas fa-microscope"></i></span>
                      <input type="text" class="form-control form-control-sm" id="editDiag">
                    </div>
                  </div>
                  <div class="mb-2">
                    <label for="med">Obat</label>
                    <div class="input-group">
                      <span class="input-group-text"><i class="fas fa-capsules"></i></span>
                      <input type="text" class="form-control form-control-sm" id="editMed">
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

    <div class="modal fade" id="viewPatientModal" tabindex="-1" aria-labelledby="viewPatientModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="viewPatientModalLabel"></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body" id="viewPatientInfo">

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"></i> Tutup</button>
          </div>
        </div>
      </div>
    </div>

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

    <form id="editQueueForm">
      <div class="modal fade" id="editQueueModal" tabindex="-1" aria-labelledby="editQueueModalLabel" aria-hidden="true">

        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="editQueueModalLabel">Ubah data</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <p class="">Anda akan menghapus <span id="qtdname"></span> dari daftar antrian</p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-arrow-left"></i> Batal</button>
              <button type="submit" class="btn btn-danger"><i class="fas fa-check"></i> Perbarui</button>
            </div>
          </div>
        </div>
      </div>
    </form>

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
    <script type="text/javascript">
      "use strict";
      const U = "<?php echo site_url()?>";
      const B = "<?php echo base_url()?>";
      const Uname = "<?php echo $this->session->userdata('name')?>";
      const Oid = "<?php echo $this->session->userdata('id')?>";
      const State = {
        patients: [],
        queues: [],
        toUpdate: {id: null},
        toDelete: {id: null},
        Queue: {
          toDelete: null,
          toUpdate: null,
          queues: [],
          current: 0,
          total: 0,
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
          ]
        },

      };

      const getPatients = () => {
        $.ajax({
          url: `${U}/patient/get`,
          dataType: "json",
          type: "get",
          async: false,
          success: function(data){
            State.patients = data;
          }
        });
      }
      const getQueues = () => {
        $.ajax({
          url: `${U}/service/get`,
          dataType: "json",
          type: "get",
          async: false,
          success: function(res){
            State.queues = res;
          }
        })
      }
      getPatients();
      // getQueues();
    </script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/queue.js')?>"></script>
  </body>
</html>
