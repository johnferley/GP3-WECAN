<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	public function index()
	{
		$this->load->view('login_view');
	}

    public function handle_login()
    {
        mysqli_connect("localhost", "root", "", "wecan")or die("mysql connection failed.");
        //mysql_select_db("dbLogin") or ("Database does not exists.");
        if (isset($_POST['Login'])){
            $username=mysql_real_escape_string($_POST['username']);
	        $password=mysql_real_escape_string($_POST['password']);
	        if (!$_POST['username'] | !$_POST['password'])
	        {
                // Not all fields completed, show error
                echo ("<SCRIPT LANGUAGE='JavaScript'>
                            window.alert('You did not complete all the require fields')
                            window.location.href='/WECAN'
                            </SCRIPT>");
                /*
                    echo ("<SCRIPT LANGUAGE='JavaScript'>
                            window.alert('You did not complete all the require fields')
                            window.location.href='login_view.php'
                            </SCRIPT>");
                */
		        //exit();
	        }
            else
            {
                $password=md5($password);
                $sql= $this->db->query("SELECT * FROM user WHERE username = '".$username."' AND password = '".$password."'");
                $cnt = $sql->num_rows();
                if($cnt > 0)
                {
                    // Login successful, go to main
                    $sess_array = array();
                    foreach($sql->result() as $row)
                    {
                        $sess_array = array('user' => $row->username, 'name' => $row->name, 'level' => $row->levelID);
                    }
                    $this->session->set_userdata('logged_in', $sess_array);
                    //$this->load->view('header');
                    //$this->load->view('home');
                    redirect('main', 'refresh');
                    /*
                        echo("<SCRIPT LANGAUAGE='JavaScript'>
                            windows.alert('Login successful!.')
                            windows.location:href='competitor_view.php'
                            </SCRIPT");
                    */
                }
                else
                {
                    // Login unsuccesful, show eror and reload login
                    // Login successful, go to main
                    echo ("<SCRIPT LANGUAGE='JavaScript'>
                                window.alert('Login Unsuccessful')
                                window.location.href='/WECAN'                      
                                </SCRIPT>");
                    /*
                        echo("<SCRIPT LANGAUAGE='JavaScript'>
                            windows.alert('Wrong Username or Password.')
                            windows.location:href='login.php'
                            </SCRIPT");
                    */
                }
            }
        }

        /*if (!isset($_SESSION['user']))
        {
            echo 'header("login.php")';
            die();
        }*/

    }
}
?>