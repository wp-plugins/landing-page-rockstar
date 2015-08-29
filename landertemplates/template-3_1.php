<?php

// Change height and width of the video code:

$newWidth = 800;
$newHeight = 450;

$embedcode = preg_replace(
   array('/width="\d+"/i', '/height="\d+"/i'),
   array(sprintf('width="%d"', $newWidth), sprintf('height="%d"', $newHeight)),
   $embedcode);
   
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
		
		
		<div id="post-<?php the_ID(); ?>" class="lp3_1 ct_lp lpid_<?php echo $templateid; ?>">
			
			<h1><?php echo $headline; ?></h1>

			<div class="lp-content">
			
			 <div id="videobox">
          <?php echo $embedcode; ?>
			 </div>
			 
       <h2><?php echo $subhead; ?></h2>
			 
			 <?php if(isset($optin_head)) : ?><h3 style="text-align: center;"><?php echo $optin_head; ?></h3><?php endif; ?>
			 <?php if(isset($optin_subhead)) : ?><h4 style="text-align: center;"><?php echo $optin_subhead; ?></h4><?php endif; ?>
			 
			 <div id="formwrapper">
			 		
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
            <input type="submit" class="orangebtn button" id="submit_<?php echo $templateid; ?>" name="<?php echo $submittags[0]; ?>" value="<?php echo $submit_value; ?>" />
          </div>
				</form>
				
			 </div>
			 <p style="text-align: center;"><?php echo $submit_note; ?></p>

			</div>
			
		</div>