<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {

	 function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper('url');
		$this->load->library('grocery_CRUD');
		$this->load->library('table');
	}

	public function index()
	{
		$this->load->view('header');
		$this->load->view('home');
	}

	public function competitor()
	{
		$this->load->view('header');
		$crud = new grocery_CRUD();
		$crud->set_theme('datatables');
		$crud->set_table('competitor');
		$crud->set_subject('Competitor');
		$crud->columns('competitorID', 'Title_titleID', 'competitorFirstName', 'competitorLastName', 'competitorDOB', 'competitorPhoto', 'Team_teamID', 'Role_roleID');
		$crud->fields('competitorFirstName', 'Title_titleID', 'competitorLastName', 'competitorDOB', 'competitorPhoto', 'Team_teamID', 'Role_roleID');
		$crud->required_fields('competitorID', 'competitorFirstName', 'competitorLastName', 'competitorDOB', 'competitorPhoto', 'Team_teamID', 'Role_roleID', 'Title_titleID');
		$crud->set_relation('Team_teamID','team','teamName');
		$crud->set_relation('Role_roleID','role','roleDescription');
		$crud->set_relation('Title_titleID','title','titleText');
		$crud->display_as('competitorID', 'Competitor ID');
		$crud->display_as('competitorFirstName', 'First Name');
		$crud->display_as('competitorLastName', 'Last Name');
		$crud->display_as('competitorDOB', 'Date of Birth');
		$crud->display_as('competitorPhoto', 'Photo');
		$crud->display_as('Team_teamID', 'Team');
		$crud->display_as('Role_roleID', 'Role');
		$crud->display_as('Title_titleID', 'Title');

		$output = $crud->render();
		$this->competitor_output($output);
	}

	function competitor_output($output = null)
	{
		$this->load->view('competitor_view.php', $output);
	}

	public function card()
	{
		$this->load->view('header');
		$crud = new grocery_CRUD();
		/*
		Custom model using CodeIgnitor, contains a new function to run an sql query based on a provided string
		Possibly need to add code to handle record count and filters
		Based on http://www.grocerycrud.com/forums/topic/1963-simple-guide-to-executing-custom-queries/
		*/
		//$crud->set_model('custom_model');
		$crud->set_theme('datatables');
		$crud->set_table('card');
		$crud->set_subject('Card');
		$crud->columns('issueNo', 'Competitor_competitorID', 'cardIssueDate', 'cardExpiryDate', 'cardValid','auth');
		$crud->fields('Competitor_competitorID', 'cardIssueDate', 'cardExpiryDate', 'cardValid','auth');
		// Compound primary key Competitor_competitorID and issueNo
		//$crud->set_relation_n_n('auth', 'authorisation', 'fixture', 'Card_Competitor_competitorID', 'Fixture_fixtureID', 'fixtureDate');
		// Custom function to display table based on sql string
		//$crud->basic_model->set_sql_str('SELECT * FROM card');
		$crud->required_fields('issueNo', 'Competitor_competitorID', 'cardIssueDate', 'cardExpiryDate', 'cardValid');
		$crud->set_relation('Competitor_competitorID','competitor','{competitorLastName}, {competitorFirstName}');
		$crud->display_as('issueNo', 'Issue No.');
		$crud->display_as('Competitor_competitorID', 'Competitor');
		$crud->display_as('cardIssueDate', 'Issue Date');
		$crud->display_as('cardExpiryDate', 'Expiry Date');
		$crud->display_as('cardValid', 'Valid');
		$crud->display_as('auth', 'Authorisations');

		$output = $crud->render();
		$this->card_output($output);
	}

	function card_output($output = null)
	{
		$this->load->view('card_view.php', $output);
	}

		public function venue()
	{
		$this->load->view('header');
		$crud = new grocery_CRUD();
		$crud->set_theme('datatables');
		$crud->set_table('venue');
		$crud->set_subject('Venue');
		$crud->columns('venueID','venueName', 'venueStadium');
		$crud->fields('venueName', 'venueStadium');
		$crud->required_fields('venueID', 'venueName', 'venueStadium');
		$crud->display_as('venueID', 'Venue ID');
		$crud->display_as('venueName', 'Venue Name');
		$crud->display_as('venueStadium', 'Stadium');

		$output = $crud->render();
		$this->venue_output($output);
	}

	function venue_output($output = null)
	{
		$this->load->view('venue_view.php', $output);
	}

	public function fixture()
	{
		$this->load->view('header');
		$crud = new grocery_CRUD();
		$crud->set_theme('datatables');
		$crud->set_table('fixture');
		$crud->set_subject('Fixture');
		$crud->columns('fixtureID', 'fixtureDate', 'Venue_venueID','teams');
		$crud->fields('fixtureID', 'fixtureDate', 'Venue_venueID','teams');
		$crud->set_relation('Venue_venueID','venue','{venueName}, {venueStadium}');
		$crud->set_relation_n_n('teams', 'team_has_fixture', 'team', 'Fixture_fixtureID', 'Team_teamID', 'teamName');
		$crud->required_fields('fixtureID', 'fixtureDate', 'Venue_venueID');
		$crud->display_as('fixtureID', 'Fixture ID');
		$crud->display_as('fixtureDate', 'Fixture Date');
		$crud->display_as('Venue_venueID', 'Venue Name, Stadium');
		$crud->display_as('teams', 'Teams');

		$output = $crud->render();
		$this->fixture_output($output);
	}

	function fixture_output($output = null)
	{
		$this->load->view('fixture_view.php', $output);
	}

	public function nfa()
	{
		$this->load->view('header');
		$crud = new grocery_CRUD();
		$crud->set_theme('datatables');
		$crud->set_table('nfa');
		$crud->set_subject('NFA');
		$crud->columns('nfaID', 'nfaName', 'nfaAcronym');
		$crud->fields('nfaName', 'nfaAcronym');
		$crud->required_fields('nfaID', 'nfaName', 'nfaAcronym');
		$crud->display_as('nfaID', 'NFA ID');
		$crud->display_as('nfaName', 'NFA Name');
		$crud->display_as('nfaAcronym', 'NFA Acronym');


		$output = $crud->render();
		$this->nfa_output($output);
	}

	function nfa_output($output = null)
	{
		$this->load->view('nfa_view.php', $output);
	}

	public function card_access_log()
	{
		$this->load->view('header');
		$crud = new grocery_CRUD();
		$crud->set_theme('datatables');
		$crud->set_table('card_access_log');
		$crud->set_subject('Access Log');
		$crud->columns('accessID', 'accessDate', 'accessAuthorised', 'Venue_venueID', 'Card_issueNo', 'Card_Competitor_competitorID');
		$crud->fields('accessDate', 'accessAuthorised', 'Venue_venueID', 'Card_issueNo', 'Card_Competitor_competitorID');
		$crud->set_relation('Venue_venueID','venue','{venueName}, {venueStadium}');
		// Compound primary key Competitor_competitorID and issueNo
		//$crud->set_relation('Card_isueNo','card','{Competitor_competitorID}, {issueNo}');
		//$crud->set_relation('Card_Competitor_competitorID','competitor','{competitorLastName}, {competitorFirstName}');
		$crud->required_fields('accessID', 'accessDate', 'accessAuthorised', 'Venue_venueID', 'Card_issueNo', 'Card_Competitor_competitorID');
		$crud->display_as('accessID', 'Access ID');
		$crud->display_as('accessDate', 'Access Date');
		$crud->display_as('accessAuthorised', 'Authorised Access');
		$crud->display_as('Card_issueNo', 'Card Issue No.');
		$crud->display_as('Card_Competitor_competitorID', 'Competitor');
		$crud->display_as('Venue_venueID', 'Venue Name, Stadium');

		$output = $crud->render();
		$this->card_access_log_output($output);
	}

	function card_access_log_output($output = null)
	{
		$this->load->view('card_access_log_view.php', $output);
	}

	public function issue_log()
	{
		$this->load->view('header');
		$crud = new grocery_CRUD();
		$crud->set_theme('datatables');
		$crud->set_table('issue_log');
		$crud->set_subject('Issue Log');
		$crud->columns('issueID', 'issueDescription', 'issueRasiedBy', 'issueRaisedDate', 'issueClosedDate', 'issueClosed', 'Venue_venueID');
		$crud->fields('issueDescription', 'issueRasiedBy', 'issueRaisedDate', 'issueClosedDate', 'issueClosed', 'Venue_venueID');
		$crud->required_fields('issueID', 'issueDescription', 'issueRasiedBy', 'issueRaisedDate', 'issueClosedDate', 'issueClosed', 'Venue_venueID');
		$crud->set_relation('Venue_venueID','venue','{venueName}, {venueStadium}');
		$crud->display_as('issueID', 'Issue ID');
		$crud->display_as('issueDescription', 'Issue Description');
		$crud->display_as('issueRasiedBy', 'Raised by');
		$crud->display_as('issueRaisedDate', 'Raised Date');
		$crud->display_as('issueClosedDate', 'Closed Date');
		$crud->display_as('issueClosed', 'Closed');
		$crud->display_as('Venue_venueID', 'Venue Name, Stadium');

		$output = $crud->render();
		$this->issue_log_output($output);
	}

	function issue_log_output($output = null)
	{
		$this->load->view('issue_log_view.php', $output);
	}

	public function team()
	{
		$this->load->view('header');
		$crud = new grocery_CRUD();
		$crud->set_theme('datatables');
		$crud->set_table('team');
		$crud->set_subject('Team');
		$crud->columns('teamID', 'teamName', 'teamNickname', 'NFA_nfaID','fixtures');
		$crud->fields('teamName', 'teamNickname', 'NFA_nfaID','fixtures');
		$crud->set_relation_n_n('fixtures', 'team_has_fixture', 'fixture', 'Team_teamID', 'Fixture_fixtureID', 'fixtureDate');
		$crud->set_relation('NFA_nfaID','nfa','nfaName');
		$crud->required_fields('teamID', 'teamName', 'NFA_nfaID');
		$crud->display_as('teamID', 'Team ID');
		$crud->display_as('teamName', 'Team Name');
		$crud->display_as('teamNickname', 'Nickname');
		$crud->display_as('NFA_nfaID', 'NFA');
		$crud->display_as('fixtures', 'Fixtures');

		$output = $crud->render();
		$this->team_output($output);
	}

	function team_output($output = null)
	{
		$this->load->view('team_view.php', $output);
	}


	public function querynav()
	{
		$this->load->view('header');
		$this->load->view('querynav_view');
	}

	public function query1()
	{
		$this->load->view('header');
		$this->load->view('query1_view');
	}

	public function query2()
	{
		$this->load->view('header');
		$this->load->view('query2_view');
	}

	public function blank()
	{
		$this->load->view('header');
		$this->load->view('blank_view');
	}

}
?>
