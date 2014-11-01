<!DOCTYPE html>

<html>
<head runat="server">
    <title></title>
    <link rel="stylesheet" type="text/css" href="styles/styles.css" />
    <link rel="stylesheet" type="text/css" href="styles/jquery-ui-1.10.3.custom.min.css" />
    <script src="scripts/jquery-1.9.1.js"></script>
    <script src="scripts/jquery-ui-1.10.3.custom.min.js"></script>

    <script type="text/javascript">
    
    $(function () {
        $(".accordion_links").accordion({ heightStyle: 'content', active: 'false', collapsible: 'true' });
    });
	
	function btnClick() {
		
	}

    </script>

</head>
<body>

    <div id="tabs">
 	    <ul id="tabsList">
			<?php
				include 'dbconnector.php';
				generateTabs();
			?>
		</ul>
		<button id="testbutton" onclick="btnClick()">Click me</button>
		<?php
			generateAccordions();
		?>

    </div>
    
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
    </script>
</body>
</html>