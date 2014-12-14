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
			case 'newTab' :
				$tabname = $_POST['tabname'];
				newTab($tabname);
				break;
			case 'deleteTab' :
				$tabid = $_POST['tabid'];
				deleteTab($tabid);
				break;
			case 'editHotlink' :
				$groupid = $_POST['groupid'];
				$linkid = $_POST['linkid'];
				$link = $_POST['link'];
				$image = $_POST['image'];
				$tooltip = $_POST['tooltip'];
				editHotlink($groupid,$linkid, $link,$image,$tooltip);
				break;
			case 'editGroup' :
				$tabid = $_POST['tabid'];
				$groupid = $_POST['groupid'];
				$groupname = $_POST['groupname'];
				editGroup($tabid,$groupid,$groupname);
				break;
			case 'editTab' :
				$tabid = $_POST['tabid'];
				$tabname = $_POST['tabname'];
				editTab($tabid, $tabname);
				break;
			case 'updateGroupOrder' :
				$groupid = $_POST['groupid'];
				$grouporder = $_POST['grouporder'];
				updateGroupOrder($groupid, $grouporder);
				
		}
	}
?>