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

function showScope() {
	var patronOption = document.getElementById("patronOption_id");
	var searchAllFeatures = document.getElementById("searchAllFeatures_id");
	var searchLoansCheckbox = document.getElementById("searchLoans_id");
	
	if ((patronOption.checked == true) || (searchLoansCheckbox.checked == true)) {
		searchAllFeatures.style.display = "none";
	}
	else {
		searchAllFeatures.style.display = "block";
	}
}

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