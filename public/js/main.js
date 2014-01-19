function formatJSON(json) {
    var i, list = "", props = [], property;
	
	if (typeof json === 'object') {
		list += "{<ul>";
		for (i in json) {
			props.push(i);
		}
		for (i = 0; i < props.length; i++) {
			list += "<li>\""+ (property = props[i]) +"\": ";
			if (typeof json[property] === "object") {
				list += formatJSON(json[property]);
			} else {
				list += "\"" + json[property] + "\"";
			}
			if (i < props.length - 1) {
				list += ",";
			}
			list += "</li>";
		}
		list += "</ul>}";
	} else {
		list += '<ul><li>' + json + '</li></ul>';
	}
	
    return list;
}