<?php
defined ("BASEPATH") OR exit ("No direct script access allowed!");

class Service extends CI_Controller {
  public function __construct(){
    parent::__construct();
    $this->load->model('service_model');
  }

  public function get(){
    $data = $this->service_model->get();
    echo json_encode($data);
  }

  public function getVisitH(){
    $data = $this->service_model->getVisitH();
    echo json_encode($data);
  }

  public function add(){
    $data = $this->service_model->add();
    echo json_encode($data);
  }
  public function delete(){
    $data = $this->service_model->delete();
    echo json_encode($data);
  }
  public function update(){
    $data = $this->service_model->update();
    echo json_encode($data);
  }

  public function call(){
    $data = $this->service_model->call();
    echo json_encode($data);
  }

  public function finish(){
    $data = $this->service_model->finish();
    echo json_encode($data);
  }
}
