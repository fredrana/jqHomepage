<?php 
	include 'dbconnector.php';
	if(isset($_POST['action']) && !empty($_POST['action'])) {
		$action = $_POST['action'];
		switch($action) {
			case 'newtab' : newtab();break;
			case 'newHotlink' : 
				$groupid = $_POST['groupid'];
				$link = $_POST['link'];
				$image = $_POST['image'];
				newHotlink($groupid,$link,$image);
				break;
			case 'deleteHotlink' :
				$groupid = $_POST['groupid'];
				$linkid = $_POST['linkid'];
				deleteHotlink($groupid,$linkid);
				break;
		}
	}

	function newtab(){
		echo "<li><a href=\"\" class=\"buttons\"><span class=\"ui-icon ui-icon-suitcase\"></span>Bank & Forsikring</a></li>";
	}
	
	function deleteHotlink($group, $link){
		executeSql("delete from HOTLINKS where GROUP_ID = ".$group." and LINK_ID = " .$link);
	}
?>