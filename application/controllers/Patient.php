<?php
defined("BASEPATH") or exit ("No direct script access allowed!");

class Patient extends CI_Controller {
  public function __construct(){
    parent::__construct();
    $this->load->model('patient_model');
  }
  public function get (){
    $data = $this->patient_model->get();
    echo json_encode($data);
  }
  public function add (){
    $data = $this->patient_model->add();
    echo json_encode($data);
  }
  public function update(){
    $data = $this->patient_model->update();
    echo json_encode($data);
  }
  public function delete(){
    $data = $this->patient_model->delete();
    echo json_encode($data);
  }
}
