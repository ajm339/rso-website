/*$(document).ready(function(){
	//handler for .ready() called

	//Hides the "username" label for the username field
	var userVal = "Username"

	//ATTN: Needs debugging.
	$('#username').focus(function(){
		$(this).focus(function() {
        	if(this.value == userVal) {
            	this.value = '';
        	}
    	});
    
    	$(this).blur(function() {
        	if(this.value == '') {
            	this.value = userVal;
        	}
    	});
	});

	//Hides the "password" label for the password field
	$('#fakePassword').show();
	$('#realPassword').hide();

	$('#fakePassword').focus(function() {
    	$('#fakePassword').hide();
    	$('#realPassword').show();
    	$('#realPassword').focus();
	});
	
	$('#realPassword').blur(function() {
    	if($('#realPassword').val() == '') {
        	$('#fakePassword').show();
        	$('#realPassword').hide();
    	}
	});



//Login Page:

    //Hides the "netid" label for the netid field
    var netidValue = "NetID";

    //ATTN: Needs debugging.
    $('#netid').focus(function(){
        $(this).focus(function() {
            if(this.value == netidValue) {
                this.value = '';
            }
        });
    
        $(this).blur(function() {
            if(this.value == '') {
                this.value = netidValue;
            }
        });
    });

    //Hides the "username" label for the userreg field
    var usernameValue = "Username";

    //ATTN: Needs debugging.
    $('#userReg').focus(function(){
        $(this).focus(function() {
            if(this.value = usernameValue) {
                this.value = '';
            }
        });
    
        $(this).blur(function() {
            if(this.value == '') {
                this.value = usernameValue;
            }
        });
    });

    //Hides the "password" label for the password field
    $('#userFakePass').show();
    $('#userRealPass').hide();

    $('#userFakePass').focus(function() {
        $('#userFakePass').hide();
        $('#userRealPass').show();
        $('#userRealPass').focus();
    });
    
    $('#userRealPass').blur(function() {
        if($('#userRealPass').val() == '') {
            $('#userFakePass').show();
            $('#userRealPass').hide();
        }
    });

});*/