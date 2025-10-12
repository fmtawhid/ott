var session = null;
let video = null;

$(document).ready(function () {
  var loadCastInterval = setInterval(function () {

    // if(chrome.cast == "undefined")
    // {
    if (chrome.cast && chrome.cast.isAvailable) {
      console.log('Cast has loaded.');
      clearInterval(loadCastInterval);
      initializeCastApi();
    }
    // }
  }, 1000);
});


function initializeCastApi() {
  var applicationID = chrome.cast.media.DEFAULT_MEDIA_RECEIVER_APP_ID;
  var sessionRequest = new chrome.cast.SessionRequest(applicationID);
  var apiConfig = new chrome.cast.ApiConfig(sessionRequest,
    sessionListener,
    receiverListener);
  chrome.cast.initialize(apiConfig, onInitSuccess, onInitError);
};


function sessionListener(e) {
  session = e;
  console.log('New session');
  if (session.media.length != 0) {
    console.log('Found ' + session.media.length + ' sessions.');
  }
}

function receiverListener(e) {
  if (e === 'available') {
    console.log("Chromecast was found on the network.");
  }
  else {
    console.log("There are no Chromecasts available.");
  }
}


function onInitSuccess() {
  console.log("Initialization succeeded");
}


function onInitError() {
  console.log("Initialization failed");
}


$('#castme').click(function () {
  video = this.getAttribute('data-name');
  console.log('click video --- ' + video);
  launchApp();
});


function launchApp() {
  console.log("Launching the Chromecast App...");
  chrome.cast.requestSession(onRequestSessionSuccess, onLaunchError);
}


function onRequestSessionSuccess(e) {
  console.log("Successfully created session: " + e.sessionId);
  session = e;
}


function onLaunchError() {
  console.log("Error connecting to the Chromecast.");
}


function onRequestSessionSuccess(e) {
  console.log("Successfully created session: " + e.sessionId);
  session = e;
  loadMedia();
}


function loadMedia() {

  console.log('loadMedia --- ' + video);

  if (!session) {
    console.log("No session.");
    return;
  }

  if (video == '') {
    console.log("Video link not available.");
    return;
  }

  // const str = video
  // const pieces = str.split(/[\s.]+/)
  // const last = pieces[pieces.length - 1]

  var mediaInfo = new
  chrome.cast.media.MediaInfo(video);
  // mediaInfo.contentType = 'video/'+last;

  var request = new chrome.cast.media.LoadRequest(mediaInfo);
  request.autoplay = true;

  session.loadMedia(request, onLoadSuccess, onLoadError);
}


function onLoadSuccess() {
  console.log('Successfully loaded.');
}


function onLoadError() {
  console.log('Failed to load.');
}


$('#stop').click(function () {
  stopApp();
});


function stopApp() {
  session.stop(onStopAppSuccess, onStopAppError);
}


function onStopAppSuccess() {
  console.log('Successfully stopped app.');
}


function onStopAppError() {
  console.log('Error stopping app.');
}
