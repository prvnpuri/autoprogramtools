<html>
	<body>
		Select file: <input type="file"  id="selectfile">
		<br/>
		<br/>
		Include IMG tag:<input id="includeTag" type="checkbox">
		<br/>
		<br/>
		<textarea id="hexcodetext" style="width:400px;height:400px;: inline-block;"></textarea>
		<div id="imgviewpanel" style="width:400px;display: inline-block;vertical-align: top;">
		</div>
	</body>
	<script type="text/javascript">
		window.addEventListener("load",function(){
			var fileElm=document.getElementById("selectfile");
			var hexcodetx=document.getElementById("hexcodetext");
			var imgview=document.getElementById("imgviewpanel");
			var isTag=document.getElementById("includeTag");
			isTag.addEventListener("change",function(){
				fileElm.dispatchEvent( new Event('change') ); 
			});
			
			fileElm.addEventListener("change",function(){
				var reader = new FileReader();
				if(this.files.length>0){
				var file=this.files[0];
			    reader.onload = function (e) {
					 var imgelmt=document.createElement('img');
					 imgelmt.setAttribute('src',e.target.result);
					 if(isTag.checked){
						hexcodetx.value=imgelmt.outerHTML;
 			         }else{
 			        	hexcodetx.value=e.target.result;
					 }
					 imgview.innerHTML="";
	 			     var appImg=imgview.appendChild(imgelmt);
	 			     appImg.style.width="100%";
	 			     var parentNode=appImg.parentNode;
	 			     var div=document.createElement("div");
	 			     div.innerHTML= "<div>Image Resolution:"+appImg.clientWidth+"x"+appImg.clientHeight+"<br/></div>";
					 parentNode.insertBefore(div.childNodes[0], appImg);
			    };
			    setTimeout(function(){
					 reader.readAsDataURL(file);
				 },500);
				}
				
			});
			
			
		});
	</script>
</html>