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

function checkDefaultFormat() {
    var format = "format";
    var formatId = "2"; //DVD is default
    var idAppended = "_id";
    var selectedFormatId = format.concat(formatId.concat(idAppended));
    var selectedFormat = document.getElementById(selectedFormatId);
    selectedFormat.checked = true;
}

function checkDefaultLocation() {
    var location = "location";
    var locationId = "1"; //Bedroom is default
    var idAppended = "_id";
    var selectedLocationId = location.concat(locationId.concat(idAppended));
    var selectedLocation = document.getElementById(selectedLocationId);
    selectedLocation.checked = true;
}

function isValidForm() {
    var addToCheckoutCheckbox = document.getElementById("addToCheckout_id");
    if (addToCheckoutCheckbox.isChecked) {
        return true;
    }
    else {
    	return false;
    }
}

function selectCheckbox() {
    var addToCheckoutCheckbox = document.getElementById("addToCheckout_id");
    addToCheckoutCheckbox.isChecked = true;
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
	var searchLoansCheckbox = document.getElementById("searchLoansOnly_id");
	var searchCurrentLoansHiddenArea = document.getElementById("searchCurrentLoansHiddenArea_id");
	var searchCurrentLoansCheckbox = document.getElementById("searchCurrentLoans_id");

	if (searchLoansCheckbox.checked == true) {
        searchCurrentLoansHiddenArea.style.display = "block";
		searchCurrentLoansCheckbox.checked = true;
	}
	else {
        searchCurrentLoansHiddenArea.style.display = "none";
        searchCurrentLoansCheckbox.checked = false;
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