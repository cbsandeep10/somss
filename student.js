
$(function(){
    var d = new Date();
    console.log(d);
    var month=d.getMonth();
    if(month<7){
        var year = d.getFullYear();
        $("#academic_year").val(year-1);
        $("#academic_year1").val(year);
    }
    else{
        var year = d.getFullYear();
        $("#academic_year").val(year);
        $("#academic_year1").val(year+1);
    }
        
});

var rowCount;

$(function() {

    $("#defense_completion_date,.date_of_qualification,#prog_start_date,#anticipated_qualifying_date,#anticipated_dissertation_prospectus_date,#thesis_completion").datepicker( {
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
	display:'none',
        dateFormat: 'MM yy',
	beforeShow: function(el, dp) {
        $('#ui-datepicker-div').toggleClass('hide-calendar', $(el).is('[data-calendar="false"]'));
	},
        onClose: function(dateText, inst) { 
            var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
            var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
            $(this).datepicker('setDate', new Date(year, month, 1));
        }
    });
});

$(function(){

    $(".help_current_goal").tooltip();

});


dataTable_flag=false;
presentation_Table_flag=false;
publication_Table_flag=false;
current_Table_flag=false;
future_Table_flag=false;
qualifying_Table_flag=false;
written_table_flag=false;
advisor_Table_flag=false;
function addRow(tableID)
{

var table=document.getElementById(tableID);
rowCount=table.rows.length;
var row=table.insertRow(rowCount);
        if(tableID!='dataTable'&& tableID!='advisor_Table' && tableID!="qualifying_Table" && tableID!="qualifying_Table_3" && tableID!="qualifying_Table_1" && tableID!="qualifying_Table_2" && tableID!="written_Table")
        {
        var cell1=row.insertCell(0);
        var element1=document.createElement("input");
        element1.type="text";
        element1.size="2"
        element1.value=rowCount;
        cell1.appendChild(element1);
        var cell2=row.insertCell(1);
        var element2=document.createElement("input");
        element2.type="text";
        element2.size="70";


        if(tableID=="presentation_Table")
        {
                element2.name="presentation";
                element2.class="presentation";
                element2.setAttribute('class','presentation');
                if(presentation_Table_flag==true)
                {
                    var value=PresentationDetails(rowCount-1);  
                    element2.value=value;
                    element2.style.backgroundColor="#FCF5D8";
                    AddPresentations(row_pre,Presentation_details);

                }

        }
        else if (tableID=="publication_Table")
        {
                element2.name="publication";
                element2.class="publication";
                element2.setAttribute('class','publication');
                if(publication_Table_flag==true)
                {
                    var value=PublicationDetails(rowCount-1);  
                    element2.value=value;
                    element2.style.backgroundColor="#FCF5D8";
                    AddPublications(row_pub,Publication_details);

                }
        }
        else if (tableID=="current_Table")
        {
                element2.name="current_goal";
                element2.class="current_goal";
                element2.setAttribute('class','current_goal');
                if(current_Table_flag==true)
                {
                    var value=CurrentDetails(rowCount-1);  
                    element2.value=value;
                    element2.style.backgroundColor="#FCF5D8";
                    AddCurrentGoal(row_current,Current_details);
                }
        }
        else if (tableID=="future_Table")
        {
                element2.name="future_goal";
                element2.class="future_goal";
                element2.setAttribute('class','future_goal');
                if(future_Table_flag==true)
                {
                    
                    var value=FutureDetails(rowCount-1);  
                    element2.value=value;
                    element2.style.backgroundColor="#FCF5D8";
                    AddFutureGoal(row_future,Future_details);
                }
        }
        cell2.appendChild(element2);

        }
        else if(tableID=="dataTable")
        {
        row.setAttribute('class','coursegrade'+(rowCount-1));
        var cell1=row.insertCell(0);
        var element1=document.createElement("input");
        element1.type="text";
        //element1.maxlength="2"
        element1.size="70";
        element1.name="course";
        element1.class="course";
        element1.setAttribute('class','course');
         if(dataTable_flag==true)
        {
            var value=CourseDetails(rowCount-1);  
            element1.value=value;
            element1.style.backgroundColor="#FCF5D8";
        }

        cell1.appendChild(element1);
        var cell2=row.insertCell(1);
        var element2=document.createElement("select");
        element2.style.width="146";
        element2.name="grade";
        element2.class="grade";
	element2.setAttribute('class','grade');
	var option1 = document.createElement("option");
	option1.innerHTML="A+";
	var option2 = document.createElement("option");
        option2.innerHTML="A";
	var option3 = document.createElement("option");
        option3.innerHTML="A-";
	var option4 = document.createElement("option");
        option4.innerHTML="B+";
	var option5 = document.createElement("option");
        option5.innerHTML="B";
	var option6 = document.createElement("option");
        option6.innerHTML="B-";
	var option7 = document.createElement("option");
        option7.innerHTML="C+";
	var option8 = document.createElement("option");
        option8.innerHTML="C";
	var option9 = document.createElement("option");
        option9.innerHTML="D";
	var option10 = document.createElement("option");
        option10.innerHTML="E";
	var option11 = document.createElement("option");
        option11.innerHTML="I";
	var option12 = document.createElement("option");
        option12.innerHTML="NR";
	var option13 = document.createElement("option");
        option13.innerHTML="P";
	var option14 = document.createElement("option");
        option14.innerHTML="W";
	var option15 = document.createElement("option");
        option15.innerHTML="X";
	var option16 = document.createElement("option");
        option16.innerHTML="Y";
	var option17 = document.createElement("option");
        option17.innerHTML="Z";
	var option18 = document.createElement("option");
        option18.innerHTML="XE";
	element2.appendChild(option1); element2.appendChild(option2);element2.appendChild(option3);element2.appendChild(option4);element2.appendChild(option5);element2.appendChild(option6);element2.appendChild(option7);element2.appendChild(option8);element2.appendChild(option9);element2.appendChild(option10);element2.appendChild(option11);element2.appendChild(option12);element2.appendChild(option13);element2.appendChild(option14);element2.appendChild(option15);element2.appendChild(option16);element2.appendChild(option17);element2.appendChild(option18);
	cell2.appendChild(element2);
    if(dataTable_flag==true)
    {
        var value=GradeDetails(rowCount-1); 
        if(value==='A+'){
            option1.setAttribute("selected","selected");

        }
        else if(value==='A'){
            option2.setAttribute("selected","selected");
        
        }
        else if(value==='A-'){
            option3.setAttribute("selected","selected");
          
        }
        else if(value==='B+'){

            option4.setAttribute("selected","selected");
        
        }
        else if(value==='B'){
            option5.setAttribute("selected","selected");
          
        }
        else if(value==='B-'){
            option6.setAttribute("selected","selected");
           
        }
        else if(value==='C+'){
            option7.setAttribute("selected","selected");
        
        }
        else if(value==='C'){
            option8.setAttribute("selected","selected");
          
        }
        else if(value==='D'){
            option9.setAttribute("selected","selected");
        
        }
        else if(value==='E'){
            option10.setAttribute("selected","selected");
          
        }
        else if(value==='I'){
            option11.setAttribute("selected","selected");
           
        }
        else if(value==='NR'){
            option12.setAttribute("selected","selected");
        
        }
        else if(value==='P'){
            option13.setAttribute("selected","selected");
          
        }
        else if(value==='W'){
            option14.setAttribute("selected","selected");
        
        }
        else if(value==='X'){
            option15.setAttribute("selected","selected");
          
        }
        else if(value==='Y'){
            option16.setAttribute("selected","selected");
           
        }
        else if(value==='Z'){
            option17.setAttribute("selected","selected");
          
        }
        else if(value==='XE'){
            option18.setAttribute("selected","selected");
           
        }

    }
        AddColumn(row_course,Course_details,Grade_details);
        }
        else if(tableID=="advisor_Table")
        {
            
            row.setAttribute('class','signature'+(rowCount-1));
            var cell1=row.insertCell(0);
            var element1=document.createElement("select");
            element1.class="advisor_member";
            element1.setAttribute('class','advisor_member');
                    var option1 = document.createElement("option");
                    option1.innerHTML= "CHAIR";
                    var option2 = document.createElement("option");
                    option2.innerHTML="CO-CHAIR";
                    var option3 = document.createElement("option");
                    option3.innerHTML="MEMBER";
            element1.appendChild(option1);
            element1.appendChild(option2);
            element1.appendChild(option3);
            cell1.appendChild(element1);
            if(advisor_Table_flag==true)
            {
                var value=CommiteeDetails(rowCount-1); 
                if(value==='CHAIR'){
                    option1.setAttribute("selected","selected");
                }
                else if(value==='CO-CHAIR'){
                    option2.setAttribute("selected","selected");
                }
                else if(value==='MEMBER'){
                    option3.setAttribute("selected","selected");
                }
             }

            var cell2=row.insertCell(1);
            var element2=document.createElement("input");
            element2.type="text";
            element2.name="advisor_firstname";
            element2.class="advisor_firstname";
            element2.size="30";
            if(advisor_Table_flag==true)
            {
                var value=FirstNameDetails(rowCount-1);  
                element2.value=value;
                element2.style.backgroundColor="#FCF5D8";
            }

            cell2.appendChild(element2);
            element2.setAttribute('class','advisor_firstname');
            var cell3=row.insertCell(2);
            var element3=document.createElement("input");
            element3.type="text";
            element3.name="advisor_secondname";
            element3.class="advisor_secondname";
            element3.size="30";
            element3.setAttribute('class','advisor_secondname');
             if(advisor_Table_flag==true)
            {
                var value=LastNameDetails(rowCount-1);  
                element3.value=value;
                element3.style.backgroundColor="#FCF5D8";
            }
            cell3.appendChild(element3);
            var cell4=row.insertCell(3);
            var element4=document.createElement("input");
            element4.type="text";
            element4.size="30";
            element4.name="advisor_mail";
            element4.class="advisor_mail";
             if(advisor_Table_flag==true)
            {
                var value=MailDetails(rowCount-1);  
                element4.value=value;
                element4.style.backgroundColor="#FCF5D8";
            }
            cell4.appendChild(element4);
            element4.setAttribute('class','advisor_mail');
            var cell5=row.insertCell(4);
            var element5=document.createElement("input");
            element5.type="text";
            element5.size="30";
            element5.name="advisor_remail";
            element5.class="advisor_remail";
            if(advisor_Table_flag==true)
            {
                var value=MailDetails(rowCount-1);  
                element5.value=value;
                element5.style.backgroundColor="#FCF5D8";
            }
            cell5.appendChild(element5);
            element5.setAttribute('class','advisor_remail');

        AddAdvisors(row_advisors,commitee_members,firstname,lastname,email_id);
            
        }

	 else if (tableID=="qualifying_Table")
        {
            row.setAttribute('class','qualifyingexam'+token+'-'+(rowCount-1));
        	var cell1=row.insertCell(0);
	        var element1=document.createElement("input");
        	element1.type="text";
        	element1.size="2";
        	element1.value=rowCount;
        	cell1.appendChild(element1);

          
        	
		var cell2=row.insertCell(1);
        	var element2=document.createElement("select");
       	 	
                element2.name="qualifying_details";
                element2.class="qualifying_details";
                element2.setAttribute('class','qualifying_details');
                    var option1=document.createElement("option");
                    option1.innerHTML="APM 501 Differential Equations I";
                    var option2=document.createElement("option");
                    option2.innerHTML="APM 502 Differential Equations II";
                    var option3=document.createElement("option");
                    option3.innerHTML="APM 503 Applied Analysis";
                    var option4=document.createElement("option");
                    option4.innerHTML="APM 504 Applied Probability";
                    var option5=document.createElement("option");
                    option5.innerHTML="APM 505 Applied and Numerical Linear Algebra";
                    var option6=document.createElement("option");
                    option6.innerHTML="APM 506 Scientific Computing";
                    element2.appendChild(option1);element2.appendChild(option2);
                    element2.appendChild(option3);element2.appendChild(option4);
                    element2.appendChild(option5);element2.appendChild(option6);
                    cell2.appendChild(element2);
                     if(qualifying_Table_flag==true)
                    {
                        var value=QualifyingSubjects(rowCount-1); 
                        if(value==='APM 501 Differential Equations I'){
                            option1.setAttribute("selected","selected");

                        }
                        else if(value==='APM 502 Differential Equations II'){
                            option2.setAttribute("selected","selected");
                        
                        }
                        else if(value==='APM 503 Applied Analysis'){
                            option3.setAttribute("selected","selected");
                          
                        }
                        else if(value==='APM 504 Applied Probability'){
                            option4.setAttribute("selected","selected");
           
                        }
                        else if(value==='APM 505 Applied and Numerical Linear Algebra'){
                            option5.setAttribute("selected","selected");
                          
                        }
                        else if(value==='APM 506 Scientific Computing'){
                            option6.setAttribute("selected","selected");
                           
                        }

                    }
                
		var cell3=row.insertCell(2);
                var element3=document.createElement("select");
		        element3.name="qualifying_grades";
                element3.class="qualifying_grades";
                element3.setAttribute('class','qualifying_grades');
                element3.style.width="146";
                var option1 = document.createElement("option");
                option1.innerHTML="A+";
                var option2 = document.createElement("option");
                    option2.innerHTML="A";
                var option3 = document.createElement("option");
                    option3.innerHTML="A-";
                var option4 = document.createElement("option");
                    option4.innerHTML="B+";
                var option5 = document.createElement("option");
                    option5.innerHTML="B";
                var option6 = document.createElement("option");
                    option6.innerHTML="B-";
                var option7 = document.createElement("option");
                    option7.innerHTML="C+";
                var option8 = document.createElement("option");
                    option8.innerHTML="C";
                var option9 = document.createElement("option");
                    option9.innerHTML="D";
                var option10 = document.createElement("option");
                    option10.innerHTML="E";
                var option11 = document.createElement("option");
                    option11.innerHTML="I";
                var option12 = document.createElement("option");
                    option12.innerHTML="NR";
                var option13 = document.createElement("option");
                    option13.innerHTML="P";
                var option14 = document.createElement("option");
                    option14.innerHTML="W";
                var option15 = document.createElement("option");
                    option15.innerHTML="X";
                var option16 = document.createElement("option");
                    option16.innerHTML="Y";
                var option17 = document.createElement("option");
                    option17.innerHTML="Z";
                var option18 = document.createElement("option");
                    option18.innerHTML="XE";
                element3.appendChild(option1); element3.appendChild(option2);element3.appendChild(option3);
                element3.appendChild(option4);element3.appendChild(option5);element3.appendChild(option6);
                element3.appendChild(option7);element3.appendChild(option8);element3.appendChild(option9);
                element3.appendChild(option10);element3.appendChild(option11);element3.appendChild(option12);
                element3.appendChild(option13);element3.appendChild(option14);element3.appendChild(option15);
                element3.appendChild(option16);element3.appendChild(option17);element3.appendChild(option18);
                cell3.appendChild(element3);
                if(qualifying_Table_flag==true)
                {
                    var value=QualifyGradeDetails(rowCount-1); 
                    if(value==='A+'){
                        option1.setAttribute("selected","selected");

                    }
                    else if(value==='A'){
                        option2.setAttribute("selected","selected");
                    
                    }
                    else if(value==='A-'){
                        option3.setAttribute("selected","selected");
                      
                    }
                    else if(value==='B+'){

                        option4.setAttribute("selected","selected");
                    
                    }
                    else if(value==='B'){
                        option5.setAttribute("selected","selected");
                      
                    }
                    else if(value==='B-'){
                        option6.setAttribute("selected","selected");
                       
                    }
                    else if(value==='C+'){
                        option7.setAttribute("selected","selected");
                    
                    }
                    else if(value==='C'){
                        option8.setAttribute("selected","selected");
                      
                    }
                    else if(value==='D'){
                        option9.setAttribute("selected","selected");
                    
                    }
                    else if(value==='E'){
                        option10.setAttribute("selected","selected");
                      
                    }
                    else if(value==='I'){
                        option11.setAttribute("selected","selected");
                       
                    }
                    else if(value==='NR'){
                        option12.setAttribute("selected","selected");
                    
                    }
                    else if(value==='P'){
                        option13.setAttribute("selected","selected");
                      
                    }
                    else if(value==='W'){
                        option14.setAttribute("selected","selected");
                    
                    }
                    else if(value==='X'){
                        option15.setAttribute("selected","selected");
                      
                    }
                    else if(value==='Y'){
                        option16.setAttribute("selected","selected");
                       
                    }
                    else if(value==='Z'){
                        option17.setAttribute("selected","selected");
                      
                    }
                    else if(value==='XE'){
                        option18.setAttribute("selected","selected");
                       
                    }
                    AddQualifySub(row_qualifying_sub,Qualifying_subjects,Qualifying_grades,degree_detail)

                }



        }

        else if (tableID=="qualifying_Table_1")
        {
            row.setAttribute('class','qualifyingexam'+token+'-'+(rowCount-1));
            var cell1=row.insertCell(0);
            var element1=document.createElement("input");
            element1.type="text";
            element1.size="2";
            element1.value=rowCount;
            cell1.appendChild(element1);

            
        var cell2=row.insertCell(1);
            var element2=document.createElement("select");           
                element2.name="qualifying_details";
                element2.class="qualifying_details";
                element2.setAttribute('class','qualifying_details');
                var option1=document.createElement("option");
                option1.innerHTML="Algebra";
                var option2=document.createElement("option");
                option2.innerHTML="Real Analysis";
                var option3=document.createElement("option");
                option3.innerHTML="Discrete Mathematics";
                var option4=document.createElement("option");
                option4.innerHTML="Geometry/Topology";
                
                element2.appendChild(option1);element2.appendChild(option2);
                element2.appendChild(option3);element2.appendChild(option4);
                
        cell2.appendChild(element2);

        var cell3=row.insertCell(2);
                var element3=document.createElement("select");
                element3.name="qualifying_grades";
                element3.class="qualifying_grades";
                element3.setAttribute('class','qualifying_grades');
                var option1=document.createElement("option");
                option1.innerHTML="MS Pass";
                var option2=document.createElement("option");
                option2.innerHTML="PhD Pass";
                var option3=document.createElement("option");
                option3.innerHTML="Fail";
                element3.appendChild(option1);element3.appendChild(option2);element3.appendChild(option3);
                cell3.appendChild(element3);

            }
            else if (tableID=="qualifying_Table_2")
        {
            row.setAttribute('class','qualifyingexam'+token+'-'+(rowCount-1));
            var cell1=row.insertCell(0);
            var element1=document.createElement("input");
            element1.type="text";
            element1.size="2";
            element1.value=rowCount;
            cell1.appendChild(element1);
            var cell2=row.insertCell(1);
            var element2=document.createElement("select");
                element2.name="qualifying_details";
                element2.class="qualifying_details";
                element2.setAttribute('class','qualifying_details');

		var optgroup=document.createElement("optgroup");
			optgroup.setAttribute("label","Mathematics Education");
		var optiona = document.createElement("option");
		optiona.innerHTML="MTE 598:Topic:Research in Undergraduate Math Education I";
		var optionb=document.createElement("option");
		optionb.innerHTML="MTE 598:Topic:Research in Undergraduate Math Education II";
		optgroup.appendChild(optiona);optgroup.appendChild(optionb);
		element2.appendChild(optgroup);	

                var optgroup1=document.createElement("optgroup");
                    optgroup1.setAttribute("label","Applied Mathematics");
                    var option1=document.createElement("option");
                    option1.innerHTML="APM 501 Differential Equations I";
                    var option2=document.createElement("option");
                    option2.innerHTML="APM 502 Differential Equations II";
                    var option3=document.createElement("option");
                    option3.innerHTML="APM 503 Applied Analysis";
                    var option4=document.createElement("option");
                    option4.innerHTML="APM 504 Applied Probability";
                    var option5=document.createElement("option");
                    option5.innerHTML="APM 505 Applied and Numerical Linear Algebra";
                    var option6=document.createElement("option");
                    option6.innerHTML="APM 506 Scientific Computing";

                optgroup1.appendChild(option1);optgroup1.appendChild(option2);
                optgroup1.appendChild(option3);optgroup1.appendChild(option4);
                optgroup1.appendChild(option5);optgroup1.appendChild(option6);
                element2.appendChild(optgroup1);


                var optgroup2=document.createElement("optgroup");
                    optgroup2.setAttribute("label","Mathematical Biology")
                    var option1=document.createElement("option");
                    option1.innerHTML="AML 610 Topics in Applied Mathematics for the Life and Social Sciences";
                    var option2=document.createElement("option");
                    option2.innerHTML="APM 531 Mathematical Neurosciences I";
                    var option3=document.createElement("option");
                    option3.innerHTML="AML 612 Applied Mathematics for the Life and social Sciences Modeling Seminar";
                    var option4=document.createElement("option");
                    option4.innerHTML="AML 613 Probability and Stochastic Modeling for the Life and Social Sciences";
                    
                optgroup2.appendChild(option1);optgroup2.appendChild(option2);
                optgroup2.appendChild(option3);optgroup2.appendChild(option4);
                
                element2.appendChild(optgroup2);



                var optgroup3=document.createElement("optgroup");
                    optgroup3.setAttribute("label","Mathematics")
                    var option1=document.createElement("option");
                    option1.innerHTML="MAT 512 Discrete Mathematics I";
                    var option2=document.createElement("option");
                    option2.innerHTML="MAT 513 Discrete Mathematics II";
                    var option3=document.createElement("option");
                    option3.innerHTML="MAT 516 Graph Theory I";
                    var option4=document.createElement("option");
                    option4.innerHTML="MAT 517 Graph Theory II";
                    var option5=document.createElement("option");
                    option5.innerHTML="MAT 543 Algebra I";
                    var option6=document.createElement("option");
                    option6.innerHTML="MAT 544 Algebra II";
                    var option7=document.createElement("option");
                    option7.innerHTML="MAT 570 Real Analysis I";
                    var option8=document.createElement("option");
                    option8.innerHTML="MAT 571 Real Analysis II";


                optgroup3.appendChild(option1);optgroup3.appendChild(option2);
                optgroup3.appendChild(option3);optgroup3.appendChild(option4);
                optgroup3.appendChild(option5);optgroup3.appendChild(option6);
                optgroup3.appendChild(option7);optgroup3.appendChild(option8);
                element2.appendChild(optgroup3);


                var optgroup4=document.createElement("optgroup");
                    optgroup4.setAttribute("label","Statistics")
                    var option1=document.createElement("option");
                    option1.innerHTML="STP 501 Theory of Statistics 1";
                    var option2=document.createElement("option");
                    option2.innerHTML="STP 502 Theory of Statistics 2";
                    var option3=document.createElement("option");
                    option3.innerHTML="STP 525 Advance Probability";
                    var option4=document.createElement("option");
                    option4.innerHTML="STP 526 Theory of Statistical Linear Model";
                    var option5=document.createElement("option");
                    option5.innerHTML="STP 527 Statistical Large Sample Theory";
                    var option6=document.createElement("option");
                    option6.innerHTML="STP 530 Applied Regression Analysis";
                    var option7=document.createElement("option");
                    option7.innerHTML="STP 531 Applied Analysis of Variance";
                    var option8=document.createElement("option");
                    option8.innerHTML="STP 532 Applied Nonparametric Statistics";
                    var option9=document.createElement("option");
                    option9.innerHTML="STP 533 Applied Multivariable Analysis";
                    var option10=document.createElement("option");
                    option10.innerHTML="STP 535 Applied Sampling Methodology";



                optgroup4.appendChild(option1);optgroup4.appendChild(option2);
                optgroup4.appendChild(option3);optgroup4.appendChild(option4);
                optgroup4.appendChild(option5);optgroup4.appendChild(option6);
                optgroup4.appendChild(option7);optgroup4.appendChild(option8);
                optgroup4.appendChild(option9);optgroup4.appendChild(option10);
                element2.appendChild(optgroup4);
                
        cell2.appendChild(element2);

        var cell3=row.insertCell(2);
                var element3=document.createElement("select");
                element3.name="qualifying_grades";
                element3.class="qualifying_grades";
                element3.setAttribute('class','qualifying_grades');
                var option1=document.createElement("option");
                option1.innerHTML="MS Pass";
                var option2=document.createElement("option");
                option2.innerHTML="PhD Pass";
                var option3=document.createElement("option");
                option3.innerHTML="Fail";
                element3.appendChild(option1);element3.appendChild(option2);element3.appendChild(option3);
                cell3.appendChild(element3);

    
        }
        else if (tableID=="qualifying_Table_3")
        {
            row.setAttribute('class','qualifyingexam'+token+'-'+(rowCount-1));
            var cell1=row.insertCell(0);
            var element1=document.createElement("input");
            element1.type="text";
            element1.size="2";
            element1.value=rowCount;
            cell1.appendChild(element1);
            
            var cell2=row.insertCell(1);
            var element2=document.createElement("select");
            
                element2.name="qualifying_details";
                element2.class="qualifying_details";
                element2.setAttribute('class','qualifying_details');
                var option1=document.createElement("option");
                option1.innerHTML="STP 501/502 Theory of Statistics";
                var option2=document.createElement("option");
                option2.innerHTML="MAT 570 Real Analysis I/MAT 571 Real Analysis II";
                var option3=document.createElement("option");
                option3.innerHTML="APM 503 Applied Analysis/APM 504 Applied Probability";
                
                element2.appendChild(option1);element2.appendChild(option2);
                element2.appendChild(option3);
                
        cell2.appendChild(element2);

        var cell3=row.insertCell(2);
                var element3=document.createElement("select");
                element3.name="qualifying_grades";
                element3.class="qualifying_grades";
                element3.setAttribute('class','qualifying_grades');
                var option1=document.createElement("option");
                option1.innerHTML="MS Pass";
                var option2=document.createElement("option");
                option2.innerHTML="PhD Pass";
                var option3=document.createElement("option");
                option3.innerHTML="Fail";
                element3.appendChild(option1);element3.appendChild(option2);element3.appendChild(option3);
                cell3.appendChild(element3);

        }
        else if(tableID="written_Table"){
                row.setAttribute('class','writtenexam'+(rowCount-1));
                var cell1=row.insertCell(0);
                var element1=document.createElement("input");
                element1.type="text";
                element1.size="2";

                element1.value=rowCount;
                cell1.appendChild(element1);
                var cell2=row.insertCell(1);
                var element2=document.createElement("input");
                element2.type="text";
                element2.size="70";
                element2.name="written_comprehensive";
                element2.class="written_comprehensive";
                element2.setAttribute('class','written_comprehensive');
                cell2.appendChild(element2);
                var cell3=row.insertCell(2);
                var element3=document.createElement("select");
                element3.name="written_grades";
                element3.class="written_grades";
                element3.setAttribute('class','written_grades');
                if(written_table_flag==true)
                {
                    var value=WrittenDetails(rowCount-1); 
                    element2.value=value;
                    AddWritten(row_written,Written_Comp,Written_Grades); 
                    element2.style.backgroundColor="#FCF5D8";
                }
                var option1=document.createElement("option");
                option1.innerHTML="Pass";
                var option2=document.createElement("option");
                option2.innerHTML="Fail";
                element3.appendChild(option1);element3.appendChild(option2);
                cell3.appendChild(element3);       
                 if(written_table_flag==true)
                {
                    var value=WrittenGrades(rowCount-1); 
                    element3.value=value;
                    if(value==='Pass'){
                            option1.setAttribute("selected","selected");

                        }
                    else if(value==='Fail'){
                            option2.setAttribute("selected","selected");
                        
                        }
                    AddWritten(row_written,Written_Comp,Written_Grades); //AddWritten
                }

        }

}


function AddAdvisors(row_advisors,commitee_members,firstname,lastname,email_id){

window.row_advisors = row_advisors-1;
console.log(firstname);
window.firstname=firstname;
window.lastname=lastname;
window.commitee_members=commitee_members;
window.email_id=email_id;

    if(row_advisors>1){
       advisor_Table_flag=true;
       addRow("advisor_Table");
    }
}



function AddColumn(row_course,Course_details,Grade_details){

window.row_course = row_course-1;
console.log(row_course);

window.Course_details=Course_details;
window.Grade_details=Grade_details;

    if(row_course>1){
       dataTable_flag=true;
       addRow("dataTable");
    }
}


function AddCurrentGoal(row_current,Current_details){

window.row_current = row_current-1;
window.Current_details=Current_details;

    if(row_current>1){
       current_Table_flag=true;
       addRow("current_Table");
    }
}


function AddFutureGoal(row_future,Future_details){

window.row_future = row_future-1;
window.Future_details=Future_details;


    if(row_future>1){
       future_Table_flag=true;
       addRow("future_Table");
    }
}

//Publications


function AddPublications(row_pub,Publication_details){

window.row_pub = row_pub-1;
window.Publication_details=Publication_details;


    if(row_pub>1){
       publication_Table_flag=true;
       addRow("publication_Table");
    }
}


function AddPresentations(row_pre,Presentation_details){

window.row_pre = row_pre-1;
window.Presentation_details=Presentation_details;

    if(row_pre>1){
       presentation_Table_flag=true;
       addRow("presentation_Table");
    }
}

function AddQualifySub(row_qualifying_sub,Qualifying_subjects,Qualifying_grades,degree_detail){

window.row_qualifying_sub=row_qualifying_sub-1;
window.Qualifying_subjects=Qualifying_subjects;
window.degree_detail=degree_detail;
window.Qualifying_grades=Qualifying_grades;
console.log(row_qualifying_sub+""+degree_detail);
    if(row_qualifying_sub>1){
        qualifying_Table_flag=true;
        if(degree_detail==='Applied Mathematics')
            addRow("qualifying_Table");
        else if(degree_detail==='Mathematics')
            addRow("qualifying_Table_1");
        else if(degree_detail==='Mathematics Education')
            addRow("qualifying_Table_2");
        else if(degree_detail==='Statistics')
            addRow("qualifying_Table_3");

    }

}


var row_written;
var Written_Comp;
var Written_Grades;
function AddWritten(row_written,Written_Comp,Written_Grades){

window.row_written=row_written-1;
window.Written_Comp=Written_Comp;
window.Written_Grades=Written_Grades;
    if(row_written>1){
        written_table_flag=true;
        addRow("written_Table");

    }
}

function FirstNameDetails(count){
        value=firstname[count];
        return value;
    }
function LastNameDetails(count){
    value=lastname[count];
    return value;
}
function MailDetails(count){
    value=email_id[count];
    return value;
}
function CommiteeDetails(count){
    value=commitee_members[count];
    return value;
}


function CourseDetails(count){
        value= Course_details[count];
        return value;
    }

function GradeDetails(count){
        value= Grade_details[count];
        return value;
}

function CurrentDetails(count){
        value= Current_details[count];
        return value;
    }
function FutureDetails(count){
        value= Future_details[count];
        return value;
    }
function PublicationDetails(count){
        value= Publication_details[count];
        return value;
    }
function PresentationDetails(count){
        value= Presentation_details[count];
        return value;
    }
    
function QualifyingSubjects(count){
    value=Qualifying_subjects[count];
    return value;
}

function QualifyGradeDetails(count){
    value=Qualifying_grades[count]
    return value;
}

function WrittenDetails(count){
    value=Written_Comp[count];
    return value;

}

function WrittenGrades(count){
    value=Written_Grades[count];
    console.log(count);
    return value;
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



//Applied mathematics
function completion_date(){
    if (document.getElementById("exam_no").checked) {
        
	document.getElementById('Q-exam').style.display = 'none';
	$('#qualifying_Table').find("tr:gt(1)").remove();
	$('.qualifying_grades').val("");
    $('.qualifying_details').val("");
    }
    else 
	{
	 		
		document.getElementById('Q-exam').style.display = 'block';
        ///$("#Q-exam_1").children().prop('disabled',true);
        //$("#Q-exam_2").children().prop('disabled',true);
        //$("#Q-exam_3").children().prop('disabled',true);
        
		
	}
}

//Mathematics
function completion_date_1(){
    if (document.getElementById("exam_no_1").checked) {
     
    document.getElementById('Q-exam_1').style.display = 'none';
    $('#qualifying_Table_1').find("tr:gt(1)").remove();
    $('.qualifying_grades').val("");
    $('.qualifying_details').val("");
    }
    else 
    {
            
        document.getElementById('Q-exam_1').style.display = 'block';
        
    }
}

//Mathematics Education
function completion_date_2(){
    if (document.getElementById("exam_no_2").checked) {
     
    document.getElementById('Q-exam_2').style.display = 'none';
    $('#qualifying_Table_2').find("tr:gt(1)").remove();
    $('.qualifying_grades').val("");
    $('.qualifying_details').val("");
    }
    else 
    {
            
        document.getElementById('Q-exam_2').style.display = 'block';
        
    }
}

//Statistics
function completion_date_3(){
    if (document.getElementById("exam_no_3").checked) {
     
    document.getElementById('Q-exam_3').style.display = 'none';
    $('#qualifying_Table_3').find("tr:gt(1)").remove();
    $('.qualifying_grades').val("");
    $('.qualifying_details').val("");
    }
    else 
    {
            
        document.getElementById('Q-exam_3').style.display = 'block';
        
    }
}



function completion_date_dissertation_prospectus(){
    if (document.getElementById("exam_not").checked) {
        document.getElementById('completion_date_dissertation_prospectus').style.display = 'block';
	document.getElementById('ifyes').style.display = 'none';
	 $("input:radio[class='defense']:checked").attr('checked',false);
    }
    else
	{ 
		document.getElementById('completion_date_dissertation_prospectus').style.display = 'none';
  		$('#anticipated_dissertation_prospectus_date').val("");
		$('#defense_completion_date').val("");
		document.getElementById('defense_date').style.display = 'none';
		document.getElementById('ifyes').style.display = 'block';
	}
}



function Member(){



if(document.getElementById('advisory_committee_yes').checked) {
    
    document.getElementById("advisor_member_div").style.display='block';
  
    //$("#advisor_member_div").css("display","block");

}
else if(document.getElementById('advisory_committee_no').checked){

document.getElementById("advisor_member_div").style.display='none';

$('#advisor_Table').find("tr:gt(1)").remove();

    $.each($('#advisor_table_body tr'),function(i,tr){

        $('.signature'+i).find('.advisor_firstname').val("");
        $('.signature'+i).find('.advisor_secondname').val("");
        $('.signature'+i).find('.advisor_mail').val("");
        $('.signature'+i).find('.advisor_remail').val("");

    });

}
}



var token;
function SelectDegree(){

   
    if($('#degree_select').val()=="Applied Mathematics")
    {
        token=1;
        document.getElementById("qualifying_exam_applied_math").style.display='block';
        document.getElementById("qualifying_exam_stat").style.display='none';
        document.getElementById("qualifying_exam_math_edu").style.display='none';
        document.getElementById("qualifying_exam_maths").style.display='none';
     

    }
    else if($('#degree_select').val()=="Mathematics")
    {
        token=2;
        document.getElementById("qualifying_exam_applied_math").style.display='none';
        document.getElementById("qualifying_exam_stat").style.display='none';
        document.getElementById("qualifying_exam_math_edu").style.display='none';
        document.getElementById("qualifying_exam_maths").style.display='block';
       
    }
    if($('#degree_select').val()=="Mathematics Education")
    {
        token=3;
        document.getElementById("qualifying_exam_applied_math").style.display='none';
        document.getElementById("qualifying_exam_stat").style.display='none';
        document.getElementById("qualifying_exam_math_edu").style.display='block';
        document.getElementById("qualifying_exam_maths").style.display='none';
        
    }
    if($('#degree_select').val()=="Statistics")
    {
        token=4
        document.getElementById("qualifying_exam_applied_math").style.display='none';
        document.getElementById("qualifying_exam_stat").style.display='block';
        document.getElementById("qualifying_exam_math_edu").style.display='none';
        document.getElementById("qualifying_exam_maths").style.display='none';
       
    }


}

function WrittenComp(){
if (document.getElementById('comprehensive_exam_yes').checked) {
        document.getElementById('written_comp_div').style.display = 'block';
    }
    else
    {    
        document.getElementById('written_comp_div').style.display = 'none';
        $('#written_Table').find("tr:gt(1)").remove();
        $('.written_comprehensive').val("");

 

    }

}


function TextBox(){
    if (document.getElementById('committee_formed_no').checked) {
        document.getElementById('textbox').style.display = 'block';
    }
    else
	{	 
		document.getElementById('textbox').style.display = 'none';
		$('#advisory_committee_reason').val("");
	}
}

function Colloquium(){
    console.log("hi");
    if (document.getElementById('colloquium_yes').checked) {
        document.getElementById('check_coll_sem').style.display = 'block';
    }
    else
        {
                document.getElementById('check_coll_sem').style.display = 'none';
                $('#colloquium_reason').val("");
        }
}



function sum() {
            var FALL = document.getElementById('fall_gpa').value;
            var SPRING = document.getElementById('spring_gpa').value;
            var result = (parseFloat(FALL) + parseFloat(SPRING))/2;
            if (!isNaN(result)) {
                document.getElementById('cum_gpa').value = result.toFixed(2);
            }
        }

//this is the function for clearing mail if written wrongly.
 $(document).ready (function () {

	$( document.body ).mousemove(function() {

				
			$.each($('#advisor_table_body tr'),function(i,tr){

           		     if($('.signature'+i).find('.advisor_mail').val()==$('.signature'+i).find('.advisor_remail').val()){

                                       
                                                 $('label[for=advisor_remail]').css({color:'#333333'});
					}
			     else{
					 $('label[for=advisor_remail]').css({color:'red'});
                                       //  $('.signature'+i).find('.advisor_remail').val("")
			
					}

                                });


			});
	


 $('.advisor_remail').on('copy paste', function(e) {
         e.preventDefault();
        });	



});



$(document).ready(function(){
$('.submit').click(function(evt){

var Degree_select=$('#degree_select').val();
var Academic_year=$("#academic_year").val();
var First_name=$('#first_name').val();
var Second_name=$('#second_name').val();
var Asu_id=$('#asu_id').val();
var Student_mail=$('#student_mail').val()+'@asu.edu';
var Prog_start_date=$('#prog_start_date').val();
var Sem_in_prog=$('#sem_in_prog').val();
var Cum_gpa=$('#cum_gpa').val();
var Advisory_committee=$("input:radio[name='advisory_committee']:checked").val();
var Met_advisor=$("input:radio[name='met_advisor']:checked").val();
var Advisory_committee_reason=$('#advisory_committee_reason').val();
var Comprehensive_exam=$("input:radio[name='comprehensive_exam']:checked").val();
var Oral_comprehensive_exam=$("input:radio[name='oral_comprehensive_exam']:checked").val();
var Colloquium=$("input:radio[name='colloquium']:checked").val();
var Research_completed=$("input:radio[name='research_completed']:checked").val();
var Qualifying_exam=$("input:radio[name='qualifying_exam']:checked").val();
var Extra=$("#extra").val();
var flag="true";
evt.preventDefault();
var alert_value='';
var alert_count=1;



//Check if Degree program has been selected
if($('#degree_select option:selected').val()==-1){

    alert_value+=alert_count+".) Please select your respective Degree Program.\n\n";
    alert_count++;
    $('label[for=degree_select]').css({color:'red'});
    flag="false";

}
else{

        $('label[for=degree_select]').css({color:'#333333'});

}




/*
//To check the academic year

if($('#academic_year').val()==='')
{
	alert_value+=alert_count+".) Please enter Academic Year.\n\n";
	alert_count++;
	$('label[for=academic_year]').css({color:'red'});
	flag="false";
}
else if($('#academic_year').val()!='') 
{
	$('label[for=academic_year]').css({color:'#333333'});
}
*/
//To check the First Name
if($('#first_name').val()==='')
{
        alert_value+=alert_count+".) Please enter First Name\n\n";
	alert_count++;
	$('label[for=first_name]').css({color:'red'});
	flag="false";
}
else
{
        
       	 regex=/^[a-z]+$|^[A-Z]+$|^[A-Z]{1}[a-z]+$/
         if(!regex.test(First_name))
        {
        alert_value+=alert_count+".)Please enter the Name in Proper Format(All caps OR All small OR First letter caps and remaining small)\n\n";
        alert_count++;
        $('label[for=first_name]').css({color:'red'});
        flag="false";
        }
}

if($('#first_name').val()!='')
{
	regex=/^[a-z]+$|^[A-Z]+$|^[A-Z]{1}[a-z]+$/
	if(regex.test(First_name))
	{
		$('label[for=first_name]').css({color:'#333333'});
	}
}	


//To check the Last Name of the student
if($('#second_name').val()==='')
{
        alert_value+=alert_count+".) Please enter Last Name\n\n";
	alert_count++;
	$('label[for=second_name]').css({color:'red'});
	flag="false";
}
else
{
        
        regex=/^[a-z]+$|^[A-Z]+$|^[A-Z]{1}[a-z]+$/
         if(!regex.test(Second_name))
        {
        alert_value+=alert_count+".)Please enter the Name in Proper Format(All caps OR All small OR First letter caps and remaining small)\n\n";
        alert_count++;
        $('label[for=second_name]').css({color:'red'});
        flag="false";
        }
}
if($('#second_name').val()!='')
{
        regex=/^[a-z]+$|^[A-Z]+$|^[A-Z]{1}[a-z]+$/
        if(regex.test(Second_name))
        {
                $('label[for=second_name]').css({color:'#333333'});
        }
} 
//To check the ASU ID of the student
if($('#asu_id').val()==='')
{
        alert_value+=alert_count+".) Please enter ASU ID\n\n";
	alert_count++;
	$('label[for=asu_id]').css({color:'red'});
	flag="false";
}
else
{
	
	regex=/^[0-9]{10,11}$/
	 if(!regex.test(Asu_id))
        {
	alert_value+=alert_count+".)Please enter the correct ASU-ID Number containing only numbers and ID being of 10 or 11 digits.\n\n";
        alert_count++;
        $('label[for=asu_id]').css({color:'red'});
        flag="false";
               // errors+=("Please enter correct ASU ID");
                //success = false;
        }
}
if($('#asu_id').val()!='')
{
        regex=/^[0-9]{10,11}$/
        if(regex.test(Asu_id))
        {
                $('label[for=asu_id]').css({color:'#333333'});
        }
} 

//To check if student has entered the ASURITE ID and has entered it correctly.
if($('#student_mail').val()==='')
{
        alert_value+=alert_count+".) Please enter ASU E-Mail ID\n\n";
        alert_count++;
        $('label[for=student_mail]').css({color:'red'});
        flag="false";
}
else
{
        
        regex=/^[a-z][a-z0-9]+?@asu.edu$/
         if(!regex.test(Student_mail))
        {
        alert_value+=alert_count+".)Please enter correct ASURITE ID (All small)\n\n";
        alert_count++;
        $('label[for=student_mail]').css({color:'red'});
        flag="false";
        }
}
if($('#student_mail').val()!='')
{
        regex=/^[a-z][a-z0-9]+?@asu.edu$/
        if(regex.test(Student_mail))
        {
                $('label[for=student_mail]').css({color:'#333333'});
        }
} 

//to check the Program Start Date.
if($('#prog_start_date').val()==='')
{
        alert_value+=alert_count+".) Please enter Program Start Date\n\n";
	alert_count++;
	$('label[for=prog_start_date]').css({color:'red'});
	flag="false";
}
else
{
	$('label[for=prog_start_date]').css({color:'#333333'});
}


//TO check is the Semester in progress has been entered correctly.
if($('#sem_in_prog option:selected').val()==-1)
{
        alert_value+=alert_count+".) Please enter Semester in Progress\n\n";
	alert_count++;
	$('label[for=sem_in_prog]').css({color:'red'});
	flag="false";
}
else
{
        $('label[for=sem_in_prog]').css({color:'#333333'});
}

//To check the cumulative GPA.
if($('#cum_gpa').val()==='')
{
        alert_value+=alert_count+".) Please enter CGPA\n\n";
        alert_count++;
	$('label[for=cum_gpa]').css({color:'red'});
	flag="false";
}
else
{
        regex=/^[0-3](\.[0-9]{1,9})?$|^4(\.?([0-2][0-9]?|3[0-3]?))$|^4$/
       if(!regex.test(Cum_gpa))
        {
                alert_value+=alert_count+".)Please enter CGPA <4.33\n\n";
                alert_count++;
                $('label[for=cum_gpa]').css({color:'red'});
                flag="false";
        }
}
if($('#cum_gpa').val()!='')
{
        regex=/^[0-3](\.[0-9]{1,9})?$|^4(\.?([0-2][0-9]?|3[0-3]?))$|^4$/
        if(regex.test(Cum_gpa))
        {
                $('label[for=cum_gpa]').css({color:'#333333'});
        }
} 

$.each($('#coursegrade_table_body tr'),function(i,tr){
    if($('.coursegrade'+i).find('.course').val()==='')
    {
         alert_value+=alert_count+".) Please enter Courses\n\n";
            alert_count++;
            $('label[for=course]').css({color:'red'});
            flag="false";
    }
    else
    {
        $('label[for=course]').css({color:'#333333'});
    }
});

//will need tis logic for everything
$.each($('#coursegrade_table_body tr'),function(i,tr){



        if($('.coursegrade'+i).find('.grade option:selected').val()==-1)
        {
                 alert_value+=alert_count+".) Please enter Grades\n\n";
                alert_count++;
                $('label[for=grade]').css({color:'red'});
                flag="false";
        }
        else
        {
                $('label[for=grade]').css({color:'#333333'});
        }
});


//Radio button Check to see if the Advisor Commitee has been formed.
if(!$("input:radio[class='advisory_committee']").is(":checked"))
{
        alert_value+=alert_count+".) Please check if Advisory Committee has been formed\n\n";
        alert_count++;
        $('label[for=advisory_committee]').css({color:'red'});
        flag="false";
}
else
{
	$('label[for=advisory_committee]').css({color:'#333333'});
}



//This is to check if the advisor column are succesfully filled on clicking yes.

if($("input:radio[id='advisory_committee_yes']").is(":checked"))
{
        $.each($('#advisor_table_body tr'),function(i,tr){

        if($('.signature'+i).find('.advisor_mail').val()===""){

                alert_value+=alert_count+".) Please enter the Advisor's Mail \n\n";
                alert_count++;
                $('label[for=advisor_mail]').css({color:'red'});
                flag="false";

        }
        else
        {
                $('label[for=advisor_mail]').css({color:'#333333'});
        }

/*
var regex=/^[A-Z,a-z,0-9]*@[a-z,A-Z]{2,}.[a-z,A-Z]{2,}$/;
var mail_check=$('.signature'+i).find('.advisor_mail').val();
	if(!regex.test(mail_check)){


                alert_value+=alert_count+".) Please enter the Advisor's Mail in the for example@aaa.bbb \n\n";
                alert_count++;
                $('label[for=advisor_mail]').css({color:'red'});
                flag="false";

        }
        else
        {
                $('label[for=advisor_mail]').css({color:'#333333'});
        }
*/

        if($('.signature'+i).find('.advisor_firstname').val()===""){

                alert_value+=alert_count+".) Please enter the Advisor's First Name \n\n";
                alert_count++;
                $('label[for=advisor_firstname').css({color:'red'});
                flag="false";
        }
        else
        {
                $('label[for=advisor_firstname]').css({color:'#333333'});
        }
        if($('.signature'+i).find('.advisor_secondname').val()===""){

        alert_value+=alert_count+".) Please enter the Advisor's Second Name \n\n";
        alert_count++;
        $('label[for=advisor_secondname]').css({color:'red'});
        flag="false";
        }
        else
        {
                $('label[for=advisor_secondname]').css({color:'#333333'});
        }



        });
}


//To check is radio button if have met advisor
if(!$("input:radio[class='met_advisor']").is(":checked"))//dependency 
{
        alert_value+=alert_count+".) Please check if You have met advisor\n\n";
        alert_count++;
        $('label[for=advisor]').css({color:'red'});
        flag="false";
}
else
{
        $('label[for=advisor]').css({color:'#333333'});
}

//To check if the Textbox for reason of not meeting the Chair has been mentioned if selected No.
if($("input:radio[class='met_advisor']:checked").val()==="0" && $("#advisory_committee_reason").val()==='' )
{
        alert_value+=alert_count+".) Please mention the reason for not having met the advisor\n\n";
        alert_count++;
        $('label[for=advisory_committee_reason]').css({color:'red'});
        flag="false";

}
else
{
        $('label[for=advisory_committee_reason]').css({color:'#333333'});
}




//This is for qualifying exam 

if(!$("input:radio[class='qualifying_exam']").is(":checked"))
{
        alert_value+=alert_count+".) Please check Qualfying Exam has been given\n\n";
        alert_count++;
        $('label[for=qualifying_exam]').css({color:'red'});
        flag="false";
}
else
{
        $('label[for=qualifying_exam]').css({color:'#333333'});
}


//Qualifying Exam details Course Validation
$.each($('#qualifying_table_body'+token+' tr'),function(i,tr){
    if($('.qualifyingexam'+token+'-'+i).find('.qualifying_details option:selected').val()=="")
    {
         alert_value+=alert_count+".) Please enter Qualifying Exams\n\n";
            alert_count++;
            $('label[for=qualifying_details]').css({color:'red'});
            flag="false";
    }
    else
    {
        $('label[for=qualifying_details]').css({color:'#333333'});
    }
});

//Qualifying Exam details Grade Validation
$.each($('#qualifying_table_body'+token+' tr'),function(i,tr){
    if($('.qualifyingexam'+token+'-'+i).find('.qualifying_grades option:selected').val()==-1)
    {
         alert_value+=alert_count+".) Please enter Grades for Qualifying Exams\n\n";
            alert_count++;
            $('label[for=qualifying_grades]').css({color:'red'});
            flag="false";
    }
    else
    {
        $('label[for=qualifying_grades]').css({color:'#333333'});
    }
});

//To check if written comprehensive has been Completed

if(!$("input:radio[name='comprehensive_exam']").is(":checked"))
{
        alert_value+=alert_count+".) Please check if Written Comprehensive Exam has been Selected\n\n";
        alert_count++;
        $('label[for=comprehensive_exam]').css({color:'red'});
        flag="false";
}
else
{
        $('label[for=comprehensive_exam]').css({color:'#333333'});
}

//written comprehensive details need to be added similar to grade and course

if($("input:radio[id='comprehensive_exam_yes']").is(":checked")){

    $.each($('#written_table_body tr'),function(i,tr){
        if($('.writtenexam'+i).find('.written_comprehensive').val()==='')
        {
             alert_value+=alert_count+".) Please enter Written comprehensive Exams\n\n";
                alert_count++;
                $('label[for=written_comprehensive]').css({color:'red'});
                flag="false";
        }
        else
        {
            $('label[for=written_comprehensive]').css({color:'#333333'});
        }
    });

}


/*
//will need tis logic for everything
$.each($('#written_table_body tr'),function(i,tr){

        if($('.writtenexam'+i).find('.written_grades option:selected').val()==-1)
        {
                 alert_value+=alert_count+".) Please enter Grades for Written Comprehensive\n\n";
                alert_count++;
                $('label[for=written_grades]').css({color:'red'});
                flag="false";
        }
        else
        {
                $('label[for=written_grades]').css({color:'#333333'});
        }
});
*/
//Validation Oral comprehensive
if(!$("input:radio[id='oral_comprehensive_exam']").is(":checked"))
{
        alert_value+=alert_count+".) Please check if Oral Comprehensive Completed\n\n";
        alert_count++;
    $('label[for=oral_comprehensive_exam]').css({color:'red'});
    flag="false";
}
else
{
        $('label[for=oral_comprehensive_exam]').css({color:'#333333'});
}



if(!$("input:radio[class='colloquium']").is(":checked"))
{
        alert_value+=alert_count+".) Please check Colloquium Lectures attended\n\n";
        alert_count++;
    $('label[for=colloquium]').css({color:'red'});
    flag="false";
}
else
{
        $('label[for=colloquium]').css({color:'#333333'});
}

//This will need changes.

if($("input:radio[id='colloquium_yes']").is(":checked") && !$("input:checkbox[id='colloquium_reason']").is(":checked"))
{
        alert_value+=alert_count+".) Please Enter the number of colloquium lectures attended\n\n";
        alert_count++;
        $('label[for=colloquium_reason]').css({color:'red'});
        flag="false";

}
else
{
        $('label[for=colloquium_reason]').css({color:'#333333'});
}

//the dependency wont be needed as they have to select from dropdown
/*
if($("input:radio[class='qualifying_exam']:checked").val()==="1" && $('.qualifying_details').val()==='' )
{
        alert_value+=alert_count+".) Please mention the Qualifying Exam Subjects\n\n";
        alert_count++;
        $('label[for=qualifying_details]').css({color:'red'});
        flag="false";

}
else
{
        $('label[for=qualifying_details]').css({color:'#333333'});
}
*/

if($('.current_goal').val()==='')
{
        alert_value+=alert_count+".) Please enter Current goals\n\n";
        alert_count++;
        $('label[for=current_goal]').css({color:'red'});
        flag="false";
}
else
{
        $('label[for=current_goal]').css({color:'#333333'});
}

if($('.publication').val()==='')
{
        alert_value+=alert_count+".) Please enter Publications\n\n";
        alert_count++;
        $('label[for=publication]').css({color:'red'});
        flag="false";
}
else
{
        $('label[for=publication]').css({color:'#333333'});
}



if($('.presentation').val()==='')
{
        alert_value+=alert_count+".) Please enter Presentations\n\n";
        alert_count++;
	$('label[for=presentation]').css({color:'red'});
	flag="false";
}
else
{
        $('label[for=presentation]').css({color:'#333333'});
}


/*
$.each($('#coursegrade_table_body tr'),function(i,tr){
        if($('.coursegrade'+i).find('.grade').val()!='' && $('.coursegrade'+i).find('.course').val()!='' && $('.coursegrade'+(i+1)).find('.grade').val()==='' && $('.coursegrade'+(i+1)).find('.course').val()==='')
        {
                 alert_value+=alert_count+".) If grades are entered please remove the additional row added.\n\n";
                alert_count++;
                flag="false";
     	}

});
*/



if($('.future_goal').val()==='')
{
        alert_value+=alert_count+".) Please enter Future goals\n\n";
        alert_count++;
        $('label[for=future_goal]').css({color:'red'});
        flag="false";
}
else
{
        $('label[for=future_goal]').css({color:'#333333'});
}



//Check for the file being submitted.
if(document.getElementById("file").value == "")
{
        alert_value+=alert_count+".) Please upload the iPOS\n\n";
        alert_count++;
        $('label[for=file]').css({color:'red'});
        flag="false";
}
else
{
        $('label[for=file]').css({color:'#333333'});
}


if(!$("input:checkbox[id='certify']").is(":checked"))
{
	alert("Please certify your information for submitting the form");
	flag="false";
}
else
{
        $('label[for=certify]').css({color:'#333333'});
}

/*When all the conditions for the form is met then 
the flag will be set to true and will take in all the values from the form*/
if(flag=="true" )
{
    var Main_advisor= "Jennifer.May@asu.edu";
    //var Main_advisor = "aiyangar@asu.edu";
	
    if($("input:radio[id='advisory_committee_yes']").is(":checked"))
    {
        var Advisor_Position=jQuery.makeArray();
        var Advisor_Firstname=jQuery.makeArray();
        var Advisor_Secondname=jQuery.makeArray();
        var Advisor_Mail=jQuery.makeArray();
        $.each($('#advisor_table_body tr'),function(i,tr){

        Advisor_Position[i]=$('.signature'+i).find('.advisor_member').val();
        Advisor_Firstname[i]=$('.signature'+i).find('.advisor_firstname').val();
        Advisor_Secondname[i]=$('.signature'+i).find('.advisor_secondname').val();
        Advisor_Mail[i]=$('.signature'+i).find('.advisor_mail').val();
         });

    }

    //Saving the Course and Grade details in array
    var Course=jQuery.makeArray();
    var Grade=jQuery.makeArray();
    $.each($('#coursegrade_table_body tr'),function(i,tr){
        
        Course[i]=$('.coursegrade'+i).find('.course').val();
        Grade[i]=$('.coursegrade'+i).find('.grade').val();
    });

    //Getting all the Advisor Mails to send them mails respectively
    var Mail=jQuery.makeArray();
    $.each($('#advisor_table_body tr'),function(i,tr){
        if($('.signature'+i).find('.advisor_mail').val()===$('.signature'+i).find('.advisor_remail').val()){

        	Mail[i]=$('.signature'+i).find('.advisor_mail').val();

        }
    });


    //Saving all the Qualifying details in resp arrays
    var Qualifying_Subjects=jQuery.makeArray();
    var Qualifying_Grades=jQuery.makeArray();
    $.each($('#qualifying_table_body'+token+' tr'),function(i,tr){
       
        Qualifying_Subjects[i]=$('.qualifyingexam'+token+'-'+i).find('.qualifying_details option:selected').val();
        Qualifying_Grades[i]=$('.qualifyingexam'+token+'-'+i).find('.qualifying_grades option:selected').val();
    });


    //Saving all the Written Exam Details in resp arrays
    var Written_Subjects=jQuery.makeArray();
    var Written_Grades=jQuery.makeArray();
    $.each($('#written_table_body tr'),function(i,tr){
        
        Written_Subjects[i]=$('.writtenexam'+i).find('.written_comprehensive').val();
        Written_Grades[i]=$('.writtenexam'+i).find('.written_grades').val();
    });

    //Saving Publication in resp array
    var Publication=jQuery.makeArray();
    $.each($('.publication'),function(){
        Publication.push($(this).val());

    });

    //Saving Colloquium semster details in resp array
    var Colloquium_Semester=jQuery.makeArray();
    $.each($('input[id="colloquium_reason"]:checked'),function(){
        Colloquium_Semester.push($(this).val());
    });


    //Saving Presentation details in resp array
    var Presentation=jQuery.makeArray();
    $.each($('.presentation'),function(){
        Presentation.push($(this).val());
    });


    //Saving current goal details in resp array
    var Current_goal=jQuery.makeArray();
    $.each($('.current_goal'),function(){
        Current_goal.push($(this).val());
    });


    //Saving future goal details in resp array
    var Future_goal=jQuery.makeArray();
    $.each($('.future_goal'),function(){

    Future_goal.push($(this).val());

    });

var Asurite=$('#student_mail').val();

    var fd = new FormData(),

    File = document.getElementById("file").files[0];
    fd.append( 'file',  File);
    fd.append('degree_select',Degree_select);
    fd.append('academic_year',Academic_year);
    fd.append('written_subjects',JSON.stringify(Written_Subjects));
    fd.append('written_grades',JSON.stringify(Written_Grades));
    fd.append('publication',JSON.stringify(Publication));
    fd.append('presentation',JSON.stringify(Presentation));
    fd.append('advisor_position',JSON.stringify(Advisor_Position));
    fd.append('advisor_firstname',JSON.stringify(Advisor_Firstname));
    fd.append('advisor_secondname',JSON.stringify(Advisor_Secondname));
    fd.append('advisor_mail',JSON.stringify(Advisor_Mail));
    fd.append('mail',JSON.stringify(Mail));
    fd.append('course',JSON.stringify(Course));
    fd.append('grade',JSON.stringify(Grade));
    fd.append('qualifying_subjects',JSON.stringify(Qualifying_Subjects));
    fd.append('qualifying_grades',JSON.stringify(Qualifying_Grades));
    fd.append('current_goal',JSON.stringify(Current_goal));
    fd.append('future_goal',JSON.stringify(Future_goal));
    fd.append('colloquium_semester',JSON.stringify(Colloquium_Semester));
    fd.append('first_name',First_name);
    fd.append('second_name',Second_name);
    fd.append('asu_id',Asu_id);
    fd.append('asurite',Asurite);
    fd.append('student_mail',Student_mail);
    fd.append('prog_start_date',Prog_start_date);
    fd.append('sem_in_prog',Sem_in_prog);
    fd.append('cum_gpa',Cum_gpa);
    fd.append('advisory_committee',Advisory_committee);
    fd.append('main_advisor',Main_advisor);
    fd.append('met_advisor',Met_advisor);
    fd.append('advisory_committee_reason',Advisory_committee_reason);
    fd.append('comprehensive_exam',Comprehensive_exam);
    fd.append('oral_comprehensive_exam',Oral_comprehensive_exam);
    fd.append('qualifying_exam',Qualifying_exam);
    fd.append('colloquium',Colloquium);
    

    fd.append('extra',Extra);
    $.ajax({
        type: "POST",
        url: "./data1.php",
        data:fd,
        processData: false,
        contentType: false,
        success:function(data){
        alert("Wow!! You have submitted the form which will be auto-reviewed and if everything looks fine you should receive an e-mail. Please make sure that you receive an mail on your ASURITE mail id. If you do not receive a mail in that case you have missed out on something and need to reach out to the Graduate Co-ordinator for further assistance.");
        
        redirect();	
        },
	error:function(exception){
	console.log('Exception: '+exception);
	alert('Exeption:'+exception);
	}
    });

}
else
{
alert(alert_value);
}

});
});

function redirect(){
	window.location="https://pi.asu.edu/somss/studentform.php";
}

