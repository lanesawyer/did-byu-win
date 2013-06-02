<?php
    include('connect.php');
    include('simple_html_dom.php');
	
	//Get the right sport
	$sport = $_GET["sport"];

	$isFootball = false;
	$rowId = 1;

	if(strcmp($sport, "football") == 0) {
		$isFootball = true;
		$rowId = 0;
	}
	
    //SQL Query
    $sql_select='SELECT * FROM tb_stats WHERE id=' . $rowId;

    //Execute SQL and save result set as variable '$results'
    $sql_result=mysql_query($sql_select);

    //iterate through result set, add results to wishList array.
    if ($row = mysql_fetch_array($sql_result)) {
        $accessTime = $row['last_access_time'];
    }

    //If the data is more than 1 minute old, go scrap it. Otherwise get what is in the database
    if(time() - $accessTime > 60) {
	
		$football = 'http://espn.go.com/college-football/team/_/id/252/brigham-young-cougars';
		$basketball = 'http://espn.go.com/mens-college-basketball/team/_/id/252/brigham-young-cougars';
		
		$results = array();
		
		if($isFootball) {
			$results = scrape_game($football, $rowId);
		}
		else {
			$results = scrape_game($basketball, $rowId);
		}
		
		$result = $results[0];
        $score = $results[1];
        $link = $results[2];
        $nextGameDate = $results[3];
        $nextGameOpponent = $results[4];
        $nextGameLink = $results[5];
    }
    else {
        $result = $row['result'];
        $score = $row['score'];
        $link = $row['link'];
        $nextGameDate = $row['next_date'];
        $nextGameOpponent = $row['next_team'];
        $nextGameLink = $row['next_link'];
    }
	
	//Gets the appropriate game from the link
	function scrape_game($link, $rowId) {
		
		// Create DOM from URL or file
		$html = file_get_html($link);
	
		// Find games
		foreach($html->find('tr[class*=row team]') as $g) {
			// If we see Eastern Time, the game hasn't been played yet
			if(strstr($g->children(2), "ET")) {
				$db_nextGameDate = $g->children(0)->plaintext . " at " . $g->children(2)->plaintext;
				
				//Deals with teams that don't have an ESPN page
				if(isset($g->children(1)->children(0)->children(2)->children(0)->href)) {
					$db_nextGameLink = $g->children(1)->children(0)->children(2)->children(0)->getAttribute('href');
					$db_nextGameOpponent = $g->children(1)->children(0)->children(2)->children(0)->plaintext;
				} else {
					$db_nextGameLink = $link;
					$db_nextGameOpponent = $g->children(1)->children(0)->children(2)->plaintext;
				}
				
				break;
			}
			
			//Check for postponed games
			if(isset($g->children(2)->firstChild()->firstChild()->plaintext)) {
				$working = $g->children(2)->firstChild()->firstChild()->plaintext;
			}
			
			if(strcmp($working, "Postponed") == 0) {
				$db_result = "P";
				$db_link = "";
				$db_score = "0-0";
			} else {
				$db_result = $g->children(2)->firstChild()->firstChild()->firstChild()->plaintext;
				$db_link = $g->children(2)->firstChild()->lastChild()->firstChild()->getAttribute('href'); 
				$db_score = $g->children(2)->firstChild()->lastChild()->firstChild()->plaintext;
			}
		}
		
        //Store scraped data in the database
        $sql_update = 'UPDATE tb_stats SET result=\'' . $db_result . '\', score=\''
                . $db_score . '\', link=\'' . $db_link . '\', next_date=\'' . $db_nextGameDate
                . '\', next_team=\'' . $db_nextGameOpponent . '\', next_link=\'' . $db_nextGameLink
                . '\', last_access_time=\'' . time() . '\' WHERE id=' . $rowId;
		
        mysql_query($sql_update);

		$results = array($db_result, $db_score, $db_link, $db_nextGameDate, $db_nextGameOpponent, $db_nextGameLink);
		
		return $results;
	}
?>
