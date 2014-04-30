function InstallController ($scope, $rootScope, $http, $location , $routeParams, apiService, webStorage) {
	$scope.app = $routeParams.app;
    $scope.api_key = $routeParams.api_key;
    $scope.nextButtonLabel = "Next";
    $scope.facebookConnect = false;

    $scope.pagelistIsLoading = true;

	if($rootScope.user === undefined){
       $scope.facebookConnect = true;
	   $scope.pagelistShowing = false;
    } else {
	    showPagelist();
		$scope.facebookConnect = false;
		$scope.pagelistShowing = true;
	}

    $scope.userPages = [];
    $scope.pagelistIsLoading = false;
    function showLoginModal(){
        $('#fbLoginModal').modal('show');
    }

    function showPagelist(){
        FB.api('/me/accounts', function(response) {
            $scope.userPages = response.data;

            //console.log("$scope.userPages",$scope.userPages);
            $scope.pagelistShowing = true;
            if(!$scope.$$phase) {
                $scope.$apply();
            }
        });
    }

    $scope.installapp = function(){
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

    }

    $scope.$on(apiService.EVENT_FACEBOOK_APP_INSTALL, function(data){
         console.log("ON: "+apiService.EVENT_FACEBOOK_APP_INSTALL, data);
        $scope.$apply(function () {
            $scope.nextButtonLabel = "Next";
        });
    });

    $scope.fbLogin = function(){
        FB.login(function(response){
                console.log(response);
                if(response.status === 'connected'){
                    FB.api('/me', function(response) {
                        $scope.user = response;
                        $scope.facebookConnect = false;
                        showPagelist();
                    });
                }else{
                    toggleElement(false);
                }
            },{  scope:'manage_pages' }
        );
    }
}