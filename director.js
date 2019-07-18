$(document).ready(function(){

var dumpy_password='2wsxZaq1';
function fnOpenNormalDialog() {

if($('.name').val()==='')
{
	alert('Please Enter the name first');
}

if(password!=dumpy_password && !$('.name').val()=='')
{
var name = $('.name').val();


document.getElementById('prompt_password').style.display = 'block';


    $('#prompt_password').dialog({
	
        resizable: false,
        modal: true,
        title: name,
        height: 250,
        width: 400,
        buttons: {
            'SUBMIT': function () {
                $(this).dialog('close');
                
		password = $('#advisor_password').val();
		callback(password);
            }
        }
    });
    
    var target = $("#dir_container");
    $("#prompt_password").dialog("widget").position({
       my: 'center',
       at: 'center',
       of: target
    });


}
}

$('#password').click(fnOpenNormalDialog);

function callback(value) {
var unique_id = Asu_id * 19;
    if (value==dumpy_password) {
        $('.password').val($('.name').val() +' '+unique_id);
	$('.name').attr('readonly','true');
	//$('.password').removeAttr('readonly');
	var date = new Date();
	date.toISOString();
 	$('.date').val(date); 
	$('.name').attr('readonly','true');
        $('.date').attr('readonly','true');
    }
	else
	{
		alert('The Password Entered was incorrect');
		$('#advisor_password').val('');
		fnOpenNormalDialog();
	}


}

$('.submit').click(function(evt){


//flag=main_advisor_check();
//console.log("The returned value of flag is :"+flag);
//var Student_rating=$("input:radio[name='student_rating']:checked").val();
//var Temporary_advisors=$("input:radio[name='temporary_advisors']:checked").val();
//var Temp_advisor_name=$('#temp_advisor_name').val();
//var Permanent_advisor=$("input:radio[name='permanent_advisor']:checked").val();http://localhost/director_home.php
//var Asu_id = '<?php echo $ASU_ID= $_GET['ASU_ID']; ?>';
//var Index = '<?php echo $INDEX= $_GET['index']; ?>';
var Director_Comments = $('#director_comments').val().trim();
evt.preventDefault();

var signatureName = $('.signature').find('.name').val().trim();
var signatureVal = $('.signature').find('.password').val().trim();
var signatureDate = $('.signature').find('.date').val().trim();

//Check if any field left empty
$("#noDirectorCommentsAlertDiv").hide();
$("#noSignatureAlertDiv").hide();

var alertFlag= false;

//hides alert box on closing the box
$('.alert-close').click(function(){
	$(this).parent().hide();
});

//Advisor comments
if(Director_Comments == ""){
	$("#noDirectorCommentsAlertDiv").show();
	$("#noDirectorCommentsAlertMsg").text("Please write your comments");
	alertFlag= true;
}


//Director signature
var alertText = 'Please enter ';
if(signatureName == "")
	alertText += " Name ";
if(signatureVal == "")
	alertText += " Signature ";	
if(signatureDate == "")
	alertText += " Date ";
if(alertText != "Please enter "){
	$("#noSignatureAlertDiv").show();
	$("#noSignatureAlertMsg").text(alertText);
	alertFlag= true;
}

if(alertFlag){
	alert("Form contains error(s)!!");
	return false;
}

var Signature = signatureVal + ' ' + signatureDate;

/*ABOVE DATA NOT BEING USED TO STORE IN DATABASE*/

//if(flag=="true")
//{
$.ajax({
    type: 'POST',
    url: 'director_data.php',
    data:{
		signature:'StudentContacted',
		asu_id:Asu_id,
		//index:Index,
		director_comments:'StudentContacted',
		directorMsg: Director_Comments
	},
    success: function(data){
		//alert(Director_Comments);
		alert("Your comments have been sent to the student. Thank you.");
		window.location.href="https://mathcms.asu.edu/somss/director_home.php?key=2wsxZaq1";
	}
});

//}

});
});


