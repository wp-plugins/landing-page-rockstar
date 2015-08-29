<style type="text/css">

</style>

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
    
    var warningLength = $(".warningContent").text().length;
    warningLength = (warningLength * 11 / 2) + 146;
    $("#warning").css("width",warningLength);
    
  
  });

</script>
		
		
		<div id="post-<?php the_ID(); ?>" class="lp1_3 ct_lp lpid_<?php echo $templateid; ?>">
		
      <div id="warning">
        <span class="warningTitle">Warning:</span>
        <span class="warningContent"><?php echo $warning; ?></span>
        <div style="clear:both;"></div>
      </div>
			
			<h1><?php echo $headline; ?></h1>
			<h2><?php echo $subhead; ?></h2>

			<div class="lp-content">
			 
			 <div id="formwrapper">
			 
			  <h3><?php echo $optin_head; ?></h3>
				
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
          <input type="submit" class="orangebtn button" id="submit_<?php echo $templateid; ?>" name="<?php echo $submittags[0]; ?>" value="<?php echo $submit_value; ?>" />
				</form>
				
			 </div>

			</div>
			
		</div>
		
		<p style="text-align: center;"><?php echo $submit_note; ?></p>