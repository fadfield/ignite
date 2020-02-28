<!DOCTYPE html>
<html >
	<head>
	  	<meta charset="UTF-8">
	  	<title>Login IGNITER</title>
	  	<link href='https://fonts.googleapis.com/css?family=Roboto:400' rel='stylesheet' type='text/css'>
		<link href="<?php echo assets_url() ?>css/bootstrap.min.css" rel="stylesheet">
		<link href="<?php echo assets_url() ?>font-awesome/css/font-awesome.css" rel="stylesheet">
		<script src="<?php echo assets_url() ?>js/jquery-3.1.1.min.js"></script>
		<script src="<?php echo assets_url() ?>js/bootstrap.js"></script>
		<style type="text/css">
		form,form h1{box-sizing:border-box}button,h1{color:#fff}button,h1,input::-webkit-input-placeholder{font-family:roboto,sans-serif;-webkit-transition:all .3s ease-in-out;transition:all .3s ease-in-out}.logo{height:150px;background:#1ab394;border-radius:3px 3px 0 0;}.logo img{height: 125px;display: block;margin: 0 auto;padding-top: 10px;}form{background-color: #fff;width:350px;margin:100px auto 0;box-shadow:2px 2px 5px 1px rgba(0,0,0,.2);padding-bottom:10px;border-radius:3px}.message{width:350px;margin:0 auto 0;}.message button{background:transparent;padding:6px;width:30px;margin:0;}form h1{padding:20px}input{margin:20px 25px;width:300px;display:block;border:none;padding:25px 0 10px;border-bottom:solid 1px #929292;-webkit-transition:all .3s cubic-bezier(.64,.09,.08,1);transition:all .3s cubic-bezier(.64,.09,.08,1);background:-webkit-linear-gradient(top,rgba(255,255,255,0) 98%,#1ab394 4%);background:linear-gradient(to bottom,rgba(255,255,255,0) 98%,#1ab394 4%);background-position:-300px 0;background-size:300px 100%;background-repeat:no-repeat;color:#0e6252;font-size: 12px;font-weight: bold;}input:focus,input:valid{box-shadow:none;outline:0;background-position:0 0;border-bottom:0}input:focus::-webkit-input-placeholder,input:valid::-webkit-input-placeholder{color:#1ab394;font-size:12px;-webkit-transform:translateY(-20px);transform:translateY(-20px);visibility:visible!important}button{border:none;background:#1ab394;cursor:pointer;padding:6px;width:150px;margin:5% 30% 0;box-shadow:0 3px 6px 0 rgba(0,0,0,.2)}button:hover{-webkit-transform:translateY(-3px);transform:translateY(-3px);box-shadow:0 6px 6px 0 rgba(0,0,0,.2)}
		</style>
	</head>
	<body style="background-color: #f1f1f1;">
		<form role="form" autocomplete="off" method="post">
			<div class="logo">
				<img src="<?php echo assets_url()?>img/logo.png">
			</div>
			<input name="username" placeholder="Username" type="text" required>
			<input name="password" placeholder="Password" type="password" required>
			<button type="submit">Submit</button>
		</form> 
		<div class="message">
			<?php $this->load->view('message_error_view')?>
	        <?php $this->load->view('message_success_view')?>
		</div>

	</body>
</html>