// JavaScript Document
// PinVoyage Clipper Javascript to be loaded in to bookmarklet

/* Daycan: this code is meant to ensure that the jQuery libraries don't conflict with those of the original page
if (!($ = window.jQuery)) { // typeof jQuery=='undefined' works too  
    script = document.createElement( 'script' );  
   script.src = 'http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js';  
    script.onload=releasetheKraken;  
    document.body.appendChild(script);  
}  
else {  
    releasetheKraken();  
}  
*/

(function(window){
  var $;

  /* This is run after we've connected to Trello and selected a list */
  var run = function(Trello, idList) {
    var name;
    // Default description is the URL of the page we're looking at
    var desc = location.href;
	
	// there was a bunch of stuff here based on the type of information that had been cut which seemed specific to GitHub

    // Get any selected text
    var selection;

    if(window.getSelection) {
      selection = ""+window.getSelection();
    } else if(document.selection && document.selection.createRange) {
      selection = document.selection.createRange().text;
    }

    // If they've selected text, add it to the name/desc of the card
    if(selection) {
      if(!name) {
        name = selection;
      } else {
        desc += "\n\n" + selection;
      }
    }

    // Create the card
    if(name) {
      /* replace this with something that posts to PinVoyage (DB?)
	  Trello.post("lists/" + idList + "/cards", { 
        name: name, 
        desc: desc
      }*/, function(card){
        // Display a little notification in the upper-left corner with a link to the card
        // that was just created
        var $cardLink = $("<a>")
        .attr({
          href: card.url,
          target: "card"
        })
        .text("Created a Trello Card")
        .css({
          position: "absolute",
          left: 0,
          top: 0,
          padding: "4px",
          border: "1px solid #000",
          background: "#fff",
          "z-index": 1e3
        })
        .appendTo("body")

        setTimeout(function(){
          $cardLink.fadeOut(3000);
        }, 5000)
      })
    }
  }

  var storage = window.localStorage;
  if(!storage) {
    return;
  }

  // Store/retrieve a value from local storage
  var store = function(key, value){
    if(arguments.length == 2){
      return (storage[key] = value);
    } else {
      return storage[key];
    }
  };

  // A fake "prompt" to get info from the user
  var overlayPrompt = function(html, hasInput, callback){
    var done = function(value){
      $div.remove();
      $overlay.remove();
      callback(value);
    };

    // Cover the existing webpage with an overlay
    var $overlay = $("<div>")
    .css({
      background: "#000",
      opacity: .75,
      "z-index": 1e4,
      position: "absolute",
      left: 0,
      top: 0,
      right: 0,
      bottom: 0
    })
    .appendTo("body")
    .click(function(){
      done(null);
    })

    // Show a "popup"
    var $div = $("<div>")
    .css({
      position: "absolute",
      border: "1px solid #000",
      padding: "16px",
      width: 300,
      top: 64,
      left: ($(window).width() - 200) / 2,
      background: "#fff",
      "z-index": 1e5
    })
    .appendTo("body");

    // Show the prompt
    $("<div>").html(html).appendTo($div);

    // Optionally show an input
    var $input = $("<input>")
    .css({ 
      width: "100%",
      "margin-top": "8px"
    })
    .appendTo($div)
    .toggle(hasInput);

    // Add an "OK" button
    $("<div>")
    .text("OK")
    .css({ 
      width: "100%", 
      "text-align": "center",
      border: "1px solid #000",
      background: "#eee",
      "margin-top": "8px",
      cursor: "pointer"
    })
    .appendTo($div)
    .click(function(){
      done($input.val());      
    });

    return $div;
  };

  // Run several asyncronous functions in order
  var waterfall = function(fxs){
    var runNext = function(){
      if(fxs.length){
        fxs.shift().apply(null, Array.prototype.slice.call(arguments).concat([runNext]))
      }
    }
    runNext();
  }

  // The ids of values we keep in localStorage
  var appKeyName = "trelloAppKey";
  var idListName = "trelloIdList";

  waterfall([
    // Load jQuery
    function(next) {
      if(window.jQuery) {
        next(null);
      } else {
        var script = document.createElement("script");
        script.src = "https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js";
        script.onload = next;
        document.getElementsByTagName("head")[0].appendChild(script);
      }
    },
    // Get the user's App Key, either from local storage, or by prompting them to retrieve it
    function(ev, next) {
      $ = window.jQuery;

      var appKey = store(appKeyName) || window[appKeyName];
      if(appKey && appKey.length == 32) {
        next(appKey);
      }
      else {
        overlayPrompt("Please specify your Trello API Key (you'll only need to do this once per site)<br><br>You can get your API Key <a href='https://trello.com/1/appKey/generate' target='apikey'>here</a><br><br>", true, function(newAppKey){
          if(newAppKey) {
            next(newAppKey);
          }
        })
      }
    },
    // Load the Trello script
    function(appKey, next) { $.getScript("https://trello.com/1/client.js?key=" + appKey, next); },
    // Authorize our application
    function(a, b, c, next) {
      store(appKeyName, Trello.key())
      Trello.authorize({
        interactive: false,
        success: next,
        error: function(){
          overlayPrompt("You need to authorize Trello", false, function(){
            Trello.authorize({
              type: "popup",
              expiration: "never",
              scope: { read: true, write: true },
              success: next
            });
          });
        }
      });
    },
    // Get the list to add cards to, either from local storage or by prompting the user
    function(next) {
      var idList = store(idListName) || window[idListName];
      if(idList && idList.length == 24) {
        next(idList);
      } else {
        Trello.get("members/me/boards", { fields: "name" }, function(boards){
          $prompt = overlayPrompt('Which list should cards be sent to?<hr><div class="boards"></div>', false, function(){
            idList = $prompt.find("input:checked").attr("id");
            next(idList);
          })

          $.each(boards, function(ix, board){
            $board = $("<div>").appendTo($prompt.find(".boards"))

            Trello.get("boards/" + board.id + "/lists", function(lists){
              $.each(lists, function(ix, list) {
                var $div = $("<div>").appendTo($board);
                idList = list.id;
                $("<input type='radio'>").attr("id", idList).attr("name", "idList").appendTo($div);
                $("<label>").text(board.name + " : " + list.name).attr("for", idList).appendTo($div);
              });
            })
          });
        });
      }      
    },
    // Store the idList for later
    function(idList, next) {
      if(idList) {
        store(idListName, idList);
        next(Trello, idList);
      }      
    },
    // Run the user portion
    run
  ]);
})(window);
