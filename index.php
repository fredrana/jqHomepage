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
		// var tabs = $( "#tabs" ).tabs();
		// var ul = tabs.find( "ul" );
		// $( "<li><a href='#1'>New Tab</a></li>" ).appendTo( ul );
		// tabs.tabs( "refresh" );
		
		$.post("ajaxcalls.php",
				{
				id:"2"
				},
				function(data,status){
					var tabs = $( "#tabs" ).tabs();
					var ul = tabs.find( "ul" );
					$( data ).appendTo( ul );
					tabs.tabs( "refresh" );
				}	
		);
	}

    </script>

</head>
<body>

    <div id="tabs">
 	    <ul id="div1">
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
    
    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <!-- Top Google Ad -->
    <ins class="adsbygoogle"
        style="display:inline-block;width:728px;height:90px; border:5px;"
        data-ad-client="ca-pub-2790826587789805"
        data-ad-slot="1997015578"></ins>
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
    
    <script type="text/javascript">
        $("#tabs").tabs({ hide: { effect: "fade", duration: 500 }, show: { effect: "fade", duration: 500 } });
    </script>
</body>
</html>