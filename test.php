<html>

<?php
echo <<<EOM
<script type="text/javascript">
Notification.requestPermission();
var n = new Notification("Hello World");
</script>
EOM;
?>