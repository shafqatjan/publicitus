<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
<meta charset="utf-8">
<title><?php echo CLIENT_PAGE_TITLE;?></title>
<link href="css/style.css" rel="stylesheet" type="text/css">
<script src="js/modernizr.js"></script>
<!--[if IE 6]>
<link href="css/IE/style-IE-6.css" rel="stylesheet" type="text/css">
<![endif]-->

<!--[if IE 7]>
<link href="css/IE/style-IE-7.css" rel="stylesheet" type="text/css">
<![endif]-->

<!--[if IE 8]>
<link href="css/IE/style-IE-8.css" rel="stylesheet" type="text/css">
<![endif]-->

</head>

<body>

 <div id="warpper">
 
  <div id="header">
<head>
    <meta charset="utf-8" />
    <title>jQuery UI Dialog - Modal form</title>
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.9.1/themes/base/jquery-ui.css" />
    <script src="http://code.jquery.com/jquery-1.8.2.js"></script>
    <script src="/resources/demos/external/jquery.bgiframe-2.1.2.js"></script>
    <script src="http://code.jquery.com/ui/1.9.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="/resources/demos/style.css" />
    <style>
        body { font-size: 62.5%; }
        label, input { display:block; }
        input.text { margin-bottom:12px; width:95%; padding: .4em; }
        fieldset { padding:0; border:0; margin-top:25px; }
        h1 { font-size: 1.2em; margin: .6em 0; }
        div#users-contain { width: 350px; margin: 20px 0; }
        div#users-contain table { margin: 1em 0; border-collapse: collapse; width: 100%; }
        div#users-contain table td, div#users-contain table th { border: 1px solid #eee; padding: .6em 10px; text-align: left; }
        .ui-dialog .ui-state-error { padding: .3em; }
        .validateTips { border: 1px solid transparent; padding: 0.3em; }
    </style>
    <script>
    $(function() {
        var name = $( "#name" ),
            email = $( "#email" ),
            password = $( "#password" ),
            allFields = $( [] ).add( name ).add( email ).add( password ),
            tips = $( ".validateTips" );
 
        function updateTips( t ) {
            tips
                .text( t )
                .addClass( "ui-state-highlight" );
            setTimeout(function() {
                tips.removeClass( "ui-state-highlight", 1500 );
            }, 500 );
        }
 
        function checkLength( o, n, min, max ) {
            if ( o.val().length > max || o.val().length < min ) {
                o.addClass( "ui-state-error" );
                updateTips( "Length of " + n + " must be between " +
                    min + " and " + max + "." );
                return false;
            } else {
                return true;
            }
        }
 
        function checkRegexp( o, regexp, n ) {
            if ( !( regexp.test( o.val() ) ) ) {
                o.addClass( "ui-state-error" );
                updateTips( n );
                return false;
            } else {
                return true;
            }
        }
 
        $( "#dialog-form" ).dialog({
            autoOpen: false,
            height: 300,
            width: 350,
            modal: true,
            buttons: {
                "Create an account": function() {
                    var bValid = true;
                    allFields.removeClass( "ui-state-error" );
 
                    bValid = bValid && checkLength( name, "username", 3, 16 );
                    bValid = bValid && checkLength( email, "email", 6, 80 );
                    bValid = bValid && checkLength( password, "password", 5, 16 );
 
                    bValid = bValid && checkRegexp( name, /^[a-z]([0-9a-z_])+$/i, "Username may consist of a-z, 0-9, underscores, begin with a letter." );
                    // From jquery.validate.js (by joern), contributed by Scott Gonzalez: http://projects.scottsplayground.com/email_address_validation/
                    bValid = bValid && checkRegexp( email, /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i, "eg. ui@jquery.com" );
                    bValid = bValid && checkRegexp( password, /^([0-9a-zA-Z])+$/, "Password field only allow : a-z 0-9" );
 
                    if ( bValid ) {
                        $( "#users tbody" ).append( "<tr>" +
                            "<td>" + name.val() + "</td>" +
                            "<td>" + email.val() + "</td>" +
                            "<td>" + password.val() + "</td>" +
                        "</tr>" );
                        $( this ).dialog( "close" );
                    }
                },
                Cancel: function() {
                    $( this ).dialog( "close" );
                }
            },
            close: function() {
                allFields.val( "" ).removeClass( "ui-state-error" );
            }
        });
 
        $( "#create-user" )
            .button()
            .click(function() {
                $( "#dialog-form" ).dialog( "open" );
            });
    });
    </script>
</head>
  </div>
  
  <div id="content">
  
   <div id="profile-warrper">
   
    <div class="profile-blue-box"> <!-- first blue box -->
    
     <div class="profile-blue-first"> <!-- blue box first row -->
      <span class="profile-blue-heading"> <h3> Does Abdul jabar have these skill or experties? </h3> </span>
      <span class="profile-blue-close-btn"> x </span>
     </div> <!-- blue box first row -->
     
     <div class="profile-blue-second"> <!-- blue box Second row -->    
       
       <div class="profile-blue-second-btn"> <!-- fisrt blue box Skill button --->
        <span class="profile-blue-second-btn-text"> Robotics </span>
        <span class="profile-blue-second-btn-close"> X </span>
       </div> <!-- fisrt blue box Skill button --->
       
       <div class="profile-blue-second-btn"> <!-- fisrt blue box Skill button --->
        <span class="profile-blue-second-btn-text"> Robotics </span>
        <span class="profile-blue-second-btn-close"> X </span>
       </div> <!-- fisrt blue box Skill button --->
       
        <div class="profile-blue-second-btn"> <!-- fisrt blue box Skill button --->
        <span class="profile-blue-second-btn-text"> Robotics </span>
        <span class="profile-blue-second-btn-close"> X </span>
       </div> <!-- fisrt blue box Skill button --->
       
        <div class="profile-blue-second-btn"> <!-- fisrt blue box Skill button --->
        <span class="profile-blue-second-btn-text"> Robotics </span>
        <span class="profile-blue-second-btn-close"> X </span>
       </div> <!-- fisrt blue box Skill button --->
       
        <div class="profile-blue-second-btn"> <!-- fisrt blue box Skill button --->
        <span class="profile-blue-second-btn-text"> Robotics </span>
        <span class="profile-blue-second-btn-close"> X </span>
       </div> <!-- fisrt blue box Skill button --->
       
        <div class="profile-blue-second-btn"> <!-- fisrt blue box Skill button --->
        <span class="profile-blue-second-btn-text"> Robotics </span>
        <span class="profile-blue-second-btn-close"> X </span>
       </div> <!-- fisrt blue box Skill button --->
       
        <div class="profile-blue-second-btn"> <!-- fisrt blue box Skill button --->
        <span class="profile-blue-second-btn-text"> Robotics </span>
        <span class="profile-blue-second-btn-close"> X </span>
       </div> <!-- fisrt blue box Skill button --->
       
        <div class="profile-blue-second-input"> <!-- fisrt blue box Skill button --->
        <span class="profile-blue-second-btn-text"> 
         <input type="text" value="Type an other area of experties" >         
        </span>
        
       </div> <!-- fisrt blue box Skill button --->
       
     </div> <!-- blue box second row -->
     
     <div class="profile-blue-third"> <!-- blue box third row -->
     
      <span class="blue-box-endorse-btn"> <input type="button" value="Endorse"> </span>
      <span class="blue-box-skip-btn"> <input type="button" value="skip"> </span>
      <span class="blue-box-what-is-this"> <a href="#"> what is this? </a> </span>
     
     </div> <!-- blue box third row -->
    
    </div> <!-- first blue box -->

    
   </div> <!-- profile warrper -->

  
  </div> <!-- content -->
  
  <!-- footer -->
  <div id="footer">
   <div id="copyright"> 
    <p> Copy Right &copy; 2012 ABC Company.ALL rights reserved. </p>
   </div>
   <div id="social-icons">
    <ul id="sn_icons">
      <li>
      <a class="facebook" href="Write your Facebook id.">   </a>
      </li>
      <li>
      <a class="twitter" href="Write your Twitter id.">   </a>
      </li>
      <li>
      <a class="linkedin" href="Write your LinkedIn id.">   </a>
      </li>
      <li>
      <a class="google" href="Write your Google+ id.">   </a>
      </li>
      <li>
      <a class="youtube" href="Write your Youtube id.">   </a>
      </li>
      <li>
      <a class="feed" href="Write your RSS Feed id.">   </a>
      </li>
    </ul>
   </div>
  </div>
 
 </div> <!-- Warpper -->

</body>
</html>
