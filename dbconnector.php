<?php	
	function executeSql($sql){	
		include 'dbconnection.php';

		// Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);
		
		// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		} 
		else{				
			$result = $conn->query($sql);
			return $result;
		}
	}
	
	
	function editGroup($tabid, $groupid, $groupname){
		$sql = "update GROUPS set GROUP_NAME = \"". $groupname. "\" where TAB_ID = ".$tabid." and GROUP_ID = " .$groupid;
		//echo $sql;
		executeSql($sql);
	}
	
	function editHotlink($groupid, $linkid, $link, $image, $tooltip){
		$sql = "update HOTLINKS set LINK_PATH = \"". $link. "\", ICON_PATH = \"". $image. "\", LINK_TITLE = \"". $tooltip. "\" where GROUP_ID = ".$groupid." and LINK_ID = " .$linkid;
		//echo $sql;
		executeSql($sql);
	}
	
	function deleteHotlink($group, $link){
		executeSql("delete from HOTLINKS where GROUP_ID = ".$group." and LINK_ID = " .$link);
	}
	
	function deleteGroup($group){
		executeSql("delete from GROUPS where GROUP_ID = ".$group);
	}
	
	function deleteTab($tabid){
		$dbh = getDbConnection();
		
		$stmt = $dbh->prepare("CALL sp_deleteTab(?)");

		$stmt->bindParam(1, $tabid, PDO::PARAM_STR); 

		$stmt->execute();
	}
	
	function newGroup($tabid,$groupname){
		$dbh = getDbConnection();
		
		$stmt = $dbh->prepare("CALL sp_newGroup(?, ?)");

		$stmt->bindParam(1, $tabid, PDO::PARAM_STR); 
		$stmt->bindParam(2, $groupname, PDO::PARAM_STR);

		$stmt->execute();	
	}
	
	function getDbConnection(){
		include 'dbconnection.php';
		
		$dsn = 'mysql:dbname='. $dbname. ';host='. $servername;
		
		try {
			$dbh = new PDO($dsn, $username, $password);
		} catch (PDOException $e) {
			echo 'Connection failed: ' . $e->getMessage();
		}
		return $dbh;
	}
	
	function newTab($tabname){
		$dbh = getDbConnection();
	
		$stmt = $dbh->prepare("CALL sp_newTab(?)");

		$stmt->bindParam(1, $tabname, PDO::PARAM_STR); 

		$stmt->execute();
	}
	
	function newHotlink($groupid, $hotlink, $image, $title){
		$dbh = getDbConnection();
 
		$stmt = $dbh->prepare("CALL sp_newHotlink(?, ?, ?, ?)");

		$stmt->bindParam(1, $groupid, PDO::PARAM_STR); 
		$stmt->bindParam(2, $hotlink, PDO::PARAM_STR);
		$stmt->bindParam(3, $image, PDO::PARAM_STR);
		$stmt->bindParam(4, $title, PDO::PARAM_STR);

		$stmt->execute();
	}
	
	function generateTabs(){
		$select = "select * from TABS order by TAB_ORDER";
		$result = executeSql($select);
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				echo "<li id=\"tab". $row["TAB_ID"]. "\" class=\"hasmenu\"><a href=\"#page".$row["TAB_ID"]. "\" class=\"buttons\"><span class=\"ui-icon ". $row["TAB_ICON"]. "\"></span>". $row["TAB_NAME"]. "</a></li>";
			}
		}
	}
	
	function generateAccordions(){
		$select = "SELECT TAB_ID FROM TABS";
		$tabs = executeSql($select);
		
		if ($tabs->num_rows > 0) {
			while($tabrow = $tabs->fetch_assoc()) {
				echo "<div id=\"page". $tabrow["TAB_ID"]. "\" class=\"hasmenu\">";
				echo "<div class=\"accordion_links\">";
				
				$select = "select * from GROUPS where TAB_ID = ". $tabrow["TAB_ID"];
				$groups = executeSql($select);
				
				while($grouprow = $groups->fetch_assoc()){
					echo "<h3 id=\"group". $grouprow["GROUP_ID"]. "header\" class=\"hasmenu\">". $grouprow["GROUP_NAME"]. "</h3>";
					echo "<div id=\"group". $grouprow["GROUP_ID"]. "\" class=\"hasmenu\">";
					
					$select = "select * from HOTLINKS where GROUP_ID = ". $grouprow["GROUP_ID"];
					$links = executeSql($select);
					
					while($linksrow = $links->fetch_assoc()){
						echo "<a id=\"group". $linksrow[GROUP_ID]. "link". $linksrow[LINK_ID]. "\" class=\"hasmenu\" href=\"". $linksrow[LINK_PATH].  "\" title=\"". $linksrow[LINK_TITLE]. "\" target=\"_blank\"><img style=\"width:300px; height:150px; float:left; \" src=\"". $linksrow[ICON_PATH]. "\" alt=\"". $linksrow[ICON_PATH]. "\" /></a>";
					}
				
					echo "</div>";
				}
				
				echo "</div>";
				echo "</div>";
			}
		}
	}
	
?>