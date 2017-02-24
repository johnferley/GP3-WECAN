<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class custom_model extends grocery_CRUD_Model {
    private $sql_str = '';

    function __construct() {
        parent::__construct();
    }

    /*
    Possible errors when filtering
    */
    function get_list() {
        $query = $this->db->query($this->sql_str);

        $results_array = $query->result();
        return $results_array;
    }

    public function set_sql_str($sql_str) {
        $this->sql_str = $sql_str;
    }


}
?>