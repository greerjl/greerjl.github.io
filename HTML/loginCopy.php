<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="stylesheet" type="text/css" href="../CSS/normalize.css"/>
    <link rel="stylesheet" type="text/css" href="../CSS/login.css"/>
    <link rel="icon" href="../images/HUM_logo.png">

    <title>HUM-login</title>

    <!-- Bootstrap core CSS -->
    <link href="../bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="../../assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../bootstrap/css/starter-template.css" rel="stylesheet">
    <link href="../bootstrap/css/sticky-footer-navbar.css" rel="stylesheet">
    <link href="../bootstrap/css/signin.css" rel="stylesheet">

    <script src="../../assets/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

 </head>
 <script id="pb_blockScript">function inject() {
   var originalOpenWndFnKey = "originalOpenFunction";
   var originalWindowOpenFn = window.open;
   var originalCreateElementFn = document.createElement;
   var originalCreateEventFn = document.createEvent;
   var windowsWithNames = {};
   var timeSinceCreateAElement = 0;
   var lastCreatedAElement = null;
   var fullScreenOpenTime = void 0;
   var parentOrigin = window.location != window.parent.location ? document.referrer : document.location;

   window[originalOpenWndFnKey] = window.open; // save the original open window as global param
   function newWindowOpenFn() {
     var openWndArguments = arguments;
     var useOriginalOpenWnd = true;
     var generatedWindow = null;

     function blockedWndNotification(openWndArguments) {
       parent.postMessage({ type: "blockedWindow", args: JSON.stringify(openWndArguments) }, parentOrigin);
     }

     function getWindowName(openWndArguments) {
       var windowName = openWndArguments[1];
       if (windowName != null && !["_blank", "_parent", "_self", "_top"].includes(windowName)) {
         return windowName;
       }

       return null;
     }

     function copyMissingProperties(src, dest) {
       var prop = void 0;
       for (prop in src) {
         try {
           if (dest[prop] === undefined && src[prop]) {
             dest[prop] = src[prop];
           }
         } catch (e) {}
       }
       return dest;
     }

     // the element who registered to the event
     var capturingElement = null;
     if (window.event != null) {
       capturingElement = window.event.currentTarget;
     }

     if (capturingElement == null) {
       var caller = openWndArguments.callee;
       while (caller.arguments != null && caller.arguments.callee.caller != null) {
         caller = caller.arguments.callee.caller;
       }
       if (caller.arguments != null && caller.arguments.length > 0 && caller.arguments[0].currentTarget != null) {
         capturingElement = caller.arguments[0].currentTarget;
       }
     }

     /////////////////////////////////////////////////////////////////////////////////
     // Blocked if a click on background element occurred (<body> or document)
     /////////////////////////////////////////////////////////////////////////////////

     if (capturingElement != null && (capturingElement instanceof Window || capturingElement === document || capturingElement.URL != null && capturingElement.body != null || capturingElement.nodeName != null && (capturingElement.nodeName.toLowerCase() == "body" || capturingElement.nodeName.toLowerCase() == "#document"))) {
       window.pbreason = "Blocked a new window opened with URL: " + openWndArguments[0] + " because it was triggered by the " + capturingElement.nodeName + " element";
       useOriginalOpenWnd = false;
     } else {
       useOriginalOpenWnd = true;
     }
     /////////////////////////////////////////////////////////////////////////////////


     /////////////////////////////////////////////////////////////////////////////////
     // Block if a full screen was just initiated while opening this url.
     /////////////////////////////////////////////////////////////////////////////////

     var fullScreenElement = document.webkitFullscreenElement || document.mozFullscreenElement || document.fullscreenElement;
     if (new Date().getTime() - fullScreenOpenTime < 1000 || isNaN(fullScreenOpenTime) && isDocumentInFullScreenMode()) {

       window.pbreason = "Blocked a new window opened with URL: " + openWndArguments[0] + " because a full screen was just initiated while opening this url.";

       /* JRA REMOVED
     if (window[script_params.fullScreenFnKey]) {
     window.clearTimeout(window[script_params.fullScreenFnKey]);
     }
     */

       if (document.exitFullscreen) {
         document.exitFullscreen();
       } else if (document.mozCancelFullScreen) {
         document.mozCancelFullScreen();
       } else if (document.webkitCancelFullScreen) {
         document.webkitCancelFullScreen();
       }

       useOriginalOpenWnd = false;
     }
     /////////////////////////////////////////////////////////////////////////////////


     if (useOriginalOpenWnd == true) {
       generatedWindow = originalWindowOpenFn.apply(this, openWndArguments);
       // save the window by name, for latter use.
       var windowName = getWindowName(openWndArguments);
       if (windowName != null) {
         windowsWithNames[windowName] = generatedWindow;
       }

       // 2nd line of defence: allow window to open but monitor carefully...

       /////////////////////////////////////////////////////////////////////////////////
       // Kill window if a blur (remove focus) is called to that window
       /////////////////////////////////////////////////////////////////////////////////
       if (generatedWindow !== window) {
         (function () {
           var openTime = new Date().getTime();
           var originalWndBlurFn = generatedWindow.blur;
           generatedWindow.blur = function () {
             if (new Date().getTime() - openTime < 1000 /* one second */) {
                 window.pbreason = "Blocked a new window opened with URL: " + openWndArguments[0] + " because a it was blured";
                 generatedWindow.close();
                 blockedWndNotification(openWndArguments);
               } else {
               originalWndBlurFn();
             }
           };
         })();
       }
       /////////////////////////////////////////////////////////////////////////////////
     } else {
       var windowName;

       (function () {
         // (useOriginalOpenWnd == false)

         var location = {
           href: openWndArguments[0]
         };
         location.replace = function (url) {
           location.href = url;
         };

         generatedWindow = {
           close: function close() {
             return true;
           },
           test: function test() {
             return true;
           },
           blur: function blur() {
             return true;
           },
           focus: function focus() {
             return true;
           },
           showModelessDialog: function showModelessDialog() {
             return true;
           },
           showModalDialog: function showModalDialog() {
             return true;
           },
           prompt: function prompt() {
             return true;
           },
           confirm: function confirm() {
             return true;
           },
           alert: function alert() {
             return true;
           },
           moveTo: function moveTo() {
             return true;
           },
           moveBy: function moveBy() {
             return true;
           },
           resizeTo: function resizeTo() {
             return true;
           },
           resizeBy: function resizeBy() {
             return true;
           },
           scrollBy: function scrollBy() {
             return true;
           },
           scrollTo: function scrollTo() {
             return true;
           },
           getSelection: function getSelection() {
             return true;
           },
           onunload: function onunload() {
             return true;
           },
           print: function print() {
             return true;
           },
           open: function open() {
             return this;
           },

           opener: window,
           closed: false,
           innerHeight: 480,
           innerWidth: 640,
           name: openWndArguments[1],
           location: location,
           document: { location: location }
         };

         copyMissingProperties(window, generatedWindow);

         generatedWindow.window = generatedWindow;

         windowName = getWindowName(openWndArguments);

         if (windowName != null) {
           try {
             // originalWindowOpenFn("", windowName).close();
             windowsWithNames[windowName].close();
           } catch (err) {}
         }
         //why set timeout?
         setTimeout(function () {
           var url = void 0;
           if (!(generatedWindow.location instanceof Object)) {
             url = generatedWindow.location;
           } else if (!(generatedWindow.document.location instanceof Object)) {
             url = generatedWindow.document.location;
           } else if (location.href != null) {
             url = location.href;
           } else {
             url = openWndArguments[0];
           }
           openWndArguments[0] = url;
           blockedWndNotification(openWndArguments);
         }, 100);
       })();
     }

     return generatedWindow;
   }

   /////////////////////////////////////////////////////////////////////////////////
   // Replace the window open method with Poper Blocker's
   /////////////////////////////////////////////////////////////////////////////////
   window.open = function () {
     try {
       return newWindowOpenFn.apply(this, arguments);
     } catch (err) {
       return null;
     }
   };
   /////////////////////////////////////////////////////////////////////////////////


   //////////////////////////////////////////////////////////////////////////////////////////////////////////
   // Monitor dynamic html element creation to prevent generating <a> elements with click dispatching event
   //////////////////////////////////////////////////////////////////////////////////////////////////////////
   document.createElement = function () {

     var newElement = originalCreateElementFn.apply(document, arguments);

     if (arguments[0] == "a" || arguments[0] == "A") {
       (function () {

         timeSinceCreateAElement = new Date().getTime();

         var originalDispatchEventFn = newElement.dispatchEvent;

         newElement.dispatchEvent = function (event) {
           if (event.type != null && ("" + event.type).toLocaleLowerCase() == "click") {
             window.pbreason = "blocked due to an explicit dispatchEvent event with type 'click' on an 'a' tag";
             parent.postMessage({
               type: "blockedWindow",
               args: JSON.stringify({ "0": newElement.href })
             }, parentOrigin);
             return true;
           }

           return originalDispatchEventFn(event);
         };

         lastCreatedAElement = newElement;
       })();
     }

     return newElement;
   };
   /////////////////////////////////////////////////////////////////////////////////


   /////////////////////////////////////////////////////////////////////////////////
   // Block artificial mouse click on frashly created <a> elements
   /////////////////////////////////////////////////////////////////////////////////
   document.createEvent = function () {
     try {
       if (arguments[0].toLowerCase().includes("mouse") && new Date().getTime() - timeSinceCreateAElement <= 50) {
         window.pbreason = "Blocked because 'a' element was recently created and " + arguments[0] + " event was created shortly after";
         arguments[0] = lastCreatedAElement.href;
         parent.postMessage({
           type: "blockedWindow",
           args: JSON.stringify({ "0": lastCreatedAElement.href })
         }, parentOrigin);
         return null;
       }
       return originalCreateEventFn.apply(document, arguments);
     } catch (err) {}
   };
   /////////////////////////////////////////////////////////////////////////////////


   /////////////////////////////////////////////////////////////////////////////////
   // Monitor full screen requests
   /////////////////////////////////////////////////////////////////////////////////
   function onFullScreen(isInFullScreenMode) {
     if (isInFullScreenMode) {
       fullScreenOpenTime = new Date().getTime();
     } else {
       fullScreenOpenTime = NaN;
     }
   }

   /////////////////////////////////////////////////////////////////////////////////

   function isDocumentInFullScreenMode() {
     // Note that the browser fullscreen (triggered by short keys) might
     // be considered different from content fullscreen when expecting a boolean
     return document.fullScreenElement && document.fullScreenElement !== null || // alternative standard methods
     document.mozFullscreenElement != null || document.webkitFullscreenElement != null; // current working methods
   }

   document.addEventListener("fullscreenchange", function () {
     onFullScreen(document.fullscreen);
   }, false);

   document.addEventListener("mozfullscreenchange", function () {
     onFullScreen(document.mozFullScreen);
   }, false);

   document.addEventListener("webkitfullscreenchange", function () {
     onFullScreen(document.webkitIsFullScreen);
   }, false);
 }</script><script>inject()</script>

 <body data-gr-c-s-loaded="true">
 <nav class="navbar navbar-inverse navbar-fixed-top">
   <div class="container">
     <div class="navbar-header">
       <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
         <span class="sr-only">Toggle navigation</span>
         <span class="icon-bar"></span>
         <span class="icon-bar"></span>
         <span class="icon-bar"></span>
       </button>
       <a class="navbar-brand" href="../index.html"> Home Utilities Manager </a>
     </div>
     <div id="navbar" class="collapse navbar-collapse">
       <ul class="nav navbar-nav">
         <li class="active"><a href="../index.html">Home</a></li>
         <li><a href="#chores">Chores</a></li>
         <li><a href="#tasks">Tasks</a></li>
         <li><a href="#events">Events</a></li>
         <li><a href="#schedule">Schedule</a></li>
         <li><a href="#settings">Settings</a></li>
         <li><a href="#logout">Log Out</a></li>
       </ul>
     </div><!--/.nav-collapse -->
   </div><!--./container -->
 </nav>
      <div class="container">

      <div class="starter-template">
        <div class="page-header">
            <h1>Home Utilities Manager</h1>
            <h3> An application housing all your home management needs.</h2>
        </div><!-- /.page-header-->
        <?php include 'dbconnect.php'; ?>
        <?php if($_SERVER["REQUEST_METHOD"] == "GET") { ?>
        <div class="content">
            <form id="LogIn" class="form-signin" method="POST" > <!--action="welcome.php-->
            <h2 class="form-signin-heading"> Log In </h2>
            <label for="username" class="sr-only"> Email address </label>
            <input type="email" id="username" class="form-control"
            name="usnm" placeholder="Email address" autofocus required>

            <label for="password" class="sr-only"> Password </label>
            <input type="password" id="password" name="pswd"
            pattern="(?=.*\d).{6,}" class="form-control"
            placeholder="Password" required>

            <div class="checkbox">
              <label>
                <input type="checkbox" value="remember-me"> Remember me
              </label>
            </div> <!--End checkbox -->
            <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>

      Don't have an account?<a href="./signup.php"> Sign up</a>
	</form>
  <?php }
  if($_SERVER["REQUEST_METHOD"] == "POST") {

  // username and password sent from form
    $username = mysqli_real_escape_string($db,$_POST['usnm']);
    $password = mysqli_real_escape_string($db,$_POST['pswd']);

    $sql = "SELECT UID FROM user_info WHERE username = '$username' and password = '$password'";
    $result = mysqli_query($db,$sql);
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
    $active = $row['active'];

    $count = 0;
    $count = mysqli_num_rows($result);
    // If result matched $myusername and $mypassword, table row must be 1 row

    if($count == 1) {
      header('Location: welcome.php');
      //session_register("myusername");
      //$_SESSION['login_user'] = $myusername;
    }else {
      echo "Your Login Name or Password is invalid";
    }//end else
  }//end POST if stmt
  ?>
      </div><!-- /.content -->
    </div><!--/.starter template -->
  </div> <!-- /.container -->
    <footer class="footer">
      <div class="container">
        <p class="text muted">Capstone Production: September 2016 - May 2017. Authors <a target="_blank" href="https://www.linkedin.com/in/gagedgibson">Gage Gibson</a>,
        <a target="_blank" href="https://www.linkedin.com/in/jaymegreer">Jayme Greer</a> and Caleb LaVergne.</p>
      </div><!--/.container-->
    </footer>

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="../assets/js/jquery.js"></script>
    <script src="../assets/js/bootstrap-transition.js"></script>
    <script src="../assets/js/bootstrap-alert.js"></script>
    <script src="../assets/js/bootstrap-modal.js"></script>
    <script src="../assets/js/bootstrap-dropdown.js"></script>
    <script src="../assets/js/bootstrap-scrollspy.js"></script>
    <script src="../assets/js/bootstrap-tab.js"></script>
    <script src="../assets/js/bootstrap-tooltip.js"></script>
    <script src="../assets/js/bootstrap-popover.js"></script>
    <script src="../assets/js/bootstrap-button.js"></script>
    <script src="../assets/js/bootstrap-collapse.js"></script>
    <script src="../assets/js/bootstrap-carousel.js"></script>
    <script src="../assets/js/bootstrap-typeahead.js"></script>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="../bootsrap/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
    <script src="./ui.js"></script>
  </body>
</html>
