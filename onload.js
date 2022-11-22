function bodyload() {
	Ufo.callback_add('dialog','get','dialog_get');
	Ufo.callback_add('dialog','abort','dialog_abort');
}
Ufo.callback_functions.dialog_abort = function(){
	document.getElementById('dialog').style.display = 'none';
	document.getElementById('dialog').innerHTML='';
}
Ufo.callback_functions.dialog_get = function(){
	document.getElementById('dialog').style.display = 'block';
}
Ufo.callback_functions.alert = function(string){
	alert(string);
}
