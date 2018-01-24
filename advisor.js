$(document).ready(function(){

var dumpy_password;
function fnOpenNormalDialog() {

    if($('.name').val()==='')
    {   
        alert('Please Enter the name first');
    }

    if($('#advisor_member').val()=="Main Advisor")
    {

    dumpy_password="1qazXsw2";
    Check_password(dumpy_password);
    }
    else
    {
        var dumpy_password="1qazXsw2";
        Check_password(dumpy_password);
    }

}


function Check_password(dumpy_password) {

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
                callback(password,dumpy_password);
                    }
                 }
         });
        }

}


$('#password').click(fnOpenNormalDialog);

function callback(value,dumpy_password) {

var unique_id = Asu_id * 19 ;
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


var Advisor_comments=$('#advisor_comments').val().trim();

var Student_rating=$("input:radio[name='student_rating']:checked").val();
//var Temporary_advisors=$("input:radio[name='temporary_advisors']:checked").val();
//var Temp_advisor_name=$('#temp_advisor_name').val();
//var Permanent_advisor=$("input:radio[name='permanent_advisor']:checked").val();

//var Chair_comments=$('#chair_comments').val();
var AdvisorOwner = $('#advisor_member').val();
//var Asu_id = '<?php echo $ASU_ID= $_GET['ASU_ID']; ?>';
//var Index = '<?php echo $INDEX= $_GET['index']; ?>';
evt.preventDefault();

var signatureName = $('.signature').find('.name').val().trim();
var signatureVal = $('.signature').find('.password').val().trim();
var signatureDate = $('.signature').find('.date').val().trim();

//Check if any field left empty
$("#noAdvisorCommentsAlertDiv").hide();
$("#noRatingAlertDiv").hide();
$("#noSignatureAlertDiv").hide();

var alertFlag= false;

//hides alert box on closing the box
$('.alert-close').click(function(){
	$(this).parent().hide();
});

//Advisor comments
if(Advisor_comments == ""){
	$("#noAdvisorCommentsAlertDiv").show();
	$("#noAdvisorCommentsAlertMsg").text("Please write your comments");
	alertFlag= true;
}

//Student rating
if(!$('input[name="student_rating"]:checked').val()){
	$("#noRatingAlertDiv").show();
	$("#noRatingAlertMsg").text('Please select an option');
	alertFlag = true;
}

//Advisor signature
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

//if(flag=="true")
//{

$.ajax({
    type: "POST",
    url: "advisor_data_v1.php",
    data:{
        Student_rating:Student_rating,
        Signature:Signature,
        ASU_ID:Asu_id,
        advisor_comments:Advisor_comments,
        //chair_comments:Chair_comments,
        Index:Index
    },

    success: function(data){
    //console.log(data);
    alert("Great!!! You have signed the document for the student you are done with your job. Go ahead and close this window");
    
    }
        });

//}

});
});




function advisor_table(){
    if (document.getElementById("permanent_advisor_yes").checked) {
        document.getElementById('permanent_adv').style.display = 'block';
    }
    else document.getElementById('permanent_adv').style.display = 'none';
}

function Member(){

if(document.getElementById('temporary_advisor_yes').checked) {

        document.getElementById("advisor_member_div").style.display='block';
        //document.getElementById("main_advisor").style.display='none';

}
else if(document.getElementById('temporary_advisor_no').checked){

document.getElementById("advisor_member_div").style.display='none';
//document.getElementById("main_advisor").style.display='block';
}
}



var rowCount;
function addRow(tableID)
{

    var table=document.getElementById(tableID);
    rowCount=table.rows.length;
    var row=table.insertRow(rowCount);
        
        //document.getElementById('advisor_Table').innerHTML = "<tr='signature'+rowCount>"i;//  row.class="signature1"//+(rowCount-1);
//      console.log(row.cla);
        row.setAttribute('class','signature');
        var cell1=row.insertCell(0);
        var element1=document.createElement("select");
        element1.class="advisor_member";
        element1.setAttribute('class','advisor_member');
                var option1 = document.createElement("option");
                option1.innerHTML= "ADVISOR";
                var option2 = document.createElement("option");
                option2.innerHTML="CO-ADVISOR/MEMBER";
                //option.innerHTML= "method2";
        element1.appendChild(option1);
        element1.appendChild(option2);
        //document.appendChild(element1);
        cell1.appendChild(element1);
        var cell2=row.insertCell(1);
        var element2=document.createElement("input");
        element2.type="text";
        element2.name="advisor_firstname";
        element2.class="advisor_firstname";
        element2.size="30";
        cell2.appendChild(element2);
        element2.setAttribute('class','advisor_firstname');
        var cell3=row.insertCell(2);
        var element3=document.createElement("input");
        element3.type="text";
        element3.name="advisor_secondname";
        element3.class="advisor_secondname";
        element3.size="30";
        element3.setAttribute('class','advisor_secondname');
        cell3.appendChild(element3);
        var cell4=row.insertCell(3);
        var element4=document.createElement("input");
        element4.type="text";
        element4.size="30";
        element4.name="advisor_mail";
        element4.class="advisor_mail";
        cell4.appendChild(element4);
        element4.setAttribute('class','advisor_mail');
        var cell5=row.insertCell(4);
        var element5=document.createElement("input");
        element5.type="text";
        element5.size="30";
        element5.name="advisor_remail";
  element5.class="advisor_remail";
        cell5.appendChild(element5);
        element5.setAttribute('class','advisor_remail');
        //document.getElementById('advisor_Table').innerHTML = "</tr>"
        
}
var count;
function delRow(tableID)
{
var table=document.getElementById(tableID);
count=table.rows.length;
if((count-1)>1)
{
var row = table.deleteRow(count-1);
}
}



