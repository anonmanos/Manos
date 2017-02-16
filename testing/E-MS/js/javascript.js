function SubmitForm(e){
	e.form.submit();
}

// JavaScript Document sAcIw
function check_number(e) {
	if(!e) var e = window.event;
	var e_k = e.keyCode || e.which;
	if (e_k != 8 && e_k != 46 && e_k != 37 && e_k != 39 && (e_k < 48 || e_k > 57)) {
		e.returnValue = false;
		e.preventDefault();
		//alert('Event : '+e_k);
  		//alert("ต้องเป็นตัวเลขเท่านั้น... \nกรุณาตรวจสอบข้อมูลของท่านอีกครั้ง..."); //masseng box
	}
}

//JQUERY เช็คค่าว่าง
function formCheckJQ(){
	$(":radio + span.require").remove();
	$(":checkbox + span.require").remove();
	$(":text + span.require").remove();
	$(":password + span.require").remove();
	$("select + span.require").remove();
	$("textarea + span.require").remove();
	$(":text,select,textarea,:password,:radio,:checkbox").each(function(){
		$(this).each(function(){
			/*pass_new,pass_cmf*/
			if($(this).attr("name")=="pass_new"){
				var len = $(this).val().length;
				if(len<3){
					$(this).after("<span class='require'><img src='images/icon24/Red star.png' width='12' height='12' class='vtip' title='รหัสผ่านต้องมี 4 ตัวขั้นไป'></span>");
				}
			}
			if($(this).attr("name")=="pass_cmf"){
				if($(this).val()!=$("input[name='pass_new']").val()){
					$(this).after("<span class='require'><img src='images/icon24/Red star.png' width='12' height='12' class='vtip' title='รหัสผ่านไม่ตรงกัน'></span>");
				}
			}
			if($(this).attr("name")=="email"){
				if(!isValidEmail($(this).val())){
					$(this).after("<span class='require'><img src='images/icon24/Red star.png' width='12' height='12' class='vtip' title='อีเมล์ไม่ถูกต้อง'></span>");
				}
			}
			if($(this).val()==""){
					$(this).after("<span class='require'><img src='images/icon24/Red star.png' width='12' height='12' class='vtip' title='จำเป็นมีข้อมูล'></span>");
			}
			/*if($(":radio,:checkbox").attr("checked")==false){
					$(":radio,:checkbox").after("<span class='require'><img src='images/icon24/Danger.png' width='7' height='7' title='จำเป็นมีข้อมูล'></span>");
				//return false;
			}else{
				$(":radio + span.require").remove();
				$(":checkbox + span.require").remove();
				return false;
			}*/
		});
	});
	if($(":text,select,textarea,:password,:radio,:checkbox").next().is(".require")==false){
		return true;
	}else{
		return false;
	}
}

function formCheckED(){
	$(":radio + span.require").remove();
	$(":checkbox + span.require").remove();
	$(":radio,:checkbox").each(function(){
		//$(this).each(function(){	
			if($(this).attr("checked")==false){
					$(this).after("<span class='require'><img src='images/icon24/Danger.png' width='9' height='9' title='จำเป็นมีข้อมูล'></span>");
			}else{
				$(":radio + span.require").remove();
				$(":checkbox + span.require").remove();
				return false;
			}
		//});
	});
	if($(":radio,:checkbox").next().is(".require")==false){
		return true;
	}else{
		return false;
	}
}

function popUpWindow(URL, N, W, H, S) { // name, width, height, scrollbars
	var winleft	=	(screen.width - W) / 2;
	var winup	=	(screen.height - H) / 2;
	winProp		=	'width='+W+',height='+H+',left='+winleft+',top='+winup+',scrollbars='+S+',resizable' + ',status=yes'
	Win			=	window.open(URL, N, winProp)
	if (parseInt(navigator.appVersion) >= 4) { Win.window.focus(); }
}

function ClickTR(id){
	$("#radio_"+id).attr("checked","true");
	$("#trcolor_"+id).attr("bgcolor","#ffcc99");
	$("tr").not("#trcolor_"+id).attr("bgcolor","#ffffff");
	/*$("#trcolor_"+id).css("background-color","#ffcc99");
	$("tr").not("#trcolor_"+id).css("background-color","#ffffff");*/
}

//การคลิกถูก checkbox
    function ClickCheckAll(vol,obj){
		var i=1;
       for(i=1;i<=obj.hdnCount.value;i++){
            if(vol.checked == true){
                eval("obj.chkDel"+i+".checked=true"); 
            }else{
                eval("obj.chkDel"+i+".checked=false");
            }
        }
    }

function delConfirm(obj){
	var status=false;
	var num = obj.elements.length;
	var counts = 0;
	for(var i=0 ; i < num ; i++ ){
		if(obj[i].type=='checkbox'){
			if(obj[i].checked==true){
				status=true;
				counts++;
			}
		}
	}
	if(status==false){
		alert('กรุณาเลือกข้อมูลอย่างน้อย 1 รายการ');
		return false;
	}else{
		if(confirm('รายการที่เลือก ทั้งหมด '+counts+' รายการ?')){
			return true;
		}else{
			return false;
		}
	}
}

function isValidEmail(str) {
	var filter=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i
	return (filter.test(str)); 
}

//คำนวณเลข
function CalculationSum(sign,num1,num2){
	switch(sign){
		case "+": return num1 + num2; break;
		case "-": return num1 - num2; break;
		case "*": return num1 * num2; break;
		case "/": return num1 / num2; break;
	}
}


//function calculation คำนวณค่าน้ำ/ค่าไฟ
// คำนวณค่าน้ำไฟแล้วนำไปแสดง
function CalculationUnit(value,keys,num,unit){
	var sum,unit,price="";
	$('#'+keys+value+num+'').keyup(function() {
		var maxs = parseFloat($('#'+keys+'max'+num+'').val());
		var mins = parseFloat($('#'+keys+'min'+num+'').val());
		if(maxs>=mins){
		  sum = CalculationSum("-",maxs,mins);
		  price = CalculationSum("*",sum,unit);
		  $('#'+keys+'sum'+num+'').val(Math.round(sum));
		  $('#'+keys+'price'+num+'').val(Math.round(price));
		}else{
		  $('#'+keys+'sum'+num+'').val('');
		  $('#'+keys+'price'+num+'').val('');
		}
	}).keyup();
}

function autoTab(obj,teamp){ 
/* กำหนดรูปแบบข้อความโดยให้ _ แทนค่าอะไรก็ได้ แล้วตามด้วยเครื่องหมาย 
หรือสัญลักษณ์ที่ใช้แบ่ง เช่นกำหนดเป็น รูปแบบเลขที่บัตรประชาชน 
4-2215-54125-6-12 ก็สามารถกำหนดเป็น _-____-_____-_-__ 
รูปแบบเบอร์โทรศัพท์ 08-4521-6521 กำหนดเป็น __-____-____ 
หรือกำหนดเวลาเช่น 12:45:30 กำหนดเป็น __:__:__ 
ตัวอย่างข้างล่างเป็นการกำหนดรูปแบบเลขบัตรประชาชน 
*/ 
var pattern=new String(teamp); // กำหนดรูปแบบในนี้ 
var pattern_ex=new String("-"); // กำหนดสัญลักษณ์หรือเครื่องหมายที่ใช้แบ่งในนี้ 
var returnText=new String(""); 
var obj_l=obj.value.length; 
var obj_l2=obj_l-1; 
for(i=0;i<pattern.length;i++){ 
if(obj_l2==i && pattern.charAt(i+1)==pattern_ex){ 
returnText+=obj.value+pattern_ex; 
obj.value=returnText; 
} 
} 
if(obj_l>=pattern.length){ 
obj.value=obj.value.substr(0,pattern.length); 
} 
} 
//เปลี่ยนค่าสีในช่องกรอกข้อมูล
/*$(document).ready(function() {
    $(':text,:password,:checkbox,:radio,select,textarea,').addClass("idleField");
	$(':text,:password,:checkbox,:radio,textarea,').focus(function() {
		$(this).removeClass("idleField").addClass("focusField");

    });
    $(':text,:password,:checkbox,:radio,select,textarea,').blur(function() {
    	$(this).removeClass("focusField").addClass("idleField");
        if ($.trim(this.value == '')){
        	this.value = (this.defaultValue ? this.defaultValue : '');
    	}
    });
});
*/
/* ทำให้ textbox สลับสี */
/*$(document).ready(function(){
	$(":text,textarea").addClass("NoActiveField");
	$(":text,textarea").focus(function(){
		$(this).addClass("ActiveField").removeClass("NoActiveField");
	}).blur(function(){
		$(this).removeClass("ActiveField").addClass("NoActiveField");
	});
});*/

//RESET TEXT BOX
$(document).ready(function(){
	$(":reset").click(function(){  
		//var objSet=$("form").find("input"); // กำหนด ส่วน หรือขอบเขต การจัดการ
		//objSet.eq(0).focus(); // กำหนดให้โฟกัสไปที่ ตัวแรก
		//$("form").reset();
		window.history.back();
		//return false;
	});
});

/*ตรวจสอบการพิมพ์ <> '' */
$(document).ready(function(){
	$(":text,textarea").keypress(function(event) {
		var e_c = event.which;//charCode
		if (e_c == '60' || e_c == '62' || e_c == '39') {
			event.preventDefault();
		}
	/*$.print(msg, 'html');
	$.print(event);*/
	});

	/*$('#other').click(function() {
		$('#target').keypress();
	});*/
});

