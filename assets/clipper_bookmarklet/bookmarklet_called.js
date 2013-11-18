// JavaScript Document
// PinVoyage Clipper Javascript to be loaded in to bookmarklet


(function(window){
	
	
	var PINVOYAGE_URL = "http://www.pinvoyage.com";
	
	// Load the CSS
	function loadCss(url) {
	  var el = document.createElement("link");
	  el.type = "text/css";
	  el.rel = "stylesheet";
	  el.href = url;
	
	  var head = document.getElementsByTagName("head")[0];
	  head.appendChild(el);
	};

	loadCss(PINVOYAGE_URL + "/assets/css/bootstrap-bookmarklet.css");
	
	// Capture the highlighted text and URL of the current page
    var pv_href = location.href;
    var pv_selection;
	var pv_imagesource;
	var range = window.getSelection().getRangeAt(0);

    if(window.getSelection) {
      pv_selection = ""+window.getSelection();
	  pv_imagesource = document.getElementsByTagName('img')[40].src;
    } else if(document.selection && document.selection.createRange) {
      pv_selection = document.selection.createRange().text;
	  // pv_imagesource = 
	  //"http://www.pinvoyage.com/assets/img/testimage.JPG";
	  //document.selection.getElementsByTagName('img')[0].attr('src');
	  }	
	  


    // Create the pop-up window	
    var $div = $("<div>")
    .css({
      position: "absolute",
      border: "1px solid #000",
	  shadow: "-moz-box-shadow: 8px 8px 4px #000; -webkit-box-shadow: 8px 8px 4px #000; box-shadow: 8px 8px 4px #000;",
      padding: "16px",
      width: 420,
	  height: 350,
      top: 64,
      left: ($(window).width() - 200) / 2,
      background: "#fff",
      "z-index": 1e5
    })
    .appendTo("body");

	
	// Show the prompt
    // $("<div>").html(html).appendTo($div);
	

	// title
	
	var $h3 = $("<h3>")
	.text("PinVoyage")
	.css({class: "muted"})
	.addClass("muted")
	.appendTo($div);
	
	var $h2 = $("<h2>")
	.text ("Clip to PinVoyage")
	.appendTo($div);
	
	// Show selected image	
	var img = $('<img />')
	.attr({  
		src: pv_imagesource
	})
	.appendTo($div);
	// $('<img />', { 'src': pv_imagesource, 'class': 'DCT_Card' })  
 	// .appendTo($div);
	
	
	
	// Text input for place title
	var $p = $("<p>")
	.text("Place title" + pv_imagesource)
	.appendTo($div);
	
    var $input = $("<input>")
    .css({ 
      width: "100%",
      "margin-top": "8px"
    })
    .appendTo($div)
	
	
	// Text area for place description
	var $p = $("<p>")
	.text("Add your description of the place here")
	.appendTo($div);

    var $textarea = $("<textarea>")
    .css({ 
      width: "100%",
	  height: 80,
      "margin-top": "8px"
    })
    .appendTo($div)
	.text(pv_selection)
	
	
	// Add an "OK" button
    var$div = $("<div>")
    .text("OK")
	.addClass("pv-button-primary")
	.addClass("btn btn-success")
    .appendTo($div)
    .click(function(){
      //insert 'ok' functionality here. Old code here: done($input.val());      
    });

})(window);