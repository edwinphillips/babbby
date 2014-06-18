<?php

include 'lib/functions.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
      "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <script type='text/javascript' src='js/jquery-1.11.0.js'></script>
    <script type='text/javascript' src='js/simple.js'></script>
    <link href="css/simple.css" rel="stylesheet" type="text/css"/>
    <title>Baby</title>
    <style>body {background-color: #<?php echo random_colour(); ?>;}</style>
</head>
<body>

    <div id="menu">
        <span id="events" class="dynamic"></span>
        <span id="contact" class="dynamic"></span>
        <span id="press" class="dynamic"></span>
        <span id="products" class="dynamic"></span>
    </div>

    <div id='content'>
        <div id='stage'>
            <div id='canvas'></div>
            <button id="video" class="dynamic">
                <img src="img/video.png"  />
            </button>
            <button id="audio"  class="dynamic">
                <img src="img/audio.png"  />
            </button>
        </div>
    </div>

    <div id="scroller">
        <span id="static-text">This text won't move</span>
        <div class="scrollingtext">
            <span class="review">
                <span class="message">
                    <a href="#">'Scrolling Text'</a>
                </span> -
                <span class="forename">Extra info</span>,
                <span class="location">Location</span>
            </span>
            <span class="review">
                <span class="message">
                    <a href="#">'More Scrolling Text'</a>
                </span> -
                <span class="forename">More Extra info</span>,
                <span class="location">Another Location</span>
            </span>
        </div>
    </div>  

</body>
</html>
