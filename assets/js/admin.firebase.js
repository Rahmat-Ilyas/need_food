// Your web app's Firebase configuration
// For Firebase JS SDK v7.20.0 and later, measurementId is optional
var firebaseConfig = {
    apiKey: "AIzaSyA5g4U_FtOK7LX789QyNyJe90DmnastiI8",
    authDomain: "kesiniku.firebaseapp.com",
    projectId: "kesiniku",
    databaseURL: "https://kesiniku-default-rtdb.firebaseio.com",
    storageBucket: "kesiniku.appspot.com",
    messagingSenderId: "901477177108",
    appId: "1:901477177108:web:55420550d15c84c801d401",
    measurementId: "G-JNBXWW8J17"
};
// Initialize Firebase
firebase.initializeApp(firebaseConfig);
// firebase.analytics();
const messaging = firebase.messaging();
var database = firebase.database();
var data = database.ref('device_token/admin_device');


messaging.onMessage((payload) => {
    console.log('Message received. ', payload);
});

messaging.requestPermission().then(function () {
    console.log("Notification permission granted.");
    return messaging.getToken()
}).then(function(token) {
    data.on('value', function(items) {
        var result = items.val();
        var exits = false;
        $.each(result, function(key, val) {
            if (val != undefined) {
                if(val.token == token) {
                    exits = true;
                }
            }
        });

        if (exits == false) {
            data.push({
                device: "web",
                token: token
            }, function(error) {
               if (error) console.log(error);
               else console.log(token);
           });
        }
    }, function(err) {
        console.log(err);
    });
}).catch(function (err) {
    console.log("Unable to get permission to notify.", err);
});