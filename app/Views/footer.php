
  <!-- Bootstrap core JavaScript-->
  <script src="<?= base_url('public/vendor/jquery/jquery.min.js')?> "></script>
  <script src="<?= base_url('public/vendor/bootstrap/js/bootstrap.bundle.min.js')?> "></script>

  <!-- Core plugin JavaScript-->
  <script src="<?= base_url('public/vendor/jquery-easing/jquery.easing.min.js')?> "></script>

  <!-- Custom scripts for all pages-->
  <script src="<?= base_url('public/js/sb-admin-2.min.js')?> "></script>

  <!-- Page level plugins -->
  <script src="<?= base_url('public/vendor/chart.js/Chart.min.js')?> "></script>

  <!-- Page level custom scripts -->
  <script src="<?= base_url('public/js/demo/chart-area-demo.js')?> "></script>
  <script src="<?= base_url('public/js/demo/chart-pie-demo.js')?> "></script>

  <!-- The core Firebase JS SDK is always required and must be listed first -->
<script src="https://www.gstatic.com/firebasejs/8.2.2/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.2.2/firebase-messaging.js"></script>


<script>
  // Your web app's Firebase configuration
  // For Firebase JS SDK v7.20.0 and later, measurementId is optional

  // var firebaseConfig = {
  //   apiKey: "AIzaSyB42wOll53yRQtogovtI7on2thnQnXf0pc",
  //   authDomain: "inventory-99b8a.firebaseapp.com",
  //   projectId: "inventory-99b8a",
  //   storageBucket: "inventory-99b8a.appspot.com",
  //   messagingSenderId: "944399221843",
  //   appId: "1:944399221843:web:4c2d125cf79515f6f372a6",
  //   measurementId: "G-4QL1JXX8GB"
  // };
  var firebaseConfig = {
    apiKey: "AIzaSyDPpsEZx5CkqhmPY0_R48l48jDwLhqAzoE",
    authDomain: "inventory-management-33945.firebaseapp.com",
    projectId: "inventory-management-33945",
    storageBucket: "inventory-management-33945.appspot.com",
    messagingSenderId: "457849077910",
    appId: "1:457849077910:web:c6dda4045a9c401614c2b7",
    measurementId: "G-7VTWCP14L3"
  };
  // Initialize Firebase
  firebase.initializeApp(firebaseConfig);
  const fcm = firebase.messaging();
  var mtoken;
  fcm.getToken({
      vapidKey:'BK8jRCeiFci3VZbquxw6dUGFKyh0rnggpDywCikHl9H7e3FOo1jXLdBUsNv_twawrHp17ibXzMQUuEIj8_E0gG4'

  }).then((token)=>{
      console.log('token: ',token);
      mtoken=token
  });

  fcm.onMessage((data)=>{
      console.log('message data',data['data']);

      let title = data['data']['title']
      let body = data['data']['body']

      //badge-counter
      let count = localStorage.getItem('notification-count')
      if(count){
        localStorage.setItem('notification-count',parseInt(count) + 1)
      }else{
        localStorage.setItem('notification-count', 1)
      }
      $('#notification-counter').text(localStorage.getItem('notification-count'))

      $('#notification-container').append(`
            <a class="dropdown-item d-flex align-items-center" href="#">
              <div class="mr-3">
                <div class="icon-circle bg-primary">
                  <i class="fas fa-file-alt text-white"></i>
                </div>
              </div>
              <div>
              <div class="small text-gray-500">${new Date().toLocaleString('en-US',{hour:'numeric',minute:'numeric',hour12:true})}</div>
                <span class="font-weight-bold">${title}</span>
                  </div>
            </a>
      
      `)

      Notification.requestPermission((status)=>{
          console.log('request permission',status);
          if(status ==='granted'){
              // let title = data['data']['title'];
              // let body = data['data']['body'];
              new Notification(title,{body:body});
          }
      })
  });


  $('#alertsDropdown').on('click',function(){
    $('#notification-counter').text('');

    localStorage.removeItem('notification-count')
  })
  
  
//ajax part
$(document).ready(function(){
  $('#loginBtn').on('click',function(){
    $('#loginBtn').prop('disabled', true);
   //$('#loginBtn').attr("disabled", true);
    let email= $('#email').val();
    let pass = $('#password').val();

    $.ajax({
      url: "<?= base_url('Home/login') ?>" ,
      type: 'POST', 
      data: {'email':email,'password':pass,'token':mtoken},
      success: function(response){
        console.log('success',response);
        window.location = "<?= base_url('dash')?>";
      },
      error:function(error){
        console.log('error',error)
      }
    })
  })
});

</script>

</body>

</html>