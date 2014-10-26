<?php
	function executeSql($sql){
		$servername = "10.246.17.50:3306";
		$dbname = "skagestad_priv_";
		$username = "skagestad_priv_";
		$password = "pwd";

		$msservername = "localhost";
		$msusername = "hpuser";
		$mspassword = "Hpuser4u";
		$mssql_tablo="ad_forum";
		
		// Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);
		//$conn = new mssql_connect($msservername, $msusername, $mspassword);
		//$conn = mssql_connect($msservername,$mssql_tablo, $msusername, $mspassword);
		
		// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		} 
		else{				
			$result = $conn->query($sql);
			return $result;
		}
	}

	function generateTabs(){
		$select = "SELECT * FROM TABS";
		$result = executeSql($select);
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				echo "<li><a href=\"#".$row["TAB_ID"]. "\" class=\"buttons\"><span class=\"ui-icon ". $row["TAB_ICON"]. "\"></span>". $row["TAB_NAME"]. "</a></li>";
			}
		}
	}
	
	function generateAccordions(){
		echo "<p>Dette er en test</p>";
	}
?>