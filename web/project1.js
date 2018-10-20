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
}

function showReferences() {
	var referencesList = document.getElementById("referencesList_id");
	var clickToExpand = document.getElementById("clickToExpand_id");

	if (referencesList.style.display == "none") {
		referencesList.style.display = "block";
		clickToExpand.textContent = "Click heading to hide references";
	}
	else {
		referencesList.style.display = "none";
		clickToExpand.textContent = "Click heading to expand references";
	}
}