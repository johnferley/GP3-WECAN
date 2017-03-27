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

	public function update_new_card()
	{
		$counter = 0;
		$pressed = $this->input->post("submitForm");
		$filter =  $this->input->post('enterFilter');
		// If comma separated, make sure each item is a number
		$ok = true;
		if(strpos($filter, ",") <> false)
		{
			$checkarr = explode(",",$filter);
			foreach($checkarr as $item)
			{
				if (ctype_digit($item) == false)
				{
					$ok = false;
				}
			}
		}
		// Otherwise make sure the filter is a single number
		else if (ctype_digit($filter) == false)
		{
			$ok = false;
		}
		// If filter is blank
		if ($filter == "")
		{
			echo ("<SCRIPT LANGUAGE='JavaScript'>
                            window.alert('Please enter a filter')
                            window.location.href=document.referrer
                            </SCRIPT>");
			exit();
		}
		// If filter contains "all"
		else if ($filter == "all")
		{
			// Add card for any competitor that doesnt have one
			$query = $this->db->query("SELECT * FROM competitor");
			foreach ($query->result() as $row)
			{
				$countcards = $this->db->query("SELECT COUNT(*) AS cardcount FROM card WHERE Competitor_competitorID = ".$row->competitorID);
				foreach ($countcards->result() as $checkrow)
				{
					$cardcount = $checkrow->cardcount;
				}
				if ($cardcount == 0)
				{
					$counter += 1;
					$this->db->query("INSERT INTO card (Competitor_competitorID, issueNo, cardIssueDate, cardExpiryDate, cardValid) VALUES (".$row->competitorID.", 1, '2017-06-16', '2017-07-06', 1)");
				}
			}
		}
		// If number or comma separated numbers
		else if ($ok == true)
		{
			$filterCompetitors = "";
			$filterTeam = "";
			// Different filters depending on page
			if ($pressed == "issueNewCardOnCompetitor")
			{
				$filterCompetitors = " WHERE competitorID IN (".$filter.")";
				$test = $this->db->query("SELECT * FROM competitor".$filterCompetitors)->num_rows();
				if ($test == 0)
				{
					echo ("<SCRIPT LANGUAGE='JavaScript'>
									window.alert('No competitors found with IDs (".$filter.")')
									window.location.href=document.referrer
									</SCRIPT>");
					exit();
				}
			}
			else if ($pressed == "issueNewCardOnTeam")
			{
				$filterTeam = " WHERE Team_teamId IN (".$filter.")";
				$test = $this->db->query("SELECT * FROM competitor".$filterCompetitors)->num_rows();
				if ($test == 0)
				{
					echo ("<SCRIPT LANGUAGE='JavaScript'>
									window.alert('No teams found with IDs (".$filter.")')
									window.location.href=document.referrer
									</SCRIPT>");
					exit();
				}
			}
			// Add card for any competitor that doesnt have one based on filters
			$query = $this->db->query("SELECT * FROM competitor".$filterCompetitors.$filterTeam);
			foreach ($query->result() as $row)
			{
				$countcards = $this->db->query("SELECT COUNT(*) AS cardcount FROM card WHERE Competitor_competitorID = ".$row->competitorID);
				foreach ($countcards->result() as $checkrow)
				{
					$cardcount = $checkrow->cardcount;
				}
				if ($cardcount == 0)
				{
					$counter += 1;
					$this->db->query("INSERT INTO card (Competitor_competitorID, issueNo, cardIssueDate, cardExpiryDate, cardValid) VALUES (".$row->competitorID.", 1, '2017-06-16', '2017-07-06', 1)");
				}
			}
		}
		// If invalid input
		else
		{
			echo ("<SCRIPT LANGUAGE='JavaScript'>
                            window.alert('Invalid filter')
                            window.location.href=document.referrer
                            </SCRIPT>");
			exit();
		}
		echo ("<SCRIPT LANGUAGE='JavaScript'>
                        window.alert('Updated ".$counter." rows')
                        window.location.href=document.referrer
                        </SCRIPT>");
	}

	public function update_valid_card()
	{
		$counter = 0;
		$pressed = $this->input->post("submitForm");
		$filter =  $this->input->post('enterFilter');
		// If comma separated, make sure each item is a number
		$ok = true;
		if(strpos($filter, ",") <> false)
		{
			$checkarr = explode(",",$filter);
			foreach($checkarr as $item)
			{
				if (ctype_digit($item) == false)
				{
					$ok = false;
				}
			}
		}
		// Otherwise make sure the filter is a single number
		else if (ctype_digit($filter) == false)
		{
			$ok = false;
		}
		// If filter is blank
		if ($filter == "")
		{
			echo ("<SCRIPT LANGUAGE='JavaScript'>
                            window.alert('Please enter a filter')
                            window.location.href=document.referrer
                            </SCRIPT>");
			exit();
		}
		// If filter contains "all"
		else if ($filter == "all")
		{
			// Set old cards to invalid for every competitor
			$query = $this->db->query("SELECT * FROM card WHERE cardValid = TRUE");
			foreach ($query->result() as $row)
			{
				$maxissue = $this->db->query("SELECT MAX(issueNo) AS maximum FROM card WHERE Competitor_competitorID = ".$row->Competitor_competitorID);
				foreach ($maxissue->result() as $issuerow)
				{
					$maxvalue = $issuerow->maximum;
				}
				if ($row->issueNo < $maxvalue)
				{
					$counter += 1;
					$this->db->query("UPDATE card SET cardValid = FALSE WHERE cardID = ".$row->cardID);
				}
			}
		}
		// If number or comma separated numbers
		else if ($ok == true)
		{
			$filterCompetitors = "";
			$filterCard = "";
			// Different filters depending on page
			if ($pressed == "updateValidityOnCard")
			{
				$filterCard = " WHERE cardID IN (".$filter.")";
				$test = $this->db->query("SELECT * FROM competitor".$filterCard)->num_rows();
				if ($test == 0)
				{
					echo ("<SCRIPT LANGUAGE='JavaScript'>
									window.alert('No cards found with IDs (".$filter.")')
									window.location.href=document.referrer
									</SCRIPT>");
					exit();
				}
				$filterCard = " AND cardID IN (".$filter.")";
			}
			else if ($pressed == "updateValidityOnCompetitor")
			{
				$filterCompetitors = " WHERE Competitor_competitorID IN (".$filter.")";
				$test = $this->db->query("SELECT * FROM competitor".$filterCard)->num_rows();
				if ($test == 0)
				{
					echo ("<SCRIPT LANGUAGE='JavaScript'>
									window.alert('No competitors found with IDs (".$filter.")')
									window.location.href=document.referrer
									</SCRIPT>");
					exit();
				}
				$filterCompetitors = " AND Competitor_competitorID IN (".$filter.")";
			}
			else if ($pressed == "updateValidityOnTeam")
			{
				// First get list of competitors in team
				$test = $this->db->query("SELECT teamID FROM team WHERE teamID IN (".$filter.")")->num_rows();
				if ($test == 0)
				{
					echo ("<SCRIPT LANGUAGE='JavaScript'>
									window.alert('No teams found with IDs (".$filter.")')
									window.location.href=document.referrer
									</SCRIPT>");
					exit();
				}
				$query = $this->db->query("SELECT competitorID FROM competitor WHERE Team_teamID IN (".$filter.")");
				if ($query->num_rows() == 0)
				{
					echo ("<SCRIPT LANGUAGE='JavaScript'>
									window.alert('No competitors found in team IDs (".$filter.")')
									window.location.href=document.referrer
									</SCRIPT>");
					exit();
				}
				$list = "";
				foreach ($query->result() as $row)
				{
					$list = $list.$row->competitorID.", ";
				}
				$list = substr($list, 0, -2);
				$filterCompetitors = " AND Competitor_competitorID IN (".$list.")";
			}
			// Set old cards to invalid for every competitor based on filters
			$query = $this->db->query("SELECT * FROM card WHERE cardValid = TRUE".$filterCard.$filterCompetitors);
			foreach ($query->result() as $row)
			{
				$maxissue = $this->db->query("SELECT MAX(issueNo) AS maximum FROM card WHERE Competitor_competitorID = ".$row->Competitor_competitorID);
				foreach ($maxissue->result() as $issuerow)
				{
					$maxvalue = $issuerow->maximum;
				}
				if ($row->issueNo < $maxvalue)
				{
					$counter += 1;
					$this->db->query("UPDATE card SET cardValid = FALSE WHERE cardID = ".$row->cardID);
				}
			}
		}
		// If invalid input
		else
		{
			echo ("<SCRIPT LANGUAGE='JavaScript'>
                            window.alert('Invalid filter')
                            window.location.href=document.referrer
                            </SCRIPT>");
			exit();
		}
		echo ("<SCRIPT LANGUAGE='JavaScript'>
                        window.alert('Updated ".$counter." rows')
                        window.location.href=document.referrer
                        </SCRIPT>");
	}

	public function update_authorisations()
	{
		$counter = 0;
		$pressed = $this->input->post("submitForm");
		$filter =  $this->input->post('enterFilter');
		// If comma separated, make sure each item is a number
		$ok = true;
		if(strpos($filter, ",") <> false)
		{
			$checkarr = explode(",",$filter);
			foreach($checkarr as $item)
			{
				if (ctype_digit($item) == false)
				{
					$ok = false;
				}
			}
		}
		// Otherwise make sure the filter is a single number
		else if (ctype_digit($filter) == false)
		{
			$ok = false;
		}

		// If filter is blank
		if ($filter == "")
		{
			echo ("<SCRIPT LANGUAGE='JavaScript'>
                            window.alert('Please enter a filter')
                            window.location.href=document.referrer
                            </SCRIPT>");
			exit();
		}
		// If filter contains "all"
		else if ($filter == "all")
		{
			// Update authorisations for all competitors
			// Reset authorisations
			$this->db->query("DELETE FROM authorisation");
			// Add authorisations based on fixings
			$card = $this->db->query("SELECT * FROM card WHERE cardValid = TRUE");
			foreach ($card->result() as $row)
			{
				$compID = $row->Competitor_competitorID;
				$team = $this->db->query("SELECT Team_teamID FROM competitor WHERE competitorID = ".$compID." LIMIT 1");
				foreach ($team->result() as $teamrow)
				{
					$teamID = $teamrow->Team_teamID;
				}
				$fixtures = $this->db->query("SELECT Fixture_fixtureID FROM team_has_fixture WHERE Team_teamID = ".$teamID);
				foreach ($fixtures->result() as $fixturerow)
				{
					$check = $this->db->query("SELECT * FROM authorisation WHERE Fixture_fixtureID = ".$fixturerow->Fixture_fixtureID." AND Card_cardID = ".$row->cardID);
					$checkcount = $check->num_rows();
					if ($checkcount == 0)
					{
						$counter += 1;
						$this->db->query("INSERT INTO authorisation (Fixture_fixtureID, Card_cardID) VALUES (".$fixturerow->Fixture_fixtureID.",".$row->cardID.")");
					}
				}
			}
		}
		// If number or comma separated numbers
		else if ($ok == true)
		{
			$filterCompetitors = "";
			$filterCardOnCard = "";
			$filterCardOnAuth = "";
			if ($pressed == "updateAuthOnCard")
			{
				$filterCardOnCard = " AND cardID IN (".$filter.")";
				$filterCardOnAuth = " WHERE Card_cardID IN (".$filter.")";
				$test = $this->db->query("SELECT * FROM card WHERE cardID IN (".$filter.")")->num_rows();
				if ($test == 0)
				{
					echo ("<SCRIPT LANGUAGE='JavaScript'>
									window.alert('No cards found with IDs (".$filter.")')
									window.location.href=document.referrer
									</SCRIPT>");
					exit();
				}
			}
			else if ($pressed == "updateAuthOnCompetitor")
			{
				$filterCompetitorsOnCard = " WHERE Competitor_competitorID IN (".$filter.")";
				$test = $this->db->query("SELECT * FROM competitor".$filterCard)->num_rows();
				if ($test == 0)
				{
					echo ("<SCRIPT LANGUAGE='JavaScript'>
									window.alert('No competitors found with IDs (".$filter.")')
									window.location.href=document.referrer
									</SCRIPT>");
					exit();
				}
				$filterCompetitorsOnCard = " AND Competitor_competitorID IN (".$filter.")";
				// Get cardIDs for competitor
				$query = $this->db->query("SELECT cardID FROM card WHERE Competitor_competitorID IN (".$filter.")");
				if ($query->num_rows() == 0)
				{
					echo ("<SCRIPT LANGUAGE='JavaScript'>
									window.alert('No cards found with competitor IDs (".$filter.")')
									window.location.href=document.referrer
									</SCRIPT>");
					exit();
				}
				$list = "";
				foreach ($query->result() as $row)
				{
					$list = $list.$row->cardID.", ";
				}
				$list = substr($list, 0, -2);
				$filterCardOnAuth = " WHERE Card_cardID IN (".$list.")";
			}
			else if ($pressed == "updateAuthOnTeam")
			{
				$test = $this->db->query("SELECT * FROM team WHERE teamID IN (".$filter.")")->num_rows();
				if ($test == 0)
				{
					echo ("<SCRIPT LANGUAGE='JavaScript'>
									window.alert('No teams found with IDs (".$filter.")')
									window.location.href=document.referrer
									</SCRIPT>");
					exit();
				}
				// Get competitors for team
				$query = $this->db->query("SELECT competitorID FROM competitors WHERE Team_teamID IN (".$filter.")");
				if ($query->num_rows() == 0)
				{
					echo ("<SCRIPT LANGUAGE='JavaScript'>
									window.alert('No competitors found with team IDs (".$filter.")')
									window.location.href=document.referrer
									</SCRIPT>");
					exit();
				}
				$list = "";
				foreach ($query->result() as $row)
				{
					$list = $list.$row->competitorID.", ";
				}
				$list = substr($list, 0, -2);
				$filterCompetitorsOnCard = " AND Competitor_competitorID IN (".$list.")";
				// Get cards for competitors
				$query = $this->db->query("SELECT cardID FROM card WHERE Competitor_competitorID IN (".$list.")");
				if ($query->num_rows() == 0)
				{
					echo ("<SCRIPT LANGUAGE='JavaScript'>
									window.alert('No cards found with team IDs (".$filter.")')
									window.location.href=document.referrer
									</SCRIPT>");
					exit();
				}
				$list = "";
				foreach ($query->result() as $row)
				{
					$list = $list.$row->cardID.", ";
				}
				$list = substr($list, 0, -2);
				$filterCardOnCard = " AND cardID IN (".$list.")";
				$filterCardOnAuth = " WHERE Card_cardID IN (".$list.")";
			}
			else if ($pressed == "updateAuthOnFixture")
			{
				$test = $this->db->query("SELECT * FROM fixture WHERE fixtureID IN (".$filter.")")->num_rows();
				if ($test == 0)
				{
					echo ("<SCRIPT LANGUAGE='JavaScript'>
									window.alert('No fixtures found with IDs (".$filter.")')
									window.location.href=document.referrer
									</SCRIPT>");
					exit();
				}
				// Get teams in fixtures
				$query = $this->db->query("SELECT Team_teamID FROM team_has_fixture WHERE Fixture_fixtureID IN (".$filter.")");
				if ($query->num_rows() == 0)
				{
					echo ("<SCRIPT LANGUAGE='JavaScript'>
									window.alert('No teams found with fixture IDs (".$filter.")')
									window.location.href=document.referrer
									</SCRIPT>");
					exit();
				}
				$list = "";
				foreach ($query->result() as $row)
				{
					$list = $list.$row->competitorID.", ";
				}
				$list = substr($list, 0, -2);
				// Get competitors in teams
				$query = $this->db->query("SELECT competitorID FROM competitors WHERE Team_teamID IN (".$list.")");
				if ($query->num_rows() == 0)
				{
					echo ("<SCRIPT LANGUAGE='JavaScript'>
									window.alert('No competitors found with fixture IDs (".$filter.")')
									window.location.href=document.referrer
									</SCRIPT>");
					exit();
				}
				$list = "";
				foreach ($query->result() as $row)
				{
					$list = $list.$row->competitorID.", ";
				}
				$list = substr($list, 0, -2);
				$filterCompetitorsOnCard = " AND Competitor_competitorID IN (".$list.")";
				// Get cards for competitors
				$query = $this->db->query("SELECT cardID FROM card WHERE Competitor_competitorID IN (".$list.")");
				if ($query->num_rows() == 0)
				{
					echo ("<SCRIPT LANGUAGE='JavaScript'>
									window.alert('No cards found with fixture IDs (".$filter.")')
									window.location.href=document.referrer
									</SCRIPT>");
					exit();
				}
				$list = "";
				foreach ($query->result() as $row)
				{
					$list = $list.$row->cardID.", ";
				}
				$list = substr($list, 0, -2);
				$filterCardOnCard = " AND cardID IN (".$list.")";
				$filterCardOnAuth = " WHERE Card_cardID IN (".$list.")";
			}
			// Update authorisations for all competitors based on filters
			// Reset authorisations based on filters
			$this->db->query("DELETE FROM authorisation".$filterCardOnAuth);
			// Add authorisations based on fixings and filters
			$card = $this->db->query("SELECT * FROM card WHERE cardValid = TRUE".$filterCardOnCard.$filterCompetitorsOnCard);
			foreach ($card->result() as $row)
			{
				$compID = $row->Competitor_competitorID;
				$team = $this->db->query("SELECT Team_teamID FROM competitor WHERE competitorID = ".$compID." LIMIT 1");
				foreach ($team->result() as $teamrow)
				{
					$teamID = $teamrow->Team_teamID;
				}
				$fixtures = $this->db->query("SELECT Fixture_fixtureID FROM team_has_fixture WHERE Team_teamID = ".$teamID);
				foreach ($fixtures->result() as $fixturerow)
				{
					$check = $this->db->query("SELECT * FROM authorisation WHERE Fixture_fixtureID = ".$fixturerow->Fixture_fixtureID." AND Card_cardID = ".$row->cardID);
					$checkcount = $check->num_rows();
					if ($checkcount == 0)
					{
						$counter += 1;
						$this->db->query("INSERT INTO authorisation (Fixture_fixtureID, Card_cardID) VALUES (".$fixturerow->Fixture_fixtureID.",".$row->cardID.")");
					}
				}
			}
		}
		// If invalid input
		else
		{
			echo ("<SCRIPT LANGUAGE='JavaScript'>
                            window.alert('Invalid filter')
                            window.location.href=document.referrer
                            </SCRIPT>");
			exit();
		}
		echo ("<SCRIPT LANGUAGE='JavaScript'>
                        window.alert('Updated ".$counter." rows')
                        window.location.href=document.referrer
                        </SCRIPT>");
	}

	public function competitor()
	{
		$this->load->view('header');
		$crud = new grocery_CRUD();
		$crud->set_theme('flexigrid');
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
		$crud->set_theme('flexigrid');
		// Create temporary table using SQL
		$this->db->query("DROP TABLE IF EXISTS temp_fixture_venue");
		$this->db->query("CREATE TEMPORARY TABLE temp_fixture_venue (PRIMARY KEY (fixtureID)) SELECT fixture.fixtureID, fixture.fixtureDate,  venue.venueName,  venue.venueStadium FROM venue JOIN fixture ON venue.venueID = fixture.Venue_venueID");
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
		$crud->set_theme('flexigrid');
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
		$crud->set_theme('flexigrid');
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
		$crud->set_theme('flexigrid');
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
		$crud->set_theme('flexigrid');
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
		$crud->set_theme('flexigrid');
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
		$crud->set_theme('flexigrid');
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
