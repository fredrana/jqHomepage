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
	
    $(function () { 
        $(".accordion_links").accordion({ 
			header: "> div > h3",
			heightStyle: 'content', 
			active: 'false', 
			collapsible: 'true' 
		}).sortable({
        axis: "y",
        handle: "h3",
        stop: function( event, ui ) {
          // IE doesn't register the blur when sorting
          // so trigger focusout handlers to remove .ui-state-focus
          ui.item.children( "h3" ).triggerHandler( "focusout" );
 
          // Refresh accordion to handle new order
          $( this ).accordion( "refresh" );
        }
		});
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
	
	<div id="yesCancelDialog" title="Are you sure?">
		<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>The item will be permanently deleted and cannot be recovered. Are you sure?</p>
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
    
	<!--<a href="http://www.beyondsecurity.com/vulnerability-scanner-verification/skagestad.priv.no"><img src="https://secure.beyondsecurity.com/verification-images/skagestad.priv.no/vulnerability-scanner-2.gif" alt="Website Security Test" border="0" /></a>-->
	
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
		var mode = '';
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
				event.stopPropagation();
				itemId = event.currentTarget.id;
				var id = itemId.replace('group','');
				groupid = id.split("link")[0];
				groupid = groupid.replace('header', ''); //if group, this will kick in.
				linkid = id.replace(groupid+'link','');
			},
			select: function(event, ui) {
				switch(ui.cmd) {
					case 'new':
						mode = 'new';
						if (itemId.indexOf("tab") > -1){
							var nameBox = document.getElementById("tabEditNameBox");
							nameBox.value = "";
							$( "#tabEditDialog" ).dialog('open');	
						}
						else if (itemId.indexOf("link") > -1 || (itemId.indexOf("group") > -1) && itemId.indexOf("header") == -1){
							var nameBox = document.getElementById("linkEditNameBox");
							nameBox.value = "";
							$( "#linkEditDialog" ).dialog('open');
						}
						else if (itemId.indexOf("group") + itemId.indexOf("page") > -2){
							var nameBox = document.getElementById("groupEditNameBox");
							nameBox.value = "";
							$( "#groupEditDialog" ).dialog('open');	
						}
						else{
							alert('Warning: New functionality not implemented for this element.');
						}
						break;
					case 'delete':
						mode = 'delete';
						if (itemId.indexOf("tab") > -1){
							var tabid = itemId.replace('tab','');
							var childCount = 0;
							if(document.getElementById('page' +tabid).childNodes.length > 0)
								childCount = document.getElementById('page' +tabid).childNodes[0].childNodes.length;
							if (childCount > 0){
								alert("Warning: This tab has sub-elements and cannot be deleted");
							}
							else{
								$('#yesCancelDialog').dialog("option", "buttons", { 
								"Yes": function() { 
									$.post("ajaxcalls.php",
										{
											action:"deleteTab",
											tabid:tabid
										},
										function(data,status){						
											$( "#"+ itemId ).remove();
										}	
									);
									$(this).dialog("close");  
								},  
								"CANCEL": 
									function() { 
										$(this).dialog("close"); }
									} 
								);
								$( "#yesCancelDialog" ).dialog('open');
							}
						}
						else if (itemId.indexOf("link") > -1){
							$('#yesCancelDialog').dialog("option", "buttons", { 
								"Yes": function() { 
									$.post("ajaxcalls.php",
										{
											action:"deleteHotlink",
											groupid:groupid,
											linkid:linkid
										},
										function(data,status){						
											$( "#"+ itemId ).remove();
										}	
									); 
									$(this).dialog("close");  
								},  
								"CANCEL": 
									function() { 
										$(this).dialog("close"); }
									} 
								);
								$( "#yesCancelDialog" ).dialog('open');
							
						}
						else if (itemId.indexOf("group") > -1){
							var childCount = document.getElementById(itemId.replace('header','')).children.length;
							if (childCount > 0){
								alert("Warning: This element has children and cannot be deleted");
							}
							else{
								$('#yesCancelDialog').dialog("option", "buttons", { 
								"Yes": function() { 
									$.post("ajaxcalls.php",
										{
											action:"deleteGroup",
											groupid:groupid
										},
										function(data,status){						
											$( "#"+ itemId ).remove();
										}	
									); 
									$(this).dialog("close");  
								},  
								"CANCEL": 
									function() { 
										$(this).dialog("close"); }
									} 
								);
								$( "#yesCancelDialog" ).dialog('open');
							}
						}
						else{
							alert('Warning: Delete functionality not implemented for this element.');
						}
						break;
					case 'edit':
						mode = 'edit';
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
							urlBox.value = itemClicked.getAttribute('href');
							imageBox.value = itemClicked.childNodes[0].getAttribute('src');
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
					var tabid = itemId.replace('tab','');
					if(mode == 'new'){
						$.post("ajaxcalls.php",
							{
								action:"newTab",
								tabname: name
							},
							function(data,status){
								//var tabs = $("#" +itemId).parent().tabs();
								//var ul = tabs.find("ul");
								//$("<li><a href=\"\" class=\"buttons\"><span class=\"ui-icon ui-icon-suitcase\"></span>"+name +"</a></li>").append
								
								$("#" +itemId).parent().append( "<li><a href=\"\" class=\"buttons\"><span class=\"ui-icon ui-icon-suitcase\"></span>"+name +"</a></li>" );
								$("#" +itemId).tabs("refresh");
								
								//Below .insertBefore can be used to insert at a specific location before the clicked tab element.
								//$("<li><a href=\"\" class=\"buttons\"><span class=\"ui-icon ui-icon-suitcase\"></span>Bank & Forsikring</a></li>").insertBefore("#"+itemId);
							}	
						);
					}
					else if (mode == 'edit'){
						$.post("ajaxcalls.php",
							{
								action:"editTab",
								tabid:tabid,
								tabname: name
							},
							function(data,status){
								//$('#' +itemId.replace('tab','page')).text(name);innerText innerHTML textContent outerText
								document.getElementById(itemId).textContent = name;
								//document.getElementById(itemId).innerText = name;
								//Below .insertBefore can be used to insert at a specific location before the clicked tab element.
								//$("<li><a href=\"\" class=\"buttons\"><span class=\"ui-icon ui-icon-suitcase\"></span>Bank & Forsikring</a></li>").insertBefore("#"+itemId);
							}	
						);
					}
					else{
						alert('Warning: Unsupported tab mode selected');
					}
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
				"Save": function() {
					var name = document.getElementById("groupEditNameBox").value;
					var tabid = null;
					if (itemId.indexOf("page") > -1){ //A page was clicked directly
						tabid = itemId.replace("page","");
					}
					else{ //Another accordion elements was clicked
						tabid = document.getElementById(itemId).parentNode.parentNode.parentNode.id.replace("page","");
					}
					if(mode == 'new'){
						$.post("ajaxcalls.php",
							{
								action:"newGroup",
								tabid:tabid,
								groupname: name
							},
							function(data,status){		
								var newDiv = "<div class=\"group\">";
								newDiv += "<h3 id=\"group" +data +"header\" class=\"hasmenu\">" +name +"</h3>";
								newDiv +="<div id=\"group" +data +"\" class=\"hasmenu\">";
								newDiv +='</div></div>';
								$(document.getElementById("page"+tabid).childNodes[0]).append(newDiv);
								$(document.getElementById("page"+tabid).childNodes[0]).accordion("refresh");     
							}	
						);
					}
					else if (mode == 'edit'){
						$.post("ajaxcalls.php",
							{
								action:"editGroup",
								tabid:tabid,
								groupid:groupid,
								groupname: name
							},
							function(data,status){						
								var itemClicked = document.getElementById(itemId);
								itemClicked.innerText = name;
							}	
						);
					}
					else{
						alert('Unsupported group mode set');
					}
					$( this ).dialog( "close" );
				},
				Cancel: function() {
					$( this ).dialog( "close" );
				}
			}
		});
		
		$("#yesCancelDialog").dialog({
			dialogClass: "no-close",
			autoOpen: false, 
			modal: true,
			buttons: {
				"Yes": function() {
					alert('A yes command is not set');
					$( this ).dialog( "close" );
				},
				Cancel: function() {
					alert('A no command is not set');
					$( this ).dialog( "close" );
				}
			}
		});
		
		$("#linkEditDialog").dialog({
			dialogClass: "no-close",
			autoOpen: false, 
			modal: true,
			buttons: {
				"Save": function() {
					var name = document.getElementById("linkEditNameBox").value;
					var url = document.getElementById("linkEditUrlBox").value;
					var img = document.getElementById("linkEditImageBox").value;
				
					if(mode == 'new'){
						$.post("ajaxcalls.php",
							{
								action:"newHotlink",
								groupid:groupid,
								link:url,
								image:img,
								tooltip: name
							},
							function(data,status){
								var newLink = "<a id=\"group" +groupid +"link" +data +"\" class='hasmenu' href=\"" +url +"\" title=\"" +name +"\" target=\"_blank\"><img style=\"width:300px; height:150px; float:left; \" src=\"" +img +"\" alt=\"\" /></a>";
								if(itemId.indexOf("link") > -1)
									$("#" +itemId).parent().append( newLink );
								else
									$("#" +itemId).append( newLink );									
							}
						);
					}
					else if (mode == 'edit'){
						$.post("ajaxcalls.php",
							{
								action:"editHotlink",
								groupid:groupid,
								linkid:linkid,
								link:url,
								image:img,
								tooltip: name
							},
							function(data,status){
								var itemClicked = document.getElementById(itemId);
								itemClicked.title = name;
								itemClicked.setAttribute('href', url);
								itemClicked.childNodes[0].setAttribute('src',img);
							}
						);
					}
					else{
						alert('Unsupported link edit mode set');
					}
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