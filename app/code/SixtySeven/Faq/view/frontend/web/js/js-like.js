define(
        [
            'jquery',
            'Magento_Ui/js/modal/modal'
        ],
        function(
            $,
            modal
        ) {  
            'use strict';
            $.widget('sixtyseven.faqlike', {
                options: {
                    likeFormUrl: '',
                },                                        
                _create: function() {
                    this._initElement();
                },
                _initElement: function() {
                    var self = this;
                    $('form.likeForm span').click(function(){
                        
                        if($(this).hasClass('likeClass')) {
                            var getLike = 'likeClass';    
                        }
                        if($(this).hasClass('dislikeClass')) {
                            var getLike = 'dislikeClass';    
                        }                        
                        var getLikeCount = $(this).parent().siblings('.likeShowClass').attr('id'); 
                        var getDislikeCount = $(this).parent().siblings('.dislikeShowClass').attr('id');                        
                        var getLikeFormId = $(this).parent().attr("id"); 
                        var getLikeId = $(this).attr("id");                       
                        if(getLike == 'likeClass'){
                            var form_data = $("#"+getLikeFormId).serialize()+ "&like_status=" + 1;
                        }
                        if(getLike == 'dislikeClass'){
                            var form_data = $("#"+getLikeFormId).serialize()+ "&like_status=" + 2;
                        } 
                        console.log(form_data);                           
                        $.ajax({ 
                            url: self.options.likeFormUrl,
                            data: form_data,
                            type: 'post',
                            success: function(result)
                            {   
                                console.log(result);                            
                                if(result.success == 'true' && result.liked == 'true'){
                                    var likes = result.likes;                                    
                                    self._displaySuccessAfterLike(likes,getLikeId,getLikeCount);
                                }
                                if(result.success == 'true' && result.liked == 'false'){
                                    var likes = result.likes;                                    
                                    self._displaySuccessAfterDislike(likes,getLikeId,getDislikeCount);
                                }
                                if(result.success == 'true' && result.liked == 'disablelike'){
                                    var likes = result.likes;                                    
                                    self._displaySuccessAfterDisableLike(likes,getLikeId,getLikeCount);
                                }
                                if(result.success == 'true' && result.liked == 'disabledislike'){
                                    var likes = result.likes;                                    
                                    self._displaySuccessAfterDisableDislike(likes,getLikeId,getDislikeCount);
                                }

                                if(result.success == 'true' && result.liked == 'change'){
                                    console.log(result);
                                    var likes = result.likes;
                                    var dislikes = result.dislikes;                                    
                                    self._displayChangeSuccessAfterDislike(likes,dislikes,getLikeId,getLikeCount,getDislikeCount);
                                }

                            }
                        });
                    });
                },
                _displaySuccessAfterLike: function(likes,getLikeId,getLikeCount){                    
                    $( "#"+getLikeCount+" span.countLikeNumber" ).text( likes );
                    $( "#"+getLikeId ).css( "font-weight","bold" );                                  
                    $("#"+getLikeId).siblings('.successLike').css('display','block');
                    setTimeout(function() {
                     $("#"+getLikeId).siblings('.successLike').fadeOut();
                    }, 5000 );                 
                },
                _displaySuccessAfterDislike: function(likes,getLikeId,getDislikeCount){                    
                    $( "#"+getDislikeCount+" span.countDislikeNumber" ).text( likes );
                    $( "#"+getLikeId ).css( "font-weight","bold" );                                  
                    $("#"+getLikeId).siblings('.successLike').css('display','block');
                    setTimeout(function() {
                     $("#"+getLikeId).siblings('.successLike').fadeOut();
                    }, 5000 );                 
                },
                _displaySuccessAfterDisableLike: function(likes,getLikeId,getLikeCount){                    
                    $( "#"+getLikeCount+" span.countLikeNumber" ).text( likes );
                    $( "#"+getLikeId ).css( "font-weight","normal" );                                  
                    $("#"+getLikeId).siblings('.successLike').css('display','block');
                    setTimeout(function() {
                     $("#"+getLikeId).siblings('.successLike').fadeOut();
                    }, 5000 );                 
                },
                _displaySuccessAfterDisableDislike: function(likes,getLikeId,getDislikeCount){                    
                    $( "#"+getDislikeCount+" span.countDislikeNumber" ).text( likes );
                    $( "#"+getLikeId ).css( "font-weight","normal" );                                  
                    $("#"+getLikeId).siblings('.successLike').css('display','block');
                    setTimeout(function() {
                     $("#"+getLikeId).siblings('.successLike').fadeOut();
                    }, 5000 );                 
                },
                _displayChangeSuccessAfterDislike: function(likes,dislikes,getLikeId,getLikeCount,getDislikeCount){                    
                    $( "#"+getLikeCount+" span.countLikeNumber" ).text( likes );
                    $( "#"+getDislikeCount+" span.countDislikeNumber" ).text( dislikes );
                    $( "#"+getLikeId ).css( "font-weight","bold" );  
                    $( "#"+getLikeId ).siblings().css( "font-weight","normal" );                                
                    $("#"+getLikeId).siblings('.successLike').css('display','block');
                    setTimeout(function() {
                     $("#"+getLikeId).siblings('.successLike').fadeOut();
                    }, 5000 );                 
                },
                
            });
            return $.sixtyseven.faqlike;
        }
);
