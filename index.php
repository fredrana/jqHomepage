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
        $("#tabs").tabs({
            beforeLoad: function (event, ui) {
                ui.jqXHR.error(function () {
                    ui.panel.html(
                      "Couldn't load this tab. We'll try to fix this as soon as possible. " +
                      "If this wouldn't be a demo.");
                });
            }
        });
    });
    
    $(function () {
        $(".accordion_links").accordion({ heightStyle: 'content', active: 'false', collapsible: 'true' });
    });

    </script>

</head>
<body>
    <script>
            $("#kunde").hide("drop", { direction: "left" }, "slow");
    </script>
    <div id="tabs">
 	    <ul>
			<?php 
				include 'dbconnector.php';
				generateTabs();
			?>
		</ul>
		
		<?php
			generateAccordions();
		?>
        <!--<div id="2">
            <div class="accordion_links">
                <h3>Interne Applikasjoner</h3>
                <div>				
                    <a href="https://asp.adrega.no/AdregaPI" target="_blank"><img style="width:300px; height:150px" src="img/timeforing.png" /></a>
                    <a href="http://adrega-builder/ccnet" target="_blank"><img style="width:300px; height:150px" src="img/cruice.png" /></a>
                    <a href="http://10.0.2.215:8080/tfs/web/" target="_blank"><img style="width:300px; height:150px" src="img/tfs.jpg" /></a>
                </div>
                <h3>Skytjenester</h3>
                <div>
                    <a href="https://drive.google.com" target="_blank"><img style="width:300px; height:150px" src="img/googledrive.jpg" /></a>
                    <a href="https://plus.google.com/" target="_blank"><img style="width:300px; height:150px" src="img/googleplus.jpg" /></a>
                    <a href="https://login.microsoftonline.com/" target="_blank"><img style="width:300px; height:150px" src="img/office365.png" /></a>
					<a href="https://www.visualstudio.com/" target="_blank"><img style="width:300px; height:150px" src="img/visualonline.png" /></a>
					<a href="https://www.controlncloud.com/" target="_blank"><img style="width:300px; height:150px" src="img/controlncloud.png" /></a>
                </div>
                <h3>Adrega Installere</h3>
                <div>
                    <a href="http://adrega-builder/39installs/" target="_blank"><img style="width:300px; height:150px" src="img/adrega39.png" /></a>
                    <a href="http://adrega-builder/trunkinstalls/" target="_blank"><img style="width:300px; height:150px" src="img/adregatrunk.png" /></a>
                </div>
            </div>
        </div>
		<div id="3" style="height: auto">
			<h3>Hjem</h3>
            <div>
				<a href="https://www.skandiabanken.no" target="_blank"><img style="width:300px; height:150px" src="img/skandia.png" /></a>
				<a href="https://www.sparebank1.no/oslo-akershus/" target="_blank"><img style="width:300px; height:150px" src="img/sparebank1.png" /></a>
            </div>
		</div>
		<div id="4" style="height: auto">
			<h3>Skytjenester</h3>
            <div>
				<a href="https://www.playcanvas.com" target="_blank"><img style="width:300px; height:150px" src="https://d1qb2nb5cznatu.cloudfront.net/startups/i/120160-541e04926e9a5da9c136ab3e7caa5d44-medium_jpg.jpg?buster=1392289755" /></a>
				<a href="https://drive.jolicloud.com" target="_blank"><img style="width:300px; height:150px" src="http://www.everonit.com/techtips/wp-content/uploads/2012/03/jolicloud_logo.jpg" /></a>
            </div>
		</div>
		<div id="5" style="height: auto">
			<h3>Nyheter</h3>
            <div>
				<a href="https://www.vg.no" target="_blank"><img style="width:300px; height:150px" src="http://dating-adventure.com/wp-content/uploads/2010/10/VG-Logo.jpg" /></a>
				<a href="https://www.dagbladet.no/" target="_blank"><img style="width:300px; height:150px" src="https://betaling.dagbladet.no/gfx/product_icons/11333.png" /></a>
            </div>
		</div>-->
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
    

    <script>
        var visible = 0;

        var switchImage = function () {

            if (visible == 0) {
                nextImage = 'img/kundesammendrag_02partial.png';
                visible = 1;
            }
            else if (visible == 1) {
                nextImage = "img/salgssammendrag.png";
                visible = 2;
            }
            else if (visible == 2) {
                nextImage = "img/produktsammendrag.png";
                visible = 0;
            }

            
            $("#image").show("fade", 1000);
            $("#image").attr('src', nextImage);
        }
    </script>
    
    <script type="text/javascript">
        $("#tabs").tabs({ hide: { effect: "fade", duration: 500 }, show: { effect: "fade", duration: 500 } });

        $("#image").click(function () {
            if (timer != null) {
                $("#slideshow").css("cursor", "url('img/play2.png'),default");
                clearInterval(timer);
                timer = null;
                
            }
            else {
                $("#slideshow").css("cursor", "url('img/pause2.png'),default");
                timer = setInterval(function () { $("#image").hide("fade", 1000, switchImage) }, 5000);    
            }
        });
    </script>
</body>
</html>