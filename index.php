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
    <div id="tabs">
 	    <ul id="tabsList">
			<?php				
				generateTabs();
			?>
		</ul>
		
		<?php
			if ($_SESSION['isAdminMode'])
				echo "<button id=\"testbutton\">Click me</button>";
		
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
				linkid = id.replace(groupid+'link','');
			},
			select: function(event, ui) {
				switch(ui.cmd) {
					case 'delete':
						$groupid = 
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
						break;
					case 'edit':
						alert('This feature is not implemented yet.');
						break;
					default:
						alert('Warning: Unexpected command in context menu.');
				}
			}
		});
    </script>
</body>
</html>