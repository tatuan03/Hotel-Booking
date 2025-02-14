<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap-grid.min.css" integrity="sha512-i1b/nzkVo97VN5WbEtaPebBG8REvjWeqNclJ6AItj7msdVcaveKrlIIByDpvjk5nwHjXkIqGZscVxOrTb9tsMA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" integrity="sha512-jnSuA4Ss2PkkikSOLtYs8BlYIeeIK1h99ty4YfvRPAlzr377vr3CXDb7sb7eEEBYjDtcYj+AjBH3FLv5uSJuXg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="/login">
    <title>Form Check-in</title>
</head>
<body>

    <div class="container">  
        <h1>TEAM 7 HOTEL</h1>
        <div class="alert alert-primary" role="alert">
    <?php
    if(isset($_REQUEST['msg']))
    echo $_REQUEST['msg'];
    ?>

    </div>


    <div class="container">
        <div class="row">
            <div class="col-6 offset-md-3">
                <form id="#" class="bg-light p-4 my-3" action="checkin.php" method="post">
                    <h2 class="py-3 text-center text-uppercase">
                        Check-in Information
                    </h2>
                    <div class="form-group">
                        <label>
                            Loại giấy tờ tuỳ thân
                        </label>
                        <select name="loai-giay-to" id="loai-giay-to" class="form-control">
                        <option value="---">---</option>
                            <option value="cmnd">Chứng minh Nhân Dân</option>
                            <option value="cccd">Căn cước Công Dân</option>
                            <option value="passport">Passport</option>
                            <option value="other">Khác</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="ma-so-giay-to">
                            Mã số giấy tờ tuỳ thân
                        </label>
                        <input type="text" name="ma-so-giay-to" class="form-control" id="ma-so-giay-to">
                    </div>
                    <div class="form-group">
                        <label for="hinh-anh-giay-to">
                            Hình ảnh mặt trước của giấy tờ:
                        </label>
                        <input type="file" name="hinh-anh-giay-to-truoc" class="form-control" id="hinh-anh-giay-to-truoc">
                    </div>
                    <div class="form-group">
                        <label for="hinh-anh-giay-to">
                            Hình ảnh mặt sau của giấy tờ:
                        </label>
                        <input type="file" name="hinh-anh-giay-to-sau" class="form-control" id="hinh-anh-giay-to-sau">
                    </div>
                    <div class="form-group">
                        <label for="ngay-checkin">
                            Ngày check-in:
                        </label>
                        <input type="date" name="ngay-checkin" class="form-control" id="ngay-checkin">
                    </div>
                    <div class="col-md-12 col-md-offset-2">
                        <label for="info">
                            Thông tin:
                        </label>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th style="width:30%;">Họ và tên</th>
                                    <th>Email</th>
                                    <th>Loại phòng</th>
                                </tr>
                                <?php 
                                    session_start();
                                    $email =  $_SESSION['email'];
                                    $con = new mysqli("localhost","root","","hotel_db");
                                    $result =mysqli_query($con,"SELECT * FROM users WHERE email ='$email'") or die (" Error !!!");
                                    $res = mysqli_fetch_array($result);
                                ?>
                                <tr>
                                    <td><?php echo $res['hoten'] ?></td>
                                    <td><?php echo $res['email'] ?></td>
                                    <td><?php echo $res['loaiphong'] ?></td>
                                    <input type="hidden" name="hoten" id="hoten" value="<?php echo $res['hoten']; ?>">
                                    <input type="hidden" name="loaiphong" id="loaiphong" value="<?php echo $res['loaiphong']; ?>">
                                    <input type="hidden" name="soluong" id="soluong" value="<?php echo $res['soluong']; ?>">
                                </tr>
                            </thead>
                        </table>
                    </div>  

                    <input type="submit" class="btn btn-success" name="checkin-btn" value="Tiến hành check-in">
                    
                </form>
                
            </div>
        </div>
    </div> 






    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.min.js" integrity="sha512-ykZ1QQr0Jy/4ZkvKuqWn4iF3lqPZyij9iRv6sGqLRdTPkY69YX6+7wvVGmsdBbiIfN/8OdsI7HABjvEok6ZopQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>
</html>