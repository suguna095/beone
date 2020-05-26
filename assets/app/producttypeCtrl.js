app.controller('producttypeCtrl', function ($scope, $rootScope, $routeParams, $location, $http,$state, Data,$window,$stateParams) {
   
    $scope.ProductlistArray=[];
	$scope.filterData = {};
	$scope.filterData.searchfield ="";
	$scope.totalCount=0;
    $scope.editproductArray={};
	
	 $scope.getProductlist = function (page_no,reset) {
		$scope.filterData.page_no=page_no;
		  if(reset==1)
		  {
		  $scope.ProductlistArray=[];
		  }
		   Data.post('ProductType/AddProduct',$scope.filterData).then(function (results) {
			   $scope.totalCount=results.count;
				//console.log(results);
				 if(results.result.length > 0)
				 {
                        angular.forEach(results.result,function(value)
						{
                          $scope.ProductlistArray.push(value);

                        });
                    }
					else
					{$scope.nodata=true
                    }
			});
		};
   
	$scope.GetProductdelete = function (pac_id) {
		//alert (id); 
        Data.post('ProductType/get_delete_Product', {pac_id:pac_id}).then(function (results) { 
			console.log(results);
		    
          // $scope.edit_compidArray=results;
        });
    };
	
	$scope.AddProductform = function (add_product) {
		  console.log(add_product);
        Data.post('ProductType/add_product_type', {
            add_product: add_product
        }).then(function (results) {
			console.log(results);  
		   
            if (results== 'true') {
				// Data.toast(results);
				
				$state.go('show_product_type');	  
				
            }
			else
				
			{
				alert("all field are required");
			
			}
        });
    };
	
	$scope.Editproductshow=function(custdata)
	{
		
		Data.post('ProductType/geteditProductData', {prid:$stateParams.prid}).then(function (results) {
		//	console.log(results);
			$scope.editproductArray=results;
			$scope.editproductArray.prid= $stateParams.prid;

        });
	};
	
	$scope.EditProductform = function (edit_product) {
	    //console.log(edit_product);  
        Data.post('ProductType/EditForm_Update', {
            edit_product: $scope.editproductArray
        }).then(function (results) {
			console.log(results);
		   
            if (results== 'true') {
				// Data.toast(results);
				$state.go('show_product_type');
				
            }
			else
			{
				alert("all field are required");
			//$scope.errormess=results.error;
			}
        });
    };
});
