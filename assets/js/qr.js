function domReady(fn) {
	if (
		document.readyState === "complete" ||
		document.readyState === "interactive"
	) {
		setTimeout(fn, 1000);
	} else {
		document.addEventListener("DOMContentLoaded", fn);
	}
}

domReady(function () {
    let scan_result = document.getElementById('scan_result');
    let event_id = document.getElementById('event_id').value;

	// If found you qr code
	function onScanSuccess(decodeText, decodeResult) {
        scan_result.value=decodeText
        // alert("You Qr is : " + decodeText, decodeResult);
        verifyMemberId( scan_result.value,event_id)
	}

	let htmlscanner = new Html5QrcodeScanner(
		"my-qr-reader",
		{ fps: 10, qrbos: 250 }
	);
	htmlscanner.render(onScanSuccess);
});

function verifyMemberId(scan_result, event_id) {
    
    $.ajax({
        url: 'verify-member-qr.php',
        method: 'POST',
        data: {
            member_id: scan_result,
            event_id: event_id
        },
        success: function(result) {
            alert(result);
            location.reload(true)
        },
        error: function(xhr, status, error) {
            alert("Error occurred: " + error);
        }
    });
}

$("#scanner").click(function(){
    let scan_result = document.getElementById('scan_result').value;
    let event_id = document.getElementById('event_id').value;
    if(scan_result ==''){
        alert('please provide member id')
    }else{
        verifyMemberId(scan_result,event_id)

    }
})



