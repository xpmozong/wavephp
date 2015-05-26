<?php

echo "<pre>";
echo $username;

?>

<img src="<?php echo Wave::app()->homeUrl.'/site/verifycode';?>" onclick="javascript:this.src='<?php echo Wave::app()->homeUrl;?>/site/verifycode?tm='+Math.random();" />