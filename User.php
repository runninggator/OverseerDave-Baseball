<?php
	require_once 'playerGenerator.php';
	class User
    {
        // The user's ID
        private $username;

        // The user's team
        public $team = array();

        // The user's current amount of money
        private $money;

        // The user's current experience
        private $experience;
        
        // This user's team ID
        private $tid;
        
        // This user's ID
        private $pid;
        
        // THis user's teamname
        private $teamname;
        
        private $wins;
        
        private $losses;

        public function __construct($username, $teamname)
        {
        	// Get the rest of the fields from the DB
        	
        	$query = "SELECT * FROM person WHERE username='$username'";
        	$result = queryMysql($query);
        	if ($result->num_rows == 1)
        	{
        		$result->data_seek(0);
				$row = $result->fetch_array(MYSQLI_ASSOC);
        		$this->username = $row['username'];
        		$this->money = $row['money'];
        		$this->experience = $row['experience'];
        		$this->wins = $row['wins'];
        		$this->losses = $row['losses'];
        		
        		// query team table for pid
        		$this->pid = $row['pid'];
        		$query = "SELECT * FROM team WHERE pid='$this->pid'";
        		$result = queryMysql($query);
        		if ($result->num_rows == 0)
        		{
        			// Create a team
        			$query = "INSERT INTO team(tid, pid, name, rank) VALUES (NULL, '$this->pid', '$teamname', NULL)";
        			$result = queryMysql($query);
        			if (!$result) echo "ERROR: Could Not Create Team<br>";
        			$this->team = playerGenerator::getNewTeam($this->experience);
        			$query = "SELECT * FROM team WHERE pid='$this->pid'";
        			$result = queryMysql($query);
        			$result->data_seek(0);
        			$row = $result->fetch_array(MYSQLI_ASSOC);
        			$this->tid = $row['tid'];
        			$this->addPlayersToDB();
        		}
        		else 
        		{
        			// Load team
        			$result->data_seek(0);
        			$row = $result->fetch_array(MYSQLI_ASSOC);
        			$this->tid = $row['tid'];
        			$this->teamname = $row['name'];
        			$query = "SELECT * FROM player WHERE tid='$this->tid' ORDER BY position";
        			$result = queryMysql($query);
        			$num_rows = $result->num_rows;
        			for ($i = 0; $i < $num_rows; $i++)
        			{
        				$result->data_seek($i);
        				$row = $result->fetch_array(MYSQLI_ASSOC);
        				array_push($this->team, new player( $row['first'], $row['last'], $row['catching'], $row['hitting'], 
        													$row['throwing'], $row['running'], $row['stamina'], $row['plid'], $i + 1));
        			}
        		}
        	}
        }

        public function hasTeam()
        {
            return empty($this->team);
        }

        public function getTeam()
        {
        	// Fills the team array with players
            return $this->team;
        }

        public function getMoney()
        {
            return $this->money;
        }
        
        public function getPid()
        {
        	return $this->pid;
        }
        
        public function getUsername()
        {
        	return $this->username;
        }

        public function getExperience()
        {
            return $this->experience;
        }
        
        public function getTeamname()
        {
        	return $this->teamname;
        }
        
        public function getWins()
        {
        	return $this->wins;
        }
        
        public function getLosses()
        {
        	return $this->losses;
        }

        public function setTeam($team)
        {
            $this->team = $team;
            $this->storeIntoDB();
        }

        public function setMoney($money)
        {
            $this->money = $money;
            $this->storeIntoDB();
        }

        public function setExperience($experience)
        {
            $this->experience = $experience;
            $this->storeIntoDB();
        }
        
        public function setWins($wins)
        {
        	$this->wins = $wins;
        	$this->storeIntoDB();
        }
        
        public function setLosses($losses)
        {
        	$this->losses = $losses;
        	$this->storeIntoDB();
        }
        
        private function addPlayersToDB()
        {
        	// Insert team
        	for ($i = 0; $i < 15; $i++)
        	{
        		$first = $this->team[$i]->getFirstName();
        		$last = $this->team[$i]->getLastName();
        		$hitting = $this->team[$i]->getHitting();
        		$throwing = $this->team[$i]->getThrowing();
        		$running = $this->team[$i]->getRunning();
        		$catching = $this->team[$i]->getCatching();
        		$stamina = $this->team[$i]->getStamina();
        		$position = $this->team[$i]->getPosition();
        		$query = "INSERT INTO player (plid, tid, first, last, hitting, catching, throwing, running, stamina, position) 
        				VALUES (NULL, '$this->tid','$first','$last','$hitting','$catching',
        				'$throwing','$running','$stamina', '$position')";
        		$result = queryMysql($query);
        	}
        }
        
        public function upgradeTeam()
        {
        	$newTeam = playerGenerator::getNewTeam($this->experience);
        	// Update Team
        	for ($i = 0; $i < 15; $i++)
        	{
        		$first = $newTeam[$i]->getFirstName();
        		$last = $newTeam[$i]->getLastName();
        		$hitting = $newTeam[$i]->getHitting();
        		$throwing = $newTeam[$i]->getThrowing();
        		$running = $newTeam[$i]->getRunning();
        		$catching = $newTeam[$i]->getCatching();
        		$stamina = $newTeam[$i]->getStamina();
        		$PLID = $this->team[$i]->getPLID();
        		$query = "UPDATE player SET first='$first', last='$last', hitting='$hitting', catching='$catching',
        					running='$running', throwing='$throwing', stamina='$stamina' WHERE plid='$PLID'";
        		$result = queryMysql($query);
        	}
        	$this->team = $newTeam;
        }
        
        private function storeIntoDB()
        {
            //// Save this object back to the database ////
            // Money and experience
            $query = "UPDATE person SET experience='$this->experience', money='$this->money', wins='$this->wins',
            			losses='$this->losses' WHERE username='$this->username'";
            $result = queryMysql($query);
            // Update team
            $query = "SELECT * FROM player WHERE tid='$this->tid'";
            $result = queryMysql($query);
            $num_rows = $result->num_rows;
            for ($i = 0; $i < $num_rows; $i++)
            {
            	$hitting = $this->team[$i]->getHitting();
            	$throwing = $this->team[$i]->getThrowing();
            	$running = $this->team[$i]->getRunning();
            	$catching = $this->team[$i]->getCatching();
            	$stamina = $this->team[$i]->getStamina();
            	$position = $this->team[$i]->getPosition();
            	$PLID = $this->team[$i]->getPLID();
            	$query = "UPDATE player SET hitting='$hitting', throwing='$throwing', running='$running', catching='$catching',
            				stamina='$stamina', position='$position' WHERE plid='$PLID'";
            	$result = queryMysql($query);
            }
        }
        
        public function analyzeUser()
        {
        	$total = 0;
        	foreach ($this->team as $player)
        	{
        		$hitting = $player->getHitting();
            	$throwing = $player->getThrowing();
            	$running = $player->getRunning();
            	$catching = $player->getCatching();
            	if ($player->getPosition() < 10) $total += 2*($hitting + $throwing + $running + $catching);
            	else $total += $hitting + $throwing + $running + $catching;
        	}
        	$total *= $this->experience;
        	return $total;
        }
    }
?>