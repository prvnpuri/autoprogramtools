
(function ( $ ) {

    $.fn.erpPaginationSettings= function(options) {

      return this.each( function() {
        // request intefacing
      	var beforeLoading=function(args){};
      	var successPaginate=function(args){};
      	var errorPaginate=function(xhr,status){};
      	var complete=function(xhr,status){};
      	var linkingpbing=function(xhr,data){};
      	// searching
      	var searchfor=[];
      	var searchUrl=null;
      	var paginationUrl=null;
      	var isPagincationSearchable=true;
      	var method="GET";


      	var limit=null;
      	var maxResultCount=null;
      	var sortBy=null;
      	var orderBy=null;
      	var page=null;
      	var prev=0;
      	var link=1;
      	var offset=0;

      	var loadPage=false;

      	var _this=this;

      	var paginatexhr=function(pageno,sort,direction,method,senddata,url){
      		var url=url;
      		senddata["page"]=pageno;
      		senddata["sort"]=sort;
      		senddata["direction"]=direction;
      		$.ajax({
      			method:method,
      			data:senddata,
      			url:url,
      			beforeSend:function(xhr,options){
      				_this.beforeLoading();
      			},
      			success:function(data,textStatus,xhr){
      				_this.successPaginate(data,textStatus,xhr);
      			},
      			error:function(xhr,data){
      				_this.errorPaginate(data,textStatus,xhr);
      			},
      			complete:function(xhr,status){
      				_this.complete(xhr,status);
      			}
      		});
      	};

      	if(options==null){
      		//throw new Error("$.eprPaginationSettings({ args : values } ) is not matched with your sysntax.");
      	}
      	if( options.hasOwnProperty("paginationUrl")&& options.paginationUrl!=null){
      		paginationUrl=options.paginationUrl;
      	}else{
      		//throw new Error("pagination url not defined! please add $.eprPaginationSettings({ \"paginationUrl\" : some url })");
      	}

      	if( options.hasOwnProperty("page")&& options.paginationUrl!=null){
      		page=options.page;
      	}else{
      		//throw new Error("page not defined! please add $.eprPaginationSettings({ \"page\" : some url })");
      	}



      	// for searching
      	if( options.hasOwnProperty("searchUrl")&& options.searchUrl!=null){
      		searchUrl=options.searchUrl;
      		isPagincationSearchable=false;
      	}else{
      		console.log("Searching on pagination is disabled");
      	}

      	if(options.searchfor!=null && 	isPagincationSearchable){
      		searchfor=options.searchfor;
      	}else{

      	}

      });


    }


}( jQuery || $ ));
