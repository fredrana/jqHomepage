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
	
	function newHotlink($groupid, $hotlink, $image){
		include 'dbconnection.php';
		//$conn = new mysqli($servername, $username, $password, $dbname);
		
		$dsn = 'mysql:dbname='. $dbname. ';host='. $servername;

		// You must first connect to the database by instantiating a PDO object
		try {
			$dbh = new PDO($dsn, $username, $password);
		} catch (PDOException $e) {
			echo 'Connection failed: ' . $e->getMessage();
		}

		// Then you can prepare a statement and execute it.    
		$stmt = $dbh->prepare("CALL sp_newHotlink(?, ?, ?)");
		// One bindParam() call per parameter

		$stmt->bindParam(1, $groupid, PDO::PARAM_STR); 
		$stmt->bindParam(2, $hotlink, PDO::PARAM_STR);
		$stmt->bindParam(3, $image, PDO::PARAM_STR); 		

		// call the stored procedure
		$stmt->execute();
	}
	
	function generateTabs(){
		$select = "SELECT * FROM TABS";
		$result = executeSql($select);
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				echo "<li id=\"tab". $row["TAB_ORDER"]. "\"><a href=\"#".$row["TAB_ID"]. "\" class=\"buttons\"><span class=\"ui-icon ". $row["TAB_ICON"]. "\"></span>". $row["TAB_NAME"]. "</a></li>";
			}

			if ($_SESSION['isAdminMode'])
				echo "<li id=\"newTab\"><a href=\"\" class=\"buttons\"><span class=\"ui-icon ui-icon-plus\"></span></a></li>";
		}
	}
	
	function generateAccordions(){
		$select = "SELECT TAB_ID FROM TABS";
		$tabs = executeSql($select);
		
		if ($tabs->num_rows > 0) {
			while($tabrow = $tabs->fetch_assoc()) {
				echo "<div id=\"". $tabrow["TAB_ID"]. "\">";
				echo "<div class=\"accordion_links\">";
				
				$select = "select * from GROUPS where TAB_ID = ". $tabrow["TAB_ID"];
				$groups = executeSql($select);
				//todo: Must add if to handle case where no groups.
				while($grouprow = $groups->fetch_assoc()){
					echo "<h3>". $grouprow["GROUP_NAME"]. "</h3>";
					echo "<div id=\"group". $grouprow["GROUP_ID"].   "\">";
					
					$select = "select * from HOTLINKS where GROUP_ID = ". $grouprow["GROUP_ID"];
					$links = executeSql($select);
					//todo: Must add if to handle case where no links.
					while($linksrow = $links->fetch_assoc()){
						echo "<a id=\"group". $linksrow[GROUP_ID]. "link". $linksrow[LINK_ID]. "\" class=\"hasmenu\" href=\"". $linksrow[LINK_PATH].  "\" target=\"_blank\"><img style=\"width:300px; height:150px; float:left; \" src=\"". $linksrow[ICON_PATH]. "\" alt=\"". $linksrow[ICON_PATH]. "\" /></a>";
					}
					if ($_SESSION['isAdminMode'])
						echo 
							"<form style=\"width:300px; height:150px; display: inline-block; float: left\">
								<fieldset>
									<legend>New Link:</legend>
									<span>URL: <input id=\"group". $grouprow["GROUP_ID"]. "url\" type=\"text\"></span><br>
									<span>Image: <input id=\"group". $grouprow["GROUP_ID"]. "image\" type=\"text\"></span>
							  </fieldset>
							  <button id=\"group". $grouprow["GROUP_ID"]. "button\">New Tab</button>
							</form>";
				
					echo "</div>";
				}
				if ($_SESSION['isAdminMode']){
					echo "<h3>+</h3>";
					echo "<div>";
					echo "</div>";
				}
				
				echo "</div>";
				echo "</div>";
			}
		}
	}
	
?>