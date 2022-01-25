$( document ).ready(function() {

	

	// Check Input Password
	$( document ).on( 'click', '.show_pass', function() {

		var value = $( 'input[id=user_password]' ).val();

		if ( value.length > 0 && value != '' ) {

			$( '.show_pass' ).removeClass( 'disabled' );

			var text = $( '.show_pass span' ).text();

			$( '.show_pass i' ).toggleClass( 'fa-eye-slash' ).toggleClass( 'fa-eye' );

			if ( text == 'Show' ) {

				$( 'input[id=user_password]' ).prop( { type:'text' } );
				$( '.show_pass span' ).text( 'Hide' );

			} else {

				$( 'input[id=user_password]' ).prop( { type:'password' } );
				$( '.show_pass span' ).text( 'Show' );

			}

    	}

	});


	function registration_form_reset( form_check ) {

		if ( form_check === 'oual_registration' ) {
			$( '.oual_form_front input, .submit_registration' ).removeAttr('disabled');
			$( '.submit_registration' ).html( 'Sign up' );
		}

		if ( form_check === 'oual_login' ) {
			$( '.oual_form_front input, .submit_login' ).removeAttr('disabled');
			$( '.submit_login' ).html( 'Log in' );
		}
		
		return;

	}

	// Submit Registration Form
	$( document ).on( 'submit', '.oual_form_front', function(e) {
		e.preventDefault();

		var form_check = $( '.oual_form_front input[name=form_check]' ).val();
		var user_email = $( '.oual_form_front input[id=user_email]' ).val();
		var user_password = $( '.oual_form_front input[id=user_password]' ).val();

		if ( form_check === 'oual_login' ) {

			var post_data = { 'form_check': form_check, 'user_email': user_email, 'user_password': user_password };

			if ( $( '.oual_form_front input[id=remember_user]:checked' ).length > 0 ) {

				var remember_user = $( '.oual_form_front input[id=remember_user]:checked' ).val();
				post_data['remember_user'] = remember_user;

			}

		}

		if ( form_check === 'oual_registration' ) {

			var post_data = { 'form_check': form_check, 'user_email': user_email, 'user_password': user_password };

		}
		

	    $.ajax({

	        type: 'POST',
	        url: window.location.origin+'/bepi/wp-content/plugins/oual-memory-book/ajax/front-ajax.php',
	        data: post_data,

	        beforeSend: function(){

	        	if ( form_check === 'oual_registration' ) {

					$( '.oual_form_front input, .submit_registration' ).prop('disabled', true);
					$( '.submit_registration' ).html('<span class="spinner-border spinner-border-sm pl_submit" role="status" aria-hidden="true"></span> Submitting &hellip;');

				}

	        	if ( form_check === 'oual_login' ) {

					$( '.oual_form_front input, .submit_login' ).prop('disabled', true);
					$( '.submit_login' ).html('<span class="spinner-border spinner-border-sm pl_submit" role="status" aria-hidden="true"></span> Logging In &hellip;');

				}
            	
        	},

	        success: function(data, textStatus, XMLHttpRequest) {

				var obj = JSON.parse(data);

				console.log(obj);

				if ( form_check === 'oual_registration' ) {
					if (obj.type == 'registration_success') {

						$( '.oual_form_front' ).prepend( '<div class="mb-3"><div class="alert alert-success" role="alert">'+obj.message+'</div></div>' );
						registration_form_reset( form_check );
						setTimeout(function() { window.location.href = window.location.origin+'/bepi/dashboard/?project_status=new'; }, 1000);

					}

					if (obj.type == 'registration_error') {

						$( '.oual_form_front' ).prepend( '<div class="mb-3"><div class="alert alert-danger" role="alert">'+obj.message+'</div></div>' );
						registration_form_reset( form_check );
						setTimeout(function() { window.location.reload(); }, 1000);

					}
				}

				if ( form_check === 'oual_login' ) {
					
					if (obj.type == 'login_success') {

						$( '.oual_form_front' ).prepend( '<div class="mb-3"><div class="alert alert-success" role="alert">'+obj.message+'</div></div>' );
						registration_form_reset( form_check );
						setTimeout(function() { window.location.href = window.location.origin+'/bepi'+obj.slug; }, 1000);
						
					}

					if (obj.type == 'login_error') {

						$( '.oual_form_front' ).prepend( '<div class="mb-3"><div class="alert alert-danger" role="alert">'+obj.message+'</div></div>' );
						registration_form_reset( form_check );
						setTimeout(function() { window.location.reload(); }, 1000);

					}

				}

	        },

	        error: function(MLHttpRequest, textStatus, errorThrown) {
	            console.log(errorThrown);
	        }

	    });

		return false;
	});


	// FileStack Upload Image
	function returnimagedata( result ) {

		if ( result.filesUploaded.length > 0 ) {

			$('input[name="user_project_photo"]').val( result.filesUploaded[0].url );
			$( '.filestack-filepicker' ).find( 'img' ).attr( 'src', '' );
			$( '.filestack-filepicker' ).find( 'img' ).attr( 'src', result.filesUploaded[0].url );
			setTimeout(function() { 
				$( '.filestack-filepicker' ).find( 'img' ).width( 400 );
				$( '.filestack-filepicker' ).css( 'background-color', '#d4edda' );
				$( '.filestack-filepicker' ).find( 'p' ).text( 'Successfully added a photo.' );
			}, 1000);

		} else {
			console.log(result);
		}
	}

	$( document ).on( 'click', '.filestack-filepicker', function() {
		const client = filestack.init('AVfRP325pSixq38fgBOFFz');
		//A3rXAZ6p7SqitqPHWxUZmz - john api key
		const options = {
			accept: ["image/*"],
			fromSources: ["local_file_system","url","imagesearch","facebook","instagram"],
			onUploadDone: (result) => returnimagedata(result),
		};

		client.picker(options).open();


	});

	function project_form_reset() {

		$( '.oual_new_project_form input, .oual_new_project_form select, .submit_project' ).removeAttr('disabled');
		$( '.submit_project' ).html( 'Start Project' );
		$( 'html, body' ).animate({
    		scrollTop: $( '.oual_new_project_form' ).offset().top
		}, 500);
		
		return;

	}

	$( document ).on( 'submit', '.oual_new_project_form', function(e) {
		e.preventDefault();

		var _user_id = $( 'input[name="user_id"]' ).val();
		var _project_heading = $( '#user_project_heading' ).val();
		var _project_fullname = $( '#user_project_fullname' ).val();
		var _project_dob = $( '#user_project_dob' ).val();
		var _project_dod = $( '#user_project_dod' ).val();
		var _project_photo = $('input[name="user_project_photo"]').val();

		// Check If Upload Photo Is Empty
		if ( _project_photo == '' ) {

			$(this).prepend( '<div class="mb-3"><div class="alert alert-danger" role="alert">Please let choose photo for your project.</div></div>' );
			$( 'html, body' ).animate({
        		scrollTop: $( '.oual_new_project_form' ).offset().top
			}, 500);
			setTimeout(function() { window.location.reload(); }, 1000);

		} else {

			var post_data = { '_user_id': _user_id, '_project_heading': _project_heading, '_project_fullname': _project_fullname, '_project_dob': _project_dob, '_project_dod': _project_dod, '_project_photo': _project_photo };

			$.ajax({

		        type: 'POST',
		        url: window.location.origin+'/bepi/wp-content/plugins/oual-memory-book/ajax/front-ajax.php',
		        data: post_data,

		        beforeSend: function(){

					$( '.oual_new_project_form input, .oual_new_project_form select, .submit_project' ).prop('disabled', true);
					$( '.submit_project' ).html('<span class="spinner-border spinner-border-sm pl_submit" role="status" aria-hidden="true"></span> Submitting &hellip;');
	            	
	        	},

		        success: function(data, textStatus, XMLHttpRequest) {

					var obj = JSON.parse(data);

					console.log(obj);

					if ( obj.type == 'add_project_success' ) {

						$( '.oual_new_project_form' ).prepend( '<div class="mb-3"><div class="alert alert-success" role="alert">'+obj.message+'</div></div>' );
						project_form_reset();
						setTimeout(function() { window.location.href = window.location.origin+'/bepi'+obj.slug; }, 1000);
						
					}

					if ( obj.type == 'add_project_error' ) {

						$( '.oual_new_project_form' ).prepend( '<div class="mb-3"><div class="alert alert-danger" role="alert">'+obj.message+'</div></div>' );
						project_form_reset();
						setTimeout(function() { window.location.reload(); }, 1000);

					}

		        },

		        error: function(MLHttpRequest, textStatus, errorThrown) {
		            console.log(errorThrown);
		        }

		    });

			return false;

		}

	});


	// Project countdown timer
	var registered_timer = $( '.project_timer' ).attr( 'data-reg' );
	var countDownDate = new Date( registered_timer ).getTime();

	// Update the count down every 1 second
	var x = setInterval(function() {

		// Get today's date and time
		var now = new Date().getTime();

		// Find the distance between now and the count down date
		var distance = countDownDate - now;

		// Time calculations for days, hours, minutes and seconds
		var days = Math.floor(distance / (1000 * 60 * 60 * 24));
		var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
		var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
		var seconds = Math.floor((distance % (1000 * 60)) / 1000);

		// Output the result in an element with id="demo"
		var composed_timer = days + 'd ' + hours + 'h ' + minutes + 'm ' + seconds + 's ';
		$( '.project_timer' ).text( composed_timer );

		// If the count down is over, write some text 
		if ( distance < 0 ) {
			clearInterval(x);
			$( '.project_timer' ).text('<span class="badge bg-danger">Expired</span>');
		}

	}, 1000);


	// Email Contributors
	function sending_invitation_reset( message, return_type ) {

		var btn_type = '';
		$( '.contributors_invitation' ).removeAttr('disabled');
		$( '.contributors_invitation' ).html( 'Send Invitation' );
		$( '#reviewInvitation' ).modal('hide');

		if ( return_type == 'success') {
			btn_type = 'alert-success';
		} else {
			btn_type = 'alert-danger';
		}

		$( '<div class="mb-3"><div class="alert '+btn_type+'" role="alert">'+message+'</div></div>' ).insertBefore( '#manageContributor' );
		setTimeout(function() { window.location.reload(); }, 2000);
		
		return;

	}

	$( document ).on( 'click', '.contributors_invitation', function(e) {
		e.preventDefault();

		var _email_recepients = $( 'input[name="email_contributors"]' ).val();
		var _email_project_slug = $( this ).attr('data-project-slug');

		if ( _email_recepients == '' ) {
			$( '#reviewInvitation' ).modal('hide');
			$( '<div class="mb-3"><div class="alert alert-danger" role="alert">Please provide an email address.</div></div>' ).insertBefore( '#manageContributor' );
			setTimeout(function() { window.location.reload(); }, 1500);
		} else {

			var post_data = { '_email_recepients': _email_recepients, '_email_project_slug': _email_project_slug };

			$.ajax({

		        type: 'POST',
		        url: window.location.origin+'/bepi/wp-content/plugins/oual-memory-book/ajax/front-ajax.php',
		        data: post_data,

		        beforeSend: function(){
	            	$( '.contributors_invitation' ).prop('disabled', true);
					$( '.contributors_invitation' ).html('<span class="spinner-border spinner-border-sm pl_submit" role="status" aria-hidden="true"></span> Sending &hellip;');
	        	},

		        success: function(data, textStatus, XMLHttpRequest) {

					var obj = JSON.parse(data);

					if ( obj.type == 'email_invitation_success' ) {
						sending_invitation_reset( obj.message, 'success' );
					}

					if ( obj.type == 'email_invitation_error' ) {
						sending_invitation_reset( obj.message, 'error' );
					}

		        },

		        error: function(MLHttpRequest, textStatus, errorThrown) {
		            console.log(errorThrown);
		        }

		    });

			return false;
		}

	});

	$( document ).on( 'click', '.del_contributor', function(e) {
		e.preventDefault();

		var email_id = $(this).attr('data-emailid');
		var email_contribute = $(this).attr('data-contributor');

		var del_confirmation = confirm('Are you sure want to delete this record?');

		if ( del_confirmation ) {
			window.location.href = window.location.origin+'/bepi/dashboard/?email_id='+email_id+'&delete_contributors='+email_contribute;
		}
   		
	});


	function validateEmail($email) {
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
       return emailReg.test( $email );
    }

    
    //sent single email for contributor
    $( document ).on( 'click', '#message_preview', function(e) {
		e.preventDefault();
	// $("#message_preview").click(function() { 

			var form_check = $( '#message-con-form input[name=form_check]' ).val();
			var user_id = $( '#message-con-form input[name=user_id]' ).val();
			var project_id = $( '#message-con-form input[name=project_id]' ).val();
            var email = $("#exampleFormControlInput1").val();

             
              if($("#exampleFormControlInput1").val()==''){

                $('#msg_alert').html('<div class="alert alert-danger" role="alert">Please enter email address..</div>');
                $("#msg_alert").fadeTo(2000, 500).slideUp(500, function() {
                  $("#msg_alert").slideUp(500);
                });
              }

              else{
                  
                  if(validateEmail($("#exampleFormControlInput1").val())){
                
                      var message = $("#exampleFormControlTextarea1").val();

                     // var pdf_link = $("input[name=pdf_book]:checked").val();
                     // var col_page_link = $("input[name=col_page]:checked").val();

                      //alert(col_page_link);
                      var post_data = { 'form_check': form_check, 'email': email, 'message': message, 'user_id': user_id, 'project_id': project_id };

                      var ajax_url = window.location.origin+'/bepi/wp-content/plugins/oual-memory-book/ajax/front-ajax.php';
                      //var ajax_url = '<?php echo admin_url( "admin-ajax.php" ); ?>';
                      
                      $.ajax({ 
                          method: 'POST',
                          url: ajax_url,
                          data: post_data,
                          success: function(data) { 

                          	//alert(data);
                          	  $('#user-contributors').html(data);

                              $('#message-con-form').trigger("reset");
                              $('#msg_alert').html('<div class="alert alert-success" role="alert">Email sent successfully..</div>');
                              $("#msg_alert").fadeTo(2000, 500).slideUp(500, function() {
                                $("#msg_alert").slideUp(500);
                              });
                          }
                      });
                  
                  }
                  else{
                      $('#msg_alert').html('<div class="alert alert-danger" role="alert">Please enter a valid email...</div>');
                       $("#msg_alert").fadeTo(2000, 500).slideUp(500, function() {
                        $("#msg_alert").slideUp(500);
                      });
                    }
              }

    });

    //sent multiple email for contributor
    $( document ).on( 'click', '#mass_message_con', function(e) {
		e.preventDefault();

			var form_check = $( '#mass-message-con-form input[name=form_check]' ).val();
			var user_id = $( '#mass-message-con-form input[name=user_id]' ).val();
			var project_id = $( '#mass-message-con-form input[name=project_id]' ).val();
			var email = $( '#mass-message-con-form input[name=mass_email]' ).val();
           	
			
			var con_emails = [];
			$("input[name=mass_email]:checked").each(function () {
			    con_emails.push($(this).val());
			});
           	
            var message = $("#exampleFormControlTextarea1").val();

                   
            var post_data = { 'form_check': form_check, 'email': con_emails, 'message': message, 'user_id': user_id, 'project_id': project_id };

            var ajax_url = window.location.origin+'/bepi/wp-content/plugins/oual-memory-book/ajax/front-ajax.php';
                      
                      
                $.ajax({ 
                    method: 'POST',
                    url: ajax_url,
                    data: post_data,
                   success: function(data) { 
                   		alert(data);
                        $('#message-con-form').trigger("reset");
                        $('#mass-message-con-form').trigger("reset");
                        $('#msg_alert').html('<div class="alert alert-success" role="alert">Email sent successfully..</div>');
                        $("#msg_alert").fadeTo(2000, 500).slideUp(500, function() {
                        $("#msg_alert").slideUp(500);
                        });
                    }
                });
                  
    });



     $("#flexCheckDefault").click(function () {
	     $('input:checkbox').not(this).prop('checked', this.checked);
	 });



     // FileStack Upload Image for meme page
	function returnimagedataformemepage( result ) {

		if ( result.filesUploaded.length > 0 ) {

			$('input[name="meme_project_photo"]').val( result.filesUploaded[0].url );
			$( '.filestack-filepicker-meme-page' ).find( 'img' ).attr( 'src', '' );
			$( '.filestack-filepicker-meme-page' ).find( 'img' ).attr( 'src', result.filesUploaded[0].url );

			setTimeout(function() { 
				$( '.filestack-filepicker-meme-page' ).find( 'img' ).width( 300 );
				$( '.filestack-filepicker-meme-page' ).css( 'background-color', '#d4edda' );
				$( '.filestack-filepicker-meme-page' ).find( 'p' ).text( 'Successfully added a photo.' );
				$('#save_text').attr("disabled", false);
			}, 1000);

		} else {
			console.log(result);
		}
	}

	$( document ).on( 'click', '.filestack-filepicker-meme-page', function() {
		const client = filestack.init('A6ulpjJhQ6KW7q5IWnfMPz');

		const options = {
			accept: ["image/*"],
			fromSources: ["local_file_system","url","imagesearch","facebook","instagram","googledrive","webcam"],
			onUploadDone: (result) => returnimagedataformemepage(result),
		};

		client.picker(options).open();


	});

     //create contributors meme page 
	 $( document ).on( 'click', '#submit_meme', function(e) {
		e.preventDefault();

			var meme_form_check = $( '#oual-meme-page-form input[name=meme_form_check]' ).val();
			var user_id = $( '#oual-meme-page-form input[name=user_id]' ).val();
			var project_id = $( '#oual-meme-page-form input[name=project_id]' ).val();
			var meme_project_photo = $( '#oual-meme-page-form input[name=meme_project_photo]' ).val();
			var organizer = $( '#oual-meme-page-form input[name=organizer]' ).val();
			var top_line_for_meme = $( '#oual-meme-page-form input[name=top_line_meme]' ).val();
			var bottom_line_for_meme = $( '#oual-meme-page-form input[name=bottom_line_meme]' ).val();
			var nickname = $( '#oual-meme-page-form input[name=nickname]' ).val();
			var email = $( '#oual-meme-page-form input[name=email]' ).val();
			var contribute_with_others = $( '#oual-meme-page-form input[name=contribute_with_others]' ).val();
           	
	      
	      	// Check If Upload Photo Is Empty
			if ( meme_project_photo == '' ) {

				$(this).prepend( '<div class="mb-3"><div class="alert alert-danger" role="alert">Please let choose photo for your project.</div></div>' );
				$( 'html, body' ).animate({
	        		scrollTop: $( '#oual-meme-page-form' ).offset().top
				}, 500);
				setTimeout(function() { window.location.reload(); }, 1000);

			} else {


	            var post_data = { 

	            	'meme_form_check': meme_form_check, 
	            	'user_id': user_id, 
	            	'project_id': project_id,
	            	'meme_project_photo': meme_project_photo,
	            	'organizer': organizer,
	            	'top_line_for_meme': top_line_for_meme,
	            	'bottom_line_for_meme': bottom_line_for_meme,
	            	'nickname': nickname,
	            	'email_address': email, 
	            	'contribute_with_others': contribute_with_others
	            	
	            };


	            /*$.each(post_data, function(key, value){
		            //$("#result").append(key + ": " + value + '<br>');

		            console.log(key + ": " + value);
		        });*/


	            var ajax_url = window.location.origin+'/bepi/wp-content/plugins/oual-memory-book/ajax/front-ajax.php';
	            var to =    window.location.origin+'/bepi/dashboard/?project_id='+project_id+'&collection_pages=true';

	                $.ajax({ 
	                    method: 'POST',
	                    url: ajax_url,
	                    data: post_data,
	                   success: function(data) { 

	                   		//alert(data);

	                        $('#oual-meme-page-form').trigger("reset");
	                        $('#msg_alert').html('<div class="alert alert-success" role="alert">Meme page was created successfully..</div>');
	                        $("#msg_alert").fadeTo(2000, 500).slideUp(500, function() {
	                        	$("#msg_alert").slideUp(500);
	                        });

	                        setTimeout(function() {
						    	 window.location.replace(to);
							}, 1000);
	                    }
	                });

	       }
                  
    });


	 //create contributors long essay page 
	 $( document ).on( 'click', '#submit_long_essay', function(e) {
		e.preventDefault();

			var essay_form_check = $( '#oual-essay-page-form input[name=essay_form_check]' ).val();
			var user_id = $( '#oual-essay-page-form input[name=user_id]' ).val();
			var project_id = $( '#oual-essay-page-form input[name=project_id]' ).val();
			var organizer = $( '#oual-essay-page-form input[name=organizer]' ).val();
			//var essay = $( '#oual-essay-page-form textarea[name=essay_editor]' ).val();
			var essay = $('.Editor-editor').html();
			var nickname = $( '#oual-essay-page-form input[name=nickname]' ).val();
			var email = $( '#oual-essay-page-form input[name=email]' ).val();
			var contribute_with_others = $( '#oual-essay-page-form input[name=contribute_with_others]' ).val();
           	
           //	alert(essay);

	            var post_data = { 

	            	'essay_form_check': essay_form_check, 
	            	'user_id': user_id, 
	            	'project_id': project_id,
	            	'essay': essay,
	            	'organizer': organizer,
	            	'nickname': nickname,
	            	'email_address': email, 
	            	'contribute_with_others': contribute_with_others
	            	
	            };

	            

	            var ajax_url = window.location.origin+'/bepi/wp-content/plugins/oual-memory-book/ajax/front-ajax.php';
	            var to =    window.location.origin+'/bepi/dashboard/?project_id='+project_id+'&collection_pages=true';
	                $.ajax({ 
	                    method: 'POST',
	                    url: ajax_url,
	                    data: post_data,
	                   success: function(data) { 

	                   		//alert(data);

	                        $('#oual-essay-page-form').trigger("reset");
	                        $('#msg_alert').html('<div class="alert alert-success" role="alert">Long Essay page was created successfully..</div>');
	                        $("#msg_alert").fadeTo(2000, 500).slideUp(500, function() {
	                        $("#msg_alert").slideUp(500);
	                        });

	                        setTimeout(function() {
						    	 window.location.replace(to);
							}, 1000);
	                       
	                    }
	                });

	       
                  
    });



	 //save arrange pages
	 $( document ).on( 'click', '#submit_page_arrange', function(e) {
		e.preventDefault();

			var arrange_page_form_check = $( '#page_arrange_form input[name=arrange_page_form_check]' ).val();
			var page_id = $( '#page_arrange_form input[name=page_id]' ).val();
			var arrange_num = $( '#page_arrange_form input[name=arrange_num]' ).val();
			

			var pageID = [];
			$("input[name=page_id]").each(function () {
			    pageID.push($(this).val());
			});


			var pageNum = [];
			$("input[name=arrange_num]").each(function () {
			    pageNum.push($(this).val());
			});

			//alert(pageID);

	            var post_data = { 

	            	'arrange_page_form_check': arrange_page_form_check, 
	            	'page_id': pageID, 
	            	'arrange_num': pageNum
	            	
	            };


	        var ajax_url = window.location.origin+'/bepi/wp-content/plugins/oual-memory-book/ajax/front-ajax.php';
	                     
	            $.ajax({ 
	                method: 'POST',
	                url: ajax_url,
	                data: post_data,
	                success: function(data) { 

	                   //	alert(data);

	                   	$('#oual-meme-page-form').trigger("reset");

	                   	location.reload();

	                    $('#msg_alert').html('<div class="alert alert-success" role="alert">Page order save successfully..</div>');
	                    $("#msg_alert").fadeTo(2000, 500).slideUp(500, function() {
	                    $("#msg_alert").slideUp(500);

	                  //  setTimeout(function() {
						    
						//}, 1000);

	                });
	            }
	        });

	       
                  
    });



	  // FileStack Upload Image for edit back cover page

	function returnimagedataforeditbackcoverpage( result ) {

		if ( result.filesUploaded.length > 0 ) {

			$('input[name="edit_back_cover_project_photo"]').val( result.filesUploaded[0].url );
			$( '.filestack-filepicker-back-cover-page' ).find( 'img' ).attr( 'src', '' );
			$( '.filestack-filepicker-back-cover-page' ).find( 'img' ).attr( 'src', result.filesUploaded[0].url );
			setTimeout(function() { 
				$( '.filestack-filepicker-back-cover-page' ).find( 'img' ).width( 180 );
				$( '.filestack-filepicker-back-cover-page' ).css( 'background-color', '#d4edda' );
				$( '.filestack-filepicker-back-cover-page' ).find( 'p' ).text( 'Photo was added successfully....' );
			}, 1000);

		} else {
			console.log(result);
		}
	}

	$( document ).on( 'click', '.filestack-filepicker-back-cover-page', function() {
		const client = filestack.init('AVfRP325pSixq38fgBOFFz');

		const options = {
			accept: ["image/*"],
			fromSources: ["local_file_system","url","imagesearch","facebook","instagram","googledrive","webcam"],
			onUploadDone: (result) => returnimagedataforeditbackcoverpage(result),
		};

		client.picker(options).open();


	});


	  // FileStack Upload Image for edit front cover page
	function returnimagedataforeditfrontcoverpage( result ) {

		if ( result.filesUploaded.length > 0 ) {

			$('input[name="edit_front_cover_project_photo"]').val( result.filesUploaded[0].url );
			$( '.filestack-filepicker-edit-front-cover-front-page' ).find( 'img' ).attr( 'src', '' );
			$( '.filestack-filepicker-edit-front-cover-front-page' ).find( 'img' ).attr( 'src', result.filesUploaded[0].url );
			setTimeout(function() { 
				$( '.filestack-filepicker-edit-front-cover-front-page' ).find( 'img' ).width( 180 );
				$( '.filestack-filepicker-edit-front-cover-front-page' ).css( 'background-color', '#d4edda' );
				$( '.filestack-filepicker-edit-front-cover-front-page' ).find( 'p' ).text( 'Photo was added successfully....' );
			}, 1000);

		} else {
			console.log(result);
		}
	}

	$( document ).on( 'click', '.filestack-filepicker-edit-front-cover-front-page', function() {
		const client = filestack.init('AVfRP325pSixq38fgBOFFz');

		const options = {
			accept: ["image/*"],
			fromSources: ["local_file_system","url","imagesearch","facebook","instagram","googledrive","webcam"],
			onUploadDone: (result) => returnimagedataforeditfrontcoverpage(result),
		};

		client.picker(options).open();


	});



	 //submit edit coverpage
	 $( document ).on( 'click', '#submit_edit_cover', function(e) {
		e.preventDefault();

			var edit_cover_form_check = $( '#oual-edit-cover-page-form input[name=edit_cover_form_check]' ).val();
			var user_id = $( '#oual-edit-cover-page-form input[name=user_id]' ).val();
			var project_id = $( '#oual-edit-cover-page-form input[name=project_id]' ).val();
			var project_title = $( '#oual-edit-cover-page-form input[name=project_title]' ).val();
			var project_back_title = $( '#oual-edit-cover-page-form input[name=project_back_title]' ).val();
			var front_project_photo = $( '#oual-edit-cover-page-form input[name=edit_front_cover_project_photo]' ).val();
			var back_project_photo = $( '#oual-edit-cover-page-form input[name=edit_back_cover_project_photo]' ).val();
			
	      	// Check If Upload Photo Is Empty
			/*if ( front_project_photo == '' ) {

				$(this).prepend( '<div class="mb-3"><div class="alert alert-danger" role="alert">Please let choose photo for your project.</div></div>' );
				$( 'html, body' ).animate({
	        		scrollTop: $( '#oual-edit-cover-page-form' ).offset().top
				}, 500);
				setTimeout(function() { window.location.reload(); }, 1000);

			} else {*/


	            var post_data = { 

	            	'edit_cover_form_check': edit_cover_form_check, 
	            	'user_id': user_id, 
	            	'project_id': project_id,
	            	'edit_front_cover_project_photo': front_project_photo,
	            	'edit_back_cover_project_photo': back_project_photo,
	            	'project_title': project_title,
	            	'project_back_title': project_back_title

	            };

	            var ajax_url = window.location.origin+'/bepi/wp-content/plugins/oual-memory-book/ajax/front-ajax.php';
	            var to =    window.location.origin+'/bepi/dashboard/?project_id='+project_id+'&edit_cover=true';

	                $.ajax({ 
	                    method: 'POST',
	                    url: ajax_url,
	                    data: post_data,
	                   success: function(data) { 

	                   		

	                   		if(data == 'success'){

		                        $('#msg_alert').html('<div class="alert alert-success" role="alert">Cover Details was updated successfully..</div>');
		                        $("#msg_alert").fadeTo(2000, 500).slideUp(500, function() {
		                        	$("#msg_alert").slideUp(500);
		                        });

		                        setTimeout(function() {
							    	 window.location.replace(to);
								}, 1000);
							}
							else{

								$('#msg_alert').html('<div class="alert alert-danger" role="alert">Sorry!!! Error found..</div>');
		                        $("#msg_alert").fadeTo(2000, 500).slideUp(500, function() {
		                        	$("#msg_alert").slideUp(500);
		                        });

		                       
							}
	                    }
	                });

	       //}
                  
    });



	 //save question answer
	 $( document ).on( 'click', '#btn_save_question', function(e) {
		e.preventDefault();


			var save_question_form_check = $( '#oual-save-question-page-form input[name=save_question_form_check]' ).val();
			var contributor_id = $( '#oual-save-question-page-form input[name=contributor_id]' ).val();
			var project_id = $( '#oual-save-question-page-form input[name=project_id]' ).val();
			var love_one = $( '#oual-save-question-page-form input[name=love_one]' ).val();
			$('#btn_save_question').html('<button class="btn btn-primary" type="button" disabled><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span> Loading...</span></button>');
			
			

			var questionID = [];
			$("input[name=question_id]").each(function () {
			    questionID.push($(this).val());
			});

			var answer = [];
			$("input[name=answer]").each(function () {
			    answer.push($(this).val());
			});

	            var post_data = { 

	            	'save_question_form_check': save_question_form_check, 
	            	'contributor_id': contributor_id, 
	            	'project_id': project_id,
	            	'question_id': questionID,
	            	'answer': answer,
	            	'love_one': love_one

	            };

	            var ajax_url = window.location.origin+'/bepi/wp-content/plugins/oual-memory-book/ajax/front-ajax.php';
	            
	                $.ajax({ 
	                    method: 'POST',
	                    url: ajax_url,
	                    data: post_data,
	                   success: function(data) { 

	                   	
	                   		
	                   		if(data == 'success'){

	                   			$('#oual-save-question-page-form').trigger("reset");
	                   			$('#btn_save_question').html('Save');
		                        $('#msg_alert').html('<div class="alert alert-success" role="alert">Data was added successfully..</div>');
		                        $("#msg_alert").fadeTo(2000, 500).slideUp(500, function() {
		                        	$("#msg_alert").slideUp(500);
		                        });

							}
							else{

								$('#msg_alert').html('<div class="alert alert-danger" role="alert">Sorry!!! Error found..</div>');
		                        $("#msg_alert").fadeTo(2000, 500).slideUp(500, function() {
		                        	$("#msg_alert").slideUp(500);
		                        });

		                       
							}
	                    }
	                });

	          
    	});


	 

	 //Send pdf to organizer
	 $( document ).on( 'click', '#btn_download_pdf', function(e) {
		e.preventDefault();

			var send_pdf_to_org_form_check = $( '#oual-send-pdf-page-form input[name=send_pdf_to_org_form_check]' ).val();
			var user_id = $( '#oual-send-pdf-page-form input[name=user_id]' ).val();
			var project_id = $( '#oual-send-pdf-page-form input[name=project_id]' ).val();

			$('#btn_download_pdf').html('<button class="btn btn-success" type="button" disabled><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span> Sending...</span></button>');
			

	            var post_data = { 

	            	'send_pdf_to_org_form_check': send_pdf_to_org_form_check, 
	            	'user_id': user_id, 
	            	'project_id': project_id

	            };
	            
	            

	            var ajax_url = window.location.origin+'/bepi/wp-content/plugins/oual-memory-book/ajax/front-ajax.php';
	           

	                $.ajax({ 
	                    method: 'POST',
	                    url: ajax_url,
	                    data: post_data,
	                   success: function(data) { 
	                   		
	                   		if(data == 'success'){

	                   			$('#oual-send-pdf-page-form').trigger("reset");
	                   			$('#btn_download_pdf').html('Click here to download');
		                        $('#msg_alert').html('<div class="alert alert-success" role="alert">PDF File was successfully sent to your email address..</div>');
		                        $("#msg_alert").fadeTo(2000, 500).slideUp(500, function() {
		                        	$("#msg_alert").slideUp(500);
		                        });

							}
							else{

								$('#btn_download_pdf').html('Click here to download');
								$('#msg_alert').html('<div class="alert alert-danger" role="alert">Sorry!!! Error found..</div>');
		                        $("#msg_alert").fadeTo(2000, 500).slideUp(500, function() {
		                        	$("#msg_alert").slideUp(500);
		                        });

		                       
							}
	                    }
	                });

	          
    	});


});


		

