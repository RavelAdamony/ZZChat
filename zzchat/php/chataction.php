<?php
error_reporting(0);
$msg = addslashes($_REQUEST['msg']);
$name = addslashes($_REQUEST['name']);
if ($msg != "" && $name != "") {
$myfile = fopen("../txt/chat.txt", "a") or die("Unable to open file!");
$msg = "<li><strong>".$name."</strong>: ".$msg."</li>";
fwrite($myfile, "". $msg);
fclose($myfile);
}
?>

<ul>
<?php echo file_get_contents("../txt/chat.txt"); ?>
</ul>