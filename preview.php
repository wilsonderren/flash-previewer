<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Flash ad preview</title>
<style type="text/css">
html { overflow-y: scroll; }
body {background: #333; color: #fff; margin:0; padding: 3em; font-family:'helvetica neue', arial, sans-serif; -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale;}
body.white {background: #fff;}
body.white * {color: #555 !important; border-color: #eee !important;}

h2 {border-top:4px solid #555; padding: 0.3em 0 1em 0; margin:0;}
p {margin: 0; padding: 0.5em 0;}
p em {font-style:normal; color: #999; font-size: 0.8em;}
.image-container { padding: 1em 0; border-top:1px solid #444;}
p.readout {color: #999; margin-top:2em;}
p.readout strong {color: #eee;}
a.toggle {position:fixed; top:10px; right:10px; display:inline-block; background:rgba(0,0,0,0.5); color: #fff; border-radius: 0.2em; padding: 7px 10px; text-decoration: none; font-weight: bold;}
</style>

</head>
<body>
	
<?php

// custom urls and click tag variable names

// if(isset($_GET['click'])&&$_GET['click']!=="")
// 	{$click_track_test_url=$_GET['click'];}
// else
// 	{$click_track_test_url="http://www.example.com";}

// if(isset($_GET['clicktag'])&&$_GET['clicktag']!=="")
// 	{$click_tag_name=$_GET['clicktag'];}
// else
// 	{$click_tag_name="clickTAG";}

$click_track_test_url="http://www2.mmu.ac.uk/study/postgraduate/";

$click_tag_name="clickTag";

// what sort of files we will show

$allowed_extensions = "swf,gif";

// code surrounding the asset

$gif = '<a href="[replace-href]"><img src="[replace-image]" alt="test ad" /></a>';

$swf = '<div>
			<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" width="[replace-width]" height="[replace-height]" id="[replace-id]" align="middle">
				<param name="movie" value="[replace-image]?[replace-tag]=[replace-href]" />
				<param name="flashvars" value="[replace-tag]=[replace-href]">
				<param name="quality" value="high" />
				<param name="bgcolor" value="#ffffff" />
				<param name="play" value="true" />
				<param name="loop" value="true" />
				<param name="wmode" value="window" />
				<param name="scale" value="showall" />
				<param name="menu" value="true" />
				<param name="devicefont" value="false" />
				<param name="salign" value="" />
				<param name="allowScriptAccess" value="sameDomain" />
				<!--[if !IE]>-->
				<object type="application/x-shockwave-flash" data="[replace-image]" width="[replace-width]" height="[replace-height]">
					<param name="movie" value="[replace-image]?[replace-tag]=[replace-href]" />
					<param name="flashvars" value="[replace-tag]=[replace-href]">
					<param name="quality" value="high" />
					<param name="bgcolor" value="#ffffff" />
					<param name="play" value="true" />
					<param name="loop" value="true" />
					<param name="wmode" value="window" />
					<param name="scale" value="showall" />
					<param name="menu" value="true" />
					<param name="devicefont" value="false" />
					<param name="salign" value="" />
					<param name="allowScriptAccess" value="sameDomain" />
				<!--<![endif]-->
					<a href="http://www.adobe.com/go/getflash">
						<img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" />
					</a>
				<!--[if !IE]>-->
				</object>
				<!--<![endif]-->
			</object>
		</div>';

$file_location = "ad-files";

function humanTiming ($time)
{

    $time = time() - $time; // to get the time since that moment

    $tokens = array (
        31536000 => 'year',
        2592000 => 'month',
        604800 => 'week',
        86400 => 'day',
        3600 => 'hour',
        60 => 'minute',
        1 => 'second'
    );

    foreach ($tokens as $unit => $text) {
        if ($time < $unit) continue;
        $numberOfUnits = floor($time / $unit);
        return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');
    }

}

?>
<!-- <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get"> 
<p>Test URI: <input type="text" name="click" size="60" value="<?php echo $click_track_test_url; ?>" /> <input type="submit" value="go" /></p>
<p>Flash click tag variable name: <input type="text" name="clicktag" size="60" value="<?php echo $click_tag_name; ?>" /> <input type="submit" value="go" /></p> </form> -->
<?php

$glob_instruction = $file_location.'/*{'.$allowed_extensions.'}';

$files = glob($glob_instruction, GLOB_BRACE);

$allowed_extensions = explode(',',$allowed_extensions);

foreach($allowed_extensions as $ext){

?>

<h2>.<?php echo $ext; ?> files</h2>

<?php 

$html_code = $$ext;

$i = 0;

foreach($files as $f){

if(substr($f, -3)==$ext){

echo '<div class="image-container">';

$image_data = getimagesize($f);

$output_code = str_replace("[replace-image]", $f, $html_code);

$output_code = str_replace("[replace-width]", $image_data[0], $output_code);

$output_code = str_replace("[replace-height]", $image_data[1], $output_code);

$output_code = str_replace("[replace-id]", 'movie-id-'.$i, $output_code);

$output_code = str_replace("[replace-tag]", $click_tag_name, $output_code);

$output_code = str_replace("[replace-href]", $click_track_test_url, $output_code);

echo $output_code;



$human_filename = str_replace($file_location.'/', '', $f);

echo '<p><strong>'.$image_data[0].'px wide &#215; '.$image_data[1].'px high</strong> &middot; '.round(filesize($f)/1024, 2).'Kb &middot; '.$human_filename.' <em>Last updated '.humantiming(filemtime($f)).' ago &middot; '.$image_data['mime'].'</em></p>';

echo '</div>';

$i++;

}

}

}



?>

<p class="readout">Test URI <strong><?php echo $click_track_test_url; ?></strong> &middot; Flash click tag variable name <strong><?php echo $click_tag_name; ?></strong></p>

</body>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script>
  $(document).ready(function() {
  $('body').append('<a href="#" class="toggle">toggle white background</a>');
$('.toggle').click(function(){

if($('body').attr('class')=='white'){$('body').removeClass('white')}else{
	$('body').attr('class', 'white');
}

return false;

});

  });
</script>



</html>