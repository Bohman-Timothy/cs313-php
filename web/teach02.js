function clickMe() {
    alert("Clicked!");
}
function customColorJS() {
    var userColor = document.getElementById("colorInputJS").value;
    document.getElementById("custom_color_js").style.backgroundColor = userColor;
    return 0;
}

$(document).ready(function() {
    var faded = false;
    
    $("#changeColorJQ").click(function() {
	$("#custom_color_jq").css("background-color", $("#colorInputJQ").val());
    });

    $("#fadeButton").click(function() {
	if(!faded) {
	    $("#fade").fadeOut("slow","linear");
	    faded = true;
	    $("#fadeButton").text("Fade in");
	}
	else {
	    $("#fade").fadeIn("slow","linear");
	    faded = false;
	    $("#fadeButton").text("Fade out");
	}
    });
});
