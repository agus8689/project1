<?php
class m_login extends ci_model{
	function cek_username_pass($username, $password){
		$this->db->where('username', $username);
		$this->db->where('password', $password);
		return $this->db->get('user_login');
	}
}