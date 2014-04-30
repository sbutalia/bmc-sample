function NorthContactController ($scope, $rootScope, $http, $location , $routeParams) {

    $scope.createAccount = function(){
        $('.north-contact-activity-message').text("");
        $('.north-contact-activity-message').hide();
        var company = $('#companyname').val();
        var firstName = $('#firstname').val();
        var lastName = $('#lastname').val();
        var email = $('#email').val();
        var country = 'United States of America';
        var username = $('#username').val();
        var password = $('#password').val();
        var repeat = $('#repeat').val();
        var name = firstName+" "+lastName;

        //Validate
        if(!firstName){
            alert('Missing First Name');
            return;
        }
        if(!lastName){
            alert('Missing Last Name');
            return;
        }
        if(!email){
            alert('Missing Email');
            return;
        }
        if(!username){
            alert('Missing Username');
            return;
        }
        if(!password){
            alert('Missing Password');
            return;
        }
        if(!repeat){
            alert('Missing Repeat Password');
            return;
        }
        if(password && repeat){
           if(password != repeat){
               alert('The passwords do not match.');
               return;
           }
        }
        if(!company){
            alert('Missing Company Name');
            return;
        }

        $.ajax({
            type: "POST",
            url: "/api/north-contact-signup.php",
            data: "company="+company+"&name="+encodeURI(name)+"&email="+encodeURI(email)+"&country="+encodeURI(country)+"&username="+encodeURI(username)+"&password="+encodeURI(password),
            success: function(data){
                var a = data.indexOf("Code");
                if(a>'0'){
                    var jsonstr = data.substring(data.indexOf('{"'), data.indexOf('"}')+2);
                    var response = JSON.parse(jsonstr);
                    if(response.Code == 150){
                        $('.north-contact-activity-message').text('Chosen email address is already being used! Please Try Again!');
                    }else if(response.Code == 172){
                        $('.north-contact-activity-message').text('You can create a maximum of five (5) clients per thirty (30) minutes! Please Try Again after sometime!');
                    }else if(response.Code == 151){
                        $('.north-contact-activity-message').text('The chosen username is already being used, either by the designer or by a client! Please Try Again!');
                    }else if(response.Code == 173){
                        $('.north-contact-activity-message').text('You cannot set client billing options for clients without Create Send access! Please Try Again!');
                    }
                    else
                        $('.north-contact-activity-message').text("There was an error while creating your Account. "+response.Message);
                    $('.north-contact-activity-message').show();
                }else{
                    $('.north-contact-activity-message').text("Account Successfully Created!");
                    $('.north-contact-activity-message').show();
                    $('#username2').val(username);
                    $('#password2').val(password);
                    $('#loginForm').submit();
                }
                $('#north-contact-activity').css("display","none");
            },
            error: function(data){
                var message = data.substring(data.indexOf('"Message":"')).split('"')[0];
                $('#north-contact-activity').css("display","none");
                $('.north-contact-activity-message').text("There was an error while creating your Account. Please try again. " + message);
            }
        });
        /*
        var apikey = $scope.api_key;
        var e = document.getElementById("pagesDropdown");
        var strSel = "The Value is: " + e.options[e.selectedIndex].value + " and text is: " + e.options[e.selectedIndex].text;
        var page_id = e.options[e.selectedIndex].value;
        var page_name = e.options[e.selectedIndex].text;
        $scope.nextButtonLabel = "...";

        $('.error-list').html("");

        //Check if page is a subscriber
        apiService.authorize(page_id, "").then(function(result) {
            var authorize_data = result.data;
			if ( (authorize_data.status == 'Success' && authorize_data.message == 'NOT_PAID') ||
                 (authorize_data.status == 'Error' && authorize_data.message == 'Page Not Found')
                ){
					//-- Ask user to Signup
                    var pageAccessToken = apiService.getFBPageToken($scope.userPages, page_id);

                    var selectedPageAndApp = apiService.getSelectedPageAndAppModel();
                    selectedPageAndApp.selectedFrom = "install";
                    selectedPageAndApp.page.name = page_name;
                    selectedPageAndApp.page.accessToken = pageAccessToken;
                    selectedPageAndApp.page.id = page_id;
                    selectedPageAndApp.app.api_key = $scope.api_key;
                    selectedPageAndApp.app.name = $scope.app;
                    webStorage.add(apiService.WEBSTORAGE_APPPAGE_SELECTION, selectedPageAndApp);

                    $scope.nextButtonLabel = "Next";

					//$('.message-list').html( "Please <a href='/#/p/pricing'>click here</a> to signup the page.");
                    window.location = "/#/p/pricing";
            }
            else if(authorize_data.status == 'Success' && authorize_data.message == 'PAID'){
                var pageAccessToken = apiService.getFBPageToken($scope.userPages, page_id);
                apiService.installAppToFacebook( $scope.api_key, page_id, pageAccessToken, true);
            }
            else{
				alert("Error occurred, Please contact support. " + authorize_data.transactionID);
			}
        });
        */
    }


}