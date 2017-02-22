<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class custom_model extends grocery_CRUD_Model {
    private $sql_str = '';

    function __construct() {
        parent::__construct();
    }

    /*
    Possible replace get_list and set_sql_str with custom code for a many-many relation with compound key
    Use CodeIgnitor to set where, order_by etc
    See https://www.codeigniter.com/userguide3/database/query_builder.html
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