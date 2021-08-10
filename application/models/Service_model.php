<?php

defined ("BASEPATH") OR die ("No direct script access allowed!");

class Service_model extends CI_Model {
  public function get(){
    $d = $this->input->get('d');

    $this->db->select('*');
    $this->db->from('services');
    $this->db->where('post_date', $d);
    $this->db->join('patients', 'patients.cid = services.pcid');
    $query = $this->db->get();
    return $query->result();
  }

  public function getVisitH(){
    $id = $this->input->get('id');

    $this->db->where('pcid', $id);

    $query = $this->db->get('services');
    return $query->result();

  }
  public function add(){
    $cid = $this->input->post('pcid');
    $oid = $this->input->post('oid');
    $post_date = $this->input->post('post_date');
    $dest = $this->input->post('dest');
    $n = $this->input->post('n');
    $tstamp = $this->input->post('tstamp');

    $data = array(
      'post_date' => $post_date,
      'pcid' => $cid,
      'oid' => $oid,
      'dest' => $dest,
      'qnumber' => $n,
      'tstamp' => $tstamp
    );


    $query = $this->db->insert('services', $data);
    return $query;
  }

  public function update(){
    $id = $this->input->post('id');
    $dest = $this->input->post('dest');

    $this->db->where('s_id', $id);
    $this->db->set('dest', $dest);
    $query = $this->db->update('services');
    return $query;
  }
  public function delete(){
    $id = $this->input->post('id');
    $this->db->where('s_id', $id);
    $query = $this->db->delete('services');
    return $query;
  }
  public function call(){
    $id = $this->input->post('id');
    $this->db->where('s_id', $id);
    $this->db->set('called', 1);
    $query = $this->db->update('services');
    return $query;
  }
  public function finish(){
    $id = $this->input->post('id');
    $this->db->where('service_id', $id);
    $this->db->set('finished', 1);
    $query = $this->db->update('services');
    return $query;
  }
}
