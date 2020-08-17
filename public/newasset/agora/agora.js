// rtc object
var rtc = {
    client: null,
    joined: false,
    published: false,
    localStream: null,
    remoteStreams: [],
    params: {}
  };
  
  // Options for joining a channel
  var option = {
    appID: "6bd9cd46a04847c6995ef5cca3e1fd6f",
    channel: "Channel name",
    uid: null,
    token: $('meta[name="csrf-token"]').attr('content')
  };



// Create a client
rtc.client = AgoraRTC.createClient({mode: "live", codec: "h264"});

// Initialize the client
rtc.client.init(option.appID, function () {
  console.log("init success");
  }, (err) => {
  console.error(err);
});