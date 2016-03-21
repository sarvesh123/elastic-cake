function focusToEnd(elem) {
	elem.focus();
	elem.selectionStart = elem.selectionEnd = elem.value.length
}

focusToEnd(document.getElementById('search'));

function submitSearch() {
	window.location.href = '/posts/search/' + document.getElementById('search').value;
}