$(document).ready(function(){




    const rtc = {
        // For the local client.
        client: null,
        // For the local audio and video tracks.
        localAudioTrack: null,
        localVideoTrack: null,
      };
      
      const options = {
        // Pass your app ID here.
        appId: "6bd9cd46a04847c6995ef5cca3e1fd6f",
        // Set the channel name.
        channel: "islam_channel",
        // Pass a token if your project enables the App Certificate.
        token: null,
      };

      async function startBasicCall() {

        rtc.client = AgoraRTC.createClient({ mode: "rtc", codec: "h264" });
        const uid = await rtc.client.join(options.appId, options.channel, options.token, null);

        // Create an audio track from the audio sampled by a microphone.
        rtc.localAudioTrack = await AgoraRTC.createMicrophoneAudioTrack();
        // Create a video track from the video captured by a camera.
        rtc.localVideoTrack = await AgoraRTC.createCameraVideoTrack();
        // Publish the local audio and video tracks to the channel.
        await rtc.client.publish([rtc.localAudioTrack, rtc.localVideoTrack]);

        console.log("publish success!");


      }

    $('#start_live_button').on('click' ,function(){

        
             startBasicCall();

       
        
        


          
         

    });
});






