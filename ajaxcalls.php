<?php 
  $id = trim($_POST["id"]);
  
  if ($id == "1")                // if user id is blank
    echo "You entered 1"; 
  else if ($id == "2")     // if user id is "johnny" (case sensitive)
    echo "<li><a href=\"#1\" class=\"buttons\"><span class=\"ui-icon ui-icon-suitcase\"></span>Bank & Forsikring</a></li>";
  else                              // if user id anything else
    echo "You entered something else: " +$id;
?>