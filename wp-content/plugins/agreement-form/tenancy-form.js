jQuery(document).ready(function() {

//jQuery time
var current_fs, next_fs, previous_fs; //fieldsets
var left, opacity, scale; //fieldset properties which we will animate
var animating; //flag to prevent quick multi-click glitches

jQuery(".next").click(function(){
    if(animating) return false;
    animating = true;

    current_fs = jQuery(this).parent();
    next_fs = jQuery(this).parent().next();

    //activate next step on progressbar using the index of next_fs
    jQuery("#progressbar li").eq(jQuery("fieldset").index(next_fs)).addClass("active");

    //show the next fieldset
    next_fs.show();
    //hide the current fieldset with style
    current_fs.animate({opacity: 0}, {
        step: function(now, mx) {
            //as the opacity of current_fs reduces to 0 - stored in "now"
            //1. scale current_fs down to 80%
            scale = 1 - (1 - now) * 0.2;
            //2. bring next_fs from the right(50%)
            left = (now * 50)+"%";
            //3. increase opacity of next_fs to 1 as it moves in
            opacity = 1 - now;
            current_fs.css({
                'transform': 'scale('+scale+')',
                'position': 'absolute'
            });
            next_fs.css({'left': left, 'opacity': opacity});
        },
        duration: 800,
        complete: function(){
            current_fs.hide();
            animating = false;
        },
        //this comes from the custom easing plugin
        easing: 'easeInOutBack'
    });
});

jQuery(".previous").click(function(){
    if(animating) return false;
    animating = true;

    current_fs = jQuery(this).parent();
    previous_fs = jQuery(this).parent().prev();

    //de-activate current step on progressbar
    jQuery("#progressbar li").eq(jQuery("fieldset").index(current_fs)).removeClass("active");

    //show the previous fieldset
    previous_fs.show();
    //hide the current fieldset with style
    current_fs.animate({opacity: 0}, {
        step: function(now, mx) {
            //as the opacity of current_fs reduces to 0 - stored in "now"
            //1. scale previous_fs from 80% to 100%
            scale = 0.8 + (1 - now) * 0.2;
            //2. take current_fs to the right(50%) - from 0%
            left = ((1-now) * 50)+"%";
            //3. increase opacity of previous_fs to 1 as it moves in
            opacity = 1 - now;
            current_fs.css({'left': left});
            previous_fs.css({'transform': 'scale('+scale+')', 'opacity': opacity});
        },
        duration: 800,
        complete: function(){
            current_fs.hide();
            animating = false;
        },
        //this comes from the custom easing plugin
        easing: 'easeInOutBack'
    });
});

jQuery(".submit").click(function(){
    return false;
})


    //Hide show textarea according to checkbox

    jQuery('.detail-textarea').click(function () {

        var x = jQuery(this).attr('name')+'-details';

        if(jQuery(this).attr('checked')){
        jQuery('textarea[name='+x+']').show();
        }
        else {
            jQuery('textarea[name='+x+']').hide();
        }

    });

});

// Dynamic feilds for tenants and landlords
jQuery(document).ready(function(){
    var next = 1;
    jQuery(".add-more-tenant").click(function(e){
        e.preventDefault();
        var addto = "#tenant" + next;
        var addRemove = "#tenant" + (next);
        next = next + 1;
        var newIn = '<input autocomplete="off" class="input form-control" id="tenant' + next + '" name="tenant[]" type="text" placeholder="Tenan'+next+'">';
        var newInput = jQuery(newIn);
        var removeBtn = '<button id="remove' + (next - 1) + '" class="btn btn-danger remove-me" >-</button></div><div id="tenant">';
        var removeButton = jQuery(removeBtn);
        jQuery(addto).after(newInput);
        jQuery(addRemove).after(removeButton);
        jQuery("#tenant" + next).attr('data-source',jQuery(addto).attr('data-source'));
        jQuery("#count").val(next);  
        
            jQuery('.remove-me').click(function(e){
                e.preventDefault();
                var tenantNum = this.id.charAt(this.id.length-1);
                var tenantID = "#tenant" + tenantNum;
                jQuery(this).remove();
                jQuery(tenantID).remove();
            });
    });
    
    var nextL = 1;
    jQuery(".add-more-landlord").click(function(e){
        e.preventDefault();

        var addto = "#landlord" + nextL;
        var addRemove = "#landlord" + (nextL);
        nextL= nextL + 1;
        var newIn = '<input autocomplete="off" class="input form-control" id="landlord' + nextL + '" name="landlord[]" type="text" placeholder="Lanlord'+nextL+'">';
        var newInput = jQuery(newIn);
        var removeBtn = '<button id="remove' + (nextL - 1) + '" class="btn btn-danger remove-me" >-</button></div><div id="landlord">';
        var removeButton = jQuery(removeBtn);
        jQuery(addto).after(newInput);
        jQuery(addRemove).after(removeButton);
        jQuery("#landlord" + nextL).attr('data-source',jQuery(addto).attr('data-source'));
        jQuery("#count").val(nextL);  
      
            jQuery('.remove-me').click(function(e){
                e.preventDefault();
                var landlordNum = this.id.charAt(this.id.length-1);
                var landlordID = "#landlord" + landlordNum;
                jQuery(this).remove();
                jQuery(landlordID).remove();
            });
    });
    
});