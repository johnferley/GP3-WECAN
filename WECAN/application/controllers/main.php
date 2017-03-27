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

	public function clear_temp_tables()
	{
		if ($this->db->table_exists('temp_fixture_venue'))
		{
			$this->db->query("DROP TABLE temp_fixture_venue");
		}
	}

	public function competitor()
	{
		$this->load->view('header');
		$crud = new grocery_CRUD();
		$crud->set_theme('datatables');
		$crud->set_table('competitor');
		$crud->set_subject('Competitor');
		$crud->columns('competitorID', 'Title_titleID', 'competitorFirstName', 'competitorLastName', 'competitorDOB', 'competitorPhoto', 'Team_teamID', 'Role_roleID');
		$crud->fields('Title_titleID', 'competitorFirstName', 'competitorLastName', 'competitorDOB', 'competitorPhoto', 'Team_teamID', 'Role_roleID');
		$crud->required_fields('competitorID', 'competitorFirstName', 'competitorLastName', 'Team_teamID', 'Role_roleID', 'Title_titleID');
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
		$crud->set_theme('datatables');
		// Create temporary table using SQL
		$this->clear_temp_tables();
		$this->db->query("CREATE TABLE temp_fixture_venue (PRIMARY KEY (fixtureID)) SELECT fixture.fixtureID, fixture.fixtureDate,  venue.venueName,  venue.venueStadium FROM venue JOIN fixture ON venue.venueID = fixture.Venue_venueID");
		$crud->set_table('card');
		$crud->set_subject('Card');
		$crud->columns('cardID', 'Competitor_competitorID', 'issueNo', 'cardIssueDate', 'cardExpiryDate', 'cardValid','auth');
		$crud->fields('Competitor_competitorID', 'cardIssueDate', 'cardExpiryDate', 'cardValid','auth');
		$crud->set_relation_n_n('auth', 'authorisation', 'temp_fixture_venue', 'Card_cardID', 'Fixture_fixtureID', '{fixtureDate}, {venueName}, {venueStadium}');
		$crud->required_fields('cardID', 'issueNo', 'Competitor_competitorID', 'cardIssueDate', 'cardExpiryDate', 'cardValid');
		$crud->set_relation('Competitor_competitorID','competitor','{competitorLastName}, {competitorFirstName}');
		$crud->display_as('cardID','Card ID');
		$crud->display_as('issueNo', 'Issue No.');
		$crud->display_as('Competitor_competitorID', 'Competitor');
		$crud->display_as('cardIssueDate', 'Issue Date');
		$crud->display_as('cardExpiryDate', 'Expiry Date');
		$crud->display_as('cardValid', 'Valid');
		$crud->display_as('auth', 'Fixtures');
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
		$cardSelected = $this->input->post('cardSelected');
		$this->load->view('header');
		$this->load->view('query1_view');
		
		
	}

	public function query2()
	{
		$this->load->view('header');
		$this->load->view('query_compList_view');
	}
    
        public function query3()
	{
		$this->load->view('header');
		$this->load->view('query3_view');
	}
    
    public function query4()
	{
		$this->load->view('header');
		$this->load->view('query4_view');
	}
	
	
    
   /* public function cardSwipe()
	{
	   $cardSelected = $this->input->post('cardSelected');
       $dateList = $this->input->post('dateList');
       $venueSelected = $this->input->post('venueSelected');
       
       echo $dateList; // check if sateList is working
       
       $fixtureList = $this->db->query('SELECT * FROM fixture where Venue_venueID = '. $venueSelected.' and fixtureDate = DATE('. $dateList. ') LIMIT 1');
			// fixtureList lists matches at the SELECTED DATE and VENUE
	   
       $authorisationList = $this->db->query('SELECT * FROM title WHERE titleText = "Yippee"');
       foreach($fixtureList->result() as $fixtureRows)
       {
            $authorisationList = $this->db->query('SELECT * FROM authorisation WHERE Fixture_fixtureID = '. $fixtureRows->fixtureID. ' and Card_cardID = '. $cardSelected);
				// Loop through fixtureList and SELECT the CARDS who have access to the FIXTURE
       }
       
       $authCount = $authorisationList->num_rows();
			// # of rows in where CARDS have access to selected FIXTURE
       if ($authCount > 0)
       {
        $authorised = 1;
       }
       else{
        $authorised = 0;
       }
       
        $this->db->query('INSERT INTO card_access_log(accessDate, accessAuthorised, Venue_venueID, Card_cardID) values(DATE('. $dateList. '),'. $authorised. ','. $venueSelected.','. $cardSelected. ')');
        //echo 'INSERT INTO card_access_log(accessDate, accessAuthorised, Venue_venueID, Card_cardID) values('. $dateList. ','. $authorised. ','. $venueSelected.','. $cardSelected. ')';
	}*/
	
	public function compVenueCheck()
	{
		$compSelected = $this->input->post('compSelected');
		//echo $compSelected;
		$compCanAccess = $this->db->query('SELECT venue.venueName, fixture.fixtureDate FROM competitor
											JOIN team_has_fixture ON team_has_fixture.Team_teamID = competitor.Team_teamID
											JOIN fixture ON fixture.fixtureID = team_has_fixture.Fixture_FixtureID
											JOIN venue ON fixture.Venue_venueID = venue.venueID
												WHERE competitorID = ' . $compSelected);
		
		echo $this->table->generate($compCanAccess);
		$this->load->view('querynav_view');
	}
	
	public function compList()
	{
		$fixtureSelected = $this->input->post('fixtureSelected');
		
		$compsAtFixture = $this->db->query('SELECT Competitor_competitorID, competitorFirstName, competitorLastName FROM card
											JOIN competitor ON card.Competitor_competitorID = competitor.competitorID
											JOIN team_has_fixture ON competitor.Team_teamID = team_has_fixture.Team_teamID
												WHERE Fixture_FixtureID = ' . $fixtureSelected . '');
		
		echo $this->table->generate($compsAtFixture);
		$this->load->view('querynav_view');
	}
	
	public function authCheck()
	{
		$cardSelected = $this->input->post('cardSelected');
		$fixtureSelected = $this->input->post('fixtureSelected');
		
		$cardAtFixture = $this->db->query('SELECT cardValid FROM card
											JOIN competitor ON card.Competitor_competitorID = competitor.competitorID
											JOIN team_has_fixture ON competitor.Team_teamID = team_has_fixture.Team_teamID
												WHERE cardID = '. $cardSelected . ' AND Fixture_fixtureID = ' . $fixtureSelected . '');
		
		
		echo $this->table->generate($cardAtFixture);
		
		if ($cardAtFixture->num_rows() > 0){
			echo ('This card is Valid!!!');
		}else{
			echo 'CARD NOT VALID';
		}
		$this->load->view('querynav_view');
	}
	public function fixtureSwipe()
	{
		$cardSelected = $this->input->post('cardSelected');
		$dateList = $this->input->post('dateList');
		$venueSelected = $this->input->post('venueSelected');
		$authorised = 0;
       
		echo 'DateList is ' . $dateList . ' '; // check if sateList is working
		echo 'VenueSelected is ' . $venueSelected; // check venue
       
		$fixtureList = $this->db->query('SELECT * FROM Fixture WHERE fixtureDate = DATE "' . $dateList . '" AND Venue_venueID = '. $venueSelected .' LIMIT 1');
	   
		echo $this->table->generate($fixtureList);
		//echo $fixtureInRange;
			// fixtureList lists matches at the selected DATE and VENUE
			

		foreach($fixtureList->result() as $fixtureRows)
		
			{
				if ($fixtureList = true){
					$authList = $this->db->query('SELECT * FROM authorisation WHERE Fixture_FixtureID = ' . $fixtureRows->fixtureID . ' AND Card_CardID = '. $cardSelected .'');
					echo  'authList ' . $this->table->generate($authList);
					$authorised = 1;
				}else{
					$authorised = 0;
				}
			}
		
		
		$this->db->query('INSERT INTO card_access_log (accessDate, accessAuthorised, Venue_venueID, Card_cardID) VALUES (DATE "' . $dateList .'", ' . $authorised . ', ' . $venueSelected . ', ' . $cardSelected. ')');
    
		$this->load->view('querynav_view');
		// Errors when swiping again after loading this view. Might need temp tables?
       
       
			// # of rows in where CARDS have access to selected FIXTURE
       
       
        
	}
    public function displayTable()
    {
           
    }
	public function query_entryAttempts()
	{
		$this->load->view('header');
		$this->load->view('query_entryAttempts_view');
	}
	
	public function query_entryLog()
	{
		$this->load->view('header');
		$this->load->view('query_entryLog_view');
	}
    
    public function query7()
	{
		$this->load->view('header');
		$this->load->view('query7_view');
	}
    
    

	public function blank()
	{
		$this->load->view('header');
		$this->load->view('blank_view');
	}

}
?>
