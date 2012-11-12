function check_erv(obj,id) {
	var checkbox = document.getElementById(id);
	checkbox.checked = (checkbox.checked) ? false : true;
	
	var parent1 = obj.parentNode; // 1 omhoog
	var parent2 = parent1.parentNode; // 2 omhoog
	var parent3 = parent2.parentNode; // 3 omhoog
	var parent4 = parent3.parentNode; // 4 omhoog
	parent4.className = (checkbox.checked)? 'check_erv' : '';
	parent4.style.borderColor = (checkbox.checked)? '#f00' : '#bbb';
}

function check_foto(obj) {
	var checkbox = document.getElementById('standaardfoto');
	checkbox.checked = (checkbox.checked) ? false : true;
	
	var parent1 = obj.parentNode; // 1 omhoog
	var parent2 = parent1.parentNode; // 2 omhoog
	parent2.className = (checkbox.checked) ? 'gallerij check' : 'gallerij';
}

function check_thumb(obj,id,naam) {
	var checkbox = document.getElementById(id);
	checkbox.checked = (checkbox.checked) ? false : true;
	
	var parent1 = obj.parentNode; // 1 omhoog
	var parent2 = parent1.parentNode; // 2 omhoog
	parent2.className = (checkbox.checked)? 'gallerij check' : 'gallerij';
}

function check_file(obj,id) {
	document.getElementById(id).className = (obj.checked)? 'check' : '';
}

function edit_meta(obj,id) {
	var inhoud = obj.innerHTML;
	var check_inhoud = inhoud.substr(0,9);
	if (check_inhoud != '<textarea') {
		obj.innerHTML = '<textarea name="meta['+ id +']" class="text_veld meta" cols="15" rows="2">'+ inhoud +'</textarea>';
		document.forms['form'].elements['meta['+ id +']'].focus();
	} else {
		return;
	}
}

function explode( delimiter, string, limit ) {
    // http://kevin.vanzonneveld.net
    var emptyArray = { 0: '' };
    
    // third argument is not required
    if ( arguments.length < 2
        || typeof arguments[0] == 'undefined'
        || typeof arguments[1] == 'undefined' )
    {
        return null;
    }
 
    if ( delimiter === ''
        || delimiter === false
        || delimiter === null )
    {
        return false;
    }
 
    if ( typeof delimiter == 'function'
        || typeof delimiter == 'object'
        || typeof string == 'function'
        || typeof string == 'object' )
    {
        return emptyArray;
    }
 
    if ( delimiter === true ) {
        delimiter = '1';
    }
    
    if (!limit) {
        return string.toString().split(delimiter.toString());
    } else {
        // support for limit argument
        var splitted = string.toString().split(delimiter.toString());
        var partA = splitted.splice(0, limit - 1);
        var partB = splitted.join(delimiter.toString());
        partA.push(partB);
        return partA;
    }
}

function urlencode( str ) {
    var ret = str;
    ret = ret.toString();
    ret = escape(ret);
    ret = ret.replace(/%20/g, '+');
    return ret;
}

// fckeditor
function CreateEditor(naam,type,size) {
	// Create an instance of FCKeditor (using the target textarea as the name).
	var oFCKeditor = new FCKeditor('editor_'+naam);
	oFCKeditor.ToolbarSet = type;
	oFCKeditor.Height = size;
	oFCKeditor.ReplaceTextarea();
}

// standaard jQuery
function loader_show() {
	//$('#loading').fadeIn(200);
	$('#loading_sprite').fadeIn(200).sprite({fps: 24, no_of_frames: 24, play_frames: 24});
}
function loader_hide() {
	setTimeout(function() {
		$('#loading_sprite').fadeOut(200);
	}, 1000);
}

