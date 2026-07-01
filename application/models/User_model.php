<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model
{
    public function getAll($limit, $start, $search = '')
    {
        if ($search) {
            $this->db->group_start();
            $this->db->like('nama', $search);
            $this->db->or_like('username', $search);
            $this->db->group_end();
        }
        $this->db->order_by('id_user', 'DESC');
        $this->db->limit($limit, $start);
        return $this->db->get('users')->result_array();
    }

    public function getById($id)
    {
        return $this->db->get_where('users', ['id_user' => $id])->row_array();
    }

    public function countAll($search = '')
    {
        if ($search) {
            $this->db->group_start();
            $this->db->like('nama', $search);
            $this->db->or_like('username', $search);
            $this->db->group_end();
        }
        return $this->db->count_all_results('users');
    }

    public function insert($data)
    {
        $this->db->insert('users', $data);
        return $this->db->insert_id();
    }

    public function update($id, $data)
    {
        $this->db->where('id_user', $id);
        $this->db->update('users', $data);
        return $this->db->affected_rows();
    }

    public function delete($id)
    {
        $this->db->where('id_user', $id);
        $this->db->delete('users');
        return $this->db->affected_rows();
    }
}
