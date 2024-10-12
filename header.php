<meta content="" name="description">
<meta content="" name="keywords">

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
<link rel="stylesheet" href="assets/font-awesome/css/all.min.css">

<!-- Vendor CSS Files -->
<link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="assets/vendor/icofont/icofont.min.css" rel="stylesheet">
<link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
<link href="assets/vendor/venobox/venobox.css" rel="stylesheet">
<link href="assets/vendor/animate.css/animate.min.css" rel="stylesheet">
<link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
<link href="assets/vendor/owl.carousel/assets/owl.carousel.min.css" rel="stylesheet">
<link href="assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">
<link href="assets/DataTables/datatables.min.css" rel="stylesheet">
<link href="assets/css/jquery.datetimepicker.min.css" rel="stylesheet">
<link href="assets/css/select2.min.css" rel="stylesheet">

<!-- Template Main CSS File -->
<link href="assets/css/style.css" rel="stylesheet">
<link type="text/css" rel="stylesheet" href="assets/css/jquery-te-1.4.0.css">

<!-- Clock and Date Display -->
<div id="page">
  <div id="header">
    <div id="clock" style="font-size: 20px; font-weight: bold; margin-top: 10px;"></div>
  </div>
</div>

<div id="loading"></div>

<script src="assets/vendor/jquery/jquery.min.js"></script>
<script src="assets/DataTables/datatables.min.js"></script>
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/vendor/jquery.easing/jquery.easing.min.js"></script>
<script src="assets/vendor/php-email-form/validate.js"></script>
<script src="assets/vendor/venobox/venobox.min.js"></script>
<script src="assets/vendor/waypoints/jquery.waypoints.min.js"></script>
<script src="assets/vendor/counterup/counterup.min.js"></script>
<script src="assets/vendor/owl.carousel/owl.carousel.min.js"></script>
<script src="assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="assets/js/select2.min.js"></script>
<script type="text/javascript" src="assets/js/jquery.datetimepicker.full.min.js"></script>
<script type="text/javascript" src="assets/font-awesome/js/all.min.js"></script>
<script type="text/javascript" src="assets/js/jquery-te-1.4.0.min.js" charset="utf-8"></script>

<script type="text/javascript">
  // Function to display the date and time in East African Time (EAT)
  function displayClock() {
    var now = new Date();
    var options = {
      timeZone: 'Africa/Nairobi',  // East African Time (EAT) timezone
      year: 'numeric',
      month: 'long',
      day: 'numeric',
      hour: '2-digit',
      minute: '2-digit',
      second: '2-digit'
    };

    var formatter = new Intl.DateTimeFormat([], options);
    document.getElementById('clock').innerHTML = formatter.format(now);

    // Update the clock every second
    setTimeout(displayClock, 1000);
  }

  // Call the displayClock function on page load
  $(document).ready(function () {
    displayClock();
  });

  // Existing onReady function
  function onReady(callback) {
    var intervalID = window.setInterval(checkReady, 1000);
    function checkReady() {
      if (document.getElementsByTagName('body')[0] !== undefined) {
        window.clearInterval(intervalID);
        callback.call(this);
      }
    }
  }

  function show(id, value) {
    document.getElementById(id).style.display = value ? 'block' : 'none';
  }

  onReady(function () {
    show('page', true);
    show('loading', false);
  });
</script>

