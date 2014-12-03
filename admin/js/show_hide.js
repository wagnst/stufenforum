/* show-hide Javascript */
function showhide() {
	new Fx.Reveal($$('div.show-hide')[0]).dissolve();
	$$('div.show-hide-content')[0].reveal();
}
function toggle(control){
	var elem = document.getElementById(control);
	if(elem.style.display == "none"){
	elem.style.display = "block";
	}else{
	elem.style.display = "none";
	}
}