/* Login Javascript */
window.addEvent('domready', function() {
	$$('div.help')[0].set('reveal', {duration: 'long', transition: 'expo:in:out'});
	var button = $$('form.login button')[0];
	button.addEvent('click', function(e){
		var user = $$('form.login input#benutzer').get('value');
		var password = $$('form.login input#passwort').get('value');
		user.clean();
		password.clean();
		if (user == "" || password == "") {
			$$('form.login input#benutzer')[0].focus();
			button.highlight('#ff3d00');
			e.stop();
		}
	});
	
	
	var textboxes = $$('form.login input.input-text');
	textboxes.each(function(input, index){
		var label = input.getPrevious('label');
		
		input.addEvent('focus', function(){
			if (input.value == "") {
				label.addClass('focus');
			}
		});
		
		input.addEvent('blur', function(){
			if (input.value == ""){
				label.removeClass('focus');
				label.removeClass('hastext');
			}
		});
		
		if (input.value != "") {
			label.addClass('hastext');
		}
		
		input.addEvent('keypress', function() {
			label.addClass('hastext');
		});
	});
	
});

function showHelp() {
	new Fx.Reveal($$('div.show-help')[0]).dissolve();
	$$('div.help')[0].reveal();
}
function toggle(control){
	var elem = document.getElementById(control);
	if(elem.style.display == "none"){
	elem.style.display = "block";
	}else{
	elem.style.display = "none";
	}
}