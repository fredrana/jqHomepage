<?php 
	if(isset($_POST['action']) && !empty($_POST['action'])) {
		$action = $_POST['action'];
		switch($action) {
			case 'newtab' : newtab();break;
			case 'blah' : blah();break;
        // ...etc...
		}
	}

	function newtab(){
		echo "<li><a href=\"\" class=\"buttons\"><span class=\"ui-icon ui-icon-suitcase\"></span>Bank & Forsikring</a></li>";
	}
?>