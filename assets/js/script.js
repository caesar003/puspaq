/*
 * script.js
 * application to manage queue of patients,
 * author: caesar, caesar-muksid.com
 */
$(document).ready(function(){
  "use strict";
  // new ClipboardJS('.cidC');
  class Queue {
    constructor(){
      this.submission = {
        get: () => {
          let response = false;
          const input = $('#queueDate').val();
          const d = df.eightDigits(new Date(input));
          $.ajax({
            url: `${U}/service/get`,
            async: false,
            dataType: "json",
            data: {d: d},
            success: function(data){
              State.Queue.list = data;
              response = true;
            }
          });
          return response;
        },
        add: (id, dest, n) => {
          let response = false;
          const d = new Date();
          $.ajax({
            url: `${U}/service/add`,
            dataType: "json",
            type: "post",
            async: false,
            data: {
              post_date: df.eightDigits(new Date(d)),
              pcid: id,
              oid: Oid,
              dest: dest,
              n: n,
              tstamp: new Date().getTime(),
            },
            success: function(data){
              response = data;
            }
          });
          return response;
        },
        update: (id, dest, n) => {
          let response = false;
          $.ajax({
            url: `${U}/service/update`,
            dataType: "json",
            type: "post",
            async: false,
            data: {
              id: id,
              dest: dest,
              n: n,
            },
            success: function(data){
              response = data;
            }
          });
          return response;
        },
        delete: id => {
          let response = false;
          $.ajax({
            url: `${U}/service/delete`,
            dataType: "json",
            type: "post",
            async: false,
            data: {id: id},
            success: function(data){
              response = data;
            }
          });
          return response;
        },
        call: (id) => {
          let response = false;
          $.ajax({
            url: `${U}/service/call`,
            dataType: "json",
            type: "post",
            async: false,
            data: {id: id},
            success: function(data){
              response = true;
            }
          });
          return response;
        },
      };
      this.parsers = {
        qnd: (data) =>{
          let qN = '';
          let qD = '';
          const dest = [
            {id: 1, label: "KIA", value: "kia", current: 0, total: 0, bg: "#007bb6", c: "#fff"},
            {id: 2, label: "MTBS", value: "mtbs", current: 0, total: 0,  bg: "#282830", c: "#fff"},
            {id: 3, label: "BP", value: "bp", current: 0, total: 0,  bg: "#e67e22", c: "#fff"},
            {id: 4, label: "Gigi dan mulut", value: "gigidanmulut", current: 0, total: 0,  bg: "#d2d7d3", c: "#000"},
            {id: 5, label: "Persalinan", value: "persalinan", current: 0, total: 0, bg: "#fffa37", c: "#000"},
          ];

          for(let x = 0; x < data.length; x++){
            const dIdx = dest.findIndex(m => m.value === data[x].dest);
            dest[dIdx].total++;
            const badge = data[x].called ? '<i class="fas fa-check-circle"></i>' : '';
            if(data[x].called) dest[dIdx].current++;
            qN += `<div class="col-12 border text-center p-1 mb-1 queueListItem" style="background:${dest[dIdx].bg};color:${dest[dIdx].c};" data-x="${x}">
              ${x+1}  - ${data[x].name} - ${data[x].cid} ${badge}
            </div>`;
          }

          for(let i = 0; i < dest.length; i++){
            qD +=  `<div class="border p-3" style="background:${dest[i].bg};color:${dest[i].c};width:17%;">
              ${dest[i].label} <br> ${dest[i].current}/${dest[i].total}</div>`;
          }

          $('#queueList').html(qN);
          $('#queueDests').html(qD);

        },

        qTotal: (data) => {
          const len = data.length;
          const called = data.filter(item => item.called).length;
          $('#queueTotal').html(`${called}/${len}`);
        },

        dL: (str) => {
          const obj = [
            {v: "kia", l: "KIA"},
            {v: "mtbs", l: "MTBS"},
            {v: "bp", l: "BP"},
            {v: "gigidanmulut", l: "Gigi dan mulut"},
            {v: "persalinan", l: "Persalinan"}
          ];
          return obj.find(m => m.v === str).l;
        }
      };
      this.formBehaviour = {
        openUpdate: () => {},
        openView: () => {},
        openDelete: () => {},
      };
      this.validation = {};
    }
    add(id, dest, n){
      if(this.submission.add(id, dest, n)){
        addQueueForm.reset();
        this.init();
      }
    }
    update(){
      const {id} = State.Queue.toUpdate;
      const dest = $('#updateQueueDest').val();
      if(this.submission.update(id, dest)){
        this.init();
        $('#updateQueueModal').modal('hide');
      }
    }
    delete(){
      const {id} = State.Queue.toDelete;
      if(this.submission.delete(id)){
        $('#deleteQueueModal').modal('hide');
        this.init();
      }
    }
    call(id){
      const s = State.Queue.list.find(m => parseInt(m.s_id) === parseInt(id));
      const idx = State.Queue.list.findIndex(m => parseInt(m.s_id) === parseInt(id));
      if(!s.called){
        if(this.submission.call(id)){
          this.init();
          this.showInfo(idx);
        }
      }
    }
    init(){
      if(this.submission.get()){
        this.render();
      }
    }
    render(){
      const data = State.Queue.list;
      this.parsers.qnd(data);
      this.parsers.qTotal(data);
      $('#queueNumber').val(data.length + 1);
    }

    showInfo(idx){
      const s = State.Queue.list[idx];
      const {address, allergic, called, cid, dest, diagnose, finished, history, jknid,
        med, name, oid, patient_id, pcid, phone, post_date, rmid, s_id, tstamp} = s;

      const callBtnCl = called ? `text-info  disabled` : `text-info call-q-item`;
      const callBadge = called ? `<small class="badge bg-success rounded-pill" style="font-size:0.7rem;"><i class="fas fa-check-circle"></i></small>` : '';
      const el = `<h4>${name} ${callBadge}
          <small>
          <span class="float-end">
            <a href="javascript:void(null);" data-id="${s_id}" class="${callBtnCl}" title="panggil"><i class="fas fa-check"></i></a>
            <a href="javascript:void(null);" data-id="${s_id}" class="text-primary edit-q-item" title="ubah"><i class="fas fa-pencil-alt"></i></a>
            <a href="javascript:void(null);" data-id="${s_id}" class="text-danger delete-q-item" title="hapus"><i class="fas fa-trash"></i></a>
          </span>
          </small>
        </h4>
      <ul class="list-group" >
        <li class="list-group-item"> No antrian: ${idx+1}</li>
        <li class="list-group-item"> Ruang: ${this.parsers.dL(dest)}</li>
        <li class="list-group-item"> NIK: ${cid}</li>
        <li class="list-group-item"> No JKN: ${jknid}</li>
        <li class="list-group-item"> No RM: ${rmid}</li>
        <li class="list-group-item"> Telepon: ${phone}</li>
        <li class="list-group-item"> Alamat: ${address}</li>
        <li class="list-group-item"> Riwayat Penyakit: ${history}</li>
        <li class="list-group-item"> Alergi: ${allergic}</li>
        <li class="list-group-item"> Diagnosa: ${diagnose}</li>
        <li class="list-group-item"> Obat: ${med}</li>
      </ul>`;
      $('#queueInfo').html(el);
    }
  };

  const queue = new Queue();
  queue.init();

  class Patient {
    constructor(){
      this.validation = {};
      this.submission = {
        get: () => {
          $.ajax({
            url: `${U}/patient/get`,
            dataType: "json",
            async: false,
            success: function(data){
              State.Patient.list = data;
            }
          });
        },
        add: (fieldVals) => {
          let response = false;
          $.ajax({
            url: `${U}/patient/add`,
            type: "post",
            dataType: "json",
            async: false,
            data: fieldVals,
            success: function(data){
              response = data;
            }
          });
          return response;
        },
        update: () => {
          let response = false;
          const fieldVals = {
            id: State.Patient.toUpdate.id,
            name: $('#updateName').val(),
            cid: $('#updateCID').val(),
            rmid:  $('#updateRM').val(),
            jknid: $('#updateJKN').val(),
            address: $('#updateAddress').val(),
            phone: $('#updatePhone').val(),
            dishis: $('#updateDisHistory').val(),
            allergic: $('#updateAllergic').val(),
            diagnose: $('#updateDiag').val(),
            med: $('#updateMed').val(),
          };


          $.ajax({
            url: `${U}/patient/update`,
            type: "post",
            dataType: "json",
            async: false,
            data: fieldVals,
            success: function(data){
              response = data;
            }
          });
          return response;

        },
        delete: () => {},
        getVisitH: (id) => {
          let response = [];
          $.ajax({
            url: `${U}/service/getVisitH`,
            dataType: "json",
            async: false,
            data: {id: id},
            success: function(data){
              response = data;
            }
          });
          return response;
        },
      };
      this.parsers = {
        visitHistory: (id) => {
          let el = '';
          const data = this.submission.getVisitH(id);
          if(data.length){
            for(let i = 0; i < data.length; i++){
              const { called, dest, finished, oid, pcid, post_date, s_id,
                tstamp, } = data[i];
              el +=  `<li>${df.dmy(post_date)} - ${this.parsers.dL(dest)}</li>`;
            }
          }
          return el;
        },
        pInfo: (p) => {
          const {address, allergic, cid, diagnose, history, jknid, med, name,
            patient_id, phone, rmid} = p;
          const el = `<ul class="list-unstyled">
            <li class="mb-1"><strong>Nama</strong>: ${name}</li>
            <li class="mb-1"><strong>NIK</strong>: ${cid}</li>
            <li class="mb-1"><strong>No JKN</strong>: ${jknid}</li>
            <li class="mb-1"><strong>No RM</strong>: ${rmid}</li>
            <li class="mb-1"><strong>Alamat</strong>: ${address}</li>
            <li class="mb-1"><strong>Telepon</strong>: ${phone}</li>
            <li class="mb-1"><strong>Riwayat Penyakit</strong>: ${history}</li>
            <li class="mb-1"><strong>Alergi</strong>: ${allergic}</li>
            <li class="mb-1"><strong>Diagnosa</strong>: ${diagnose}</li>
            <li class="mb-1"><strong>Obat</strong>: ${med}</li>
          </ul>`;
          return el;
        },
        dL: (str) => {
          const obj = [
            {v: "kia", l: "KIA"},
            {v: "mtbs", l: "MTBS"},
            {v: "bp", l: "BP"},
            {v: "gigidanmulut", l: "Gigi dan mulut"},
            {v: "persalinan", l: "Persalinan"}
          ];
          return obj.find(m => m.v === str).l;
        }
      };
    }
    init(){
      this.submission.get();
    }
    add(){
      const fieldVals = {
        name: $('#regName').val(),
        cid: $('#regCID').val(),
        rm: $('#regRM').val(),
        jknid: $('#regJKN').val(),
        address: $('#regAddress').val(),
        phone: $('#regPhone').val(),
        dishis: $('#regDisHistory').val(),
        allergic: $('#regAllergic').val(),
        diagnose: $('#regDiag').val(),
        med: $('#regMed').val(),
        addToList: $('#addToList').is(':checked') || false,
        dest: $('#regAddQueue').val(),
      }
      const {addToList, dest, cid} = fieldVals;
      if(this.submission.add(fieldVals)){
        addPatientForm.reset();
        $('#addPatientModal').modal('hide');
        patient.init();
        if(addToList) queue.add(cid, dest);
      }
    }
    update(){
      if(this.submission.update()){
        updatePatientForm.reset();
        $('#updatePatientModal').modal('hide');
        patient.init();
      }

    }
    delete(){

    }
    show(id){
      const p = State.Patient.list.find(m => parseInt(m.patient_id) === parseInt(id));

      const pInfo = this.parsers.pInfo(p);
      const vHist = this.parsers.visitHistory(p.cid);
      $('#viewPatientModalLabel').html(p.name);
      $('#viewPatientInfo').html(pInfo);
      $('#vHist').html(vHist);
      $('#viewPatientModal').modal('show');
    }
  };

  const patient = new Patient();
  patient.init();

  $('#addQueueForm').on('submit', function(e){
    e.preventDefault();
    const cid = $('#queueID').val();
    const dest = $('#queueDest').val();
    const n = $('#queueNumber').val();
    if(cid && dest && n) queue.add(cid, dest, n);
  });

  $('#queueList').on('click', '.queueListItem', function(){
    const idx = $(this).data('x');
    queue.showInfo(idx);
  });

  $('#queueList').on('dblclick', '.queueListItem', function(){
    const idx = $(this).data('x');
    queue.call(State.Queue.list[idx].s_id);

  })
  $('#queueInfo').on('click', '.call-q-item', function(){
    const id = $(this).data('id');
    queue.call(id);
  });


  $('#queueDate').on('change', function(){
    queue.init();
  });

  $('#queueInfo').on('click', '.edit-q-item', function(){
    const id = $(this).data('id');
    // find the object;
    const s = State.Queue.list.find(m => parseInt(m.s_id) === parseInt(id));

    // put its s_id to the state;
    State.Queue.toUpdate.id = s.s_id;
    // // const option = $('#updateQueueDest');
    $('#updateQueueID').val(s.pcid);
    $(`#updateQueueDest option[value="${s.dest}"]`).attr("selected", "selected");
    $('#updateQueueModal').modal('show');
  });

  $('#updateQueueForm').on('submit', function(e){
    e.preventDefault();
    queue.update();
  });

  $('#queueInfo').on('click', '.delete-q-item', function(){
    const id = $(this).data('id');
    State.Queue.toDelete.id = id;
    $('#deleteQueueModal').modal('show');
  });

  $('#deleteQueueForm').on('submit', function(e){
    e.preventDefault();
    queue.delete();
  });

  $('#addPatientForm').on('submit', function(e){
    e.preventDefault();
    patient.add();
  });

  $('#addToList').on('change', function(){
    if($(this).is(':checked'))
      $('#regAddQueueC').fadeIn('slow');
    else
      $('#regAddQueueC').fadeOut('fast');
  });

  $('#patientList').on('click', '.patientEdit', function(e){

    const id = $(this).data('id');
    State.Patient.toUpdate.id = id;

    const p = State.Patient.list.find(m => parseInt(m.patient_id) === parseInt(id));

    const {
      address, allergic, cid, diagnose, history, jknid, med, name, patient_id, phone, rmid
    } = p;

    $('#updateName').val(name);
    $('#updateCID').val(cid);
    $('#updateRM').val(rmid);
    $('#updateJKN').val(jknid);
    $('#updateAddress').val(address);
    $('#updatePhone').val(phone);
    $('#updateDisHistory').val(history);
    $('#updateAllergic').val(allergic);
    $('#updateDiag').val(diagnose);
    $('#updateMed').val(med);
    $('#updatePatientModal').modal('show');
  });

  $('#updatePatientForm').on('submit', function(e){
    e.preventDefault();
    patient.update();
  });

  $('#patientList').on('click', '.patientDelete', function(){
    const id = $(this).data('id');
    State.Patient.toDelete.id = id;
    $('#deletePatientModal').modal('show');
  });

  $('#deletePatientForm').on('submit', function(e){
    e.preventDefault();
    const id = State.Patient.toDelete.id;

    $.ajax({
      url: `${U}/patient/delete`,
      dataType: "json",
      type: "post",
      async: false,
      data: {id: id},
      success: function(data){

        // refetch the data;
        patient.init();
        // hide modal
        $('#deletePatientModal').modal('hide');
        // clear the form
        deletePatientForm.reset();
      }
    })
  });

  $('#patientList').on('click', '.patientView', function(){
    const id = $(this).data('id');
    patient.show(id);
  });


  /*
    {
      "decimal":        "",
      "emptyTable":     "No data available in table",
      "info":           "Showing _START_ to _END_ of _TOTAL_ entries",
      "infoEmpty":      "Showing 0 to 0 of 0 entries",
      "infoFiltered":   "(filtered from _MAX_ total entries)",
      "infoPostFix":    "",
      "thousands":      ",",
      "lengthMenu":     "Show _MENU_ entries",
      "loadingRecords": "Loading...",
      "processing":     "Processing...",
      "search":         "Search:",
      "zeroRecords":    "No matching records found",
      "paginate": {
          "first":      "First",
          "last":       "Last",
          "next":       "Next",
          "previous":   "Previous"
      },
      "aria": {
          "sortAscending":  ": activate to sort column ascending",
          "sortDescending": ": activate to sort column descending"
      }
  }
  */


  $('#patientList').DataTable({
    response: true,
    ajax: {
      url: `${U}/patient/get`,
      dataSrc: "",
    },
    language: {
      search: "Cari",
      lengthMenu: "Menampilkan _MENU_ entri",
      info: "Menampilkan _START_-_END_ dari _TOTAL_ entri",
      emptyTable: "Tidak ada data di tabel",
      infoEmpty: "Menampilkan 0-0 dari 0 entri",
      infoFiltered: "(disaring dari _MAX_ total entri)",
      loadingRecords: "Memuat...",
      processing: "Memproses...",
      zeroRecords: "Tidak ada hasil yang sesuai",
      paginate: {
          "first": "Pertama",
          "last": "Terakhir",
          "next": "Berikutnya",
          "previous": "Sebelumnya"
      }
    },
    columns: [
      {
        data: "patient_id",
      },
      {
        data: "name"
      },
      {
        data: "cid",
        render: (data, meta, row, type) => {
          return `${data} <button class="float-end btn btn-sm cidC" data-clipboard-text="${data}"><i class="fas fa-clipboard"></i></button>`;
        },
      },
      {
        data: "rmid"
      },
      {
        data: "jknid"
      },
      {
        data: "address"
      },
      {
        data: "phone",
      },
    /*  {
        data: "history"
      },
      {
        data: "allergic",
      },
      {
        data: "diagnose",
      },
      {
        data: "med_allergic",
      }, */
      {
        data: "patient_id",
        render: (x, b, c, d) => {
          const a = `<a href="javascript:void(0);" class="patientEdit text-info" data-id="${x}"><i class="fas fa-pencil-alt"></i></a>
            <a href="javascript:void(0);" class="patientDelete text-danger" data-id="${x}"><i class="fas fa-trash"></i></a>
            <a href="javascript:void(0);" class="patientView text-primary" data-id="${x}"><i class="fas fa-eye"></i></a>`;
          return a;
        }
      }
    ],
  });

});
