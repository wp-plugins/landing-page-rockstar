<?php

if(get_post_thumbnail_id( $post->ID )) {

$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );
   
?>

<style type="text/css">
  html {
    background: url('<?php echo $image[0]; ?>') center top no-repeat;
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
    filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='.myBackground.jpg', sizingMethod='scale');
  -ms-filter: "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='myBackground.jpg', sizingMethod='scale')";
  }
</style>

<?php

  } // end if statement to see if there is a background img
  
?>

<script>

  $(function() {
  
    var inputvalues = [];
  
    $("input[type='text']").each(function() {
      inputvalues[$(this).attr('name')] = $(this).val();
    });

    $("input[type='text']").focus(function() {
        var inputname = $(this).attr('name');
        if($(this).val() == inputvalues[inputname]) {
          $(this).val('')
        }        
    });
    
    $("input[type='text']").blur(function() {
      var inputname = $(this).attr('name');
      if($(this).val() == "") {
        $(this).val(inputvalues[inputname]);
      }
    });
  
  });

</script>

		<div id="post-<?php the_ID(); ?>" class="lp1_1 ct_lp lpid_<?php echo $templateid; ?>">
		
      <?php if($logo) : ?>
      <header>
        <img src="<?php echo $logo; ?>" alt="Logo" />
      </header>
      <?php endif; ?>
			
			<h1><?php echo $headline; ?></h1>
			<h2><?php echo $subhead; ?></h2>
			
      <div class="sidebar_r">
        <div id="optin">
        
        </div>
      </div>

			<div class="lp-content">
			
			 <div id="contentwrapper">
				
				<?php echo $the_content; ?>
				
			 </div>
			 
			 <div id="formwrapper">
			 
			  <h3><?php echo $optin_head; ?></h3>
			  <h4><?php echo $optin_subhead; ?></h4>
				
				<form id="formid_<?php echo $templateid; ?>" action="<?php echo $formtag; ?>">
				  <div id="formfields">
            <?php
              foreach($inputtags as $inputname => $inputtag) { // display the hidden inputs
                echo $inputtag . "\n"; 
              }
              foreach($texttags as $inputname => $inputtag) { // display the text inputs
                // Insert the label into the value field
                $inputtag = preg_replace('/(<[^>]+) value=".*?"/i','$1 value="'.ucwords(strtolower($inputname)).'"',$inputtag);
                echo $inputtag . "\n";
              }
            ?>
          </div>
          <input type="submit" class="orangebtn" id="submit_<?php echo $templateid; ?>" name="<?php echo $submittags[0]; ?>" value="<?php echo $submit_value; ?>" /><br />
          <p style="text-align: center;"><?php echo $submit_note; ?></p>
				</form>
				
			 </div>

			</div>
			
			<div id="belowContent">
        <?php echo $below_content; ?>
			</div>
			
		</div>