<!DOCTYPE html>
<html lang="en">
<title>QR Generator</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="leaflet/leaflet.css" />
<style>
body {font-family: "Lato", sans-serif;}
.mySlides {display: none;}
</style>
<body>

<!-- Navbar -->
<div class="w3-top">
  <div class="w3-bar w3-black w3-card">
    <a href="index.html" class="w3-bar-item w3-button w3-padding-large">BE SAFE 19</a>
    <a class="w3-bar-item w3-button w3-padding-large w3-hide-medium w3-hide-large w3-right" href="javascript:void(0)" onclick="myFunction()" title="Toggle Navigation Menu"><i class="fa fa-bars"></i></a>
    <a href="medical.html" class="w3-bar-item w3-button w3-padding-large w3-hide-small w3-right">Medical Authorities</a>
    <a href="qr.html" class="w3-bar-item w3-button w3-padding-large w3-hide-small w3-right">QR for Businesses</a>
        <a href="contact_tracing.php" class="w3-bar-item w3-button w3-padding-large w3-hide-small w3-right">Contact Tracing</a>
    <a href="contact.html" class="w3-bar-item w3-button w3-padding-large w3-hide-small w3-right">Contact</a>
  </div>
</div>

<!-- Navbar on small screens (remove the onclick attribute if you want the navbar to always show on top of the content when clicking on the links) -->
<div id="navDemo" class="w3-bar-block w3-black w3-hide w3-hide-large w3-hide-medium w3-top" style="margin-top:46px">
  <a href="medical.html" class="w3-bar-item w3-button w3-padding-large" onclick="myFunction()">Medical Authorities</a>
  <a href="qr.html" class="w3-bar-item w3-button w3-padding-large" onclick="myFunction()">QR for Businesses</a>
      <a href="contact_tracing.php" class="w3-bar-item w3-button w3-padding-large" onclick="myFunction()">Contact Tracing</a>
  <a href="contact.html" class="w3-bar-item w3-button w3-padding-large" onclick="myFunction()">Contact</a>
</div>

<!-- Page content -->
<div class="w3-content" style="max-width:2000px;margin-top:46px">

  <!-- The Band Section -->
  <div class="w3-container w3-content w3-center w3-padding-64" style="max-width:800px" id="band">
    <h2 class="w3-wide">YOUR QR CODE</h2>
    
    <?php 
		$loc = explode(", ", str_replace("LatLng(", "", substr($_POST['location'], 0, strlen($_POST['location'])-1)));

    require "vendor/autoload.php";
		
    use MrShan0\PHPFirestore\FirestoreClient;
    use MrShan0\PHPFirestore\Fields\FirestoreGeoPoint;

		$firestoreClient = new FirestoreClient('besafe19-65c3d', '53f143a931a714ae80c0b75de321880c18d46ec9', [
    		'database' => '(default)',
		]);

		$timestamp = round(microtime(true) * 1000);
		$firestoreClient->addDocument('companies', [
		    'name' => $_POST['name'],
		    'contact' => $_POST['contact'],
		    'email' => $_POST['email'],
		    'loc' => new FirestoreGeoPoint($loc[0], $loc[1])
		], $timestamp);



		include "qrcode.php"; 

	    $qc = new QRCODE();
	    // Create Text Code
	    $qc->TEXT($timestamp);
	    // Save QR Code
	    $qc->QRCODE(400,'qrcodes/' . $timestamp . ".png");

	    echo '<img src="qrcodes/' .$timestamp. '.png"><br>';

	    echo '<a href="qrcodes/' .$timestamp. '.png" download><button class="w3-button w3-black w3-section">Download</button></a>';

      ?>

  </div>
<!-- End Page Content -->
</div>

<!-- Image of location/map
<img src="/w3images/map.jpg" class="w3-image w3-greyscale-min" style="width:100%">
-->

<!-- Footer -->
<footer class="w3-container w3-padding-64 w3-center w3-opacity w3-light-grey w3-xlarge">
  <i class="fa fa-facebook-official w3-hover-opacity"></i>
  <i class="fa fa-instagram w3-hover-opacity"></i>
  <i class="fa fa-snapchat w3-hover-opacity"></i>
  <i class="fa fa-pinterest-p w3-hover-opacity"></i>
  <i class="fa fa-twitter w3-hover-opacity"></i>
  <i class="fa fa-linkedin w3-hover-opacity"></i>
  <!-- <p class="w3-medium">Powered by <a href="https://www.w3schools.com/w3css/default.asp" target="_blank">w3.css</a></p> -->
</footer>

<script>

// Used to toggle the menu on small screens when clicking on the menu button
function myFunction() {
  var x = document.getElementById("navDemo");
  if (x.className.indexOf("w3-show") == -1) {
    x.className += " w3-show";
  } else { 
    x.className = x.className.replace(" w3-show", "");
  }
}

// When the user clicks anywhere outside of the modal, close it
var modal = document.getElementById('ticketModal');
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
</script>

</body>
</html>
