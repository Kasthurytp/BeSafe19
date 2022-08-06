<!DOCTYPE html>
<html lang="en">
<title>Be Safe 19</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
body {font-family: "Lato", sans-serif}
.mySlides {display: none}
</style>
<body>
<div id="divnic" style="display: none;"><?php echo $_POST['nic']; ?></div>
<div id="divdate" style="display: none;"><?php echo $_POST['date']; ?></div>
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
    <h2 class="w3-wide">CONTACT TRACING</h2>
    <br>
      <center>
        <select class="w3-input w3-border" required name="place" id="place">
          <option>Loading Places...</option>
        </select>
        <button class="w3-button w3-black w3-section w3-wide" style="padding-left: 30pt; padding-right: 30pt; float: left;" id="trace">TRACE</button>
        <br>
        <br>
        <br>
        <h4 class="w3-wide">Below people went same place that infected person went</h4>
        <br>
        <ul id="nics"></ul>
      </center>
  </div>

<!-- End Page Content -->
</div>

<!-- Image of location/map
<img src="/w3images/map.jpg" class="w3-image w3-greyscale-min" style="width:100%">
-->

<!-- Footer -->
<footer class="w3-container w3-padding-64 w3-center w3-opacity w3-light-grey w3-xlarge" style="position: fixed; bottom: 0; width: 100%;">
  <i class="fa fa-facebook-official w3-hover-opacity"></i>
  <i class="fa fa-instagram w3-hover-opacity"></i>
  <i class="fa fa-snapchat w3-hover-opacity"></i>
  <i class="fa fa-pinterest-p w3-hover-opacity"></i>
  <i class="fa fa-twitter w3-hover-opacity"></i>
  <i class="fa fa-linkedin w3-hover-opacity"></i>
  <!-- <p class="w3-medium">Powered by <a href="https://www.w3schools.com/w3css/default.asp" target="_blank">w3.css</a></p> -->
</footer>

<script type="module">
  // Import the functions you need from the SDKs you need
  import { initializeApp } from "https://www.gstatic.com/firebasejs/9.6.4/firebase-app.js";
  import { getFirestore, collection, query, where, getDocs } from "https://www.gstatic.com/firebasejs/9.6.4/firebase-firestore.js";
  // TODO: Add SDKs for Firebase products that you want to use
  // https://firebase.google.com/docs/web/setup#available-libraries

  // Your web app's Firebase configuration
  const firebaseConfig = {
    apiKey: "AIzaSyD6-Qv4JbEQwoyC3dO-ZHailtln5ecGDRU",
    authDomain: "besafe19-65c3d.firebaseapp.com",
    databaseURL: "https://besafe19-65c3d-default-rtdb.firebaseio.com",
    projectId: "besafe19-65c3d",
    storageBucket: "besafe19-65c3d.appspot.com",
    messagingSenderId: "189488652642",
    appId: "1:189488652642:web:2e18a63d3a29d0f5498c3b"
  };

  // Initialize Firebase
  const app = initializeApp(firebaseConfig);
  const db = getFirestore();

  const usersRef = collection(db, "users");
  const q = query(usersRef, where("nic", "==", document.getElementById('divnic').textContent));

  const querySnapshot = await getDocs(q);
  querySnapshot.forEach((doc) => {
    // doc.data() is never undefined for query doc snapshots
    //console.log(doc.id, " => ", doc.data());
    loadPlaces(doc.id);
  });

  async function loadPlaces(uid) {
    try {
      let c = collection(db, 'users/' + uid + "/EntryDetails");
      let places = await getDocs(c);
      let s = "";
      let dt = Date.parse(document.getElementById('divdate').textContent)/1000;

      let i = 0;
      places.forEach((doc) => {
        i += 1;
      });

      let j = 0;
      places.forEach((doc) => {
        j += 1;
        let cin = BigInt(doc.data()['check-in'].seconds);
        let cout = BigInt(doc.data()['check-out'].seconds);
        if (cin >= dt) {
          s += "<option value=\""+doc.data().qrCode+"_"+cin+"_"+cout+"\">"+doc.data().placeName+"</option>\n";
        }
        if (i == j) {
          if(s.localeCompare("") == 0) {
            document.getElementById('place').innerHTML = "<option>This person didn't went anywhere</option>";
          }else {
            document.getElementById('place').innerHTML = s;
          }
        }
      });
    } catch(e) {
      console.log(e);
      document.getElementById('place').innerHTML = "<option>This person didn't went anywhere</option>";
    }
  }

  document.getElementById('trace').onclick = async function() {
    let selectedPlace = document.getElementById("place").value.split("_");
    let checkIn = BigInt(selectedPlace[1]);
    let checkOut = BigInt(selectedPlace[2]);
    let qr = selectedPlace[0];
    document.getElementById('nics').innerHTML = "";
    let qu = query(usersRef, where("nic", "!=", document.getElementById('divnic').textContent));
    let users = await getDocs(qu);

    let i = 0;
    users.forEach((user) => {
      i += 1;
    });

    let j = 0;
    users.forEach(async(user) => {
      j += 1;
      await checkPlaces(user.id, qr, checkIn, checkOut, user.data().nic, j==i);
    });

  };

  function babs(big) {
    if (big < BigInt(0))
    {
      return big*BigInt(-1);
    }
    return big;
  }

  async function checkPlaces(uid, qr, cin, cout, nic, last) {
    let c = collection(db, 'users/' + uid + "/EntryDetails");
    let places = await getDocs(c);
    let s = "";
    places.forEach((doc) => {
      if (doc.data().qrCode.localeCompare(qr) == 0) {
        let checkIn = BigInt(doc.data()['check-in'].seconds);
        let checkOut = BigInt(doc.data()['check-out'].seconds);
        if (babs(checkIn-cin) <= BigInt(86400) && checkIn <= cout && (checkIn >= cin || checkOut >= cin)) {
          s += "<li>"+nic+"</li><br>\n";
        }
      }
    });
    document.getElementById('nics').innerHTML += s;
    if (last) {
      if(document.getElementById('nics').innerHTML.localeCompare("") == 0) {
        document.getElementById('nics').innerHTML = "<li>No Contacts</li>";
      }
    }
  }



</script>

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
