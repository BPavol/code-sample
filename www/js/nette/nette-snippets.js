/**
 * Nette Snippets for Nette 2.4
 *
 * @author BPavol
 * @version 1.0.0-dev
 */

function NetteSnippets(){
	this.stopProcessing = false;
}

/**
 * Handle data from Nette JSON response 
 */
NetteSnippets.handle = function(data) {
	if (this.stopProcessing) {
		return false;		
	}
	
	if (data.redirect) {
		window.location.href = data.redirect;
		this.stopProcessing = true;
	}
		
	if (data.snippets) {
		NetteSnippets.handleSnippets( data.snippets );
	}
	
	if (data.form) {
		NetteSnippets.handleForm( data.form );
	}
};

/**
 * Function for handling snippets 
 */
NetteSnippets.handleSnippets = function (snippets) {
	var reloadedSnippets = [];

	for( var index in snippets )
		reloadedSnippets.push({element: $('#'+index), data: snippets[index], index: index});
		
	$.each( reloadedSnippets, function (index, value) {
		var snippet = this;
		
		snippet.element.html(snippet.data);				
	});
};

/* Function for handling ajax form data */
NetteSnippets.handleForm = function (forms) {
	for (var formId in forms) {
		var form = $('#' + formId);
				
		if (forms[formId].errors) {
			for (var inputId in forms[formId].errors) {
				if(typeof Nette !== 'undefined'){
					Nette.addError(form.find('#'+inputId).get(0), forms[formId].errors[inputId].join('<br />'));
				}
			}
		}
		
		if (forms[formId].clear) {
			for(var j in forms[formId].clear){
				form.find('#'+forms[formId].clear[j]).val('');
			}
		}
	}
};