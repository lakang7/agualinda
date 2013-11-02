<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<script src="recursos/js/jquery-1.9.1.js" ></script>
<script src="recursos/js/jquery-ui.js"></script>
<script type="text/javascript" language="javascript">
$(document).ready(function(){
//save or delete

$('.taskbutton').click(function() {
    window.onbeforeunload = null;
    window.location='yourUrl'; //navigate to required page..

});

window.onbeforeunload = function() {
              var message = 'You have unsaved changes, please stay and save or delete them.';
              return message;
          }    
}); 
</script>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>
<a id='savenewscopesheet' class='taskbutton'>Save</a>
  <a id='deletenewscopesheet' class='taskbutton'>Delete</a>
</body>
</html>