$(document).ready(function(){
  "use strict";
  class Queue {
    constructor(){

      this.submission = {
        getData: () => {
          let response = false;
          const d = df.eightDigits(new Date($('#queueDate').val()));
          $.ajax({
            url: `${U}/service/get`,
            async: false,
            dataType: "json",
            data: {d: d},
            success: function(data){
              if(data.length){
                State.Queue.list = data;
                response = true;
              }
            }
          });
          return response;
        },

        add: (cid, dest) => {
          let response = false;
          $.ajax({
            url: `${U}/service/add`,
            dataType: "json",
            type: "post",
            async: false,
            data: {
              uid: cid,
              oid: Oid,
              post_date: df.eightDigits(new Date()),
              dest: dest,
              tstamp: new Date().getTime(),
            },
            success: function(data){
              response = data;
            }
          });
          return response;
        },
        update: () => {},
        call: () => {},
      };

      this.validation = {
        add: (id) => State.Patient.list.indexOf(m => parseInt(m.cid) === parseInt(id) !== -1),
      };
    }
    add(cid, d){
      // const pIdx = State.Patient.list.findIndex(m => parseInt(m.cid) === parseInt(id));
      if(this.submission.add(cid, d)){
        addQueueForm.reset();
        this.init();
      }
    }
    delete(){

    }
    update(){

    }
    call(){

    }
    init(){
      if(this.submission.getData()) this.render;
      // this.submission.getData();
    }
    render(){
      console.log(State.Queue);
    }
  }

  const queue = new Queue();
  queue.init();

  class Patient {
    constructor(){
      this.getData = () => {
        let response = false;
        $.ajax({
          url: `${U}/patient/get`,
          dataType: "json",
          async: false,
          success: function(data){
            State.Patient.list = data;
            response = true;
          }
        });
        return response;
      };
      this.submit = {
        add: () => {},
        update: () => {},
        delete: () => {},
      };
      this.validation = {
        add: () => {},
        update: () => {},
      };
    }
    init(){
      this.getData();
    }
    add(){

    }
    update(){

    }
    delete(){

    }


  }

  const patient = new Patient ();
  patient.init();

  $('#addPatientForm').on('submit', function(e){
    e.preventDefault();
    patient.add();
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

  });

  $('#deletePatientForm').on('submit', function(e){
    e.preventDefault();
    patient.delete();
  });

  $('#addQueueForm').on('submit', function(e){
    e.preventDefault();
    const cid = $('#queueID').val();
    const dest = $('#queueDest').val();
    // simply does nothing if all any of two fields not filled
    // if((cid && dest) || (id !== '' && dest !== ''))
    // if(cid && dest)
    //   queue.add(cid, dest);
    if(cid && dest){
      $.ajax({
        url: `${U}/service/add`,
        type: "post",
        async: false,
        dataType: "json",
        data: {
          post_date: df.eightDigits(new Date()),
          cid: cid, // citizen id
          oid: Oid, // officer id;
          dest: dest,
          tstamp: new Date().getTime(),
        },
        success: function(data){
          console.log(data);
        }
      });
    }
  });

  $('#editQueueForm').on('submit', function(e){
    e.preventDefault();
    queue.update();
  });

  $('#deleteQueueForm').on('submit', function(e){
    e.preventDefault();
    queue.delete();
  })

  // $('#')


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
