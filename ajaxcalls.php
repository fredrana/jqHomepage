<?php 
	include 'dbconnector.php';
	if(isset($_POST['action']) && !empty($_POST['action'])) {
		$action = $_POST['action'];
		switch($action) {
			case 'newtab' : 
				newtab();
				break;
			case 'newHotlink' : 
				$groupid = $_POST['groupid'];
				$link = $_POST['link'];
				$image = $_POST['image'];
				$tooltip = $_POST['tooltip'];
				newHotlink($groupid,$link,$image,$tooltip);
				break;
			case 'deleteHotlink' :
				$groupid = $_POST['groupid'];
				$linkid = $_POST['linkid'];
				deleteHotlink($groupid,$linkid);
				break;
			case 'newGroup' :
				$tabid = $_POST['tabid'];
				$groupname = $_POST['groupname'];
				newGroup($tabid,$groupname);
				break;
			case 'deleteGroup' :
				$groupid = $_POST['groupid'];
				deleteGroup($groupid);
				break;
		}
	}

	function newtab(){
		echo "<li><a href=\"\" class=\"buttons\"><span class=\"ui-icon ui-icon-suitcase\"></span>Bank & Forsikring</a></li>";
	}
?>