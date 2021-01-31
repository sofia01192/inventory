importScripts('https://www.gstatic.com/firebasejs/8.2.2/firebase-app.js')
importScripts('https://www.gstatic.com/firebasejs/8.2.2/firebase-messaging.js')

var firebaseConfig = {
  apiKey: "AIzaSyDPpsEZx5CkqhmPY0_R48l48jDwLhqAzoE",
  authDomain: "inventory-management-33945.firebaseapp.com",
  projectId: "inventory-management-33945",
  storageBucket: "inventory-management-33945.appspot.com",
  messagingSenderId: "457849077910",
  appId: "1:457849077910:web:c6dda4045a9c401614c2b7",
  measurementId: "G-7VTWCP14L3"
};
firebase.initializeApp(firebaseConfig);
  const fcm = firebase.messaging();
  var mtoken;
  fcm.getToken({
      vapidKey:'BK8jRCeiFci3VZbquxw6dUGFKyh0rnggpDywCikHl9H7e3FOo1jXLdBUsNv_twawrHp17ibXzMQUuEIj8_E0gG4'

  }).then((token)=>{
      console.log('token: ',token);
      //mtoken=token
  });
  // Initialize Firebase
  // firebase.initializeApp(firebaseConfig);

  // const fcm = firebase.messaging()
  // fcm.getToken({
  //     vapidKey:'BKtgNNC2Im8n3Ri6fO56NR0BBLdNAf39sfpjzXXD6hWNPuEfFu-PxsQahRjzBQ7OkHmGb5UyNg1fMRAaZsb_n64'

  // }).then((token)=>{
  //     console.log('token: ',token);
  // });

  fcm.onBackgroundMessage((data) => {
    console.log('onBackgroundMessage: ', data)
    let title = data['data']['title']
    let body = data['data']['body']
  
    self.registration.showNotification(title, {
      body: body
    });
  })
