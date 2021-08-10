/*
 * queue.js
 * for patient queue in hospital/clinic
 * author: caesar @ https://caesar-muksid.com
 */

$(document).ready(function(){

  "use strict";
  class Queue {
    constructor(){
      // defines parameters
      // this.state = {
      //   data: () => {},
      //
      // };
      this.buttons = {
        st : $('.start-queue'),
        nx : $('.next-queue'),
        fn : $('.finish-queue'),
      };
      this.submission = {
        add: (obj) => {
          let response = false;
          $.ajax({
            url: `${U}/service/add`,
            type: "post",
            dataType: "json",
            async: false,
            data: obj,
            success: function(data){
              // refetch queues data, and rerender the page;
              response = data;
            }
          });
          return response;
        },
        delete: (id) => {

          let response = false;
          $.ajax({
            url: `${U}/service/delete`,
            type: "post",
            dataType: "json",
            async: false,
            data: {id: id},
            success: function(data){
              response = data;
            }
          });
          return response;
        },
        update: () => {},
        call: id => {
          let response = false;
          $.ajax({
            type: "post",
            url: `${U}/service/call`,
            dataType: "json",
            async: false,
            data: {id:id},
            success: function(data){
              response = data;
            }
          })
          return response;
        },
        finish: id => {
          let response = false;

          $.ajax({
            type: "post",
            url: `${U}/service/finish`,
            async: false,
            dataType: "json",
            data: {id: id},
            success: function(data){
              console.log(data);
            }
          });
          return response;
        },
      };
    }
    init(){
      if(this.get()){
        this.constructState();
        this.render();
      }
    }
    constructState(){
      const data = State.Queue;
      // defines array length
      data.total = data.queues.length;
      // reset current queue
      data.current = 0;
      // iterate through destinations and reset all current and total
      for(let x = 0; x < data.dest.length; x ++){
        data.dest[x].current = 0;
        data.dest[x].total = 0;
      }

      // now reconstruct those values
      for(let i = 0; i < data.total ; i++){
        const d = data.dest.findIndex(m => m.value === data.queues[i].dest);
        data.dest[d].total++;
        if(data.queues[i].called){
          data.current++;
          data.dest[d].current++;
        }
      }
    }
    render(){
      // define neccessary variables;
      const {queues:q, destPEls: pe, total: t, current: c} = State.Queue;
      const {st, nx, fn} = this.buttons;
      // call other methods to show certain parts;
      // display the list;
      this.getList();
      // console.log(list);

      // display the queue number (2/8)
      this.getDisplay();

      // display destination group
      this.constructDest(); // gets an array back

      // show info if the queue has started
      if (c > 0) this.constructInfo();

      // determine which of the start/next/finish button that shown

      if(q.findIndex(i=>i.called) === -1){ // current queue = 0;
        st.removeClass('is-hidden');
        nx.addClass('is-hidden');
        fn.addClass('is-hidden');
      } else if(q.findIndex(i=>!i.called||!i.finished) === -1){ // no queues
        st.addClass('is-hidden');
        nx.addClass('is-hidden');
        fn.addClass('is-hidden');
      } else if (c === t && !q[q.length-1].finished) { // curent item on the queue is the last item;
        st.addClass('is-hidden');
        nx.addClass('is-hidden');
        fn.removeClass('is-hidden');
      } else { // in the middle
        st.addClass('is-hidden');
        nx.removeClass('is-hidden');
        fn.addClass('is-hidden');
      }

    }
    get(){
      // requests data from the server
      let response = false;
      const d = this.parseDate();
      $.ajax({
        url: `${U}/service/get?d=${d}`,
        dataType: "json",
        async: false,
        success: function(res){
          State.Queue.queues = res;
          response = true;
        }
      });
      return response;
    }
    startQ(){
      // only triggered if current queue = 0;
      // calls the first item of the list;
      if(this.call(0))
        this.init();
    }
    move(){
      console.log(State);
      const {current:c, total: t} = State.Queue;
      // finishes up the current item and calls the next item on the list;
      if(this.finishP(c-1) && this.call(c))
        this.init();
    }
    call(id){
      const sid = State.Queue.queues[id].service_id;
      let response = false;
      $.ajax({
        url: `${U}/service/call`,
        type: "post",
        dataType: "json",
        async: false,
        data: {id: sid},
        success: function(data){
          response = data;
        }
      });
      return response;
    }
    finishP(id){
      const sid = State.Queue.queues[id].service_id;
      let response = false;
      $.ajax({
        url: `${U}/service/finish`,
        type: "post",
        dataType: "json",
        async: false,
        data: {id: sid},
        success: function(data){
          response = data;
        }
      });
      return response;
    }
    finishQ(){
      const {current:c, total: t} = State.Queue;
      // finishes the last item of the queue
      if(this.finishP(t-1))
        this.init();
    }
    add(id, dest){
      /*
       * to dos: validations
       * id not found;
       * fields empty;
      */
      // adds new patient to the list;
      const today = new Date(),
            p = State.patients.find(item => parseInt(item.cid) === parseInt(id)),
            post_date = this.parseDate(today),
            tstamp = today.getTime(),
            oid = Oid,
            uid = p.patient_id;
      // let response = false;
      const obj = {post_date, uid, oid, dest, tstamp};
      if(this.submission.add(obj)){
        this.init();
        // $('addQueue')
        addQueue.reset();
      }
      // if(response) this.init();
    }
    delete(){
      // deletes an item from the list
      // console.log(State);
      const id = State.Queue.toDelete;

      if(this.submission.delete(id)){
        $('#deleteQueueModal').modal('hide');
        this.init();
      };
    }
    parseDate(){

      // return a string of eight digits date yyyymmdd
      const d = new Date($('#queueDate').val());
      const date = d.getDate() < 10 ? '0' + d.getDate() : d.getDate();
      const month = d.getMonth() < 10 ? '0' + d.getMonth() : d.getMonth();

      return `${d.getFullYear()}${month}${date}`
    }
    constructDest(){
      const {queues:q, destPEls: pe, total: t, current: c} = State.Queue;
      // groups items of the list into their corresponding destination

      const Ch = [];
      const d = State.Queue.dest;
      for(let i = 0;  i < d.length; i++) Ch.push(`${d[i].label}<br>${d[i].current}/${d[i].total}`);
      // return Ch;
      for(let i = 0; i < pe.length; i++) pe[i].html(Ch[i]);
    }
    constructInfo(current = State.Queue.current){
      // constructs info of the patient
      // console.log(State);
      const {queues} = State.Queue;
      // console.log()
      const p = queues[current-1];
      // console.log(p);
      const {
        address, allergic, called, cid, dest, diagnose, finished, history, jknid,
        med_allergic, name, oid, patient_id, phone, post_date, rmid, service_id,
        tstamp, uid,
      } = p;
      const destination = State.Queue.dest.find(item => item.value === dest).label;
      const el = `  <div class="col-6">
          <ul class="list-unstyled">
            <li><strong>Nomor antrian</strong>: ${current}</li>
            <li><strong>Ruang</strong>: ${destination}</li>
            <li><strong>Nama</strong>: ${name}</li>
            <li><strong>NIK</strong>: ${cid}</li>
            <li><strong>No RM</strong>: ${rmid}</li>
            <li><strong>Alamat</strong>: ${address}</li>
            <li><strong>Telepon</strong>: ${phone} </li>
          </ul>
        </div>
        <div class="col-6">
          <ul class="list-unstyled">
            <li><strong>Riwayat penyakit</strong>: ${history} </li>
            <li><strong>Alergi</strong>: ${allergic}</li>
            <li><strong>Diagnosa</strong>: ${diagnose}</li>
            <li><strong>Obat</strong>: ${med_allergic}</li>
          </ul>
        </div>`;
      $('#patientInfo').html(el);
    }
    getList(){
      // constructs list of patients;
      const data = State.Queue.queues;
      let el = '';
      for(let i = 0; i < data.length; i++)
        el += `<li class="list-group-item">
            <a class="queue-list-item${data[i].finished?' finished':''}" href="javascript:void(0)" data-id="${data[i].service_id}">
              ${i+1}. ${data[i].name}
            </a>
            <a title="Hapus dari antrian" class="float-end delete-queue" href="javascript:void(0);" data-id="${data[i].service_id}">
              <i class="fas fa-times"></i>
            </a>
          </li>`;
      $('#queueList').html(el);

    }
    playSound(){

    }
    getDisplay(){
      // const data = State.Queue.queues;
      const {total: t, current: c} = State.Queue;
      const el = `${c}/<small>${t}</small>`;
      $('#queueDisplay').html(el);
    }
    openDeleteForm(id){
      State.Queue.toDelete = id;
      const q = State.Queue.queues.find(m => parseInt(m.service_id) === parseInt(id));
      const name = q.name;
      // console.log(name);
      $('#qtdname').html(`<strong>${name}</strong>`);
      $('#deleteQueueModal').modal('show');
    }
  }
  const queue = new Queue();

  queue.init();

  class Patient {
    constructor(){
      this.submission = {
        add: (obj) => {
          let response;
          $.ajax({
            url: `${U}/patient/add`,
            type: "post",
            dataType: "json",
            async: false,
            data: obj,
            success: function(data){
              response = data;
            }
          });
          return response;
        },
        update: (obj) => {
          let response = false;
          $.ajax({
            url: `${U}/patient/update`,
            type: "post",
            dataType: "json",
            async: false,
            data: obj,
            success: function(data){
              response = data;
            }
          });
          return response;
        },
        delete: () => {
          let response = false;
          $.ajax({
            url: `${U}/patient/delete`,
            type: "post",
            dataType: "json",
            async: false,
            data: {id: State.toDelete.id},
            success: function(data){
              console.log(data);
              response = data;
            }
          });
          return response;
        },
        get: () => {},
      };
      this.validation = {

      };
    }
    add(){ // inserting new patient into the database;
      const fieldVals = {
        name : $('#regName').val(),
        cid : $('#regCID').val(),
        rmid : $('#regRM').val(),
        jknid : $('#regJKN').val(),
        address: $('#regAddress').val(),
        phone: $('#regPhone').val(),
        history : $('#regDisHistory').val(),
        allergic : $('#regAllergic').val(),
        diagnose : $('#regDiag').val(),
        med: $('#regMed').val(),
        addToList: $('#addToList').is(':checked')||!1,
        regAddQueue: $('#regAddQueue').val()
      };

      const {addToList, cid, regAddQueue} = fieldVals;
      if(this.submission.add(fieldVals)){
        addPatientForm.reset();
        $('#patientList').DataTable().ajax.reload();
        getPatients();
        if(addToList) queue.add(cid, regAddQueue);
      }
    }
    update(){ // editing patient's information;
      const fieldVals = {
        id: State.toUpdate.id, // id stored in openForm event.
        name: $('#editName').val(),
        cid: $('#editCID').val(),
        rmid: $('#editRM').val(),
        jknid: $('#editJKN').val(),
        address: $('#editAddress').val(),
        phone: $('#editPhone').val(),
        history: $('#editDisHistory').val(),
        allergic: $('#editAllergic').val(),
        diagnose: $('#editDiag').val(),
        med_allergic: $('#editMed').val(),
      };

      const {
        id, name, cid, rmid, jknid, address, phone, history, allergic,
        diagnose, med_allergic
      } = fieldVals;
      if(this.submission.update(fieldVals)){
        editPatientForm.reset();
        $('#editPatientModal').modal('hide');
        $('#patientList').DataTable().ajax.reload();
        queue.init();
      }

    }
    delete(){
      if(this.submission.delete()){
        $('#patientList').DataTable().ajax.reload();
        $('#deletePatientModal').modal('hide');
        queue.init();
      }

    }
    view(id){
      const p = State.patients.find(m => parseInt(m.patient_id) === parseInt(id));
      console.log(p);
      const {
        address,
        allergic,
        cid,
        diagnose,
        history,
        jknid,
        med_allergic,
        name,
        patient_id,
        phone,
        rmid,
      } = p;
      $('#viewPatientModalLabel').html(name);
      const el = `  <div class="row">
          <div class="col-6">
            <ul class="list-unstyled ps-2">
              <li class="mb-3"><strong>Nama</strong>: ${name}</li>
              <li class="mb-3"><strong>NIK</strong>: ${cid}</li>
              <li class="mb-3"><strong>No RM</strong>: ${rmid}</li>
              <li class="mb-3"><strong>No JKN</strong>: ${jknid}</li>
              <li class="mb-3"><strong>No Telepon</strong>: ${phone}</li>
              <li class="mb-3"><strong>Alamat</strong>: ${address} </li>
            </ul>
          </div>
          <div class="col-6">
            <ul class="list-unstyled ps-2">
              <li class="mb-3"><strong>Riwayat Penyakit</strong>: <br> ${history} </li>
              <li class="mb-3"><strong>Alergi</strong>: <br> ${allergic}</li>
              <li class="mb-3"><strong>Diagnosa</strong>: <br> ${diagnose}</li>
              <li class="mb-3"><strong>Obat</strong>: <br> ${med_allergic}</li>
            </ul>
          </div>
        </div>`;
      $('#viewPatientInfo').html(el);
      $('#viewPatientModal').modal('show');
    }

    openUpdateForm(id){
      // keep this id in the State, so it can be accessed later  on the submission
      State.toUpdate.id = id;
      const person = State.patients.find(item => parseInt(item.patient_id) === parseInt(id));
      const { address, allergic, cid, diagnose, history, jknid, med_allergic, name, phone, rmid, } = person;
      $('#editName').val(name);
      $('#editCID').val(cid);
      $('#editRM').val(rmid);
      $('#editJKN').val(jknid);
      $('#editAddress').val(address);
      $('#editPhone').val(phone);
      $('#editDisHistory').val(history);
      $('#editAllergic').val(allergic);
      $('#editDiag').val(diagnose);
      $('#editMed').val(med_allergic);
      $('#editPatientModal').modal('show');
    }
    openDeleteForm(id){

    }
  };

  const patient = new Patient();


  $('#addPatientForm').on('submit', function(e){
    e.preventDefault();
    patient.add();
  });

  $('#addQueue').on('submit', function(e){
    e.preventDefault();
    const id = $('#queueID').val();
    const dest = $('#queueDest').val();
    if(id&&dest) queue.add(id, dest);
  });


  $('.start-queue').on('click', function(){
    queue.startQ();
  });
  $('.next-queue').on('click', function(){
    queue.move();
  });
  $('.finish-queue').on('click', function(){
    queue.finishQ();
  });
  $('#patientList').on('click', '.patientEdit', function(){
    const id = $(this).data('id');
    patient.openUpdateForm(id);
  });

  $('#editPatientForm').on('submit', function(e){
    e.preventDefault();
    patient.update();
  });

  $('#patientList').on('click', '.patientDelete', function(){

    $('#deletePatientModal').modal('show');
    const id = $(this).data('id');
    State.toDelete.id = id;
  });

  $('#deletePatientForm').on('submit', function(e){
    e.preventDefault();
    patient.delete();
  });

  $('#patientList').on('click', '.patientView', function(){
    const id = $(this).data('id');
    patient.view(id);
  });

  $('#queueDate').on('change', function(){
    // queue.get();
    // queue.render();
  });

  $('#addToList').on('change', function(){
    if($(this).is(':checked'))
      $('#regAddQueueC').fadeIn('slow');
    else
      $('#regAddQueueC').fadeOut('slow');
  });

  $('#queueList').on('click', '.delete-queue', function(e){
    const id = $(this).data('id');
    queue.openDeleteForm(id);
  });

  $('#deleteQueueForm').on('submit', function(e){
    e.preventDefault();
    queue.delete();
  });

  $('#queueList').on('click', '.queue-list-item', function(e){
    const id = $(this).data('id');
    const sid = State.Queue.queues.findIndex(m => parseInt(m.service_id) === parseInt(id));
    queue.constructInfo(sid+1);
  });

  $('#destFilterSelect').on('change', function(){
    // console.log(e);
    // console.log($(this).val());
    const dest = $(this).val();
    if(dest || dest !== undefined || dest !== ''){

    }
  });

  $('#patientList').DataTable({
    responsive: true,
    ajax: {
      url: `${U}/patient/get`,
      dataSrc: "",
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
        render: (x, b, c, ) => {
          const a = `<a href="javascript:void(0);" class="patientEdit" data-id="${x}"><i class="fas fa-pencil-alt"></i></a>
            <a href="javascript:void(0);" class="patientDelete" data-id="${x}"><i class="fas fa-trash"></i></a>
            <a href="javascript:void(0);" class="patientView" data-id="${x}"><i class="fas fa-eye"></i></a>`;
          return a;
        }
      }
    ],
  });
});
