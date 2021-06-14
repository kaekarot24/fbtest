<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin Dashboard</title>

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

            <div class="side-nav">
                <div class="side-nav-inner">
                    <ul class="side-nav-menu scrollable">
                        <li>
                            <a href="{{route('admindashboard')}}">User List</a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Page Container START -->
            <div class="page-container">
                

                <!-- Content Wrapper START -->
                <div class="main-content">
                    <div class="page-header">
                        <h2 class="header-title">User List</h2>
                        <div class="header-sub-title">
                            <nav class="breadcrumb breadcrumb-dash">
                                <a href="#" class="breadcrumb-item"><i class="anticon anticon-home m-r-5"></i>Home</a>
                                <a class="breadcrumb-item" href="#">User List</a>
                            </nav>
                        </div>
                    </div>
                    
                    <div class="card">
                        <div class="card-body">
                            <h4>User List</h4>
                            <div class="m-t-25">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Photo</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">Email</th>
                                                <th scope="col">Facebook ID</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="user-details"></tbody>
                                    </table>
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
</div>

    
    <!-- Core Vendors JS -->
    <script src="{{asset('public/assets/js/vendors.min.js')}}"></script>

    <!-- page js -->

    <!-- Core JS -->
    <script src="{{asset('public/assets/js/app.min.js')}}"></script>
    <script type="text/javascript">
     $(document).ready(function(){
            $("body").on('click', '.delete-user', function(){                 
                    var userid = $(this).attr('data-id');
                    if(userid!=''){
                         $.ajax({
                             url: "{{ url('api/users/delete') }}/"+userid,
                             type: 'DELETE',
                             dataType: 'json',
                             headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                'Authorization': 'Bearer ' + $('meta[name="api_token"]').attr('content'),
                            },
                            success: function(response){
                                if(response.status=='ok'){
                                   $("#user_rowdata_"+userid).remove();
                                }
                                if(response.status=='failed'){
                                   alert(response.message);
                                }
                             },  
                                error: function (xhr, status, err) {  
                                    console.log('Error in Operation');  
                                }
                         });
                    }
            });     
     });

     function getusers()
    {
        jQuery.ajax({
            url: "{{ route('apiusers') }}",
            method: 'get',
            success: function(result){
                var json = JSON.parse(result);
                var html = '';
                $.each(json, function(i, value){
                    var id = json[i].id; 
                    html += '<tr id="user_rowdata_'+json[i].id+'">';
                    html += '<th scope="row">'+json[i].id+'</th>';
                    html += '<td><img src="'+json[i].profile_photo_path+'" /></td>';
                    html += '<td>'+json[i].name+'</td>';
                    html += '<td>'+json[i].email+'</td>';
                    html += '<td>'+json[i].fb_id+'</td>';
                    html += '<td><a href="javascript:void(0)" class="btn btn-sm btn-danger delete-user" data-id="'+json[i].id+'">Delete</a>&nbsp;<a href="{{ url("/admin/changepassword") }}/'+id+'" class="btn btn-sm btn-primary">Change Password</a></td>';   
                    html += '</tr>';   
                });
                $("#user-details").html(html);
            }});
    }
     getusers();
    </script> 
</body>

</html>