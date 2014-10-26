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
            var currentbar = $(".progressbar");
            currentbar.progressbar({
                value: 69
            });
        });

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
        $("#accordion_links").accordion({ heightStyle: 'content', active: 'false', collapsible: 'true' });
    });

    var timer = null;

    $(document).ready(function () {
        timer = setInterval(function () { $("#image").hide("fade", 1000, switchImage) }, 5000);
        $("#slideshow").css("cursor", "url('img/pause2.png'),default");
    });

    </script>

</head>
<body>
        <script>
            $("#kunde").hide("drop", { direction: "left" }, "slow");
    </script>
    <div id="tabs">
 	    <ul>
			<li><a href="#bankInsurance" class="buttons"><span class="ui-icon ui-icon-mail-open"></span>Bank & Forsikring</a></li>
		    <li><a href="tasks.html" class="buttons"><span class="ui-icon ui-icon-clipboard"></span>Nyheter</a></li>
			<li><a href="projects.html" class="buttons"><span class="ui-icon ui-icon-suitcase"></span>Skytjenester</a></li>
            <li><a href="#links" class="buttons"><span class="ui-icon ui-icon-extlink"></span>Adrega</a></li>
            <!--<li><a href="customerlog.aspx" class="buttons"><span class="ui-icon ui-icon-person"></span>Kundehenvendelser</a></li>
            <li><a href="saleslog.aspx" class="buttons"><span class="ui-icon ui-icon-cart"></span>Salgshenvendelser</a></li>-->
		</ul>
        <div id="bankInsurance" style="height: auto">
			<h3>Bank & Forsikring</h3>
            <div>
				<a href="https://www.skandiabanken.no" target="_blank"><img style="width:300px; height:150px" src="img/skandia.png" /></a>
				<a href="https://www.sparebank1.no/oslo-akershus/" target="_blank"><img style="width:300px; height:150px" src="img/sparebank1.png" /></a>
            </div>
        </div>
        <div id="projects">
        </div>
        <div id="links">
            <div id="accordion_links">
                <h3>Interne Applikasjoner</h3>
                <div>
					<?php
						$servername = "10.246.17.50:3306";
						$dbname = "skagestad_priv_";
						$username = "skagestad_priv_";
						$password = "rk6xTU9G";
						
						$msservername = "localhost";
						$msusername = "hpuser";
						$mspassword = "Hpuser4u";
						$mssql_tablo="ad_forum"; 

						// Create connection
						$conn = new mysqli($servername, $username, $password, $dbname);
						//$conn = new mssql_connect($msservername, $msusername, $mspassword);
						//$conn = mssql_connect($msservername,$mssql_tablo, $msusername, $mspassword);
						
						// Check connection
						if ($conn->connect_error) {
							die("Connection failed: " . $conn->connect_error);
						} 
						else{				
							$sql = "SELECT * FROM TABS";
							$result = $conn->query($sql);
							
							if ($result->num_rows > 0) {
								while($row = $result->fetch_assoc()) {
									echo "The name is: ". $row["TAB_NAME"];
								}
							} else {
								echo "0 results";
							}
						}
					?>
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