jQuery(document).ready(function() {
  
  function hideHeadlines(selection) {
  
    var selectionId = selection.substring(selection.indexOf("template-") + 9, selection.indexOf(".php"));
    jQuery(".showfor").hide(); // reset all showfor divs
    jQuery(".hidefor").show(); // reset all hidefor divs
    jQuery(".hidefor." + selectionId).hide();
    jQuery(".showfor." + selectionId).show();
    jQuery('.toggleLink').next().hide();
  
  }

  jQuery(".themethumbnail").click(function() {
    jQuery(".themethumbnail").removeClass('active');
    jQuery(this).addClass('active');
    
    var picked = jQuery(this).attr('id');
    jQuery("#"+inputName).val(picked);
    hideHeadlines(picked);
  });
  jQuery(".theme_thumb_preview").click(function() {
    var preview_image = jQuery(this).attr("rel");
    
    jQuery("#ct_theme_preview .ct_preview_img").html("<img src='"+pluginsURL+"/lprockstar/landertemplates/images/preview/"+preview_image+".jpg' />");
    jQuery("#ct_theme_preview").show();
    
  });
  jQuery("#ct_theme_preview").click(function() {
    jQuery("#ct_theme_preview").hide();
  });
  jQuery("#theme_choice_select").change(function() {
    var id = jQuery(this).val();
    jQuery(".theme_series").hide();
    jQuery("#buynow").hide();
    if(jQuery("#"+id).length) {
      jQuery("#"+id).show();
    } else {
      jQuery("#buynow").show();
    }
  });
  jQuery("option[value='series_"+pickedThemeExt+"']").prop('selected',true);
  hideHeadlines(pickedTheme);
  
  jQuery(".lprs_theme_filter_choice").on('click',function() {
  
    var thisFilter = jQuery(this).attr('id');
    thisFilter = thisFilter.substring(18);
    
    jQuery(".lprs_theme_filter_choice").removeClass("lprs_theme_filter_active");
    jQuery(this).addClass("lprs_theme_filter_active");
    
    if(thisFilter != 0) {
      jQuery(".theme_thumb_box").hide();
      jQuery(".category-"+thisFilter).show();
    } else {
      jQuery(".theme_thumb_box").show();
    }
  
  });
  
});