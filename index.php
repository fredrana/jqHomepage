<?php
session_start();
$_SESSION['isAdminMode'] = true;

include 'dbconnector.php';
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <title>My Startpage</title>
    <link rel="stylesheet" type="text/css" href="styles/styles.css" />
    <link rel="stylesheet" type="text/css" href="styles/jquery-ui-1.10.3.custom.min.css" />
    <script src="scripts/jquery-1.9.1.js"></script>
    <script src="scripts/jquery-ui-1.10.3.custom.min.js"></script>
	<script src="scripts/jquery.ui-contextmenu.min.js"></script>

    <script type="text/javascript">
    
	$(function(){ //ButtonClick
		$('button').on('click',function( event ){
			event.stopPropagation();
			event.preventDefault();
			
			if (itemId.indexOf("tab") > -1){
				// Handled separately.
			}
			else if (itemId.indexOf("link") > -1 || itemId == "" /*remove idtemId == "" when admin mode is made unnecessary*/){
				var senderId = event.target.id;
				var parentId = senderId.replace('button','');
				var header = document.getElementById(parentId);
				var url = document.getElementById(parentId +'url').value;
				var img = document.getElementById(parentId +'image').value;
				var tooltip = document.getElementById(parentId +'tooltip').value;
				
				$.post("ajaxcalls.php",
					{
						action:"newHotlink",
						groupid:parentId.replace('group',''),
						link:url,
						image:img,
						tooltip: tooltip
					},
					function(data,status){						
						header.innerHTML = "<a href=\"" +url +"\" target=\"_blank\"><img style=\"width:300px; height:150px; float:left; \" src=\"" +img +"\" alt=\"\" /></a>" +header.innerHTML;
						alert('data: ' +data +" status: " +status);
					}	
				);
			}
			else if (itemId.indexOf("group") > -1){
				
			}
			else{
				alert('Warning: New functionality not implemented for this element.');
			}
		});
	});
	
    $(function () { 
        $(".accordion_links").accordion({ heightStyle: 'content', active: 'false', collapsible: 'true' });
    });
	
	$(function() {
		$( document ).tooltip({track: true});
	});
	
    </script>

</head>
<body>
	<div id="tabEditDialog" title="New\Rename Tab">
		<form>
			<fieldset>
				<label for="tabEditNameBox">Name</label>
				<input type="text" name="name" id="tabEditNameBox" class="text ui-widget-content ui-corner-all">
				<!-- Allow form submission with keyboard without duplicating the dialog button -->
				<input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
			</fieldset>
		</form>
	</div>
	
	<div id="linkEditDialog" title="Edit Hotlink">
		<form>
			<fieldset>
				<label for="linkEditNameBox">Tooltip</label>
				<input type="text" name="name" id="linkEditNameBox" class="text ui-widget-content ui-corner-all">
				<label for="linkEditUrlBox">URL</label>
				<input type="text" name="link" id="linkEditUrlBox" class="text ui-widget-content ui-corner-all">
				<label for="linkEditImageBox">Image</label>
				<input type="text" name="image" id="linkEditImageBox" class="text ui-widget-content ui-corner-all">
				<!-- Allow form submission with keyboard without duplicating the dialog button -->
				<input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
			</fieldset>
		</form>
	</div>
	
	<div id="groupEditDialog" title="Create new\Rename Group">
		<form>
			<fieldset>
				<label for="groupEditNameBox">Name</label>
				<input type="text" name="name" id="groupEditNameBox" class="text ui-widget-content ui-corner-all">
				<!-- Allow form submission with keyboard without duplicating the dialog button -->
				<input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
			</fieldset>
		</form>
	</div>

    <div id="tabs">
 	    <ul id="tabsList">
			<?php				
				generateTabs();
			?>
		</ul>
		
		<?php
			generateAccordions();
		?>

    </div>
	<a href="http://validator.w3.org/check?uri=http%3A%2F%2Fskagestad.priv.no%2F;st=1" target="_blank">This page is validated as HTML5</a>
    
	<a href="http://www.beyondsecurity.com/vulnerability-scanner-verification/skagestad.priv.no"><img src="https://secure.beyondsecurity.com/verification-images/skagestad.priv.no/vulnerability-scanner-2.gif" alt="Website Security Test" border="0" /></a>
	
    <!--<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>-->
    <!-- Top Google Ad -->
    <!--<ins class="adsbygoogle"
        style="display:inline-block;width:728px;height:90px; border:5px;"
        data-ad-client="ca-pub-2790826587789805"
        data-ad-slot="1997015578"></ins>
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
    </script>-->
    
    <script type="text/javascript">
        $("#tabs").tabs({ hide: { effect: "fade", duration: 500 }, show: { effect: "fade", duration: 500 }, beforeActivate: function (event, ui) {
            if(ui.newTab[0].id == 'newTab'){
				$.post("ajaxcalls.php",
					{
					action:"newtab"
					},
					function(data,status){						
						var tabs = $( "#tabs" ).tabs();
						var index = tabs.tabs('option', 'active') +1;
						//var ul = tabs.find( "ul" );
						var tabInserted = "<li><a href=\"#" +index +"\" class=\"buttons\"><span class=\"ui-icon ui-icon-suitcase\"></span>Bank & Forsikring</a></li>";
						$(tabInserted).insertBefore(ui.newTab[0]);
						tabs.tabs('option', 'active', tabs.tabs('option', 'active') -1);
						tabs.tabs( "refresh" );		
					}	
				);
			}
        } });
		
		var itemId = '';
		var groupid = '';
		var linkid = '';
		$(document).contextmenu({
			delegate: ".hasmenu",
			menu: [
				{title: "New", cmd: "new", uiIcon: "ui-icon-arrowthickstop-1-e"},
				{title: "Delete", cmd: "delete", uiIcon: "ui-icon-circle-close"},
				{title: "Edit", cmd: "edit", uiIcon: "ui-icon-comment"}
				//{title: "----"},
				//{title: "More", children: [
				//	{title: "Sub 1", cmd: "sub1"},
				//	{title: "Sub 2", cmd: "sub1"}
			],
			beforeOpen: function(event, ui) {
				itemId = event.currentTarget.id;
				var id = itemId.replace('group','');
				groupid = id.split("link")[0];
				groupid = groupid.replace('header', ''); //if group, this will kick in.
				linkid = id.replace(groupid+'link','');
			},
			select: function(event, ui) {
				switch(ui.cmd) {
					case 'new':
						if (itemId.indexOf("tab") > -1){
							var nameBox = document.getElementById("tabEditNameBox");
							nameBox.value = "";
							$( "#tabEditDialog" ).dialog('open');	
						}
						else if (itemId.indexOf("link") > -1){
							alert('Warning: New function not implemented for links yet.');
						}
						else if (itemId.indexOf("group") > -1){
							var nameBox = document.getElementById("groupEditNameBox");
							nameBox.value = "";
							$( "#groupEditDialog" ).dialog('open');	
						}
						else{
							alert('Warning: New functionality not implemented for this element.');
						}
						break;
					case 'delete':
						if (itemId.indexOf("tab") > -1){
							alert('Warning: Delete function not implemented for tabs yet.');
						}
						else if (itemId.indexOf("link") > -1){
							$.post("ajaxcalls.php",
								{
									action:"deleteHotlink",
									groupid:groupid,
									linkid:linkid
								},
								function(data,status){						
									$( "#"+ itemId ).remove();
									alert('Delete: ' +data +" status: " +status);
								}	
							);
						}
						else if (itemId.indexOf("group") > -1){
							var childCount = document.getElementById(itemId.replace('header','')).children.length;
							if (childCount > 1){
								alert("Warning: This element has children and cannot be deleted");
								
							}
							else{
								$.post("ajaxcalls.php",
									{
										action:"deleteGroup",
										groupid:groupid
									},
									function(data,status){						
										$( "#"+ itemId ).remove();
										alert('Delete: ' +data +" status: " +status);
									}	
								);
							}
						}
						else{
							alert('Warning: Delete functionality not implemented for this element.');
						}
						break;
					case 'edit':
						if (itemId.indexOf("tab") > -1){
							var itemClicked = document.getElementById(itemId);
							var nameBox = document.getElementById("tabEditNameBox");
							nameBox.value = itemClicked.innerText;
							$( "#tabEditDialog" ).dialog('open');	
						}
						else if (itemId.indexOf("link") > -1){
							var itemClicked = document.getElementById(itemId);
							var nameBox = document.getElementById("linkEditNameBox");
							var urlBox = document.getElementById("linkEditUrlBox");
							var imageBox = document.getElementById("linkEditImageBox");
							nameBox.value = itemClicked.title;
							urlBox.value = itemClicked.href;
							imageBox.value = itemClicked.childNodes[0].src
							$( "#linkEditDialog" ).dialog('open');
						}
						else if (itemId.indexOf("group") > -1){
							var itemClicked = document.getElementById(itemId);
							var nameBox = document.getElementById("groupEditNameBox");
							nameBox.value = itemClicked.innerText;
							$( "#groupEditDialog" ).dialog('open');	
						}
						else{ //should never happen.
							alert('Warning: Edit function not implemented for this element.');
						}
						break;
					default:
						alert('Warning: The command has not been implemented yet.');
				}
			}
		});
		
		$("#tabEditDialog").dialog({
			dialogClass: "no-close",
			autoOpen: false, 
			modal: true,
			buttons: {
				"Save Changes": function() {
					var name = document.getElementById("tabEditNameBox").value;
					var tabid = itemId.replace('Item','');
					$.post("ajaxcalls.php",
						{
							action:"newTab",
							tabname: name
						},
						function(data,status){
							$("#" +itemId).parent().append( "<li><a href=\"\" class=\"buttons\"><span class=\"ui-icon ui-icon-suitcase\"></span>"+name +"</a></li>" );
							
							//Below can be used to insert at a specific location before the clicked tab element.
							//$("<li><a href=\"\" class=\"buttons\"><span class=\"ui-icon ui-icon-suitcase\"></span>Bank & Forsikring</a></li>").insertBefore("#"+itemId);
						}	
					);
					$( this ).dialog( "close" );
				},
				Cancel: function() {
					$( this ).dialog( "close" );
				}
			}
		});
		
		$("#groupEditDialog").dialog({
			dialogClass: "no-close",
			autoOpen: false, 
			modal: true,
			buttons: {
				"Save Changes": function() {
					var name = document.getElementById("groupEditNameBox").value;
					var tabid = document.getElementById(itemId).parentNode.parentNode.id;
					$.post("ajaxcalls.php",
						{
							action:"newGroup",
							tabid:tabid,
							groupname: name
						},
						function(data,status){						
							//header.innerHTML = "<a href=\"" +url +"\" target=\"_blank\"><img style=\"width:300px; height:150px; float:left; \" src=\"" +img +"\" alt=\"\" /></a>" +header.innerHTML;
							alert('data: ' +data +" status: " +status);
						}	
					);
					$( this ).dialog( "close" );
				},
				Cancel: function() {
					$( this ).dialog( "close" );
				}
			}
		});
		
		$("#linkEditDialog").dialog({
			dialogClass: "no-close",
			autoOpen: false, 
			modal: true,
			buttons: {
				"Save Changes": function() {
					$( this ).dialog( "close" );
				},
				Cancel: function() {
					$( this ).dialog( "close" );
				}
			}
		});
    </script>
</body>
</html>