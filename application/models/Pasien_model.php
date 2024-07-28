<?php
class Pasien_model extends CI_Model
{
    public function getPasien($id = null)
    {
        if ($id === null) {
            return $this->db->get('pasien')->result_array();
        } else {
            return $this->db->get_where('pasien', ['id' => $id])->result_array();
        }
    }

    public function deletePasien($id)
    {
        $this->db->delete('pasien', ['id' => $id]);
        return $this->db->affected_rows();
    }
    public function createPasien($data)
    {
        
        $this->db->insert('pasien', $data);
        return $this->db->affected_rows();
    }
    public function updatePasien($data, $id)
    {
        $this->db->update('pasien', $data, ['id' => $id]);
        return $this->db->affected_rows();
    }
}