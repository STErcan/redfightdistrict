<h2>U bent nu uitgelogd.</h2>
<br>
<span id="loader" style="background-color:#f60;width:0px;height:5px;display:none;"></span>
U wordt automatisch doorverwezen.
<script language="javascript" type="text/javascript">
	$('#loader').animate({'width':'300px', 'opacity':'show'},1000);
</script>
<?php
echo redirect($base_href.'admin/?pagina=login',1000);
?>

