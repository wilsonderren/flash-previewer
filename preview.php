<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Flash ad preview</title>
<style type="text/css">
html { overflow-y: scroll; }
body {background: #333; color: #fff; margin:0; padding: 3em; font-family:'helvetica neue', arial, sans-serif; -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale;}
h2 {border-top:4px solid #444; padding: 0.3em 0 1em 0;}
p {margin: 0; padding: 0.5em 0;}
.image-container { padding: 1em 0; border-top:1px solid #444;}

</style>

</head>
<body>
	
<?

// custom urls and click tag variable names

if(isset($_GET['click'])&&$_GET['click']!=="")
	{$click_track_test_url=$_GET['click'];}
else
	{$click_track_test_url="http://www.example.com";}

if(isset($_GET['clicktag'])&&$_GET['clicktag']!=="")
	{$click_tag_name=$_GET['clicktag'];}
else
	{$click_tag_name="clickTAG";}

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

$file_location = "put-ads-here";

?>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
<p>Test URI: <input type="text" name="click" size="60" value="<?php echo $click_track_test_url; ?>" /> <input type="submit" value="go" /></p>
<p>Flash click tag variable name: <input type="text" name="clicktag" size="60" value="<?php echo $click_tag_name; ?>" /> <input type="submit" value="go" /></p>
</form>
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

echo '<p>'.$human_filename.' &middot; <strong>'.$image_data[0].'px wide &#215; '.$image_data[1].'px high</strong> &middot; '.round(filesize($f)/1024, 2).'Kb &middot; '.$image_data['mime'].'</p>';

echo '</div>';

$i++;

}

}

}

?>

</body>
</html>