<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();
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
		if ($this->session->userdata('logged_in'))
		{
			$sessiondata = $this->session->userdata('logged_in');

			$this->load->view('header', $sessiondata);
			$this->load->view('home');
		}
		else
		{
			redirect('login', 'refresh');
		}
	}

	public function delete_duplicates()
	{		
		if ($this->session->userdata('logged_in'))
			{	
				$pressed = $this->input->post("submitForm");
				$count = 0;

				// Delete duplicates depending on the page the button was clicked on
				if ($pressed == "deleteDuplicatesOnCompetitor" || $pressed == "deleteAll")
				{
					$this->db->query("DROP TABLE IF EXISTS temp_delete_duplicates");
					$this->db->query("CREATE TEMPORARY TABLE temp_delete_duplicates (SELECT * FROM (SELECT * FROM competitor AS a ORDER BY a.competitorID DESC) AS b GROUP BY b.competitorFirstName,b.competitorLastName,b.competitorDOB,b.Team_teamID,b.Role_roleID,b.Title_titleID)");
					$countOrig = $this->db->query("SELECT * FROM competitor")->num_rows();
					$countNew = $this->db->query("SELECT * FROM temp_delete_duplicates")->num_rows();
					$count += $countOrig - $countNew;
					$this->db->query("DELETE FROM competitor");
					$this->db->query("INSERT INTO competitor SELECT * FROM temp_delete_duplicates");
				}
				else if ($pressed == "deleteDuplicatesOnCard" || $pressed == "deleteAll")
				{
					$this->db->query("DROP TABLE IF EXISTS temp_delete_duplicates");
					$this->db->query("CREATE TEMPORARY TABLE temp_delete_duplicates (SELECT * FROM (SELECT * FROM card AS a ORDER BY a.cardID DESC) AS b GROUP BY b.Competitor_competitorID,b.cardIssueDate,b.cardExpiryDate,b.cardValid)");
					$countOrig = $this->db->query("SELECT * FROM card")->num_rows();
					$countNew = $this->db->query("SELECT * FROM temp_delete_duplicates")->num_rows();
					$count += $countOrig - $countNew;
					$this->db->query("DELETE FROM card");
					$this->db->query("INSERT INTO card SELECT * FROM temp_delete_duplicates");
				}
				else if ($pressed == "deleteDuplicatesOnVenue" || $pressed == "deleteAll")
				{
					$this->db->query("DROP TABLE IF EXISTS temp_delete_duplicates");
					$this->db->query("CREATE TEMPORARY TABLE temp_delete_duplicates (SELECT * FROM (SELECT * FROM venue AS a ORDER BY a.venueID DESC) AS b GROUP BY b.venueName,b.venueStadium)");
					$countOrig = $this->db->query("SELECT * FROM venue")->num_rows();
					$countNew = $this->db->query("SELECT * FROM temp_delete_duplicates")->num_rows();
					$count += $countOrig - $countNew;
					$this->db->query("DELETE FROM venue");
					$this->db->query("INSERT INTO venue SELECT * FROM temp_delete_duplicates");
				}
				else if ($pressed == "deleteDuplicatesOnFixture" || $pressed == "deleteAll")
				{
					$this->db->query("DROP TABLE IF EXISTS temp_delete_duplicates");
					$this->db->query("CREATE TEMPORARY TABLE temp_delete_duplicates (SELECT * FROM (SELECT * FROM fixture AS a ORDER BY a.fixtureID DESC) AS b GROUP BY b.fixtureID,b.fixtureDate,b.Venue_venueID)");
					$countOrig = $this->db->query("SELECT * FROM fixture")->num_rows();
					$countNew = $this->db->query("SELECT * FROM temp_delete_duplicates")->num_rows();
					$count += $countOrig - $countNew;
					$this->db->query("DELETE FROM fixture");
					$this->db->query("INSERT INTO fixture SELECT * FROM temp_delete_duplicates");
				}
				else if ($pressed == "deleteDuplicatesOnNFA" || $pressed == "deleteAll")
				{
					$this->db->query("DROP TABLE IF EXISTS temp_delete_duplicates");
					$this->db->query("CREATE TEMPORARY TABLE temp_delete_duplicates (SELECT * FROM (SELECT * FROM nfa AS a ORDER BY a.nfaID DESC) AS b GROUP BY b.nfaName,b.nfaAcronym)");
					$countOrig = $this->db->query("SELECT * FROM nfa")->num_rows();
					$countNew = $this->db->query("SELECT * FROM temp_delete_duplicates")->num_rows();
					$count += $countOrig - $countNew;
					$this->db->query("DELETE FROM nfa");
					$this->db->query("INSERT INTO nfa SELECT * FROM temp_delete_duplicates");
				}
				else if ($pressed == "deleteDuplicatesOnAccess" || $pressed == "deleteAll")
				{
					$this->db->query("DROP TABLE IF EXISTS temp_delete_duplicates");
					$this->db->query("CREATE TEMPORARY TABLE temp_delete_duplicates (SELECT * FROM (SELECT * FROM card_access_log AS a ORDER BY a.accessID DESC) AS b GROUP BY b.accessDate,b.accessAuthorised,b.Venue_venueID,b.Card_cardID)");
					$countOrig = $this->db->query("SELECT * FROM card_access_log")->num_rows();
					$countNew = $this->db->query("SELECT * FROM temp_delete_duplicates")->num_rows();
					$count += $countOrig - $countNew;
					$this->db->query("DELETE FROM card_access_log");
					$this->db->query("INSERT INTO card_access_log SELECT * FROM temp_delete_duplicates");
				}
				else if ($pressed == "deleteDuplicatesOnIssue" || $pressed == "deleteAll")
				{
					$this->db->query("DROP TABLE IF EXISTS temp_delete_duplicates");
					$this->db->query("CREATE TEMPORARY TABLE temp_delete_duplicates (SELECT * FROM (SELECT * FROM issue_log AS a ORDER BY a.issueID DESC) AS b GROUP BY b.issueDescription,b.issueRaisedBy,b.issueRaisedDate,b.issueClosedDate,b.issueClosed,b.Venue_venueID)");
					$countOrig = $this->db->query("SELECT * FROM issue_log")->num_rows();
					$countNew = $this->db->query("SELECT * FROM temp_delete_duplicates")->num_rows();
					$count += $countOrig - $countNew;
					$this->db->query("DELETE FROM issue_log");
					$this->db->query("INSERT INTO issue_log SELECT * FROM temp_delete_duplicates");
				}
				else if ($pressed == "deleteDuplicatesOnTeam" || $pressed == "deleteAll")
				{
					$this->db->query("DROP TABLE IF EXISTS temp_delete_duplicates");
					$this->db->query("CREATE TEMPORARY TABLE temp_delete_duplicates (SELECT * FROM (SELECT * FROM team AS a ORDER BY a.teamID DESC) AS b GROUP BY b.teamName,b.teamNickname,b.NFA_nfaID)");
					$countOrig = $this->db->query("SELECT * FROM team")->num_rows();
					$countNew = $this->db->query("SELECT * FROM temp_delete_duplicates")->num_rows();
					$count += $countOrig - $countNew;
					$this->db->query("DELETE FROM team");
					$this->db->query("INSERT INTO team SELECT * FROM temp_delete_duplicates");
				}
				
				// Always delete duplicate authorisation and team_has_fixture records
				$this->db->query("DROP TABLE IF EXISTS temp_delete_duplicates");
				$this->db->query("CREATE TEMPORARY TABLE temp_delete_duplicates (SELECT * FROM authorisation AS b GROUP BY b.Fixture_fixtureID,b.Card_cardID)");
				$this->db->query("DELETE FROM authorisation");
				$this->db->query("INSERT INTO authorisation SELECT * FROM temp_delete_duplicates");

				$this->db->query("DROP TABLE IF EXISTS temp_delete_duplicates");
				$this->db->query("CREATE TEMPORARY TABLE temp_delete_duplicates (SELECT * FROM team_has_fixture AS b GROUP BY b.Team_teamID,b.Fixture_fixtureID)");
				$this->db->query("DELETE FROM team_has_fixture");
				$this->db->query("INSERT INTO team_has_fixture SELECT * FROM temp_delete_duplicates");

				if ($count == 0)
				{
				echo ("<SCRIPT LANGUAGE='JavaScript'>
								window.alert('No duplicates found')
								window.location.href=document.referrer
								</SCRIPT>");
				}
				else
				{
				echo ("<SCRIPT LANGUAGE='JavaScript'>
								window.alert('Deleted ".$count." rows')
								window.location.href=document.referrer
								</SCRIPT>");
				}
		}
		else
		{
			redirect('login', 'refresh');
		}
	}

	public function delete_orphans()
	{
		if ($this->session->userdata('logged_in'))
			{	
				$pressed = $this->input->post("submitForm");
				$count = 0;

				// Delete duplicates depending on the page the button was clicked on
				if ($pressed == "deleteOrphansOnCard" || $pressed == "deleteAll")
				{
					$countOrig = $this->db->query("SELECT * FROM card")->num_rows(); 
					$query = $this->db->query("DELETE FROM card WHERE (SELECT COUNT(*) FROM competitor WHERE competitorID = Competitor_competitorID) = 0");
					$countNew = $this->db->query("SELECT * FROM card")->num_rows(); 
					$count += $countOrig - $countNew;
				}

				// Always delete orphans in authorisation and team_has_fixture
				$query = $this->db->query("DELETE FROM authorisation WHERE (SELECT COUNT(*) FROM fixture WHERE fixtureID = Fixture_fixtureID) = 0 OR (SELECT COUNT(*) FROM card WHERE cardID = Card_cardID) = 0");
				$query = $this->db->query("DELETE FROM team_has_fixture WHERE (SELECT COUNT(*) FROM team WHERE teamID = Team_teamID) = 0 OR (SELECT COUNT(*) FROM fixture WHERE fixtureID = Fixture_fixtureID) = 0");

				if ($count == 0)
				{
				echo ("<SCRIPT LANGUAGE='JavaScript'>
								window.alert('No orphans found')
								window.location.href=document.referrer
								</SCRIPT>");
				}
				else
				{
				echo ("<SCRIPT LANGUAGE='JavaScript'>
								window.alert('Deleted ".$count." rows')
								window.location.href=document.referrer
								</SCRIPT>");
				}
		}
		else
		{
			redirect('login', 'refresh');
		}
	}

	public function update_new_card()
	{
		if ($this->session->userdata('logged_in'))
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
				else if ($filter == "all" || $pressed = "issueNewAll")
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
		else
		{
			redirect('login', 'refresh');
		}
	}

	public function update_valid_card()
	{
		if ($this->session->userdata('logged_in'))
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
				else if ($filter == "all" || $pressed = "updateValidityAll")
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
		else
		{
			redirect('login', 'refresh');
		}
	}

	public function update_authorisations()
	{
		if ($this->session->userdata('logged_in'))
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
				else if ($filter == "all" || $pressed = "updateAuthAll")
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
					else if ($pressed == "updateAuthOnVenue")
					{
						$test = $this->db->query("SELECT * FROM venue WHERE venueID IN (".$filter.")")->num_rows();
						if ($test == 0)
						{
							echo ("<SCRIPT LANGUAGE='JavaScript'>
											window.alert('No venues found with IDs (".$filter.")')
											window.location.href=document.referrer
											</SCRIPT>");
							exit();
						}
						// Get fixtures in venue
						$query = $this->db->query("SELECT fixtureID FROM fixture WHERE Venue_venueID IN (".$filter.")");
						if ($query->num_rows() == 0)
						{
							echo ("<SCRIPT LANGUAGE='JavaScript'>
											window.alert('No fixtures found with venue IDs (".$filter.")')
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
						// Get teams in fixtures
						$query = $this->db->query("SELECT Team_teamID FROM team_has_fixture WHERE Fixture_fixtureID IN (".$list.")");
						if ($query->num_rows() == 0)
						{
							echo ("<SCRIPT LANGUAGE='JavaScript'>
											window.alert('No teams found with venue IDs (".$filter.")')
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
		else
		{
			redirect('login', 'refresh');
		}
	}

	public function competitor()
	{
		if ($this->session->userdata('logged_in'))
		{
			$sessiondata = $this->session->userdata('logged_in');
			if ($sessiondata['level'] <> 2)
			{
        		$sessiondata = $this->session->userdata('logged_in');
				$this->load->view('header', $sessiondata);
        
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
			else
			{
				$this->load->view('header', $sessiondata);
				$this->load->view('home', $sessiondata);
			}
		}
		else
		{
			redirect('login', 'refresh');
		}
	}

	function competitor_output($output = null)
	{
		if ($this->session->userdata('logged_in'))
		{
			$sessiondata = $this->session->userdata('logged_in');
			if ($sessiondata['level'] <> 2)
			{
				$this->load->view('competitor_view.php', $output);
			}
			else
			{
				$this->load->view('header', $sessiondata);
				$this->load->view('home', $sessiondata);
			}
		}
		else
		{
			redirect('login', 'refresh');
		}
	}

	public function card()
	{
		if ($this->session->userdata('logged_in'))
		{
			$sessiondata = $this->session->userdata('logged_in');
			if ($sessiondata['level'] <> 2)
			{
        		$sessiondata = $this->session->userdata('logged_in');
				$this->load->view('header', $sessiondata);

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
			else
			{
				$this->load->view('header', $sessiondata);
				$this->load->view('home', $sessiondata);
			}
		}
		else
		{
			redirect('login', 'refresh');
		}
	}

	function card_output($output = null)
	{
		if ($this->session->userdata('logged_in'))
		{
			$sessiondata = $this->session->userdata('logged_in');
			if ($sessiondata['level'] <> 2)
			{
				$this->load->view('card_view.php', $output);
			}
			else
			{
				$this->load->view('header', $sessiondata);
				$this->load->view('home', $sessiondata);
			}
		}
		else
		{
			redirect('login', 'refresh');
		}
	}

	public function venue()
	{
		if ($this->session->userdata('logged_in'))
		{
			$sessiondata = $this->session->userdata('logged_in');
			if ($sessiondata['level'] <> 3)
			{
				$sessiondata = $this->session->userdata('logged_in');
				$this->load->view('header', $sessiondata);
        
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
			else
			{
				$this->load->view('header', $sessiondata);
				$this->load->view('home', $sessiondata);
			}
		}
		else
		{
			redirect('login', 'refresh');
		}
	}

	function venue_output($output = null)
	{
		if ($this->session->userdata('logged_in'))
		{
			$sessiondata = $this->session->userdata('logged_in');
			if ($sessiondata['level'] <> 3)
			{
				$this->load->view('venue_view.php', $output);
			}
			else
			{
				$this->load->view('header', $sessiondata);
				$this->load->view('home', $sessiondata);
			}
		}
		else
		{
			redirect('login', 'refresh');
		}
	}

	public function fixture()
	{
		if ($this->session->userdata('logged_in'))
		{
			$sessiondata = $this->session->userdata('logged_in');
			if ($sessiondata['level'] <> 3)
			{
				$sessiondata = $this->session->userdata('logged_in');
				$this->load->view('header', $sessiondata);
        
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
			else
			{
				$this->load->view('header', $sessiondata);
				$this->load->view('home', $sessiondata);
			}
		}
		else
		{
			redirect('login', 'refresh');
		}
	}

	function fixture_output($output = null)
	{
		if ($this->session->userdata('logged_in'))
		{
			$sessiondata = $this->session->userdata('logged_in');
			if ($sessiondata['level'] <> 3)
			{
				$this->load->view('fixture_view.php', $output);
			}
			else
			{
				$this->load->view('header', $sessiondata);
				$this->load->view('home', $sessiondata);
			}
		}
		else
		{
			redirect('login', 'refresh');
		}
	}

	public function nfa()
	{
		if ($this->session->userdata('logged_in'))
		{
			$sessiondata = $this->session->userdata('logged_in');
			if ($sessiondata['level'] <> 3)
			{
				$sessiondata = $this->session->userdata('logged_in');
				$this->load->view('header', $sessiondata);
        
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
			else
			{
				$this->load->view('header', $sessiondata);
				$this->load->view('home', $sessiondata);
			}
		}
		else
		{
			redirect('login', 'refresh');
		}
	}

	function nfa_output($output = null)
	{
		if ($this->session->userdata('logged_in'))
		{
			$sessiondata = $this->session->userdata('logged_in');
			if ($sessiondata['level'] <> 3)
			{
				$this->load->view('nfa_view.php', $output);
			}
			else
			{
				$this->load->view('header', $sessiondata);
				$this->load->view('home', $sessiondata);
			}
		}
		else
		{
			redirect('login', 'refresh');
		}
	}

	public function card_access_log()
	{
		if ($this->session->userdata('logged_in'))
		{
			$sessiondata = $this->session->userdata('logged_in');
			if ($sessiondata['level'] <> 3)
			{
				$sessiondata = $this->session->userdata('logged_in');
				$this->load->view('header', $sessiondata);
        
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
			else
			{
				$this->load->view('header', $sessiondata);
				$this->load->view('home', $sessiondata);
			}
		}
		else
		{
			redirect('login', 'refresh');
		}
	}

	function card_access_log_output($output = null)
	{
		if ($this->session->userdata('logged_in'))
		{
			$sessiondata = $this->session->userdata('logged_in');
			if ($sessiondata['level'] <> 3)
			{
				$this->load->view('card_access_log_view.php', $output);
			}
			else
			{
				$this->load->view('header', $sessiondata);
				$this->load->view('home', $sessiondata);
			}
		}
		else
		{
			redirect('login', 'refresh');
		}
	}

	public function issue_log()
	{
		if ($this->session->userdata('logged_in'))
		{
			$sessiondata = $this->session->userdata('logged_in');
			$this->load->view('header', $sessiondata);
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
		else
		{
			redirect('login', 'refresh');
		}
	}

	function issue_log_output($output = null)
	{
		if ($this->session->userdata('logged_in'))
		{
			$this->load->view('issue_log_view.php', $output);
		}
		else
		{
			redirect('login', 'refresh');
		}
	}

	public function team()
	{
		if ($this->session->userdata('logged_in'))
		{
			$sessiondata = $this->session->userdata('logged_in');
			$this->load->view('header', $sessiondata);
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
		else
		{
			redirect('login', 'refresh');
		}
	}

	function team_output($output = null)
	{
		if ($this->session->userdata('logged_in'))
		{
			$this->load->view('team_view.php', $output);
		}
		else
		{
			redirect('login', 'refresh');
		}
	}

	public function querynav()
	{
		if ($this->session->userdata('logged_in'))
		{
			$sessiondata = $this->session->userdata('logged_in');
			$this->load->view('header', $sessiondata);
			$this->load->view('querynav_view');
		}
		else
		{
			redirect('login', 'refresh');
		}
	}

	public function query1()
	{
		if ($this->session->userdata('logged_in'))
		{
			$sessiondata = $this->session->userdata('logged_in');
			$cardSelected = $this->input->post('cardSelected');
			$this->load->view('header', $sessiondata);
			$this->load->view('query1_view');
		}
		else
		{
			redirect('login', 'refresh');
		}
	}

	public function query2()
	{
		if ($this->session->userdata('logged_in'))
		{
			$sessiondata = $this->session->userdata('logged_in');
			$this->load->view('header', $sessiondata);
			$this->load->view('query_compList_view');
		}
		else
		{
			redirect('login', 'refresh');
		}
	}
    
    public function query3()
	{
		if ($this->session->userdata('logged_in'))
		{
			$sessiondata = $this->session->userdata('logged_in');
			$this->load->view('header', $sessiondata);
			$this->load->view('query3_view');
		}
		else
		{
			redirect('login', 'refresh');
		}
	}
    
    public function query4()
	{
		if ($this->session->userdata('logged_in'))
		{
			$sessiondata = $this->session->userdata('logged_in');
			$this->load->view('header', $sessiondata);
			$this->load->view('query4_view');
		}
		else
		{
			redirect('login', 'refresh');
		}
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
		if ($this->session->userdata('logged_in'))
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
		else
		{
			redirect('login', 'refresh');
		}
	}
	
	public function compList()
	{
		if ($this->session->userdata('logged_in'))
		{
			$fixtureSelected = $this->input->post('fixtureSelected');
			
			$compsAtFixture = $this->db->query('SELECT Competitor_competitorID, competitorFirstName, competitorLastName FROM card
												JOIN competitor ON card.Competitor_competitorID = competitor.competitorID
												JOIN team_has_fixture ON competitor.Team_teamID = team_has_fixture.Team_teamID
													WHERE Fixture_FixtureID = ' . $fixtureSelected . '');
			
			echo $this->table->generate($compsAtFixture);
			$this->load->view('querynav_view');
		}
		else
		{
			redirect('login', 'refresh');
		}
	}
	
	public function authCheck()
	{
		if ($this->session->userdata('logged_in'))
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
		else
		{
			redirect('login', 'refresh');
		}
	}
	

	public function fixtureSwipe()
	{
		if ($this->session->userdata('logged_in'))
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
		else
		{
			redirect('login', 'refresh');
		}     
	}

    public function displayTable()
    {
		if ($this->session->userdata('logged_in'))
		{
		}
		else
		{
			redirect('login', 'refresh');
		}   
           
    }

	public function query_entryAttempts()
	{
		if ($this->session->userdata('logged_in'))
		{
			$sessiondata = $this->session->userdata('logged_in');
			$this->load->view('header', $sessiondata);
			$this->load->view('query_entryAttempts_view');
		}
		else
		{
			redirect('login', 'refresh');
		}
	}
	
	public function query_entryLog()
	{
		if ($this->session->userdata('logged_in'))
		{
			$sessiondata = $this->session->userdata('logged_in');
			$this->load->view('header', $sessiondata);
			$this->load->view('query_entryLog_view');
		}
		else
		{
			redirect('login', 'refresh');
		}
	}
    
    public function query7()
	{
		if ($this->session->userdata('logged_in'))
		{
			$sessiondata = $this->session->userdata('logged_in');
			$this->load->view('header', $sessiondata);
			$this->load->view('query7_view');
		}
		else
		{
			redirect('login', 'refresh');
		}
	}

	public function blank()
	{
		if ($this->session->userdata('logged_in'))
		{
			$sessiondata = $this->session->userdata('logged_in');
			$this->load->view('header', $sessiondata);
			$this->load->view('blank_view');
		}
		else
		{
			redirect('login', 'refresh');
		}
	}

	public function logout()
	{
		if ($this->session->userdata('logged_in'))
		{

			$this->session->unset_userdata('logged_in');
			session_destroy();
			$this->load->view('login_view.php');
		}
		else
		{
			redirect('login', 'refresh');
		}
	}

	public function home()
	{
		if ($this->session->userdata('logged_in'))
		{	
			$sessiondata = $this->session->userdata('logged_in');
			$this->load->view('header', $sessiondata);
			$this->load->view('home');
		}
		else
		{
			redirect('login', 'refresh');
		}
	}

	public function account()
	{
		if ($this->session->userdata('logged_in'))
		{
			$sessiondata = $this->session->userdata('logged_in');
			$this->load->view('header', $sessiondata);
			$this->load->view('account_view');
		}
		else
		{
			redirect('login', 'refresh');
		}
	}

	public function update_login()
	{
		if ($this->session->userdata('logged_in'))
		{
			$name = $this->input->post("name");
			$password = $this->input->post("password");
			$sessiondata = $this->session->userdata('logged_in');
			$message = "";

			if ($name <> $sessiondata["name"] && $name <> "")
			{
				$this->db->query("UPDATE user SET name = '".$name."' WHERE username = '".$sessiondata["user"]."'");
				$message .= "Name";
				$sessiondata["name"] = $name;
				 $this->session->set_userdata('logged_in', $sessiondata);
			}

			if ($password <> "")
			{
				$this->db->query("UPDATE user SET password = '".md5($password)."' WHERE username = '".$sessiondata["user"]."'");
				$message .= " and Password";
			}

			if ($message == " and Password")
			{
				$message = "Password";
			}
			if ($message <> "")
			{
				$message .= " updated";
			}
			else
			{
				$message = "No updates made";
			}
			echo ("<SCRIPT LANGUAGE='JavaScript'>
							window.alert('".$message."')
							window.location.href=document.referrer
							</SCRIPT>");
		}
		else
		{
			redirect('login', 'refresh');
		}

	}

}
?>
