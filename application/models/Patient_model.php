<?php
defined ("BASEPATH") OR exit ("No direct script access allowed!");

class Patient_model extends CI_Model {

  public function get(){
    $query = $this->db->get('patients');
    return $query->result();
  }
  public function add (){

    $name = $this->input->post('name');
    $cid = $this->input->post('cid');
    $rm = $this->input->post('rmid');
    $jknid = $this->input->post('jknid');
    $address = $this->input->post('address');
    $phone = $this->input->post('phone');
    $dishist = $this->input->post('dishis');
    $allergic = $this->input->post('allergic');
    $diagnose = $this->input->post('diagnose');
    $med = $this->input->post('med');

    $data = array(
      'name' =>  $name,
      'cid' =>  $cid,
      'rmid' =>  $rm,
      'jknid' =>  $jknid,
      'address' =>  $address,
      'phone' =>  $phone,
      'history' =>  $dishist,
      'allergic' =>  $allergic,
      'diagnose' =>  $diagnose,
      'med' =>  $med,
    );

    $query = $this->db->insert('patients', $data);
    return $query;
  }
  public function update(){
    $id = $this->input->post('id');
    $name = $this->input->post('name');
    $cid = $this->input->post('cid');
    $rmid = $this->input->post('rmid');
    $jknid = $this->input->post('jknid');
    $address = $this->input->post('address');
    $phone = $this->input->post('phone');
    $dishist = $this->input->post('dishis');
    $allergic = $this->input->post('allergic');
    $diagnose = $this->input->post('diagnose');
    $med = $this->input->post('med');

    $this->db->set('name', $name);
    $this->db->set('cid', $cid);
    $this->db->set('rmid', $rmid);
    $this->db->set('jknid', $jknid);
    $this->db->set('address', $address);
    $this->db->set('phone', $phone);
    $this->db->set('history', $dishist);
    $this->db->set('allergic', $allergic);
    $this->db->set('diagnose', $allergic);
    $this->db->set('med', $med);

    $this->db->where('patient_id', $id);

    $query = $this->db->update('patients');
    return $query;

  }
  public function delete(){

  }

}
