var facebookModule = angular.module('FB', []);

facebookModule.directive('fbConnect', ['$compile', '$rootScope', 'fbookAppID', 'fbookChannel', function($compile, $rootScope, fbookAppID, fbookChannel) {
    return {
        restrict: 'A',
        scope: {},
        templateUrl: '/tpl/directives/angular-facebook/fbConnect.html',
        link: function($scope, $element, $attrs) {
            $scope.htmlText = "";
            $scope.user;
            $scope.isLoggedIn = false;
            $scope.isLoading = true;

            // Covers load order
            if(window.FB) {
                console.log("Facebook SDK Ready");
                facebookReady();
            } else {
                window.fbAsyncInit = facebookReady;
            }

            function toggleElement(isLoggedIn){
                $scope.isLoggedIn = isLoggedIn;
                $scope.isLoading = false;

                if(!$scope.$$phase) {
                    $scope.$apply();
                }
            }

            // Event fired when facebook SDK loads
            function facebookReady() {
                console.log(fbookChannel);
				FB.init({
                    appId: fbookAppID,
                    channelUrl : fbookChannel,
                    status     : true, // check the login status upon init?
                    cookie     : true, // set sessions cookies to allow your server to access the session?
                    xfbml      : true  // parse XFBML tags on this page?
                });

                FB.getLoginStatus(function(response) {
                    if (response.status === 'connected') {
                        // User is logged in
                        FB.api('/me', function(response) {
                            if(response.name != undefined){
                                $scope.user = response;
								$rootScope.user = response;
                                toggleElement(true);
                            }
                        });
						FB.api('/me/accounts', function(response) {
							$rootScope.userPages = response.data;
							if(!$scope.$$phase) {
								$scope.$apply();
							}
						});
                    } else if (response.status === 'not_authorized') {
                        // the user is logged in to Facebook,
                        // but has not authenticated the app
                        toggleElement(false);
                    } else {
                        // the user isn't logged in to Facebook.
                        toggleElement(false);
                    }
                });
            };

            $scope.fbLogin = function(){
                FB.login(function(response){
                        console.log(response);
                        if(response.status === 'connected'){
                            FB.api('/me', function(response) {
                                $scope.user = response;
                                toggleElement(true);
                            });
                        }else{
                            toggleElement(false);
                        }
                    },
                    {  perms:'manage_pages' }
                );
            }

        }
    };
}]);



facebookModule.directive('fbPagelist', ['$compile', '$http', '$location', 'apiService', function($compile, $http, $location,apiService) {
    return {
        restrict: 'A',
        scope: {"apikey":"="},
        templateUrl: '/tpl/directives/facebook_pagelist/pagelist.html',
        link: function($scope, $element, $attrs) {
			$scope.userPages = [];
            $scope.pagelistIsLoading = false;
            function showLoginModal(){
                $('#fbLoginModal').modal('show');
            }



            function showPagelist(){
                FB.api('/me/accounts', function(response) {
                    $scope.userPages = response.data;
                    $scope.pagelistShowing = true;
                    if(!$scope.$$phase) {
                        $scope.$apply();
                    }
                });
            }

            // External button that triggers this directive
            $scope.$on("event:appInstallButtonClicked", function(){
                $scope.pagelistIsLoading = true;
                if(!$scope.$$phase) {
                    $scope.$apply();
                }

                FB.getLoginStatus(function(response) {
                    $scope.pagelistIsLoading = false;
                    if(response.status === 'connected') {
                        // User is logged in
                        showPagelist();
                    }else {
                        // the user isn't logged in to Facebook.
                        $scope.fbLogin();
                    }
                });
            });



            $scope.installapp = function(){
                var apikey = $scope.apikey;
				var e = document.getElementById("pagesDropdown");
                var strSel = "The Value is: " + e.options[e.selectedIndex].value + " and text is: " + e.options[e.selectedIndex].text;
                var page_id = e.options[e.selectedIndex].value;
				var page_name = e.options[e.selectedIndex].text;
                apiService.authorize(page_id, "").then(function(result) {
					var authorize_data = result.data;
					if ((authorize_data.message == 'NOT_PAID') || (authorize_data.message == 'Page Not Found')) {
						$location.path('/p/pricing');
					} else {
						apiService.install(page_id).then(function(result) {
							var install_data = result.data;
							if (install_data) {
								var httpUrl = "https://www.facebook.com/add.php?api_key="+apikey+"&pages=1&page="+page_id;
								window.location.href = httpUrl;
							}
						});
						
					}
				});
				
			}

			$scope.fbLogin = function(){
				 FB.login(function(response){
					console.log(response);
					if(response.status === 'connected'){
						FB.api('/me', function(response) {
						$scope.user = response;
						showPagelist();
					});
					}else{
						toggleElement(false);
					}
					},{  perms:'manage_pages' }
					);
			 }
		}
	};
}]);
