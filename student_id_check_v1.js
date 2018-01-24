

function Formsubmit(){
    if (document.getElementById('student_form_details-0').checked) {
        document.getElementById('form_student_id').style.display = 'block';
    }
    else
	{	 
		document.getElementById('form_student_id').style.display = 'none';
		$('#asu_id').val("");
	}
}
