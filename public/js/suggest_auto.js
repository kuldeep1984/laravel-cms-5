    jQuery(document).ready(function () {
         
        $('#projectsearch').autocomplete({
            source: "/suggest-auto?mode=city&type=projectName&id="+$('#citydd').val(),
            minLength : 1,
            select: function(event, ui){                
                if ($('#project_id').length) {                    
                    $("#project_id").val(ui.item.value);                    
                }
                if ($('#project_name').length) {                    
                    $("#project_name").val(ui.item.project_name);                    
                }
                
            },            
            response: function(event, ui){
                console.log("===>HELLLLLLLLLL",ui.content);
                if(ui.content.length == 0){                 
                    $("#project_id").val(''); 
                    $("#project_name").val('');
                }
            }
            
        });
        
        $('#cityName').autocomplete({
            source: "/suggest-auto?type=city",
            minLength : 1,
            select: function(event, ui){
                if ($('#city').length) {                    
                    $("#city").val(ui.item.city_id);
                    update_locality(ui.item.city_id);
                }
                if($("#cityId").length){
                   $("#cityId").val(ui.item.city_id);
                   update_locality(ui.item.city_id); 
                }
            },
            response: function(event, ui){
                if(ui.content.length == 0){                 
                    $("#city").val(''); 
                    $("#cityId").val('');
                }
            }
            
        });
        $('#localityName').autocomplete({
            source: "/suggest_auto.php?type=localityOnly",
            minLength : 1,
            select: function(event, ui){
                
                if($("#localityId").length){
                   $("#localityId").val(ui.item.id);                   
                }
            },
            response: function(event, ui){
                if(ui.content.length == 0){                  
                    $("#localityId").val('');
                }
            }
            
        });
        $('#builderName').autocomplete({
            source: "/suggest-auto?type=builder",
            minLength: 1,
            select: function (event, ui) {                

                //updating builder image
                if ($('#builderbox').length) {
                    $(".builderId").val(ui.item.builder_id); 
                    getBuilderImage();
                    getBuilderJV();
                }
                if ($('.builerUPdate').length) {
                    $(".builerUPdate").val(ui.item.builder_id);                   
                }
                if ($('#builder').length) {                    
                    $("#builder").val(ui.item.builder_id);
                }
            },
            response: function( event, ui ) {
                if(ui.content.length == 0){                 
                    $(".builderId").val('');                    
                }
            }
        });        
        $('#townshipName').autocomplete({
            source: "/suggest-auto?type=townships&id=true",
            minLength: 1,
            select: function (event, ui) {
                if($("#townshipId").length){
                    $("#townshipId").val(ui.item.id);
                }
                if($("#township").length){
                    $("#township").val(ui.item.id);
                }
                
            },
            response: function( event, ui ) {
                if(ui.content.length == 0){                  
                    $("#township").val('');
                }
                   
            }
        });
    });

