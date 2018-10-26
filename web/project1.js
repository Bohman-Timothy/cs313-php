/*document.forms["search"].elements["searchType"].addEventListener("click", showScope);
document.forms["search"].elements["searchLoans"].addEventListener("click", showScope);*/

function showFeatureIdInputField() {
	var updateFeatureCheckbox = document.getElementById("updateFeatureCheckbox_id");
	var enterFeatureIdHiddenArea = document.getElementById("enterFeatureIdHiddenArea_id");
	
	if (updateFeatureCheckbox.checked == true) {
		enterFeatureIdHiddenArea.style.visibility = "visible";
	}
	else {
		enterFeatureIdHiddenArea.style.visibility = "hidden";
	}
}

//AJAX Non-working example code
/*$("#newScriptureEntry_id").submit(function(e) {
    var form = $(this);
    var url = form.attr('action');

    $.ajax({
        type: "POST",
        url: url,
        data: form.serialize(),
        success: function(data) {
            alert(data);
            console.log('Form submitted by AJAX');
        }
    });

    e.preventDefault(); // Prevents form from submitting the normal way
});*/

function showCurrentLoansOption() {
	var searchLoansCheckbox = document.getElementById("searchLoans_id");
	var currentLoans = document.getElementById("currentLoans_id");
	
	if (searchLoansCheckbox.checked == true) {
		currentLoans.style.display = "block";
	}
	else {
		currentLoans.style.display = "none";
	}
}

/*function showScope() {
	var patronOption = document.getElementById("patronOption_id");
	var searchAllFeatures = document.getElementById("searchAllFeatures_id");
	var searchLoansCheckbox = document.getElementById("searchLoans_id");
	
	if ((patronOption.checked == true) || (searchLoansCheckbox.checked == true)) {
		searchAllFeatures.style.display = "none";
	}
	else {
		searchAllFeatures.style.display = "block";
	}
}*/

function showReferences() {
	var referencesList = document.getElementById("referencesList_id");
	var clickToShowReferences = document.getElementById("clickToShowReferences_id");

	if (referencesList.style.display == "none") {
		referencesList.style.display = "block";
		clickToShowReferences.textContent = "Click heading to hide references";
	}
	else {
		referencesList.style.display = "none";
		clickToShowReferences.textContent = "Click heading to show references";
	}
}