function PurchaseController ($scope, $filter, $timeout, $http, $location , $routeParams, apiService, PlanArray, webStorage, ENV) {
	var page_id = $routeParams.pageId;
	var plan_code = $routeParams.planCode;
	var planInfo = $.grep(PlanArray, function(e){ return e.id == plan_code;});	
	if (!page_id || (planInfo.length == 0)) {
		$location.path('/p/pricing');
	}
	$scope.planInfo = planInfo[0];
    console.log("planInfo:", planInfo);
	$scope.billingPage = true;
    $scope.creditCardContext = true;

    $scope.editPageRedirectURL = "";

    $scope.referralCodeContext = false;
    $scope.digitalSignatureContext = false;
    if($scope.planInfo.type == "credit") {
        $scope.referralCodeContext = true;
	}
    else if($scope.planInfo.type == "invoice"){
        $scope.digitalSignatureContext = true;
        $scope.creditCardContext = false;
		$scope.credit_card_number = '4111-1111-1111-1111';
		$scope.credit_card_month = '1';
		$scope.credit_card_year = '2013';
		$scope.credit_card_verification_value = '123';
    }

    console.log($scope.planInfo.type);

	$scope.orderPage = false;
	$scope.summaryShowing = true;
	$scope.confirmPage = false;
    $scope.missingItems = false;
	$scope.redirect = 'app';
	

	$scope.nextPage = function(page_number){
        $('.error-list').html("");
		switch(page_number) {
			case 1:
				$scope.billingPage = true;
				$scope.orderPage = false;
				
				break;
			case 2:
                var credit_card = [];
				credit_card['number'] = $scope.credit_card_number;
				credit_card['month'] = $scope.credit_card_month;
				credit_card['year'] = $scope.credit_card_year;
				credit_card['verification_value'] = $scope.credit_card_verification_value;
				$scope.credit_card = $.extend({}, credit_card);	
				$('.btn-review-order').val("Loading...");
				if ($scope.form.$valid) {
					$('#payment-progress ul li:nth-child(2)').addClass('selected').siblings('.selected').removeClass('selected');
					$scope.billingPage = false;
					$scope.orderPage = true;
				}
                else{
                    $scope.missingItems = true;
                }

                $('.btn-review-order').val("Review Order");
				break;
		}								
	}

	$scope.purchase = function(){
        $('.error-list').html("");
        $('.btn-submit-order').val("Loading...");
		if ($scope.agree_term) {
			var apiUrl = "api/payment";
			var jsonData = {
				"networkPageID":page_id,
                "planInfo":$scope.planInfo,
				"plan_code":$scope.planInfo.code,
				"account":$scope.account,
				"billing_info":$scope.billing_info,
				"credit_card":$scope.credit_card
			};
			$http.post(apiUrl, jsonData).success(function (data) {
				if(data.status == 'Success'){
                    $scope.order_number = data.message.id;
					$scope.card_type = data.message.card_type;
					$scope.last_four = data.message.last_four;
					$scope.date = $filter('date')(new Date(), 'MM/dd/yyyy');
                    var selectedAppPage = webStorage.get(apiService.WEBSTORAGE_APPPAGE_SELECTION);

		            if (data.message.code == "new") {
                          var httpUrl = '/data/apps/first-impression.json';
                          $http.get(httpUrl).success(function (data) {
                                console.log("First Impression Data",data);
                                if(data !== undefined ){
                                    $scope.pageData = data;

                                    var firstImpression_api_key = $scope.pageData['api_key'][ENV];

                                    console.log("Installing First Impression",firstImpression_api_key);
                                    apiService.installAppToFacebook(firstImpression_api_key, page_id, selectedAppPage.page.accessToken, false);
                                    $scope.editPageRedirectURL = "https://www.facebook.com/"+page_id+"?sk=app_"+firstImpression_api_key;

                                    //Installed selected App from "apps" page

                                    if(selectedAppPage.selectedFrom == "install")
                                        $scope.secondaryInstall = selectedAppPage;

                                    webStorage.remove(apiService.WEBSTORAGE_APPPAGE_SELECTION);
                                }
                          }).error(function (resp) {
                              //handle error
                                  console.log("Error in getting data for First Impression.",resp);
                          });
		              
		            }
                    else{
                        //Installed selected App from "apps" page
                        $scope.editPageRedirectURL = "https://www.facebook.com/"+page_id;

                        if(selectedAppPage.selectedFrom == "install"){
                            console.log("Installing Selected App", selectedAppPage.app.api_key);
                            apiService.installAppToFacebook(selectedAppPage.app.api_key, page_id, selectedAppPage.page.accessToken, false);
                            $scope.editPageRedirectURL = "https://www.facebook.com/"+page_id+"?sk=app_"+selectedAppPage.app.api_key;
                        }

                    }
                    $scope.summaryShowing = false;
                    $scope.orderPage = false;
                    $scope.confirmPage = true;
                    $('#payment-progress ul li:nth-child(3)').addClass('selected').siblings('.selected').removeClass('selected');
                }
                else if(data.status == 'Error'){
					$scope.errors = [];
					if (Array.isArray(data.message)) {
						var errors = [];
						for (var key in data.message) {
							switch (data.message[key]['ID']) {
								case 'Field4':
									data.message[key]['ID'] = 'Email';
									break;
								case 'Field5':
									data.message[key]['ID'] = 'Phone Number';
									break;
							}
							errors.push(data.message[key]);
						}
						$scope.errors = errors;
                    } else {
						$('.error-list').html(data.message);
					}
					
					$scope.summaryShowing = false;
                    $scope.orderPage = false;
                    $scope.billingPage = true;
					$('#payment-progress ul li:nth-child(1)').addClass('selected').siblings('.selected').removeClass('selected');
                }
                else
                    console.log("Unknown Error.");
					$('.btn-submit-order').val("Submit");
                
			}).error(function (resp) {
				//handle error
                console.log("Error: ", resp);

                //$(".errors-list").html(resp);
                $('.btn-submit-order').val("Submit");
			});	
		} else {
		   $(".errors-list").html("Please agree to North Social Terms of Service.")
		}

	}

    $scope.$on(apiService.EVENT_FACEBOOK_APP_INSTALL, function(data){
        console.log("ON: "+apiService.EVENT_FACEBOOK_APP_INSTALL, data);

        $scope.$apply(function () {
            if($scope.secondaryInstall != null){
                var selectedAppPage = $scope.secondaryInstall;
                console.log("Installing Secondary App", selectedAppPage.app.api_key);
                apiService.installAppToFacebook(selectedAppPage.app.api_key, selectedAppPage.page.id, selectedAppPage.page.accessToken, false);
                $scope.editPageRedirectURL = "https://www.facebook.com/"+selectedAppPage.page.id+"?sk=app_"+selectedAppPage.app.api_key;
                $scope.secondaryInstall = null;
            }
        });
    });


	$scope.gotoPage = function(){
	    if ($scope.redirect === 'app')
	    {
			var url = webStorage.get('url');
			webStorage.add('pageId', page_id);
			webStorage.remove('url');
            $location.path(url);
	    } else {
		    window.location = "https://www.facebook.com/"+page_id+"?sk=app_"+$scope.pageData['api_key'][ENV];
		}
	}

    $scope.editFanPage = function(){
        window.location = $scope.editPageRedirectURL;
    }

	$scope.printReceipt = function(){
        var receiptWindow = window.open('Receipt Page', '', '1000', '1000');
		receiptWindow.document.write($('.print-receipt').html());
		receiptWindow.document.close();
		receiptWindow.focus();
		receiptWindow.print();
    }

	$scope.reset = function(){
		$scope.account = {};
		$scope.billing_info = {};
		if($scope.planInfo.type == "credit"){
			$scope.credit_card_number = '';
			$scope.credit_card_month = '';
			$scope.credit_card_year = '';
			$scope.credit_card_verification_value = '';
		}
	}
}