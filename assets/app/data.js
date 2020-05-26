app.factory("Data", ['$http',
    function ($http, toaster) { // This service connects to our REST API

        var serviceBase = '';


        var obj = {};
       
        obj.get = function (q) {
			///alert('mm');
            return $http.get(serviceBase + q).then(function (results) {
                return results.data;
            });
        };
        obj.post = function (q, object) {
				//alert('vv');
            return $http.post(serviceBase + q, object).then(function (results) {
                return results.data;
            });
        };
        obj.put = function (q, object) {
				//alert('yyy');
            return $http.put(serviceBase + q, object).then(function (results) {
                return results.data;
            });
        };
        obj.delete = function (q) {
            return $http.delete(serviceBase + q).then(function (results) {
                return results.data;
            });
        };

        return obj;
}]);