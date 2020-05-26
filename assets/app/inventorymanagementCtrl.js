app.controller('inventorymanagementCtrl', function ($scope, $rootScope, $routeParams, $location, $http, $state, Data, $window, $stateParams) {

    $scope.ShelvelistArray = [];
    $scope.WarehouselistArray = [];
    $scope.filterData = {};
    $scope.totalCount = 0;
    $scope.routeArray = {};
    $scope.editshelveArray = {};
    $scope.editlocationArray = {};
    $scope.CountryData = {};
    $scope.cityDropArr = {};
    $scope.Excelshelvelist = {};
    $scope.shelveDropArr = {};
    $scope.searchPost = {};
    //$scope.InventoryFatchArr=[];
    $scope.CityData = {};
    $scope.totalShelvelist = [];
    function disableScreen(val) {
        if (val == 1)
        {
            var div = document.createElement("div");
            div.className += "overlay";
            document.body.appendChild(div);
        } else
            $("div").removeClass("overlay");
    }
    $scope.getshelvelist = function (page_no, reset) {
        $scope.filterData.page_no = page_no;
        if (reset == 1)
        {
            $scope.ShelvelistArray = [];
        }
        console.log($scope.filterData);
        Data.post('InventoryManagement/showShelve_Data', $scope.filterData).then(function (results) {
            $scope.totalCount = results.count;
            console.log(results);
            if (results.result.length > 0)
            {
                angular.forEach(results.result, function (value)
                {
                    $scope.ShelvelistArray.push(value);

                });
            } else
            {
                $scope.nodata = true
            }
        });
    };

    $scope.isAll = false;
    $scope.selectshelveCheck = function () {
        if ($scope.isAll === false) {
            angular.forEach($scope.ShelvelistArray, function (data) {
                data.checked = true;
            });
            $scope.isAll = true;
        } else {
            angular.forEach($scope.ShelvelistArray, function (data) {
                data.checked = false;
            });
            $scope.isAll = false;
        }
    };

    $scope.getExcelshelvelist = function () {

        Data.post('InventoryManagement/showExcelShelve_Data').then(function (results) {
            //	console.log(results);
            $scope.Excelshelvelist = results;


        });
    };


    $scope.AddShelveform = function (add_shelve) {
        //console.log(add_shelve);
        Data.post('InventoryManagement/AddShelve', {
            add_shelve: add_shelve
        }).then(function (results) {
            //console.log(results);  

            if (results == 'true') {
                // Data.toast(results);
                alert("Added Succeessfully");
                $state.go('show_shelve');

            } else

            {
                alert("Already Exits");

            }
        });
    };


    $scope.GetShelvedelete = function (id)
    {

        Data.post('InventoryManagement/get_delete_shelve', {id: id}).then(function (results) {
            alert("Deleted Succeessfully");
            console.log(results);
            $state.reload()
        });
    };

    $scope.EditShelveshow = function (custdata)
    {

        Data.post('InventoryManagement/ShowEditShelve', {sheid: $stateParams.sheid}).then(function (results) {
            //	console.log(results);
            $scope.editshelveArray = results;
            $scope.editshelveArray.sheid = $stateParams.sheid;
            $scope.editshelveArray.city_id = $scope.editshelveArray.cityname;
            $scope.Getcitydropdata($scope.editshelveArray.country_id);
            $scope.GetshalevelocationDrop($scope.editshelveArray.city_id);

        });
    };

    $scope.EditShelveform = function (edit_shelve) {
        //console.log(edit_shelve);  
        Data.post('InventoryManagement/AddEditShelve', {
            edit_shelve: $scope.editshelveArray
        }).then(function (results) {
            //console.log(results);

            if (results == 'true') {
                // Data.toast(results);
                alert("Updated Succeessfully");
                $state.go('show_shelve');

            } else
            {
                alert("all field are required");
                //$scope.errormess=results.error;
            }
        });
    };


    $scope.getwarehouselist = function (page_no, reset) {
        $scope.filterData.page_no = page_no;
        if (reset == 1)
        {
            $scope.WarehouselistArray = [];
        }
        Data.post('InventoryManagement/showWarehouse_Data', $scope.filterData).then(function (results) {
            $scope.totalCount = results.count;
            console.log(results);
            if (results.result.length > 0)
            {
                angular.forEach(results.result, function (value)
                {
                    $scope.WarehouselistArray.push(value);

                });
            } else
            {
                $scope.nodata = true
            }
        });
    };

    $scope.GetWarehousedelete = function (id)
    {

        Data.post('InventoryManagement/get_delete_warehouse', {id: id}).then(function (results) {
            alert("Deleted Succeessfully");
            $state.reload()
            $scope.getwarehouselist(1, 0);

        });
    };

    $scope.AddLocationform = function (add_location) {
        //console.log(add_location);
        Data.post('InventoryManagement/AddLocation', {
            add_location: add_location
        }).then(function (results) {
            //console.log(results);  

            if (results == 'true') {
                // Data.toast(results);
                alert("Inserted Successfully");
                $state.go('manage_location');

            } else

            {
                alert("Already Exits");

            }
        });
    };

    $scope.EditLocationshow = function (custdata)
    {


        Data.post('InventoryManagement/ShowEditLocation', {loid: $stateParams.loid}).then(function (results) {
            console.log(results);
            $scope.editlocationArray = results;
            $scope.editlocationArray.loid = $stateParams.loid;

            $scope.Getcitydropdata($scope.editlocationArray.country_id);
            $scope.editlocationArray.city_id = $scope.editlocationArray.cityname;

        });
    };

    $scope.EditLocationform = function (edit_location) {
        //console.log(edit_location);  
        Data.post('InventoryManagement/AddEditLocation', {
            edit_location: $scope.editlocationArray
        }).then(function (results) {
            //console.log(results);

            if (results == 'true') {
                // Data.toast(results);
                alert("Updated Successfully");
                $state.go('manage_location');

            } else
            {
                alert("all field are required");
                //$scope.errormess=results.error;
            }
        });
    };


    $scope.GetCountryDropshow = function ()
    {
        //alert("ssssss");
        Data.post('InventoryManagement/GetCountryDropshowShow').then(function (results) {
            console.log(results);
            $scope.CountryData = results;
        });
    }

    $scope.GetCityDropshow = function ()
    {
        //alert("ssssss");
        Data.post('InventoryManagement/GetCityDropshowShow').then(function (results) {
            console.log(results);
            $scope.CityData = results;
            $scope.shelvearray = [];
            angular.forEach($scope.CityData, function (results) {
                $scope.shelvearray.push(results.city);
            });

            var input = document.getElementById("show_city_dropdown");
            var awesomplete = new Awesomplete(input);

            /* ...more code... */

            awesomplete.list = $scope.shelvearray;
            console.log($scope.shelvearray);
        });
    }

    $scope.Getcitydropdata = function (country_id)
    {
        disableScreen(1);
        $scope.loadershow = true;
        Data.post('InventoryManagement/Getcitydropdatashow', {country_id: country_id}).then(function (results) {
            console.log(results);
            disableScreen(0);
            $scope.loadershow = false;
            $scope.originlist = results;
            $scope.shelvearray = [];
            angular.forEach($scope.originlist, function (results) {
                $scope.shelvearray.push(results.city);
            });

            var input = document.getElementById("show_city_dropdownss");
            var awesomplete = new Awesomplete(input);

            /* ...more code... */

            awesomplete.list = $scope.shelvearray;
            console.log($scope.shelvearray);

        });
    }
    $scope.GetshalevelocationDrop = function (city_id)
    {
        //alert("ssssss");
        disableScreen(1);
        $scope.loadershow = true;
        Data.post('InventoryManagement/shelve_warehouse_boxDrop', {city_id: city_id}).then(function (results) {
            console.log(results);
            disableScreen(0);
            $scope.loadershow = false;
            $scope.shelveDropArr = results;
        });
    }


    $scope.GetImportShelveData = function (arrayimg)
    {
        Data.post('Excel_export/shelvefileImport', {imgpath: arrayimg}).then(function (results) {
            console.log(results);
        });
    }
    $scope.Warningshow = {};
    $scope.upload = function (value) {
        var filedata = new FormData();
        angular.forEach($scope.uploadfiles, function (file) {
            filedata.append('file', file);
        });
//console.log(filedata);
        $http({
            method: 'post',
            url: 'InventoryManagement/shelvefileImport',
            data: filedata,
            headers: {'Content-Type': undefined},
        }).then(function (response) {
            console.log(response.data.shelv_locationErr);
            if (response.data != 'null')
            {
                var err_msg = '';
                if(response.data.shelv_locationErr != undefined){
                    err_ids = response.data.shelv_locationErr.toString();
                    err_msg = "These rows not updated. rows:"+err_ids;
                }
                ///var  filedata=[];
                $scope.Warningshow = response.data;
                alert("Added Successfully. "+err_msg);
                // $scope.getshelvelist(1,0);
                $state.reload()
                //$state.go('show_shelve'); 
            } else
                alert("please select file");

        });
    }


    $scope.uploadShelveLocation = function (value) {
        //alert("Hi");      
        var filedata = new FormData();
        angular.forEach($scope.uploadfiles, function (file) {
            filedata.append('file', file);
        });
        //console.log(filedata);
        $http({
            method: 'post',
            url: 'InventoryManagement/shelveLocationfileImport',
            data: filedata,
            headers: {'Content-Type': undefined},
        }).then(function (response) {
            console.log(response);
            if (response.data != 'null')
            {

                ///var  filedata=[];
               var mis_data = '';
               //var match_data = '';
                $scope.Warningshow = response.data;
                if(response.data.cityiderr != undefined){
                    mds = response.data.cityiderr.toString();
                    mis_data = "These rows not matched with database "+mds;
                }
                
                
                alert("Added Successfully. "+mis_data);
                // $scope.getshelvelist(1,0);
                $state.reload()
                //$state.go('show_shelve'); 
            } else
                alert("please select file");

        });
    }

    $scope.ShowShelveCityDrop = function ()
    {
        //alert("ssssssss");
        Data.post('InventoryManagement/ShelveCityDrop').then(function (results) {
            console.log(results);
            $scope.ShelveCityArray = results;
            $scope.CityData = results;
            $scope.shelvearray = [];
            angular.forEach($scope.CityData, function (results) {
                $scope.shelvearray.push(results.city);
            });

            var input = document.getElementById("show_city_dropdown");
            var awesomplete = new Awesomplete(input);

            /* ...more code... */

            awesomplete.list = $scope.shelvearray;
            console.log($scope.shelvearray);
        });
    };
    $scope.InventoryFatchArr = [];
    $scope.GetsearchShelveNo = function (page_no, reset)
    {
        $scope.filterData.page_no = page_no;
        if (reset == 1)
        {
            $scope.InventoryFatchArr = [];
        }
        Data.post('InventoryManagement/GetsearchShelveNoPage', $scope.filterData).then(function (results) {
            // $scope.InventoryFatchArr=[];
            $scope.totalCount = results.count;
            // $scope.InventoryFatchArr=results.result;     
            if (results.result.length > 0)
            {
                angular.forEach(results.result, function (value)
                {
                    $scope.InventoryFatchArr.push(value);

                });
            }
            console.log($scope.InventoryFatchArr);
        });
    }

    $scope.gettotalofd = function (custdata)
    {
        //alert("HIii");
        Data.post('InventoryManagement/ShowtotalshelveDetails', {shelv_no: $stateParams.shelv_no}).then(function (results) {
            console.log(results);
            $scope.totalShelvelist = results.result;


        });
    };


});

