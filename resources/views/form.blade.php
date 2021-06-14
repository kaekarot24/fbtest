<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Change Password</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{asset('public/assets/images/logo/favicon.png')}}">

    <!-- page css -->

    <!-- Core css -->
    <link href="{{asset('public/assets/css/app.min.css')}}" rel="stylesheet">

</head>

<body>
    <div class="app">
        <div class="layout">
            <!-- Header START -->
            <div class="header">
                <div class="logo logo-dark">
                    <a href="#.">
                        <h2>ADMIN</h2>
                    </a>
                </div>
                <div class="logo logo-white">
                    <a href="index.html">
                        <h2>ADMIN</h2>   
                    </a>
                </div>
                <div class="nav-wrap">
                    <ul class="nav-left">
                    </ul>
                    <ul class="nav-right">
                        
                        <li class="dropdown dropdown-animated scale-left">
                            <div class="pointer" data-toggle="dropdown">
                                <div class="avatar avatar-image  m-h-10 m-r-15">
                                    <img src="{{asset('public/assets/images/avatars/thumb-3.jpg')}}"  alt="">
                                </div>
                            </div>
                            <div class="p-b-15 p-t-20 dropdown-menu pop-profile">
                                <div class="p-h-20 p-b-15 m-b-10 border-bottom">
                                    <div class="d-flex m-r-50">
                                        <div class="avatar avatar-lg avatar-image">
                                            <img src="{{asset('public/assets/images/avatars/thumb-3.jpg')}}" alt="">
                                        </div>
                                        <div class="m-l-10">
                                            <p class="m-b-0 text-dark font-weight-semibold">Admin</p>
                                        </div>
                                    </div>
                                </div>
                                <a href="{{route('adminlogout')}}" class="dropdown-item d-block p-h-15 p-v-10">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <i class="anticon opacity-04 font-size-16 anticon-logout"></i>
                                            <span class="m-l-10">Logout</span>
                                        </div>
                                        <i class="anticon font-size-10 anticon-right"></i>
                                    </div>
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>    
            <!-- Header END -->

            <!-- Side Nav START -->
            <div class="side-nav">
                <div class="side-nav-inner">
                    <ul class="side-nav-menu scrollable">
                        <li>
                            <a href="{{route('admindashboard')}}">User List</a>
                        </li>
                     </ul>
                </div>
            </div>
            <!-- Side Nav END -->

            <!-- Page Container START -->
            <div class="page-container">
                

                <!-- Content Wrapper START -->
                <div class="main-content">
                    <div class="page-header">
                        <h2 class="header-title">Change Password</h2>
                        <div class="header-sub-title">
                            <nav class="breadcrumb breadcrumb-dash">
                                <a href="#" class="breadcrumb-item"><i class="anticon anticon-home m-r-5"></i>Home</a>
                                <a class="breadcrumb-item" href="#">Change Password</a>
                                <span class="breadcrumb-item active">Password</span>
                            </nav>
                        </div>
                    </div>
                    
                    <div class="card">
                        <div class="card-body">
                           <div class="m-t-25">
                                <form id="form-validation">    
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label control-label">New Password</label>
                                        <div class="col-md-5">
                                            <input id="newpass" type="password" class="form-control" name="new_password" placeholder="Enter your New password">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label control-label">Confirm New Password</label>
                                        <div class="col-md-5">
                                            <input type="password" id="confirm_newpass" class="form-control" name="confirm_password" placeholder="Enter your new password again">
                                        </div>
                                    </div>
                                    <div class="form-group text-right">
                                        <input type="hidden" id="user_id" value="{{ request()->id }}" />
                                        <button type="button" class="btn btn-primary change-pass">Change Password</button>
                                    </div>
                                </form>
                            </div>
                            
                            
                            
                        </div>
                    </div>
                </div>
                <!-- Content Wrapper END -->

                <!-- Footer START -->
                <footer class="footer">
                    <div class="footer-content">
                        <p class="m-b-0">Copyright © 2021 . All rights reserved.</p>
                    </div>
                </footer>
                <!-- Footer END -->

            </div>
            <!-- Page Container END -->

        </div>
    </div>

    
    <!-- Core Vendors JS -->
    <script src="{{asset('public/assets/js/vendors.min.js')}}"></script>

    <!-- page js -->
    <script src="{{asset('public/assets/vendors/jquery-validation/jquery.validate.min.js')}}"></script>
    <script src="{{asset('public/assets/js/pages/form-validation.js')}}"></script>

    <!-- Core JS -->
    <script src="{{asset('public/assets/js/app.min.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $("body").on('click', '.change-pass', function(){
                  var uid = $("#user_id").val();
                  var data = { id: uid, password: $("#newpass").val() } ;
                  if(uid!=''){

                    if($.trim($("#newpass").val())!=''){  

                        if($.trim($("#newpass").val()) == $.trim($("#confirm_newpass").val())){
                            
                            $.ajax({
                                url: " {{ url('api/users/changepass') }}/"+uid,
                                type: "PUT",
                                dataType: "json",    
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                    'Authorization': 'Bearer ' + $('meta[name="api_token"]').attr('content'),
                                },
                                data: JSON.stringify(data),
                                success: function(data){
                                    if(data.status=='ok'){
                                        $("#form-validation")[0].reset();
                                        alert(data.message);
                                    }
                                    if(data.status=='failed'){
                                        alert(data.message); 
                                    }
                                },  
                                error: function (xhr, status, err) {  
                                    console.log('Error in Operation');  
                                }
                            });
                        } else {
                            alert('PAssword does not match with confirm password');
                            $("#confirm_newpass").focus();
                        }
                       
                    } else {
                      alert('Please enter new password');
                      $("#newpass").focus();
                    }

                  } 
            });
        });
    </script>
</body>

</html>