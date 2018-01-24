
function getRowIndex(value, row, index){
	return index + 1;
}

function onAcademicYearChange(){

	var academic_year = $("#academic_year_select").val();
	window.location="http://localhost/student_demo.php?ID=" + Asu_id + "&valid=0" + "&AcademicYear=" + academic_year;
}

//Template for Courses table
function setCourseTableTemplate(){

var options = {
    columns: [{
    	width: 36,
    	formatter: getRowIndex,
    	searchable: false,
    },	{
    	field: "courseUniqueID",
    	visible: false,
    },	{
        field: "course",
        title: "Course",
        align: 'center',
        searchable: false,
    }, {
        field: "grade",
        title: "Grade",
        align: 'center',
        searchable: false,
    }],
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


//Template for Advisors table
function setAdvisorTableTemplate(){
	
	var options = {
    columns: [{
    	width: 36,
    	formatter: getRowIndex,
    	
    },	{
    	field: "advisorUniqueID",
    	visible: false,
    	
    },	{
    	field: "advisorType",
    	title: "Advisor Position",
    	align: 'center',
    	
    },{
        field: "advisorFirstName",
        title: "First Name",
        align: 'center',
        
    }, {
        field: "advisorLastName",
        title: "Last Name",
        align: 'center',
    },{
        field: "advisorEmailID",
        title: "E-mail ID",
        align: 'center',
    }],
    data: []
};

$('#advisorTable').bootstrapTable(options);

}

//Populate Advisors table
function AddAdvisors(position,firstname,lastname,email_id){
	
	if(position == null || position == ""){
		return;
	}

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

//Template for qualifying subjects table
function setQualifyingExamTableTemplate(){

	var options = {
		columns: [{
			width: 36,
			formatter: getRowIndex,
			
		},	{
			field: "qualSubUniqueID",
			visible: false,
			
    	},	{
		    field: "qualifyingSubject",
		    title: "Qualifying Exam Subject",
		    align: 'center',
		}, {
		    field: "qualifyingSubjectGrade",
		    title: "Grade",
		    align: 'center',
		}],
		data: []
	};
	
	$('#qualifying_subject_table').bootstrapTable(options);
	
}


//Populate qualifying subjects table
function AddQualifyingSubjects(qual_subjects, qual_grades){
	
	if(qual_subjects == null || qual_subjects == ""){
		return;
	}
	
	$("#qualifying_exam_subjects_div").show();
	
	//JSON object to store subjects and their respective grades
	var rows = [];
	
	for(var i = 0; i < qual_subjects.length; i++){
		var row = {'qualSubUniqueID':i + 1, 'qualifyingSubject':qual_subjects[i], 'qualifyingSubjectGrade':qual_grades[i]};
		rows.push(row);
	}
	
	$("#qualifying_subject_table").bootstrapTable('refreshOptions', {'data' : rows})
}

//Template for ComprehensiveExam table
function setComprehensiveExamTableTemplate(){

	var options = {
		columns: [{
			width: 36,
			formatter: getRowIndex,
			
		},	{
			field: "compExamUniqueID",
			visible: false,
			
    	},	{
		    field: "comprehensiveExam",
		    title: "Written Comprehensive Exam",
		    align: 'center',
		    
		}, {
		    field: "compExamGrade",
		    title: "Grade",
		    align: 'center',
		    
		}],
		data: []
	};

	$('#comprehensiveExamTable').bootstrapTable(options);

}

//Populate ComprehensiveExam table
function AddComprehensiveExams(exam_list, grade_list){

	if(exam_list == null || exam_list == ""){
		return;
	}

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

//Function for changes in Yes-No radiobutton for 'Colloquium/Distinguished Lecture Series Attended?'
function Check_Colloquium_Attended(colloquium_attended){
	
	if (colloquium_attended == 1) {
		$("#colloquium_semester_div").show();
	}
	else if (colloquium_attended == 0){
		$('#colloquium_semester_div').hide();
	}

}


//Template for Current Goals table
function setCurrentGoalsTableTemplate(){

var options = {
    columns: [{
    	width: 36,
    	formatter: getRowIndex,
    	
    },	{
    	field: "currentGoalUniqueID",
    	visible: false,
    },	{
        field: "currentGoal",
        title: "Current Accomplished Goals",
        align: 'center',
    }],
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

//Template for Publications table
function setPublicationsTableTemplate(){

	var options = {
		columns: [{
			width: 36,
			formatter: getRowIndex,
			
		},	{
			field: "publicationUniqueID",
			visible: false,
		},	{
		    field: "publication",
		    title: "Publications",
		    align: 'center',
		}],
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

//Template for Presentations table
function setPresentationsTableTemplate(){

var options = {
    columns: [{
    	width: 36,
    	formatter: getRowIndex,
    	
    },	{
    	field: "presentationUniqueID",
    	visible: false,
    },	{
        field: "presentation",
        title: "Presentations",
        align: 'center',
    }],
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


//Template for FutureGoals table
function setFutureGoalsTableTemplate(){

var options = {
    columns: [{
    	width: 36,
    	formatter: getRowIndex,
    	
    },	{
    	field: "futureGoalUniqueID",
    	visible: false,
    	
    },	{
        field: "futureGoal",
        title: "Future Goals",
        align: 'center',
    }],
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

//Function to display comments
function DisplayStudentComments(comments){

	//Whitespaces regex
	var whitespace_regex = /^\s+$/;
	
	if(comments == null || whitespace_regex.test(comments) || comments == ""){
		$("#comments_textarea").val("None");
	}
	else{
		$("#comments_textarea").val(comments);
	}
}

//Function to display Advisor Approval
function DisplayAdvisorApproval(advisory_com_present){
	if(advisory_com_present == 1)
		$("#advisor_approval_yes_div").show();
	else if(advisory_com_present == 0)
		$("#advisor_approval_no_div").show();
}

