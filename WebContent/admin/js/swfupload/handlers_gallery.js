/* Demo Note:  This demo uses a FileProgress class that handles the UI for displaying the file name and percent complete.
The FileProgress class is not part of SWFUpload.
*/


/* **********************
   Event Handlers
   These are my custom event handlers to make my
   web application behave the way I went when SWFUpload
   completes different tasks.  These aren't part of the SWFUpload
   package.  They are part of my application.  Without these none
   of the actions SWFUpload makes will show up in my application.
   ********************** */
function preLoad() {
	if (!this.support.loading) {
		alert("You need the Flash Player 9.028 or above to use SWFUpload.");
		return false;
	}
}
function loadFailed() {
	this.customSettings.fileErrors.show().prepend('<div><strong>Fout:</strong> De file-uploader kan niet gestart worden. Neem contact op met BE-Interactive als dit probleem zich blijft voordoen!</div>');
}

function fileQueued(file) {
	try {
		this.customSettings.filesQueued.innerHTML = this.getStats().files_queued;
	} catch (ex) {
		this.debug(ex);
	}
}

function fileDialogComplete() {
	this.startUpload();
	if (this.getStats().files_queued > 0) {
		$('#swf_status').show();
	}
}

function uploadStart(file) {
	try {
		this.customSettings.progressCount = 0;
		updateDisplay.call(this, file);
		this.customSettings.filesStatus.show().html('Afbeelding uploaden...');
	}
	catch (ex) {
		this.debug(ex);
	}
	
}

function uploadProgress(file, bytesLoaded, bytesTotal) {
	try {
		this.customSettings.progressCount++;
		updateDisplay.call(this, file);
	} catch (ex) {
		this.debug(ex);
	}
	
}


function fileQueueError(file, errorCode, message) {
	try {

		switch (errorCode) {
			case SWFUpload.QUEUE_ERROR.QUEUE_LIMIT_EXCEEDED:
				this.customSettings.fileErrors.show().prepend('<div><strong>Fout:</strong> u probeert teveel bestanden tegelijkertijd te uploaden. <em>'+message+'</em> is maximaal toegestaan.</div>');
				return;
				break;
			case SWFUpload.QUEUE_ERROR.ZERO_BYTE_FILE:
			case SWFUpload.QUEUE_ERROR.INVALID_FILETYPE:
				this.customSettings.fileErrors.show().prepend('<div><strong>Fout:</strong> Kan bestand <em>'+file.name+'</em> niet uploaden omdat het geen correct bestand is.</div>');
				break;
			case SWFUpload.QUEUE_ERROR.FILE_EXCEEDS_SIZE_LIMIT:
				this.customSettings.fileErrors.show().prepend('<div><strong>Fout:</strong> Kan bestand <em>'+file.name+'</em> niet uploaden omdat het bestand te groot is </div>');
				break;
			default:
				this.customSettings.fileErrors.show().prepend('<div><strong>Fout:</strong> <em>'+message+' | '+errorCode+'</em></div>');
				break;
		}

	} catch (ex) {
		this.debug(ex);
	}
}


function uploadSuccess(file, serverData) {
	try {
		updateDisplay.call(this, file);
		this.customSettings.filesStatus.append('thumbnail genereren...');
		var status_array = jQuery.parseJSON(serverData);
		
		// upload status
		if(status_array.upload_status) {
			this.customSettings.fileData.show().prepend(status_array.upload_status);
		}
		
		// verplaats + thumb status
		if(status_array.upload_verplaatst && status_array.thumb_verplaatst ) {
			$("#thumbnails").prepend(status_array.img_preview);
			
			$("img[rel='"+status_array.file_id+"']").load(function() {
				var image = $("img[rel='"+status_array.file_id+"']");
				$(image).animate({
					opacity:1
				},1000);							
			});
		}
		
		if (status_array.melding) {
			this.customSettings.fileErrors.show().prepend(status_array.melding);
		}

	} catch (ex) {
		this.debug(ex);
	}
}

function uploadComplete(file) {
	this.customSettings.filesQueued.show().html(this.getStats().files_queued);
	this.customSettings.filesUploaded.show().html(this.getStats().successful_uploads);
	
	if (this.getStats().files_queued > 0) {
		//this.customSettings.tdErrors.innerHTML = this.getStats().upload_errors;
	} else {
		this.customSettings.filesStatus.html('Klaar met uploaden!');
		var targets = this.customSettings;
		setTimeout(function() {
			targets.fileLoader.animate({width:'0%'},300);
			targets.fileErrors.hide(300).html('');
			targets.fileData.hide(300).html('');
		}, 2000);
	}
}

function updateDisplay(file) {
	this.customSettings.fileLoader.animate({width:file.percentUploaded+'%'},10);
}