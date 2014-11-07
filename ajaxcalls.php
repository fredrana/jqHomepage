<?php 
	include 'dbconnector.php';
	if(isset($_POST['action']) && !empty($_POST['action'])) {
		$action = $_POST['action'];
		switch($action) {
			case 'newtab' : newtab();break;
			case 'saveHotlink' : 
				$groupid = $_POST['groupid'];
				$link = $_POST['link'];
				$image = $_POST['image'];
				saveHotlink($groupid,$link,$image);
				break;
		}
	}

	function newtab(){
		echo "<li><a href=\"\" class=\"buttons\"><span class=\"ui-icon ui-icon-suitcase\"></span>Bank & Forsikring</a></li>";
	}
	
	function saveHotlink($groupid, $link, $image){
		executeSql("insert into HOTLINKS values (".$groupid.",\"" .$link ."\",\"". $image ."\");");
	}
?>