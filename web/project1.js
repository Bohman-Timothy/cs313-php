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