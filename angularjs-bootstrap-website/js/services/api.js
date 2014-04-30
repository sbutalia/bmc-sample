nswebModule.service('apiService', function($http, $rootScope) {
	this.EVENT_FACEBOOK_APP_INSTALL = "event:facebookAppInstalled";

    this.WEBSTORAGE_APPPAGE_SELECTION = "webstorage:appPage_SelectedPageName";

    this.SUCCESS_CONST = "Success";
    this.ERROR_CONST = "Error";

    this.getSelectedPageAndAppModel = function(){
        return {selectedFrom: "", page: {name:"", id:"", accessToken:""}, app:{api_key:"", name:""}};
    }

    this.authorize = function(pageId, status) {
		var apiUrl = "api/authorize";
		$http.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded";
		var jsonData = { "status":status, "networkPageID":pageId};
		return $http.post(apiUrl, jsonData).success(function (data) {
			return data;
		}).error(function (resp) {
			//handle error
		});
	},
	this.install = function(pageId) {
		var apiUrl = "api/install";
		var jsonData = { "whitelabel":"0", "partner_id":"1",  "name":"Dev Framework","category":"Internet", "networkPageID":pageId, "networkID":"1" }

		return $http.post(apiUrl, jsonData).success(function (data) {
			return data;
		}).error(function (resp) {
			//handle error
		});
	}

    this.installToFacebook = function(FB, pageId, appId, pageAccessToken) {
        var params = {};
        params['app_id'] = appId;
        FB.api('/'+pageId+'/tabs?access_token='+pageAccessToken, 'post', params, function(response) {
            if (!response || response.error) {
                console.log("Error Installing:");
                console.log(response);
            } else {
                console.log("Installed :)");
                console.log(response);
            }
        });
    }

    //-- pages: array of pages
    //-- selectedPage by the user
    this.getFBPageToken = function(pages, page_id){
        var pageAccessToken;
        for(var i=0;i< pages.length; i++)
            if( pages[i].id == page_id)
                var pageAccessToken = pages[i].access_token;

        //console.log("pageAccessToken: ", pageAccessToken);
        return pageAccessToken;
    }

    this.installAppToFacebook = function(api_key, page_id, pageAccessToken, redirect){
        var resp = {"status":this.SUCCESS, "message:":"" };
        var that = this;

        var params = {};
        params['app_id'] = api_key;
        FB.api('/'+page_id+'/tabs?access_token='+pageAccessToken, 'post', params, function(response) {
            if (!response || response.error) {
                $('.error-list').html( response.error);
                console.log("Error Installing App", api_key);
                console.log(response);

                resp.status = this.ERROR_CONST;
                resp.message = response;
                $rootScope.$broadcast(that.EVENT_FACEBOOK_APP_INSTALL, resp);

            } else {
                console.log("App Installed", api_key);
                console.log(response);

                resp.status = this.SUCCESS_CONST;
                resp.message = response;
                $rootScope.$broadcast(that.EVENT_FACEBOOK_APP_INSTALL, resp);

                if(redirect)
                    window.location = "https://www.facebook.com/"+page_id+"?sk=app_"+api_key;
            }
        });
    }
	
})