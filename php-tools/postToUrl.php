<html>
	<head>
	</head>
	<body>
		<h3>Post Custom data</h3>
		<div  style="width:80%">
    		<label style="display:inline-block; width:150px"> Form Url : </label> <input name="formurl" style="width:80%" />
    		<br/>
    		<label style="display:inline-block;width:150px"> Form Method : </label> <input name="formmethod" style="width:80%" placeholder="Enter only get/post" />
    		
        		<hr/>
        		<label style="display:inline-block;width:150px"> Add inputs: </label>	
    			<table class="formtable">
    				
    				<tr class="row">
    					<td style="width:30%">
    						<input placeholder='Input name'  style="width:100%" type="text" name="inputname"/>
    					<td>
    					<td style="width:60%">
    						<input  placeholder='Input value'   style="width:100%" type="text" name="inputvalue"/>
    					<td>
    					<td style="width:10%">
    						<input style="padding:2px;font-weight: bold;" class="remover" type="button" value=" - ">
    					</td>
    				</tr>
    				
    			</table>
    			<input type = "button" class="add" value = " + Add " />
    						<input type = "button" class="submit" value = " >> Submit " />
    		
		</div>
		<script>

		var rowHtml="";
		
		window.addEventListener( "load", function(){

			rowHtml=findElmt(".formtable .row").get(0).elmt.outerHTML;
			var addRow=function(){
				var table=findElmt(".formtable").get(0).elmt;
				var div = document.createElement('table');
				div.innerHTML = rowHtml;
				table.appendChild(div.childNodes[0]);
				findElmt(".remover",div).get(0).elmt.onclick=function(){
					table.removeChild(div);
				}	
			}
			findElmt(".add").get(0).elmt.onclick=function(){
				addRow();
			}

			var submit=findElmt(".submit").get(0).elmt;
			submit.addEventListener("click",function(){
				var form=document.createElement('form');
				form.setAttribute('action',findElmt("inout[name=formurl]").get(0).elmt.value);
				form.setAttribute('action',findElmt("inout[name=formmethod]").get(0).elmt.value);
				var inputs=findElmt("input[name=inputname]");
				for(var i =0; i< inputs.size() ; i++ ){
					var inputname= inputs.get(i).elmt;
						
				}
				var input=document.createElement('input');
			});
			
				
		})
		
		
		function findElmt(query,_elmt){
			_elmt==null ?_elmt=document:_elmt=_elmt;
			var elmt=_elmt.querySelectorAll(query);
			if(elmt==null){
				elmt=[]
			}
			return {
				findElmt:function(_query){
					return findElmt(_query,_elmt);
				},
				get:function(index){
					return { 
					 elmt:	elmt.length>index? elmt[index]:null,
					 html:function(html){
    						 if(elmt.length>index){
        						if(html!=null){
        							elmt[index].innerHTML=html;
        						} 
        						html=elmt[index].innerHTML;
    						 }
							 return html;
						
						}
					}
				},
				size:function(){
					return _elmt!=null ?  _elmt.length : 0 ;
				},
				parent:function(){
					return _elmt.parentElement
				}
			}
		}
		
		</script>
	</body>
</html>