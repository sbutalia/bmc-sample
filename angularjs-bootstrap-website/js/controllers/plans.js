function PlanController ($scope, $rootScope, $http, $location, apiService, fbookAppID, fbookChannel, webStorage) {
	$scope.pricingShowing = false;
    $scope.menuShowing = false;
    $scope.pagelistShowing = true;
    $scope.pageSelectedContext = false;

    var ACTIVE = '';
    var NOT_ACTIVE = 'not-active'; //CSS Class

    $scope.selectButton = NOT_ACTIVE; //Flag to ensure pricing page doesn't ask user to pay for a page that's already paid for.

    //-- If page was already selected from App Install Page, surface the selected page.
    // install.js
    $scope.selectedPageAndApp = webStorage.get(apiService.WEBSTORAGE_APPPAGE_SELECTION);
    console.log("selectedPageAndApp: ", $scope.selectedPageAndApp);
    if($scope.selectedPageAndApp != null){
        if($scope.selectedPageAndApp.selectedFrom == "install"){
            $scope.pagelistShowing = false;
            $scope.pageSelectedContext = true;
            $scope.selectButton = ACTIVE; //Activate pricing plans select buttons
        }
    }

    $scope.clearSelectedPage = function(){
        webStorage.remove(apiService.WEBSTORAGE_APPPAGE_SELECTION);
        $scope.selectedPageAndApp = null;

        $scope.pagelistShowing = true;
        $scope.pageSelectedContext = false;
    }

	function showLoginModal(){
		$('#fbLoginModal').modal('show');
	}

	function closeLoginModal(){
		$('#fbLoginModal').modal('hide');
	}

	function getPagelist(){
		FB.api('/me/accounts', function(response) {
			$scope.userPages = response.data;
			if(!$scope.$$phase) {
				$scope.$apply();
			}
		});
	}

	function getUserInfo(){
		FB.api('/me', function(response) {
			$scope.user = response;
		});
	}


    $scope.selectPageClick = function(){
        //Check if user is logged into facebook
        if($rootScope.user === undefined){
            showLoginModal();
        }
    }

    //Initiated via the dropdown
	$scope.selectPage = function(){
        $('.message-list').html("");
        $('.errors-list').html("");
        //Check Auth status in API-APPS
        var page_id = $scope.selectedPage;
        console.log("selected_page_id: ", page_id);

        if (page_id) {
            apiService.authorize(page_id, "").then(function(result) {
                var data = result.data;
                console.log(data);
                if (
                        (data.status == 'Success' && data.message == 'NOT_PAID') ||
                        (data.status == 'Error' && data.message == 'Page Not Found')
                   ){
                    $scope.pricingShowing = true;
                    $scope.menuShowing = true;
                    $scope.selectButton = ACTIVE;

                    var pageAccessToken =  apiService.getFBPageToken($scope.userPages, page_id);
                    $scope.selectedPageAndApp = apiService.getSelectedPageAndAppModel();
                    $scope.selectedPageAndApp.selectedFrom = "plans";
                    $scope.selectedPageAndApp.page.id = page_id;
                    $scope.selectedPageAndApp.page.accessToken = pageAccessToken;
                }
                else if (data.status == 'Success' || data.message == 'PAID') {
                    //alert('You are all setup for this page. Please select an application to install via the apps page.');
                    //$location.path('p/apps/overview');
                    $scope.selectButton = NOT_ACTIVE;

                    $('.message-list').html('You are all setup for this page. Please <a href="/#/p/apps/overview">select an application</a> to install.');
				}
                else {
                    $('.errors-list').html("Error occurred, Please contact support. " + data.transactionID);
                }
            });

        }
	}

	$scope.createAccount = function(){
		var page_id = $scope.selectedPageAndApp.page.id;
        $('.message-list').html("");
        $('.errors-list').html("");

		if ($scope.planCode != null)
		{
			if (page_id) {
                $('.message-list').html("");
                $('.errors-list').html("");

                //Get facebook oauth token
                webStorage.add(apiService.WEBSTORAGE_APPPAGE_SELECTION, $scope.selectedPageAndApp);
                console.log("selectedPageAndApp: ", $scope.selectedPageAndApp);

                //Redirect to Order Form Page
                $location.path('p/purchase/' + page_id + '/' + $scope.planCode);
			} else {
				$(".errors-list").html('Please select a page first.');
			}
		} else {
            $(".errors-list").html('Please select a plan option.');
		}

		
	}
	
	$scope.fbLogin = function(){
		 closeLoginModal();
		 console.log("fbLogin() starting");
		 FB.login(function(response){
			console.log("fbLogin() ", response);

            if(response.status === 'connected'){
                 FB.api('/me', function(response) {
                     window.location.reload();
                 });
            }
		 },{  scope:'manage_pages' });
	 }
}