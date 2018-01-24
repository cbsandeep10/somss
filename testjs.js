$(function(){

    //GET ACADEMIC YEAR
    var d = new Date();
    console.log(d);
    var month=d.getMonth();
    if(month<7){
        var year = d.getFullYear();
        $("#academic_year_fall").val(year-1);
        $("#academic_year_spring").val(year);
    }
    else{
        var year = d.getFullYear();
        $("#academic_year_fall").val(year);
        $("#academic_year_spring").val(year+1);
    }

	//SHOW CALENDAR
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
    
    //$(".help_current_goal").tooltip();

});

function getRowIndex(value, row, index){
	return index + 1;
}

//Template for Courses table

//Previous Year courses
function setCourseTableTemplate_PY(){

var options = {
    columns: [{
    	width: 36,
    	formatter: getRowIndex,
    	searchable: false,
    },	{
    	field: "courseUniqueID_PY",
    	visible: false,
    },	{
        field: "course_PY",
        title: "Course",
        align: 'center',
        searchable: false,
    }, {
        field: "grade_PY",
        title: "Grade",
        align: 'center',
        searchable: false,
    }],
    formatNoMatches: function () {
        return 'No Courses exist';
    },
    data: []
};

$('#coursesTable_PY').bootstrapTable(options);
}

//Populate Courses Table for previous years
function AddCourses_PY(Course_details_PY, Grade_details_PY){
	console.log("ABCDEFGH");
	console.log(Course_details_PY);
	if(Course_details_PY == null || Grade_details_PY == "")
		return;

	//JSON object to store courses and their respective grades
	var rows = [];

	for(var i = 0; i < Course_details_PY.length; i++){
		var row = {'courseUniqueID_PY':i + 1, 'course_PY':Course_details_PY[i], 'grade_PY':Grade_details_PY[i]};
		rows.push(row);
	}
	
	//Populate Courses table with values in 'rows' object
	var options = $("#coursesTable_PY").bootstrapTable('getOptions');
	options["data"] = rows;
	$('#coursesTable_PY').bootstrapTable('refreshOptions',{'data' : options["data"]});
	
}

//Current Year Courses
function setCourseTableTemplate(){

var options = {
    columns: [{
    	field: "selectBoxCourse",
    	checkbox: true,
    	searchable: false,
    },	{
    	
    	width: 36,
    	formatter: getRowIndex,
    	searchable: false,
    },	{
    	field: "courseUniqueID",
    	visible: false,
    },	{
        field: "course",
        title: "Course<span class='glyphicon glyphicon-info-sign help_current_goal'></span><sup class='star'>*</sup>",
        titleTooltip: "Courses taken since last progress with grades",
        align: 'center',
        editable: {
        	type: 'text',
        	mode: 'inline',
        },
        searchable: false,
    }, {
        field: "grade",
        title: "Grade<sup class='star'>*</sup>",
        align: 'center',
        editable: {
        	type: 'select',
        	source: [
        		{value:'A+', text:'A+'},
        		{value:'A', text:'A'},
        		{value:'A-', text:'A-'},
        		{value:'B+', text:'B+'},
        		{value:'B', text:'B'},
        		{value:'B-', text:'B-'},
        		{value:'C+', text:'C+'},
        		{value:'C', text:'C'},
        		{value:'D', text:'D'},
        		{value:'E', text:'E'},
        		{value:'EN', text:'EN'},
        		{value:'I', text:'I'},
        		{value:'NR', text:'NR'},
        		{value:'P', text:'P'},
        		{value:'W', text:'W'},
        		{value:'X', text:'X'},
        		{value:'Y', text:'Y'},
        		{value:'Z', text:'Z'},
        		{value:'XE', text:'XE'}
        	],
       		mode: 'inline',
       		showbuttons: false,
        },
        searchable: false,
    }],
    formatNoMatches: function () {
        return 'Please add Course(s)';
    },
    data: []
};

$('#coursesTable').bootstrapTable(options);
}

//Populate Courses table
function AddCourses(Course_details, Grade_details){

	if(Course_details == null || Course_details == "")
		return;

	//JSON object to store courses and their respective grades
	var rows = [];

	for(var i = 0; i < Course_details.length; i++){
		var row = {'courseUniqueID':i + 1, 'course':Course_details[i], 'grade':Grade_details[i]};
		rows.push(row);
	}
	
	//Populate Courses table with values in 'rows' object
	var options = $("#coursesTable").bootstrapTable('getOptions');
	options["data"] = rows;
	$('#coursesTable').bootstrapTable('refreshOptions',{'data' : options["data"]});
	
}

//Add row to Courses table
function addCourseRow(){
	var courseName = $("#courseTitle").val().trim();
	var grade = $("#courseGrade").val();
	
	//INPUT VALIDATION
	$("#courseTitleAlertDiv").hide();
	$("#courseGradeAlertDiv").hide();
	var alertFlag = false;
	
	if(courseName == ""){
		$("#courseTitleAlertDiv").show();
		$("#courseTitleAlertMsg").text("Please enter a Course");
		alertFlag = true;
	}
	
	if(grade == null){
		$("#courseGradeAlertDiv").show();
		$("#courseGradeAlertMsg").text("Please select a Grade");
		alertFlag = true;
	}
	
	if(alertFlag){
		return false;
	}
	/**VALIDATION OVER**/
	
	$("#courseTableAlertDiv").hide();
	
	//Generate unique id for the row
	var total_rows = $("#coursesTable").bootstrapTable('getData').length;
	var unique_id;
	if(total_rows > 0)
		unique_id = $("#coursesTable").bootstrapTable('getData')[total_rows-1].courseUniqueID + 1;
	else
		unique_id = 1;
	
	
	var row_data = {'courseUniqueID':unique_id, 'course': courseName, 'grade': grade};
	//$("#coursesTable").bootstrapTable('append',row_data);
	$("#coursesTable").bootstrapTable('insertRow', {
		index: unique_id,
		row: row_data
	});

	//reset form inputs
	$("#courseTitle").val("");
	$("#courseGrade").val("-1");
	
	$("#addCourseModal").modal("toggle");
}

//Remove row(s) from Courses table
function removeCourseRow(){
	
	var course_IDs = $.map($("#coursesTable").bootstrapTable('getSelections'), function (row) {
		return row.courseUniqueID;
	});
    $("#coursesTable").bootstrapTable('remove', {
        field: 'courseUniqueID',
        values: course_IDs
    });
}


//Function for changes in Yes-No radiobutton for 'Advisory Committee Formed?'
function AdvisoryCommitteeFormed(){
	
	$("#advisorCommitteeAlertDiv").hide();
	
	if($("#advisory_committee_yes").is(':checked')){
		$("#advisor_member_div").show();
	}
	else if($("#advisory_committee_no").is(':checked')){
		//$("#advisory_committee_no").prop('checked',true);
		$("#advisor_member_div").hide();
		$("#advisorTableAlertDiv").hide();
	}

}

//Template for Advisors table
function setAdvisorTableTemplate(){
	
	var options = {
    columns: [{
    	field: "selectBoxAdvisor",
    	checkbox: true,
    
    }, {
    	width: 36,
    	formatter: getRowIndex,
    	
    },	{
    	field: "advisorUniqueID",
    	visible: false,
    	
    },	{
    	field: "advisorType",
    	title: "Chair/Co-Chair/Member",
    	align: 'center',
    	editable: {
    		type: 'select',
    		source: [
    			{value:'CHAIR', text:'CHAIR'},
    			{value:'CO-CHAIR', text:'CO-CHAIR'},
    			{value:'MEMBER', text:'MEMBER'}
    		],
    		mode: 'inline',
    		showbuttons: false,
    	},
    },{
        field: "advisorFirstName",
        title: "First Name",
        align: 'center',
        editable: {
        	type: 'text',
        	mode: 'inline',
        },
    }, {
        field: "advisorLastName",
        title: "Last Name",
        align: 'center',
        editable: {
        	type: 'text',
        	mode: 'inline',
        },
    },{
        field: "advisorEmailID",
        title: "E-mail ID",
        align: 'center',
        editable: {
        	type: 'text',
        	mode: 'inline',
        },
    }],
    formatNoMatches: function () {
        return 'Please add Advisor(s)';
    },
    data: []
};

$('#advisorTable').bootstrapTable(options);

}

//Populate Advisors table
function AddAdvisors(position,firstname,lastname,email_id){
	
	//Initialize tooltip for 'No' radiobutton
	$('input[rel="advCommTooltip"]').tooltip();
	
	if(position == null || position == ""){
		//$("#advisory_committee_no").prop("disabled",false);
		console.log("hello");
		$('input[rel="advCommTooltip"]').tooltip("destroy");
		return;
	}

	if(email_id == null || email_id == ""){
		email_id = [];
		for(var i = 0;i < position.length; i++){
			email_id.push('gravetka@asu.edu');
		}
	}

	$("#advisory_committee_no").prop("disabled",true);
	$("#advisor_member_div").show();

	//JSON object to store advisor information
	var rows = [];

	for(var i = 0; i < position.length; i++){
		var row = {'advisorUniqueID':i + 1, 'advisorType':position[i], 'advisorFirstName':firstname[i], 'advisorLastName':lastname[i],'advisorEmailID': email_id[i]};
		rows.push(row);
	}

	//Populate Advisors table with values in 'rows' object
	var options = $("#advisorTable").bootstrapTable('getOptions');
	options["data"] = rows;
	$('#advisorTable').bootstrapTable('refreshOptions',{'data' : options["data"]});

}

//Add row to Advisors table
function addAdvisorRow(){
	var position = $("#advisorModalPosition").val();
	var first_name = $("#advisorModalFName").val().trim();
	var last_name = $("#advisorModalLName").val().trim();
	var emailID = $("#advisorModalEmailID").val().trim();
	var confirmEmailID = $("#advisorModalConfirmEmailID").val().trim();
	
	//INPUT VALIDATION
	$("#advisorPositionAlertDiv").hide();
	$("#advisorFNameAlertDiv").hide();
	$("#advisorLNameAlertDiv").hide();
	$("#advisorEmailIDAlertDiv").hide();
	$("#advisorConfirmEmailIDAlertDiv").hide();
	var alertFlag = false;
	
	if(position == null){
		$("#advisorPositionAlertDiv").show();
		$("#advisorPositionAlertMsg").text("Please select a Position");
		alertFlag = true;
	}
	if(first_name == ""){
		$("#advisorFNameAlertDiv").show();
		$("#advisorFNameAlertMsg").text("Please enter Advisor's First Name");
		alertFlag = true;
	}
	if(last_name == ""){
		$("#advisorLNameAlertDiv").show();
		$("#advisorLNameAlertMsg").text("Please enter Advisor's Last Name");
		alertFlag = true;
	}
	
	var email_regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
	if(emailID == ""){
		$("#advisorEmailIDAlertDiv").show();
		$("#advisorEmailIDAlertMsg").text("Please enter Advisor's Email ID");
		alertFlag = true;
	}
	else if(!email_regex.test(emailID)){
		$("#advisorEmailIDAlertDiv").show();
		$("#advisorEmailIDAlertMsg").text("Please enter a valid Email ID (abc@pqr.xyz)");
		alertFlag = true;
	}
	else if(emailID != confirmEmailID){
		$("#advisorConfirmEmailIDAlertDiv").show();
		$("#advisorConfirmEmailIDAlertMsg").text("Email ID's do not match");
		alertFlag = true;
	}
	
	if(alertFlag){
		return false;
	}
	/**VALIDATION OVER**/
	
	//Generate unique id for the row
	var total_rows = $("#advisorTable").bootstrapTable('getData').length;
	var unique_id;
	if(total_rows > 0)
		unique_id = $("#advisorTable").bootstrapTable('getData')[total_rows-1].advisorUniqueID + 1;
	else
		unique_id = 1;
	
	var row_data = {'advisorUniqueID':unique_id, 'advisorType': position, 'advisorFirstName': first_name, 'advisorLastName': last_name, 'advisorEmailID': emailID};
	$("#advisorTable").bootstrapTable('append',row_data);
	
	//reset form inputs
	$("#advisorModalFName").val("");
	$("#advisorModalLName").val("");
	$("#advisorModalEmailID").val("");
	$("#advisorModalConfirmEmailID").val("")
	$("#advisorModalPosition").val("-1");
	
	$("#advisory_committee_no").prop("disabled",true);
	$('input[rel="advCommTooltip"]').tooltip();
	$("#addAdvisorModal").modal("toggle");
}

//Remove row(s) from Advisors table
function removeAdvisorRow(){
	var advisor_IDs = $.map($("#advisorTable").bootstrapTable('getSelections'), function (row) {
		return row.advisorUniqueID;
	});
	
    $("#advisorTable").bootstrapTable('remove', {
        field: 'advisorUniqueID',
        values: advisor_IDs
    });
    
    var rowcount = $('#advisorTable').bootstrapTable('getData').length;
   
    if(rowcount == 0){
    	$("#advisory_committee_no").prop("disabled",false);
    	$('input[rel="advCommTooltip"]').tooltip("destroy");
    }
}

//Function for changes in Yes-No radiobutton for 'Student met Chair for current academic year?'
function ChairMet(not_met_reason){
	/*
	if ($("#committee_formed_no").is(':checked')) {
		$("#NotMetChairReason_div").show();
		if(not_met_reason != "The Student met the advisory committee")
			$('#chair_notmet_reason').val(not_met_reason);
	}
	else{
		$("#advisory_committee_no").prop('checked',true);
		$('#NotMetChairReason_div').hide();
		$('#chair_notmet_reason').val("");
	}
	*/
	$("#chairNotMetAlertDiv").hide();
	
	if($("#committee_formed_yes").is(':checked')){
		$('#NotMetChairReason_div').hide();
		$('#chair_notmet_reason').val("");
		$("#chairNotMetReasonAlertDiv").hide();
	}
	else if($("#committee_formed_no").is(':checked')){
		//$("#committee_formed_no").prop('checked',true);
		$("#NotMetChairReason_div").show();
		if(not_met_reason != "The Student met the advisory committee")
			$('#chair_notmet_reason').val(not_met_reason);
	}

}

//Previous Years Qualifying Subjects

//Template for qualifying subjects table
function setQualifyingExamTableTemplate_PY(){

	var options = {
		columns: [{
			width: 36,
			formatter: getRowIndex,
			
		},	{
			field: "qualSubUniqueID_PY",
			visible: false,
			
    	},	{
		    field: "qualifyingSubject_PY",
		    title: "Qualifying Exam Subject",
		    align: 'center',
		}, {
		    field: "qualifyingSubjectGrade_PY",
		    title: "Grade",
		    align: 'center',
		}],
		formatNoMatches: function () {
        	return 'No Subjects Exist';
    	},
		data: []
	};
	
	$('#qualifying_subject_table_PY').bootstrapTable(options);
	
}

//Populate qualifying subjects table
function AddQualifyingSubjects_PY(qual_subjects_PY, qual_grades_PY){
	
	if(qual_subjects_PY == null || qual_subjects_PY == ""){
		return;
	}
	
	//JSON object to store subjects and their respective grades
	var rows = [];
	
	for(var i = 0; i < qual_subjects_PY.length; i++){
		var row = {'qualSubUniqueID_PY':i + 1, 'qualifyingSubject_PY':qual_subjects_PY[i], 'qualifyingSubjectGrade_PY':qual_grades_PY[i]};
		rows.push(row);
	}
	
	$("#qualifying_subject_table_PY").bootstrapTable('refreshOptions', {'data' : rows})
}

//Current Year Qualifying Subjects

//Template for qualifying subjects table
function setQualifyingExamTableTemplate(){

	var options = {
		columns: [{
			field: "selectBoxQualifyingExam",
			checkbox: true,
		
		}, 	{
    	
			width: 36,
			formatter: getRowIndex,
			
		},	{
			field: "qualSubUniqueID",
			visible: false,
			
    	},	{
		    field: "qualifyingSubject",
		    title: "Qualifying Exam Subject",
		    align: 'center',
		    editable: {
		    	type: 'select',
		    	source: [],
		    	mode: 'inline',
		    	showbuttons: false,
		    },
		}, {
		    field: "qualifyingSubjectGrade",
		    title: "Grade",
		    align: 'center',
		    editable: {
		    	type: 'select',
		    	source: [],
		   		mode: 'inline',
		   		showbuttons: false,
		    },
		}],
		formatNoMatches: function () {
        	return 'Please add Subject(s)';
    	},
		data: []
	};
	
	$('#qualifying_subject_table').bootstrapTable(options);
	
}

//change qualifying subjects according to degree program
function resetQualifyingExamTable(degree_program){

	if(degree_program == null)
		return;

	var grades = ['A+','A','A-','B+','B','B-','C+','C','D','E','EN','I','NR','P','W','X','Y','Z','XE'];

	var grades1 = ['MS Pass','PhD Pass','Fail'];

	//Lists of subjects according to degree program selected

	var applied_math_subjects = ['APM 501 Differential Equations I','APM 502 Differential Equations II','APM 503 Applied Analysis','APM 504 Applied Probability','APM 505 Applied and Numerical Linear Algebra','APM 506 Scientific Computing'];

	var math_subjects = ['Algebra','Real Analysis','Discrete Mathematics','Geometry/Topology'];

	var math_education_subjects = ['MTE 598: Topic - Research in Undergraduate Math Education I','MTE 598: Topic - Research in Undergraduate Math Education II','APM 501 Differential Equations I','APM 502 Differential Equations II','APM 503 Applied Analysis','APM 504 Applied Probability','APM 505 Applied and Numerical Linear Algebra','APM 506 Scientific Computing','AML 610 Topics in Applied Mathematics for the Life and Social Sciences','APM 531 Mathematical Neurosciences I','AML 612 Applied Mathematics for the Life and social Sciences Modeling Seminar','AML 613 Probability and Stochastic Modeling for the Life and Social Sciences','MAT 512 Discrete Mathematics I','MAT 513 Discrete Mathematics II','MAT 516 Graph Theory I','MAT 517 Graph Theory II','MAT 543 Algebra I','MAT 544 Algebra II','MAT 570 Real Analysis I','MAT 571 Real Analysis II','STP 501 Theory of Statistics 1','STP 502 Theory of Statistics 2','STP 525 Advance Probability','STP 526 Theory of Statistical Linear Model','STP 527 Statistical Large Sample Theory','STP 530 Applied Regression Analysis','STP 531 Applied Analysis of Variance','STP 532 Applied Nonparametric Statistics','STP 533 Applied Multivariable Analysis','STP 535 Applied Sampling Methodology'];

	var stats_subjects = ['STP 501/502 Theory of Statistics','MAT 570 Real Analysis I/MAT 571 Real Analysis II','APM 503 Applied Analysis/APM 504 Applied Probability'];

	var qualSubList = [];
	var gradeList = [];

	//Options for Add Qualifying Subject modal
	var qualSubListModal = [];
	var gradeListModal = [];

	if(degree_program == 'Applied Mathematics'){
		for(var i =0; i < applied_math_subjects.length; i++){
			var qualSub = {'value':applied_math_subjects[i], 'text':applied_math_subjects[i]};
			qualSubList.push(qualSub);
			qualSub = {'id':applied_math_subjects[i], 'text':applied_math_subjects[i]};
			qualSubListModal.push(qualSub);
		}
	
		for(var i = 0; i < grades.length; i++){
			var grade = {'value':grades[i], 'text':grades[i]};
			gradeList.push(grade);
			grade = {'id':grades[i], 'text':grades[i]};
			gradeListModal.push(grade);
		}
	}
	else if(degree_program == 'Mathematics'){
		for(var i =0; i < math_subjects.length; i++){
			var qualSub = {'value':math_subjects[i], 'text':math_subjects[i]};
			qualSubList.push(qualSub);
			qualSub = {'id':math_subjects[i], 'text':math_subjects[i]};
			qualSubListModal.push(qualSub);
		}
	
		for(var i = 0; i < grades1.length; i++){
			var grade = {'value':grades1[i], 'text':grades1[i]};
			gradeList.push(grade);
			grade = {'id':grades1[i], 'text':grades1[i]};
			gradeListModal.push(grade);		
		}
	}
	else if(degree_program == 'Mathematics Education'){
		for(var i =0; i < math_education_subjects.length; i++){
			var qualSub = {'value':math_education_subjects[i], 'text':math_education_subjects[i]};
			qualSubList.push(qualSub);
			qualSub = {'id':math_education_subjects[i], 'text':math_education_subjects[i]};
			qualSubListModal.push(qualSub);
		}
	
		for(var i = 0; i < grades1.length; i++){
			var grade = {'value':grades1[i], 'text':grades1[i]};
			gradeList.push(grade);
			grade = {'id':grades1[i], 'text':grades1[i]};
			gradeListModal.push(grade);
		}
	}
	else if(degree_program == 'Statistics'){
		for(var i =0; i < stats_subjects.length; i++){
			var qualSub = {'value':stats_subjects[i], 'text':stats_subjects[i]};
			qualSubList.push(qualSub);
			qualSub = {'id':stats_subjects[i], 'text':stats_subjects[i]};
			qualSubListModal.push(qualSub);
		}
	
		for(var i = 0; i < grades1.length; i++){
			var grade = {'value':grades1[i], 'text':grades1[i]};
			gradeList.push(grade);
			grade = {'id':grades1[i], 'text':grades1[i]};
			gradeListModal.push(grade);
		}
	}
	
	var options = $("#qualifying_subject_table").bootstrapTable('getOptions');
	//console.log(options);
	options['columns'][0][3]['editable']['source'] = qualSubList;
	options['columns'][0][4]['editable']['source'] = gradeList;


	$("#qualifying_subject_table").bootstrapTable('refreshOptions', {'columns' : options['columns']})
	options = $("#qualifying_subject_table").bootstrapTable('getOptions');
	console.log(options);

	//Set options for Add Qualifying Subject modal
	
	$('#selectQualSubject').empty();
	$('#selectQualSubject').append("<option disabled selected value='-1'> Please select a subject</option>");
	$("#selectQualSubject").select2({
		data: qualSubListModal
	});
	
	$('#selectQualGrade').empty();
	$('#selectQualGrade').append("<option disabled selected value='-1'> Please select a grade</option>");
	$("#selectQualGrade").select2({
		data: gradeListModal
	});


}

//Change qualifying subjects when degree program is changed
function onDegreeProgramChange(initial_degree_program, qual_subjects, qual_grades){
	
	var selected_degree_pgm = $("#degree_select").val();
	
	//Remove data from Qualifying Subjects Table
	$("#qualifying_subject_table").bootstrapTable('removeAll');
	$("#exam_no").prop("disabled",false);
	
	resetQualifyingExamTable(selected_degree_pgm);
	
	if(initial_degree_program != null && selected_degree_pgm == initial_degree_program)
		AddQualifyingSubjects(qual_subjects, qual_grades);
}

//Populate qualifying subjects table
function AddQualifyingSubjects(qual_subjects, qual_grades){
	
	//Initialize tooltip for 'No' radiobutton
	$('input[rel="qualExamTooltip"]').tooltip();
	
	if(qual_subjects == null || qual_subjects == ""){
		$('input[rel="qualExamTooltip"]').tooltip("destroy");
		return;
	}
	
	$("#exam_no").prop("disabled",true);
	$("#qualifying_exam_subjects_div").show();
	
	//JSON object to store subjects and their respective grades
	var rows = [];
	
	for(var i = 0; i < qual_subjects.length; i++){
		var row = {'qualSubUniqueID':i + 1, 'qualifyingSubject':qual_subjects[i], 'qualifyingSubjectGrade':qual_grades[i]};
		rows.push(row);
	}
	
	//var options = $("#qualifying_subject_table").bootstrapTable('getOptions');
	//options["data"] = rows;	//Populate qualifying subjects table with values in 'rows' object
	$("#qualifying_subject_table").bootstrapTable('refreshOptions', {'data' : rows})
}

//Function for changes in Yes-No radiobutton for 'Qualifying Subjects Completed?'
function qualifyingExamTable(){
	
	$("#qualExamAlertDiv").hide();
	
	if($("#exam_yes").is(':checked')){
		if($("#degree_select").val() == null ){
			alert("Please select a degree program");
			$("#exam_yes").prop('checked',false);
			return;
		}
		$("#qualifying_exam_subjects_div").show();
	}
	else if($("#exam_no").is(':checked')){
		//$("#exam_no").prop('checked',true);
		$("#qualifying_exam_subjects_div").hide();
		$("#qualExamTableAlertDiv").hide();
	}
	
}


//Add row to Qualifying Subjects Table
function addQualSubjectRow(){
	var qualSubject = $("#selectQualSubject").val();
	var grade = $("#selectQualGrade").val();
	
	//INPUT VALIDATION
	$("#selectQualSubjectAlertDiv").hide();
	$("#selectQualGradeAlertDiv").hide();
	var alertFlag = false;
	
	if(qualSubject == null){
		$("#selectQualSubjectAlertDiv").show();
		$("#selectQualSubjectAlertMsg").text("Please select a Qualifying Subject");
		alertFlag = true;
	}
	
	if(grade == null){
		$("#selectQualGradeAlertDiv").show();
		$("#selectQualGradeAlertMsg").text("Please select a Grade");
		alertFlag = true;
	}
	
	if(alertFlag){
		return false;
	}
	/**VALIDATION OVER**/
	
	//ADD ROW TO TABLE
	
	$("#qualExamTableAlertDiv").hide();
	
	//Generate unique id for the row
	var total_rows = $("#qualifying_subject_table").bootstrapTable('getData').length;
	var unique_id;
	if(total_rows > 0)
		unique_id = $("#qualifying_subject_table").bootstrapTable('getData')[total_rows-1].qualSubUniqueID + 1;
	else
		unique_id = 1;
	
	var row_data = {'qualSubUniqueID':unique_id, 'qualifyingSubject':qualSubject, 'qualifyingSubjectGrade':grade};
	$("#qualifying_subject_table").bootstrapTable('append',row_data);
	
	//reset form inputs
	/*var formElement = $("#addCourseModal").find("form")[0].reset();
	console.log(formElement);*/
	$("#selectQualSubject").val('-1').change();
	$("#selectQualGrade").val("-1").change();
	
	//disable 'No' radiobutton if qualifying subjects have been added
	$("#exam_no").prop("disabled",true);
	$('input[rel="qualExamTooltip"]').tooltip();
	$("#addQualSubjectModal").modal('toggle');
}

//Remove row from Qualifying Subjects Table
function removeQualSubjectRow(){
	var qualSub_IDs = $.map($("#qualifying_subject_table").bootstrapTable('getSelections'), function (row) {
		return row.qualSubUniqueID;
	});
	
    $("#qualifying_subject_table").bootstrapTable('remove', {
        field: 'qualSubUniqueID',
        values: qualSub_IDs
    });
    
    var rowcount = $('#qualifying_subject_table').bootstrapTable('getData').length;
   
   	//enable 'No' radiobutton when no qualifying subjects exist in the table
    if(rowcount == 0){
    	 $('input[rel="qualExamTooltip"]').tooltip("destroy");
    	 $("#exam_no").prop("disabled",false);
    }
}


//Function for changes in Yes-No radiobutton for 'Written Comprehensive Exam Completed?'
function ComprehensiveExamCompleted(){

	$("#compExamAlertDiv").hide();

	if($("#comprehensive_exam_yes").is(':checked')){
		$("#comprehensive_exam_div").show();
	}
	else if($("#comprehensive_exam_no").is(':checked')){
		//$("#comprehensive_exam_no").prop('checked',true);
		$("#comprehensive_exam_div").hide();
		$("#compExamTableAlertDiv").hide();
	}
}


//Previous Year
//Template for ComprehensiveExam table
function setComprehensiveExamTableTemplate_PY(){

	var options = {
		columns: [{
			width: 36,
			formatter: getRowIndex,
			
		},	{
			field: "compExamUniqueID_PY",
			visible: false,
    	},	{
		    field: "comprehensiveExam_PY",
		    title: "Written Comprehensive Exam",
		    align: 'center',
		}, {
		    field: "compExamGrade_PY",
		    title: "Grade",
		    align: 'center',
		}],
		formatNoMatches: function () {
        	return 'No Comprehensive Exams exist';
    	},
		data: []
	};

	$('#comprehensiveExamTable_PY').bootstrapTable(options);

}

//Populate ComprehensiveExam table
function AddComprehensiveExams_PY(exam_list_PY, grade_list_PY){

	if(exam_list_PY == null || exam_list_PY == ""){
		return;
	}

	//JSON object to store exams and their respective grades
	var rows = [];

	for(var i = 0; i < exam_list.length; i++){
		var row = {'compExamUniqueID_PY':i + 1, 'comprehensiveExam_PY':exam_list_PY[i], 'compExamGrade_PY':grade_list_PY[i]};
		rows.push(row);
	}
	
	//Populate ComprehensiveExam table with values in 'rows' object
	var options = $("#comprehensiveExamTable_PY").bootstrapTable('getOptions');
	options["data"] = rows;
	$('#comprehensiveExamTable_PY').bootstrapTable('refreshOptions',{'data' : options["data"]});

}

//Current Year
//Template for ComprehensiveExam table
function setComprehensiveExamTableTemplate(){

	var options = {
		columns: [{
			field: "selectBoxComprehensiveExam",
			checkbox: true,
		
		}, 	{
			width: 36,
			formatter: getRowIndex,
			
		},	{
			field: "compExamUniqueID",
			visible: false,
			
    	},	{
		    field: "comprehensiveExam",
		    title: "Written Comprehensive Exam",
		    align: 'center',
		    editable: {
		    	type: 'text',
		    	mode: 'inline',
		    },
		}, {
		    field: "compExamGrade",
		    title: "Grade",
		    align: 'center',
		    editable: {
		    	type: 'select',
		    	source: [
		    		{value:'Pass', text:'Pass'},
		    		{value:'Fail', text:'Fail'}
		    	],
		   		mode: 'inline',
		   		showbuttons: false,
		    },
		}],
		formatNoMatches: function () {
        	return 'Please add Exam(s)';
    	},
		data: []
	};

	$('#comprehensiveExamTable').bootstrapTable(options);

}

//Populate ComprehensiveExam table
function AddComprehensiveExams(exam_list, grade_list){

	//Initialize tooltip for 'No' radiobutton
	$('input[rel="compExamTooltip"]').tooltip();

	if(exam_list == null || exam_list == ""){
		//$("#comprehensive_exam_no").prop("disabled",false);
		$('input[rel="compExamTooltip"]').tooltip("destroy");
		return;
	}

	$("#comprehensive_exam_no").prop("disabled",true);
	$("#comprehensive_exam_div").show();
	
	//JSON object to store exams and their respective grades
	var rows = [];

	for(var i = 0; i < exam_list.length; i++){
		var row = {'compExamUniqueID':i + 1, 'comprehensiveExam':exam_list[i], 'compExamGrade':grade_list[i]};
		rows.push(row);
	}
	
	//Populate ComprehensiveExam table with values in 'rows' object
	var options = $("#comprehensiveExamTable").bootstrapTable('getOptions');
	options["data"] = rows;
	$('#comprehensiveExamTable').bootstrapTable('refreshOptions',{'data' : options["data"]});

}


//Add row to Comprehensive Exam Table
function addComprehensiveExamRow(){
	var compSubject = $("#compSubjectTitle").val().trim();
	var grade = $("#compSubjectGrade").val();
	
	//INPUT VALIDATION
	$("#compSubjectAlertDiv").hide();
	$("#compSubjectGradeAlertDiv").hide();
	var alertFlag = false;
	
	if(compSubject == ""){
		$("#compSubjectAlertDiv").show();
		$("#compSubjectAlertMsg").text("Please enter a Subject");
		alertFlag = true;
	}
	
	if(grade == null){
		$("#compSubjectGradeAlertDiv").show();
		$("#compSubjectGradeAlertMsg").text("Please select a Grade");
		alertFlag = true;
	}
	
	if(alertFlag){
		return false;
	}
	/**VALIDATION OVER**/
	
	//ADD ROW TO TABLE
	
	$("#compExamTableAlertDiv").hide();
	
	//Generate unique id for the row
	var total_rows = $("#comprehensiveExamTable").bootstrapTable('getData').length;
	var unique_id;
	if(total_rows > 0)
		unique_id = $("#comprehensiveExamTable").bootstrapTable('getData')[total_rows-1].compExamUniqueID + 1;
	else
		unique_id = 1;
	
	var row_data = {'compExamUniqueID':unique_id, 'comprehensiveExam':compSubject, 'compExamGrade':grade};
	$("#comprehensiveExamTable").bootstrapTable('append',row_data);
	
	//reset form inputs
	$("#compSubjectTitle").val("");
	$("#compSubjectGrade").val("-1");
	
	//disable 'No' radiobutton if comprehensive exams have been added
	$("#comprehensive_exam_no").prop("disabled",true);
	$('input[rel="compExamTooltip"]').tooltip();
	$("#addCompExamModal").modal('toggle');
}


//Remove row(s) from Comprehensive Exam Table
function removeComprehensiveExamRow(){
	var compExam_IDs = $.map($("#comprehensiveExamTable").bootstrapTable('getSelections'), function (row) {
		return row.compExamUniqueID;
	});
	
    $("#comprehensiveExamTable").bootstrapTable('remove', {
        field: 'compExamUniqueID',
        values: compExam_IDs
    });
    
    var rowcount = $('#comprehensiveExamTable').bootstrapTable('getData').length;
   
   	//enable 'No' radiobutton when no comprehensive exams exist in the table
    if(rowcount == 0){
    	 $("#comprehensive_exam_no").prop("disabled",false);
    	 $('input[rel="compExamTooltip"]').tooltip("destroy");
    }
}


//Function for Disseration Prospectus
function dissertationProspectus(){
	$("#dissertationAlertDiv").hide();
}

//Function for changes in Yes-No radiobutton for 'Colloquium/Distinguished Lecture Series Attended?'
function Check_Colloquium_Attended(){

	$("#colloquiumAlertDiv").hide();
	
	if ($("#colloquium_yes").is(':checked')) {
		$("#colloquium_semester_div").show();
	}
	else if ($("#colloquium_no").is(':checked')){
		$('#colloquium_semester_div').hide();
		$("input[name='colloquium_semester']").attr('checked',false);
		$("#colloquiumSemesterAlertDiv").hide();
	}

}

//Colloquium Semesters oncheck
function colloquiumSemChange(checkbox){
	if(checkbox.checked)
		$("#colloquiumSemesterAlertDiv").hide();
}

//Previous Years
//Template for Current Goals table
function setCurrentGoalsTableTemplate_PY(){

var options = {
    columns: [{
    	width: 36,
    	formatter: getRowIndex,
    	
    },	{
    	field: "currentGoalUniqueID_PY",
    	visible: false,
    },	{
        field: "currentGoal_PY",
        title: "Current Accomplished Goals",
        align: 'center',
    }],
    formatNoMatches: function () {
        return 'No goals exist';
    },
    data: []
};

$('#currentGoalsTable_PY').bootstrapTable(options);

}

//Populate Current Goals table
function AddCurrentGoals_PY(current_goals_PY){

	if(current_goals_PY == null || current_goals_PY == ""){
		return;
	}
	
	//JSON object to store goals
	var rows = [];

	for(var i = 0; i < current_goals_PY.length; i++){
		var row = {'currentGoalUniqueID_PY':i + 1, 'currentGoal_PY': current_goals_PY[i]};
		rows.push(row);
	}
	
	//Populate Current Goals table with values in 'rows' object
	var options = $("#currentGoalsTable_PY").bootstrapTable('getOptions');
	options["data"] = rows;
	$('#currentGoalsTable_PY').bootstrapTable('refreshOptions',{'data' : options["data"]});

}

//Current Year
//Template for Current Goals table
function setCurrentGoalsTableTemplate(){

var options = {
    columns: [{
    	field: "selectBoxCurrentGoal",
    	checkbox: true,
    
    }, 	{
    	width: 36,
    	formatter: getRowIndex,
    	
    },	{
    	field: "currentGoalUniqueID",
    	visible: false,
    },	{
        field: "currentGoal",
        title: "Current Accomplished Goals<span class='glyphicon glyphicon-info-sign help_current_goal'></span><sup class='star'>*</sup>",
        titleTooltip: "Enter goals you thought were important and you completed them. eg: Completed Qualification Exam. Completed current thesis work",
        align: 'center',
        editable: {
        	type: 'text',
        	mode: 'inline',
        },
    }],
    formatNoMatches: function () {
        return 'Please add Goal(s)';
    },
    data: []
};

$('#currentGoalsTable').bootstrapTable(options);

}

//Populate Current Goals table
function AddCurrentGoals(current_goals){

	if(current_goals == null || current_goals == ""){
		return;
	}
	
	//JSON object to store goals
	var rows = [];

	for(var i = 0; i < current_goals.length; i++){
		var row = {'currentGoalUniqueID':i + 1, 'currentGoal': current_goals[i]};
		rows.push(row);
	}
	
	//Populate Current Goals table with values in 'rows' object
	var options = $("#currentGoalsTable").bootstrapTable('getOptions');
	options["data"] = rows;
	$('#currentGoalsTable').bootstrapTable('refreshOptions',{'data' : options["data"]});

}

//Add row to Current Goals Table
function addCurrentGoalRow(){
	
	var goal = $("#currentGoal").val().trim();
	
	//INPUT VALIDATION
	$("#addCurrentGoalAlertDiv").hide();
	alertFlag = false;
	if(goal == ""){
		$("#addCurrentGoalAlertDiv").show();
		$("#addCurrentGoalAlertMsg").text("Please enter a goal");
		alertFlag = true;
	}
	if(alertFlag == true)
		return false;
	/***VALIDATION OVER***/
	
	//ADD ROW TO TABLE
	
	$("#currentGoalsTableAlertDiv").hide();
	
	//Generate unique id for the row
	var total_rows = $("#currentGoalsTable").bootstrapTable('getData').length;
	var unique_id;
	if(total_rows > 0)
		unique_id = $("#currentGoalsTable").bootstrapTable('getData')[total_rows-1].currentGoalUniqueID + 1;
	else
		unique_id = 1;
	
	var row_data = {'currentGoalUniqueID':unique_id, 'currentGoal':goal};
	$("#currentGoalsTable").bootstrapTable('append',row_data);
	
	//reset form inputs
	$("#currentGoal").val("");
	$("#addCurrentGoalModal").modal('toggle');
}

//Remove row(s) from Current Goals Table
function removeCurrentGoalRow(){
	var goals_IDs = $.map($("#currentGoalsTable").bootstrapTable('getSelections'), function (row) {
		return row.currentGoalUniqueID;
	});
	
    $("#currentGoalsTable").bootstrapTable('remove', {
        field: 'currentGoalUniqueID',
        values: goals_IDs
    });
    
}

//Previous Year
//Template for Publications table
function setPublicationsTableTemplate_PY(){

	var options = {
		columns: [{
			width: 36,
			formatter: getRowIndex,
			
		},	{
			field: "publicationUniqueID_PY",
			visible: false,
		},	{
		    field: "publication_PY",
		    title: "Publications",
		    align: 'center',
		}],
		formatNoMatches: function () {
        	return 'No Publications exist';
    	},
		data: []
	};

	$('#publicationsTable_PY').bootstrapTable(options);

}

//Populate Publications table
function AddPublications_PY(publications_PY){

	if(publications_PY == null || publications_PY == ""){
		return;
	}

	//JSON object to store publications
	var rows = [];

	for(var i = 0; i < publications_PY.length; i++){
		var row = {'publicationUniqueID_PY':i + 1, 'publication_PY': publications_PY[i]};
		rows.push(row);
	}
	
	//Populate Publications table with values in 'rows' object
	var options = $("#publicationsTable_PY").bootstrapTable('getOptions');
	options["data"] = rows;
	$('#publicationsTable_PY').bootstrapTable('refreshOptions',{'data' : options["data"]});

}

//Current Year
//Template for Publications table
function setPublicationsTableTemplate(){

	var options = {
		columns: [{
			field: "selectBoxPublication",
			checkbox: true,
		
		}, 	{
			width: 36,
			formatter: getRowIndex,
			
		},	{
			field: "publicationUniqueID",
			visible: false,
		},	{
		    field: "publication",
		    title: "Publications<span class='glyphicon glyphicon-info-sign help_current_goal'></span><sup class='star'>*</sup>",
		    titleTooltip: "If you have not yet done a publication please write 'Yet To Do'",
		    align: 'center',
		    editable: {
		    	type: 'text',
		    	mode: 'inline',
		    },
		}],
		formatNoMatches: function () {
        	return 'Please add Publication(s)';
    	},
		data: []
	};

	$('#publicationsTable').bootstrapTable(options);

}

//Populate Publications table
function AddPublications(publications){

	if(publications == null || publications == ""){
		return;
	}

	//JSON object to store publications
	var rows = [];

	for(var i = 0; i < publications.length; i++){
		var row = {'publicationUniqueID':i + 1, 'publication': publications[i]};
		rows.push(row);
	}
	
	//Populate Publications table with values in 'rows' object
	var options = $("#publicationsTable").bootstrapTable('getOptions');
	options["data"] = rows;
	$('#publicationsTable').bootstrapTable('refreshOptions',{'data' : options["data"]});

}

//Add row to Publications Table
function addPublicationRow(){
	var publication = $("#publication").val().trim();
	publication_test = publication.replace(/\s/g,"");		//Remove whitespaces
	var no_publication_flag = false;
	
	//INPUT VALIDATION
	$("#addPublicationAlertDiv").hide();
	
	if(publication == ""){
		$("#addPublicationAlertDiv").show();
		$("#addPublicationAlertDiv").text("Please enter a publication");
		return false;
	}
	
	var publication_regex = /^.*[a-zA-Z].*:.*[a-zA-Z].*:Status=(Approved|Rejected)$/i;		//Regular expression for the pattern Publication:Journal:Status=Approved/Rejected
																							//Publication should contain atleast one alphabet
																							//Journal should contain atleast one alphabet
																	
	var nopublication_regex = /^YetToDo$/i;													//Regular expression to match 'Yet To Do' in case of no publication
	if(nopublication_regex.test(publication_test)){
		if($("#publicationsTable").bootstrapTable('getData').length > 0){
			$("#addPublicationAlertDiv").show();
			$("#addPublicationAlertMsg").html("Please enter in the following format <br>Publication:Journal:Status=Approved/Rejected<br>eg. Abc:Pqr:Status=Approved");
			return false;
		}
		publication = "Yet To Do";
		no_publication_flag = true;
	}
	else if(!publication_regex.test(publication_test)){
		$("#addPublicationAlertDiv").show();
		$("#addPublicationAlertDiv").html("Please enter in the following format <br>Publication:Journal:Status=Approved/Rejected<br>eg. Abc:Pqr:Status=Approved");
		return false;
	}
	/****VALIDATION OVER****/
	
	//Remove 'Yet To Do' entry if a publication is added
	if(!no_publication_flag){
		$("#publicationsTable").bootstrapTable('remove', {
		    field: 'publication',
		    values: ['Yet To Do']
    	});
	}
	
	$("#publicationsTableAlertDiv").hide();
	
	//Generate unique id for the row
	var total_rows = $("#publicationsTable").bootstrapTable('getData').length;
	var unique_id;
	if(total_rows > 0)
		unique_id = $("#publicationsTable").bootstrapTable('getData')[total_rows-1].publicationUniqueID + 1;
	else
		unique_id = 1;
	
	var row_data = {'publicationUniqueID':unique_id, 'publication':publication};
	$("#publicationsTable").bootstrapTable('append',row_data);
	
	//reset form inputs
	$("#publication").val("");
	$("#addPublicationModal").modal('toggle');
}

//Remove row(s) from Publications Table
function removePublicationRow(){
	var publication_IDs = $.map($("#publicationsTable").bootstrapTable('getSelections'), function (row) {
		return row.publicationUniqueID;
	});
	
    $("#publicationsTable").bootstrapTable('remove', {
        field: 'publicationUniqueID',
        values: publication_IDs
    });
    
}

//Previous Year
//Template for Presentations table
function setPresentationsTableTemplate_PY(){

var options = {
    columns: [{
    	width: 36,
    	formatter: getRowIndex,
    	
    },	{
    	field: "presentationUniqueID_PY",
    	visible: false,
    },	{
        field: "presentation_PY",
        title: "Presentations",
        align: 'center',
    }],
    formatNoMatches: function () {
        return 'No Presentations exist';
    },
    data: []
};

$('#presentationsTable_PY').bootstrapTable(options);

}

//Populate Presentations table
function AddPresentations_PY(presentations_PY){

	if(presentations_PY == null || presentations_PY == ""){
		return;
	}
	
	//JSON object to store presentations
	var rows = [];

	for(var i = 0; i < presentations_PY.length; i++){
		var row = {'presentationUniqueID_PY':i + 1, 'presentation_PY': presentations_PY[i]};
		rows.push(row);
	}
	
	//Populate Presentations table with values in 'rows' object
	var options = $("#presentationsTable_PY").bootstrapTable('getOptions');
	options["data"] = rows;
	$('#presentationsTable_PY').bootstrapTable('refreshOptions',{'data' : options["data"]});

}

//Current_year
//Template for Presentations table
function setPresentationsTableTemplate(){

var options = {
    columns: [{
    	field: "selectBoxPresentation",
    	checkbox: true,
    
    }, 	{
    	width: 36,
    	formatter: getRowIndex,
    	
    },	{
    	field: "presentationUniqueID",
    	visible: false,
    },	{
        field: "presentation",
        title: "Presentations<span class='glyphicon glyphicon-info-sign help_current_goal'></span><sup class='star'>*</sup>",
        titleTooltip: "If you have not yet done a presentation please write 'Yet To Do'",
        align: 'center',
        editable: {
        	type: 'text',
        	mode: 'inline',
        },
    }],
    formatNoMatches: function () {
        return 'Please add Presentation(s)';
    },
    data: []
};

$('#presentationsTable').bootstrapTable(options);

}

//Populate Presentations table
function AddPresentations(presentations){

	if(presentations == null || presentations == ""){
		return;
	}
	
	//JSON object to store presentations
	var rows = [];

	for(var i = 0; i < presentations.length; i++){
		var row = {'presentationUniqueID':i + 1, 'presentation': presentations[i]};
		rows.push(row);
	}
	
	//Populate Presentations table with values in 'rows' object
	var options = $("#presentationsTable").bootstrapTable('getOptions');
	options["data"] = rows;
	$('#presentationsTable').bootstrapTable('refreshOptions',{'data' : options["data"]});

}

//Add row to Presentations Table
function addPresentationRow(){
	var presentation = $("#presentation").val().trim();
	presentation_test = presentation.replace(/\s/g,"");		//Remove whitespaces
	var no_presentation_flag = false;
	
	//INPUT VALIDATION
	$("#addPresentationAlertDiv").hide();
	
	if(presentation == ""){
		$("#addPresentationAlertDiv").show();
		$("#addPresentationAlertMsg").text("Please enter a presentation");
		return false;
	}
	
	var presentation_regex = /^.*[a-zA-Z].*:.*[a-zA-Z][^:]*$/i;		//Regular expression for the pattern Presentation:Conference
																	//Presentation should contain at least one alphabet
																	//Confernece should contain at least one alphabet
																	//Input should not end with ':'
	
	var nopresentation_regex = /^YetToDo$/i;						//Regular expression to match 'Yet To Do' in case of no presentation
	if(nopresentation_regex.test(presentation_test)){
		if($("#presentationsTable").bootstrapTable('getData').length > 0){
			$("#addPresentationAlertDiv").show();
			$("#addPresentationAlertMsg").html("Please enter in the following format <br>Presentation:Conference<br>eg. abc:pqr");
			return false;
		}
		presentation = "Yet To Do";
		no_presentation_flag = true;
	}
	else if(!presentation_regex.test(presentation_test)){
		$("#addPresentationAlertDiv").show();
		$("#addPresentationAlertMsg").html("Please enter in the following format <br>Presentation:Conference<br>eg. abc:pqr");
		return false;
	}
	/****VALIDATION OVER****/
	
	//Remove 'Yet To Do' entry if a presentation is added
	if(!no_presentation_flag){
		$("#presentationsTable").bootstrapTable('remove', {
		    field: 'presentation',
		    values: ['Yet To Do']
    	});
	}
	
	$("#presentationsTableAlertDiv").hide();
	
	//Generate unique id for the row
	var total_rows = $("#presentationsTable").bootstrapTable('getData').length;
	var unique_id;
	if(total_rows > 0)
		unique_id = $("#presentationsTable").bootstrapTable('getData')[total_rows-1].presentationUniqueID + 1;
	else
		unique_id = 1;
	
	var row_data = {'presentationUniqueID':unique_id, 'presentation':presentation};
	$("#presentationsTable").bootstrapTable('append',row_data);
	
	//reset form inputs
	$("#presentation").val("");
	$("#addPresentationModal").modal('toggle');
}

//Remove row(s) from Presentations Table
function removePresentationRow(){
	var presentation_IDs = $.map($("#presentationsTable").bootstrapTable('getSelections'), function (row) {
		return row.presentationUniqueID;
	});
	
    $("#presentationsTable").bootstrapTable('remove', {
        field: 'presentationUniqueID',
        values: presentation_IDs
    });
    
}

//Previous Years
//Template for FutureGoals table
function setFutureGoalsTableTemplate_PY(){

var options = {
    columns: [{
    	width: 36,
    	formatter: getRowIndex,
    	
    },	{
    	field: "futureGoalUniqueID_PY",
    	visible: false,
    	
    },	{
        field: "futureGoal_PY",
        title: "Future Goals",
        align: 'center',
    }],
    formatNoMatches: function () {
        return 'No future goals listed during the previous years';
    },
    data: []
};

$('#futureGoalsTable_PY').bootstrapTable(options);

}

//Populate FutureGoals table
function AddFutureGoals_PY(future_goals_PY){

	if(future_goals_PY == null || future_goals_PY == ""){
		return;
	}

	//JSON object to store goals
	var rows = [];

	for(var i = 0; i < future_goals_PY.length; i++){
		var row = {'futureGoalUniqueID_PY':i + 1, 'futureGoal_PY': future_goals_PY[i]};
		rows.push(row);
	}
	
	//Populate FutureGoals table with values in 'rows' object
	var options = $("#futureGoalsTable_PY").bootstrapTable('getOptions');
	options["data"] = rows;
	$('#futureGoalsTable_PY').bootstrapTable('refreshOptions',{'data' : options["data"]});

}

//Current Year
//Template for FutureGoals table
function setFutureGoalsTableTemplate(){

var options = {
    columns: [{
    	field: "selectBoxFutureGoal",
    	checkbox: true,
    
    }, 	{
    	width: 36,
    	formatter: getRowIndex,
    	
    },	{
    	field: "futureGoalUniqueID",
    	visible: false,
    	
    },	{
        field: "futureGoal",
        title: "Future Goals<span class='glyphicon glyphicon-info-sign help_current_goal'></span><sup class='star'>*</sup>",
        titleTooltip: "Enter goals you think are important and you need to complete them. eg: Completing Qualification Exam. Completing some current thesis work",
        align: 'center',
        editable: {
        	type: 'text',
        	mode: 'inline',
        },
    }],
    formatNoMatches: function () {
        return 'Please add Goal(s)';
    },
    data: []
};

$('#futureGoalsTable').bootstrapTable(options);

}

//Populate FutureGoals table
function AddFutureGoals(future_goals){

	if(future_goals == null || future_goals == ""){
		return;
	}

	//JSON object to store goals
	var rows = [];

	for(var i = 0; i < future_goals.length; i++){
		var row = {'futureGoalUniqueID':i + 1, 'futureGoal': future_goals[i]};
		rows.push(row);
	}
	
	//Populate FutureGoals table with values in 'rows' object
	var options = $("#futureGoalsTable").bootstrapTable('getOptions');
	options["data"] = rows;
	$('#futureGoalsTable').bootstrapTable('refreshOptions',{'data' : options["data"]});

}

//Add row to Future Goals Table
function addFutureGoalRow(){
	var goal = $("#futureGoal").val().trim();
	
	//INPUT VALIDATION
	$("#addFutureGoalAlertDiv").hide();
	alertFlag = false;
	if(goal == ""){
		$("#addFutureGoalAlertDiv").show();
		$("#addFutureGoalAlertMsg").text("Please enter a goal");
		alertFlag = true;
	}
	if(alertFlag == true)
		return false;
	/***VALIDATION OVER***/
	
	$("#futureGoalsTableAlertDiv").hide();
	
	//Generate unique id for the row
	var total_rows = $("#futureGoalsTable").bootstrapTable('getData').length;
	var unique_id;
	if(total_rows > 0)
		unique_id = $("#futureGoalsTable").bootstrapTable('getData')[total_rows-1].futureGoalUniqueID + 1;
	else
		unique_id = 1;
	
	var row_data = {'futureGoalUniqueID':unique_id, 'futureGoal':goal};
	$("#futureGoalsTable").bootstrapTable('append',row_data);
	
	//reset form inputs
	$("#futureGoal").val("");
	$("#addFutureGoalModal").modal('toggle');
}

//Remove row(s) from Future Goals Table
function removeFutureGoalRow(){
	var goals_IDs = $.map($("#futureGoalsTable").bootstrapTable('getSelections'), function (row) {
		return row.futureGoalUniqueID;
	});
	
    $("#futureGoalsTable").bootstrapTable('remove', {
        field: 'futureGoalUniqueID',
        values: goals_IDs
    });
    
}


$(function(){
	$("#submit_progressReportForm").click(function(evt){
		//var Degree_select=$('#degree_select').val();
		var degree_program=$('#degree_select').val();
		console.log("degree : " + degree_program);
		//var academic_year_fall=$("#academic_year_fall").val();
		var academic_year_fall=$("#academic_year_fall").val().trim();
		console.log("academic_year_fall : " + academic_year_fall);
		//var academic_year_spring=$("#academic_year_spring").val();
		var academic_year_spring=$("#academic_year_spring").val().trim();
		console.log("academic_year_spring : " + academic_year_spring);
		//var First_name=$('#first_name').val();
		var first_name=$('#first_name').val().trim();
		console.log("first_name : " + first_name);
		//var Second_name=$('#second_name').val();
		var second_name=$('#second_name').val().trim();
		console.log("second_name : " + second_name);
		//var Asu_id=$('#asu_id').val();
		var asu_id=$('#asu_id').val().trim();
		console.log("asu_id : " + asu_id);
		//var Student_mail=$('#student_mail').val()+'@asu.edu';
		var student_emailID=$('#student_mail').val().trim()+'@asu.edu';
		console.log("student_emailID : " + student_emailID);
		//var Prog_start_date=$('#prog_start_date').val();
		var program_start_date=$('#prog_start_date').val().trim();
		console.log("program_start_date : " + program_start_date);
		//var Sem_in_prog=$('#sem_in_prog').val();
		var semester_in_progress=$('#sem_in_prog').val();
		console.log("semester_in_progress : " + semester_in_progress);
		//var Cum_gpa=$('#cum_gpa').val();
		var cumulative_gpa=$('#cumulative_gpa').val().trim();
		console.log("cumulative_gpa : " + cumulative_gpa);
		//var Advisory_committee=$("input:radio[name='advisory_committee']:checked").val();
		var advisory_committee_formed=$("input:radio[name='advisory_committee']:checked").val();
		console.log("advisory_committee_formed : " + advisory_committee_formed);
		//var Met_advisor=$("input:radio[name='met_advisor']:checked").val();
		var met_advisor=$("input:radio[name='met_advisor']:checked").val();
		console.log("met_advisor : " + met_advisor);
		//var chair_notmet_reason=$('#chair_notmet_reason').val();
		var chair_notmet_reason=$('#chair_notmet_reason').val().trim();
		console.log("chair_notmet_reason : " + chair_notmet_reason);
		//var Comprehensive_exam=$("input:radio[name='comprehensive_exam']:checked").val();
		var comprehensive_exam_completed=$("input:radio[name='comprehensive_exam']:checked").val();
		console.log("comprehensive_exam_completed : " + comprehensive_exam_completed);
		//var Oral_comprehensive_exam=$("input:radio[name='oral_comprehensive_exam']:checked").val();
		var dissertation_prosectus_completed=$("input:radio[name='dissertation_prosectus']:checked").val();	//oral_comprehensive_exam
		console.log("dissertation_prosectus_completed : " + dissertation_prosectus_completed);
		//var Colloquium=$("input:radio[name='colloquium']:checked").val();
		var colloquium=$("input:radio[name='colloquium']:checked").val();
		console.log("colloquium : " + colloquium);
		//var Research_completed=$("input:radio[name='research_completed']:checked").val();
		//var Research_completed=$("input:radio[name='research_completed']:checked").val();
		//var Qualifying_exam=$("input:radio[name='qualifying_exam']:checked").val();
		var qualifying_exam_completed=$("input:radio[name='qualifying_exam_completed']:checked").val();
		console.log("qualifying_exam_completed : " + qualifying_exam_completed);
		//var Extra=$("#extra").val();
		var comments=$("#comments").val().trim();
		console.log("comments : " + comments);
		//var flag="true";
		var flag="true";
		//evt.preventDefault();
		evt.preventDefault();
		//var alert_value='';
		var alert_value='';
		//var alert_count=1;
		var alert_count=1;
		
		
		$("#degreeProgramAlertDiv").hide();
		$("#academicYearAlertDiv").hide();
		$("#firstNameAlertDiv").hide();
		$("#lastNameAlertDiv").hide();
		$("#asuIDAlertDiv").hide();
		$("#asuriteIDAlertDiv").hide();
		$("#pgmStartDateAlertDiv").hide();
		$("#semInProgressAlertDiv").hide();
		$("#cumGPAAlertDiv").hide();
		$("#courseTableAlertDiv").hide();
		$("#advisorTableAlertDiv").hide();
		$("#chairNotMetAlertDiv").hide();
		$("#chairNotMetReasonAlertDiv").hide();
		$("#qualExamAlertDiv").hide();
		$("#qualExamTableAlertDiv").hide();
		$("#compExamAlertDiv").hide();
		$("#compExamTableAlertDiv").hide();
		$("#dissertationAlertDiv").hide();
		$("#colloquiumAlertDiv").hide();
		$("#colloquiumSemesterAlertDiv").hide();
		$("#currentGoalsTableAlertDiv").hide();
		$("#publicationsTableAlertDiv").hide();
		$("#presentationsTableAlertDiv").hide();
		$("#futureGoalsTableAlertDiv").hide();
		$("#fileAlertDiv").hide();
		$("#certifyAlertDiv").hide();
		var alertFlag= false;
		
		//hides alert box on closing the box
		$('.alert-close').click(function(){
			$(this).parent().hide();
		});
		
		/******Perform Form Validation ******/

		//Check if Degree Program has been selected
		if(degree_program == null){
			$("#degreeProgramAlertDiv").show();
			$("#degreeProgramAlertMsg").text("Please select a Degree Program");
			alertFlag= true;
		}
		
		//Check if Academic Year is valid	//Mostly not required as user input not taken
		var year_regex = /^\d{4}$/;
		if(academic_year_fall == ""){
			$("#academicYearAlertDiv").show();
			$("#academicYearAlertMsg").text("Invalid input");
			alertFlag= true;
		}
		else if(!year_regex.test(academic_year_fall)){
			$("#academicYearAlertDiv").show();
			$("#academicYearAlertMsg").text("Invalid input");
			alertFlag= true;
		}
		//academic_year_spring
		if(academic_year_spring == ""){
			$("#academicYearAlertDiv").show();
			$("#academicYearAlertMsg").text("Invalid input");
			alertFlag= true;
		}
		else if(!year_regex.test(academic_year_spring)){
			$("#academicYearAlertDiv").show();
			$("#academicYearAlertMsg").text("Invalid input");
			alertFlag= true;
		}
		
		//First name
		var name_regex = /^\w+$/
		if(first_name == ""){
			$("#firstNameAlertDiv").show();
			$("#firstNameAlertMsg").text("Please enter your first name");
			alertFlag= true;
		}
		else if(!name_regex.test(first_name)){
			$("#firstNameAlertDiv").show();
			$("#firstNameAlertMsg").text("Please enter a valid first name");
			alertFlag= true;
		}
		
		//Last Name
		if(second_name == ""){
			$("#lastNameAlertDiv").show();
			$("#lastNameAlertMsg").text("Please enter your last name");
			alertFlag= true;
		}
		else if(!name_regex.test(second_name)){
			$("#lastNameAlertDiv").show();
			$("#lastNameAlertMsg").text("Please enter a valid last name");
			alertFlag= true;
		}
		
		//ASU ID
		var asuID_regex=/^[0-9]{10,11}$/
		if(asu_id == ""){
			$("#asuIDAlertDiv").show();
			$("#asuIDAlertMsg").text("Please enter your ASU ID");
			alertFlag= true;
		}
		else if(!asuID_regex.test(asu_id)){
			$("#asuIDAlertDiv").show();
			$("#asuIDAlertMsg").text("Please enter a valid ASU ID consisting of 10 or 11 digits");
			alertFlag= true;
		}
		
		//ASURITE ID
		var asuriteID_regex=/^\w[\w\d]+@asu.edu$/
		if(student_emailID == "@asu.edu"){
			$("#asuriteIDAlertDiv").show();
			$("#asuriteIDAlertMsg").text("Please enter your ASURITE ID");
			alertFlag= true;
		}
		else if(!asuriteID_regex.test(student_emailID)){
			$("#asuriteIDAlertDiv").show();
			$("#asuriteIDAlertMsg").text("Please enter a valid ASURITE ID");
			alertFlag= true;
		}
		
		//PROGRAM START DATE
		var pgmStartDate_regex = /^\w+\s\d{4}$/
		var month_array = ['January','February','March','April','May','June','July','August','September','October','November','December'];
		
		if(program_start_date == ""){
			$("#pgmStartDateAlertDiv").show();
			$("#pgmStartDateAlertMsg").text("Please enter your Program Start Date");
			alertFlag= true;
		}
		else if(!pgmStartDate_regex.test(program_start_date)){
			$("#pgmStartDateAlertDiv").show();
			$("#pgmStartDateAlertMsg").text("Please enter a valid Program Start Date");
			alertFlag= true;
		}
		else if(pgmStartDate_regex.test(program_start_date)){
			if($.inArray(program_start_date.split(" ")[0],month_array) == -1){
				$("#pgmStartDateAlertDiv").show();
				$("#pgmStartDateAlertMsg").text("Please enter a valid Program Start Date");
				alertFlag= true;
			}
		}
		
		//SEMESTER IN PROGRESS
		if(semester_in_progress == null){
			$("#semInProgressAlertDiv").show();
			$("#semInProgressAlertMsg").text("Please select a Semester");
			alertFlag= true;
		}
		
		//CGPA
		if(cumulative_gpa == ""){
			$("#cumGPAAlertDiv").show();
			$("#cumGPAAlertMsg").text("Please enter your CGPA");
			alertFlag= true;
		}
		else if(isNaN(cumulative_gpa) || cumulative_gpa > 4.33 || cumulative_gpa < 0){
			$("#cumGPAAlertDiv").show();
			$("#cumGPAAlertMsg").text("Please enter a valid CGPA");
			alertFlag= true;
		}
		
		console.log("Adv committee: " + $('input[name="advisory_committee"]:checked').val());
		
		//Course Table
		var row_count = $("#coursesTable").bootstrapTable('getData').length;
		if(row_count == 0){
			$("#courseTableAlertDiv").show();
			$("#courseTableAlertMsg").html("Please enter Courses. Check <span class='glyphicon glyphicon-info-sign help_current_goal'></span> for details.");
			alertFlag= true;
		}
		
		//Advisory Committee formed
		if(!$('input[name="advisory_committee"]:checked').val()){
			$("#advisorCommitteeAlertDiv").show();
			$("#advisorCommitteeAlertMsg").text("Please select an option");
			alertFlag= true;
		}
		
		if($("#advisory_committee_yes").is(':checked')){
			var row_count = $("#advisorTable").bootstrapTable('getData').length;
			if(row_count == 0){
				$("#advisorTableAlertDiv").show();
				$("#advisorTableAlertMsg").text("Advisor Table is empty. Are you sure Advisory Committee has been formed?");
				alertFlag= true;
			}
			else{		//Check if advisory committe has advisor/co-advisor
				var chair_flag = false;
				$.each($("#advisorTable").bootstrapTable('getData'),function(index, value){
					if(value["advisorType"] == "CHAIR" || value["advisorType"] == "CO-CHAIR"){
						chair_flag = true;
					}
				});
				if(!chair_flag){
					$("#advisorTableAlertDiv").show();
					$("#advisorTableAlertMsg").text("The Advisory Committee should consist of a Chair/Co-chair");
					alertFlag= true;
				}
			}
		}
		
		//Chair Met
		if(!$('input[name="met_advisor"]:checked').val()){
			$("#chairNotMetAlertDiv").show();
			$("#chairNotMetAlertMsg").text("Please select an option");
			alertFlag= true;
		}
		
		if($("#committee_formed_no").is(':checked')){
			if(chair_notmet_reason == ""){
				$("#chairNotMetReasonAlertDiv").show();
				$("#chairNotMetReasonAlertMsg").text("Please provide a reason for not having an Advisory Committee");
				alertFlag= true;
			}
		}
		
		//Qualifying Exam
		if(!$('input[name="qualifying_exam_completed"]:checked').val()){
			$("#qualExamAlertDiv").show();
			$("#qualExamAlertMsg").text('Please select an option');
			alertflag = true;
		}
		
		if($("#exam_yes").is(':checked')){
			var row_count = $("#qualifying_subject_table").bootstrapTable('getData').length;
			if(row_count == 0){
				$("#qualExamTableAlertDiv").show();
				$("#qualExamTableAlertMsg").text("Qualifying Exam Table is empty. Are you sure Qualifying Exam(s) have been completed?");
				alertFlag= true;
			}
		}
		
		//Comprehensive Exam
		if(!$('input[name="comprehensive_exam"]:checked').val()){
			$("#compExamAlertDiv").show();
			$("#compExamAlertMsg").text('Please select an option');
			alertflag = true;
		}
		
		if($("#comprehensive_exam_yes").is(':checked')){
			var row_count = $("#comprehensiveExamTable").bootstrapTable('getData').length;
			if(row_count == 0){
				console.log("COMP EMPTY")
				$("#compExamTableAlertDiv").show();
				$("#compExamTableAlertMsg").text("Comprehensive Exam Table is empty. Are you sure Comprehensive Exam(s) have been completed?");
				alertFlag= true;
			}
		}
		
		//Dissertation
		if(!$('input[name="dissertation_prosectus"]:checked').val()){
			$("#dissertationAlertDiv").show();
			$("#dissertationAlertMsg").text("Please select an option");
			alertFlag = true;
		}
		
		//Colloquium
		if(!$('input[name="colloquium"]:checked').val()){
			$("#colloquiumAlertDiv").show();
			$("#colloquiumAlertMsg").text("Please select an option");
			alertFlag= true;
		}
		
		if($("#colloquium_yes").is(':checked') && !$('input[name="colloquium_semester"]:checked').val()){
			console.log("Helllooo");
			$("#colloquiumSemesterAlertDiv").show();
			$("#colloquiumSemesterAlertMsg").text("No semester has been selected. Are you sure you have attended Colloquium?");
			alertFlag =true;
		}
		
		//Current goals table
		var row_count = $("#currentGoalsTable").bootstrapTable('getData').length;
		if(row_count == 0){
			$("#currentGoalsTableAlertDiv").show();
			$("#currentGoalsTableAlertMsg").html("Please enter Current Accomplished Goals. Check <span class='glyphicon glyphicon-info-sign help_current_goal'></span> for details.");
			alertFlag =true;
		}
		
		//Publications table
		var row_count = $("#publicationsTable").bootstrapTable('getData').length;
		if(row_count == 0){
			$("#publicationsTableAlertDiv").show();
			$("#publicationsTableAlertMsg").html("Please enter Publications. Check <span class='glyphicon glyphicon-info-sign help_current_goal'></span> for details.");
			alertFlag =true;
		}
		
		//Presentations table
		var row_count = $("#presentationsTable").bootstrapTable('getData').length;
		if(row_count == 0){
			$("#presentationsTableAlertDiv").show();
			$("#presentationsTableAlertMsg").html("Please enter Presentations. Check <span class='glyphicon glyphicon-info-sign help_current_goal'></span> for details.");
			alertFlag =true;
		}
		
		//Future goals table
		var row_count = $("#futureGoalsTable").bootstrapTable('getData').length;
		if(row_count == 0){
			$("#futureGoalsTableAlertDiv").show();
			$("#futureGoalsTableAlertMsg").html("Please enter Future Goals. Check <span class='glyphicon glyphicon-info-sign help_current_goal'></span> for details.");
			alertFlag =true;
		}
		
		//Check if iPOS has been uploaded
		if($("#transcript_file").val() == ""){
			$("#fileAlertDiv").show();
			$("#fileAlertMsg").text("Please upload a file");
			alertFlag = true;
		}
		
		//Certify information
		if(!$('#certify').is(':checked')){
			$("#certifyAlertDiv").show();
			$("#certifyAlertMsg").text("Please certify the information for submitting the form");
			alertFlag = true;
		}
		
		if(alertFlag){
			alert("Form contains error(s)!!");
			return false;
		}
		
		
		/*****VALIDATION OVER*****/
		
		//When all the conditions for the form is met then 
		//the flag will be set to true and will take in all the values from the form
		if(flag=="true" )
		{
			
			//Saving the Course and Grade details in array
			var course_array = jQuery.makeArray();
			var courseGrade_array = jQuery.makeArray();
			
			$.each($("#coursesTable").bootstrapTable('getData'), function(index, value){
				course_array[index] = value["course"];
				courseGrade_array[index] = value["grade"];
			});
			
			console.log(course_array + "   ******   " + courseGrade_array);
			
			//Saving Advisor information if advisory committee is formed
			//var Main_advisor= "Jennifer.May@asu.edu";
			var Main_advisor= "gravetka@asu.edu";
			//var Main_advisor = "aiyangar@asu.edu";
	
			if($("input:radio[id='advisory_committee_yes']").is(":checked"))
			{
				var advisorPosition_array = jQuery.makeArray();
				var advisorFirstname_array = jQuery.makeArray();
				var advisorSecondname_array = jQuery.makeArray();
				var advisorEmailID_array = jQuery.makeArray();
				
				$.each($("#advisorTable").bootstrapTable('getData'), function(index, value){
					advisorPosition_array[index] = value["advisorType"];
					advisorFirstname_array[index] = value["advisorFirstName"];
					advisorSecondname_array[index] = value["advisorLastName"];
					advisorEmailID_array[index] = value["advisorEmailID"];
				});
			
				console.log(advisorPosition_array + "   ******   " + advisorFirstname_array + "   ******   " + advisorSecondname_array + "   ******   " + advisorEmailID_array);

			}

			///////////NOT SURE USED FOR WHAT
			/*
			//Getting all the Advisor Mails to send them mails respectively
			var Mail=jQuery.makeArray();
			$.each($('#advisor_table_body tr'),function(i,tr){
				if($('.signature'+i).find('.advisor_mail').val()===$('.signature'+i).find('.advisor_remail').val()){

					Mail[i]=$('.signature'+i).find('.advisor_mail').val();

				}
			});
			*/
			
			
			//Saving all the Qualifying details in arrays
			var qualifyingSubject_array = jQuery.makeArray();
			var qualifyingSubjectGrade_array = jQuery.makeArray();
			
			$.each($("#qualifying_subject_table").bootstrapTable('getData'), function(index, value){
				qualifyingSubject_array[index] = value["qualifyingSubject"];
				qualifyingSubjectGrade_array[index] = value["qualifyingSubjectGrade"];
			});
			
			console.log(qualifyingSubject_array + "   ******   " + qualifyingSubjectGrade_array);

			
			//Saving all the Comprehensive Exam Details in arrays
			var compExamSubject_array=jQuery.makeArray();
			var compExamSubjectGrade_array=jQuery.makeArray();
			$.each($("#comprehensiveExamTable").bootstrapTable('getData'), function(index, value){
				compExamSubject_array[index] = value["comprehensiveExam"];
				compExamSubjectGrade_array[index] = value["compExamGrade"];
			});
			
			console.log(compExamSubject_array + "   ******   " + compExamSubjectGrade_array);
			
			//Saving Colloquium semster details in array
			var colloquiumSemester_array=jQuery.makeArray();
			$.each($('input[id="colloquium_semester"]:checked'),function(){
				colloquiumSemester_array.push($(this).val());
			});
			
			console.log(colloquiumSemester_array);
			
			//Saving current accomplished goals in array
			var currentGoals_array=jQuery.makeArray();
			$.each($("#currentGoalsTable").bootstrapTable('getData'), function(index, value){
				currentGoals_array[index] = value["currentGoal"];
			});
			
			console.log(currentGoals_array);
			
			
			//Saving Publications in array
			var publication_array=jQuery.makeArray();
			$.each($("#publicationsTable").bootstrapTable('getData'), function(index, value){
				publication_array[index] = value["publication"];
			});
			
			console.log(publication_array);

			
			//Saving Presentations in array
			var presentation_array=jQuery.makeArray();
			$.each($("#presentationsTable").bootstrapTable('getData'), function(index, value){
				presentation_array[index] = value["presentation"];
			});
			
			console.log(presentation_array);
			
			//Saving Future Goals in array
			var futureGoals_array=jQuery.makeArray();
			$.each($("#futureGoalsTable").bootstrapTable('getData'), function(index, value){
				futureGoals_array[index] = value["futureGoal"];
			});
			
			console.log(futureGoals_array);

			
			var AsuriteID=$('#student_mail').val();

			var fd = new FormData(),

			File = document.getElementById("transcript_file").files[0];
			fd.append( 'file',  File);
			fd.append('degree_select',degree_program);
			fd.append('academic_year',academic_year_fall);
			fd.append('academic_year_fall',academic_year_fall);
			fd.append('academic_year_spring',academic_year_spring);
			fd.append('written_subjects',JSON.stringify(compExamSubject_array));
			fd.append('written_grades',JSON.stringify(compExamSubjectGrade_array));
			fd.append('publication',JSON.stringify(publication_array));
			fd.append('presentation',JSON.stringify(presentation_array));
			fd.append('advisor_position',JSON.stringify(advisorPosition_array));
			fd.append('advisor_firstname',JSON.stringify(advisorFirstname_array));
			fd.append('advisor_secondname',JSON.stringify(advisorSecondname_array));
			fd.append('advisor_mail',JSON.stringify(advisorEmailID_array));
			//fd.append('mail',JSON.stringify(Mail));
			fd.append('mail','NULL');
			fd.append('course',JSON.stringify(course_array));
			fd.append('grade',JSON.stringify(courseGrade_array));
			fd.append('qualifying_subjects',JSON.stringify(qualifyingSubject_array));
			fd.append('qualifying_grades',JSON.stringify(qualifyingSubjectGrade_array));
			fd.append('current_goal',JSON.stringify(currentGoals_array));
			fd.append('future_goal',JSON.stringify(futureGoals_array));
			fd.append('colloquium_semester',JSON.stringify(colloquiumSemester_array));
			fd.append('first_name',first_name);
			fd.append('second_name',second_name);
			fd.append('asu_id',asu_id);
			fd.append('asurite',AsuriteID);
			fd.append('student_mail',student_emailID);
			fd.append('prog_start_date',program_start_date);
			fd.append('sem_in_prog',semester_in_progress);
			fd.append('cum_gpa',cumulative_gpa);
			fd.append('advisory_committee',advisory_committee_formed);
			fd.append('main_advisor',Main_advisor);
			fd.append('met_advisor',met_advisor);
			fd.append('chair_notmet_reason',chair_notmet_reason);
			fd.append('comprehensive_exam',comprehensive_exam_completed);
			fd.append('oral_comprehensive_exam',dissertation_prosectus_completed);
			fd.append('qualifying_exam',qualifying_exam_completed);
			fd.append('colloquium',colloquium);
		

			fd.append('extra',comments);
			$.ajax({
				type: "POST",
				url: "./data1_v1.php",
				data:fd,
				processData: false,
				contentType: false,
				success:function(data){
				alert("Wow!! You have submitted the form which will be auto-reviewed and if everything looks fine you should receive an e-mail. Please make sure that you receive an mail on your ASURITE mail id. If you do not receive a mail in that case you have missed out on something and need to reach out to the Graduate Co-ordinator for further assistance.");
				
				redirect();	
				},
			error:function(exception){
			console.log(exception);
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
	window.location="http://localhost/studentform_v1.php";
}

