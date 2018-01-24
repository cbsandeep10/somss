degree : null  student_v1.js:1894:3
academic_year_fall : 2016  student_v1.js:1897:3
first_name :   student_v1.js:1900:3
second_name :   student_v1.js:1903:3
asu_id :   student_v1.js:1906:3
student_emailID : @asu.edu  student_v1.js:1909:3
program_start_date :   student_v1.js:1912:3
semester_in_progress : null  student_v1.js:1915:3
cumulative_gpa :   student_v1.js:1918:3
advisory_committee_formed : undefined  student_v1.js:1921:3
met_advisor : undefined  student_v1.js:1924:3
cumulative_gpa :   student_v1.js:1927:3
comprehensive_exam_completed : undefined  student_v1.js:1930:3
dissertation_prosectus_completed : undefined  student_v1.js:1933:3
colloquium : undefined  student_v1.js:1936:3
qualifying_exam_completed : undefined  student_v1.js:1941:3
comments : 



$("#degreeProgramAlertDiv").hide();
$("#academicYearAlertDiv").hide();
$("#firstNameAlertDiv").hide();
$("#lastNameAlertDiv").hide();
$("#asuIDAlertDiv").hide();
$("#asuriteIDAlertDiv").hide();
$("#pgmStartDateAlertDiv").hide();
$("#semInProgressAlertDiv").hide();
$("#cumGPAAlertDiv").hide();
$("#advisorTableAlertDiv").hide();
$("#chairNotMetAlertDiv").hide();
$("#qualExamTableAlertDiv").hide();

//Initialize tooltip for 'No' radiobutton
$('input[rel="advCommTooltip"]').tooltip();

if(position == null || position == ""){
		$("#advisory_committee_no").prop("disabled",false);
		$('input[rel="advCommTooltip"]').tooltip("destroy");
		return;
	}

//add row
$('input[rel="advCommTooltip"]').tooltip();

//remove row -> rowcount = 0
$('input[rel="advCommTooltip"]').tooltip("destroy");


<th data-formatter="getRowIndex" style="width: 36px;"></th>
<th data-field="presentationUniqueID" visible="false"></th>


//Template for Courses table
function setCourseTableTemplate(){

var options = {
    columns: [{
    	field: "selectBoxCourse",
    	checkbox: true,
    
    },	{
    	width: 36,
    	formatter: getRowIndex,
    	
    },	{
    	field: "futureGoalUniqueID",
    	visible: false,
    },	{
        field: "course",
        title: "Course<span class='glyphicon glyphicon-info-sign help_current_goal'></span>",
        titleTooltip: "Courses taken since last progress with grades",
        align: 'center',
        editable: {
        	type: 'text',
        	mode: 'inline',
        },
    }, {
        field: "grade",
        title: "Grade",
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
		var row = {'futureGoalUniqueID':i + 1, 'course':Course_details[i], 'grade':Grade_details[i]};
		rows.push(row);
	}

	//Populate Courses table with values in 'rows' object
	var options = $("#coursesTable").bootstrapTable('getOptions');
	options["data"] = rows;
	$('#coursesTable').bootstrapTable('refreshOptions',{'data' : options["data"]});
	options = $("#coursesTable").bootstrapTable('getOptions');
	
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
		unique_id = $("#coursesTable").bootstrapTable('getData')[total_rows-1].futureGoalUniqueID + 1;
	else
		unique_id = 1;
	
	
	var row_data = {'futureGoalUniqueID':unique_id, 'course': courseName, 'grade': grade};
	$("#coursesTable").bootstrapTable('append',row_data);

	//reset form inputs
	$("#courseTitle").val("");
	$("#courseGrade").val("-1");
	
	$("#addCourseModal").modal("toggle");
}

//Remove row(s) from Courses table
function removeCourseRow(){
	
	var currentGoalUniqueIDs = $.map($("#coursesTable").bootstrapTable('getSelections'), function (row) {
		return row.futureGoalUniqueID;
	});
    $("#coursesTable").bootstrapTable('remove', {
        field: 'futureGoalUniqueID',
        values: currentGoalUniqueIDs
    });
}
