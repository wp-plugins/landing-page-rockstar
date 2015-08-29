<?php

// Change height and width of the video code:

$newWidth = 560;
$newHeight = 315;

$embedcode = preg_replace(
   array('/width="\d+"/i', '/height="\d+"/i'),
   array(sprintf('width="%d"', $newWidth), sprintf('height="%d"', $newHeight)),
   $embedcode);

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

		<div id="post-<?php the_ID(); ?>" class="lp3_2 ct_lp lpid_<?php echo $templateid; ?>">
		
      <?php if($logo) : ?>
      <header>
        <img src="<?php echo $logo; ?>" alt="Logo" />
      </header>
      <?php endif; ?>
			
			<div class="lp-content">
			
        <div class="colourbar">
			
           <div class="contentwrapper">

              <h1><?php echo $headline; ?></h1>
              <h2><?php echo $subhead; ?></h2>
              
              <?php echo $embedcode; ?>
            
           </div>
           
         </div>
         
         <div id="formwrapper">
         
          <div id="formheader">
            <h3><?php echo $optin_head; ?></h3>
          </div>
         
          <div id="formcontent">
          
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
              <input type="submit" class="orangebtn2 button" id="submit_<?php echo $templateid; ?>" name="<?php echo $submittags[0]; ?>" value="<?php echo $submit_value; ?>" /><br />
              <p class="privacystatement"><?php echo $submit_note; ?></p>
            </form>
            
          </div>
          
         </div>
         
			<?php if(isset($lprsFeatures)) : ?>
			
        <div id="featuresbox">
        
          <?php foreach($lprsFeatures as $lprsFeature) : ?>
        	
            <div class="features">
              <h3><?php echo $lprsFeature['feature_headline']; ?></h3>
              <p><?php echo $lprsFeature['feature_copy']; ?></p>
            </div>
          
          <?php endforeach; ?>
        
        </div>
      
      <?php endif; ?>
      
      <div id="main_content_area">
        <?php echo $the_content; ?>
      </div>
			 
			 <div id="footerarea">
			 
          <?php if($lprsSocialImages) : ?>
            <h4><?php echo $socialheadline; ?></h4>
            <p class="socialimg">
              <?php foreach($lprsSocialImages as $lprsSocialImage) : ?>
                <img src="<?php echo $lprsSocialImage['image_image']; ?>" alt="Social Image 1" />
              <?php endforeach; ?>
            </p>
          <?php endif; ?>
          
			 </div>

			</div>
			
		</div>
		
		 <?php if ($below_content) : ?>
			<div id="belowContent">
        <?php echo $below_content; ?>
			</div>
		 <?php endif; ?>