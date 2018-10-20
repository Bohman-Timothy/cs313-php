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
	var references = document.getElementById("references_id");
	var clickToExpand = document.getElementById("clickToExpand_id");

	if (references.style.display == "none") {
		references.style.display = "block";
		clickToExpand.content = "Click to hide";
	}
	else {
		references.style.display = "none";
		clickToExpand.content = "Click to expand";
	}
}