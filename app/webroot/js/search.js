function focusToEnd(elem) {
	elem.focus();
	elem.selectionStart = elem.selectionEnd = elem.value.length
}

focusToEnd(document.getElementById('search'));

function submitSearch() {

	var searchStr = '/posts/search/' + document.getElementById('search').value;
	
	if ( document.getElementById('max-price').value ) {
		searchStr += '/max-price:' + document.getElementById('max-price').value;
	}
	if ( document.getElementById('min-price').value ) {
		searchStr += '/min-price:' + document.getElementById('min-price').value;
	}

	window.location.href = searchStr;
}