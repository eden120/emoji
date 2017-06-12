var Script = function () {

    //morris chart

    $(function () {
       
      Morris.Donut({
        element: 'user-perc',
        data: [
          {label: 'User', value:user },
          {label: 'Seller', value: seller },
          {label: 'Service Provider', value:s_provider }
        ],
        formatter: function (y) { return y + "" }
      });
  
    });
	
	$(function () {
       
      Morris.Donut({
        element: 'product-perc',
        data: [
          {label: 'Products', value: products },
          {label: 'Services', value:services }
        ],
        formatter: function (y) { return y + "" }
      });
  
    });

}();




