function clickMe() {
    alert("Clicked!");
}
function customColorJS() {
    var userColor = document.getElementById("colorInputJS").value;
    document.getElementById("custom_color_js").style.backgroundColor = userColor;
    return 0;
}
/*function customColorJQ() {
	var userColor = $("#colorInputJQ").val();
    alert("Value: " + $("#colorInputJQ").val());
    $(document).ready(function(){
	$("#").css("background-color", userColor);
    });
}*/

$(document).ready(function() {
    var faded = false;
    
    $("#changeColorJQ").click(function() {
	$("#custom_color_jq").css("background-color", $("#colorInputJQ").val());
    });

    $("#fadeButton").click(function() {
	if(!faded) {
	    $("#fade").fadeOut("slow","linear");
	    faded = true;
	    $("#fadeButton").text("Fade In");
	}
	else {
	    $("#fade").fadeIn("slow","linear");
	    faded = false;
	    $("#fadeButton").text("Fade Out");
	}
    });
});
