<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Aamarpay CodeIgniter</title>

	<meta name="viewport" content="width=device-width, initial-scale=1" />

	<style type="text/css">

	::selection { background-color: #E13300; color: white; }
	::-moz-selection { background-color: #E13300; color: white; }

	body {
		background-color: #fff;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		color: #4F5155;
		display: flex;
		align-items: center;
		justify-content: center;
		min-height: 100vh;
		
	}

	a {
		color: #003399;
		background-color: transparent;
		font-weight: normal;
		text-decoration: none;
	}

	a:hover {
		color: #97310e;
	}

	h1 {
		color: #444;
		background-color: transparent;
		border-bottom: 1px solid #D0D0D0;
		font-size: 19px;
		font-weight: normal;
		margin: 0 0 14px 0;
		padding: 15px 15px;
		text-transform: uppercase;
	}

	h3 {
		color: #444;
		font-size: 17px;
	}

	p {
		margin: 0 0 10px;
		padding:0;
	}

	p.footer {
		text-align: left;
		font-size: 11px;
		border-top: 1px solid #D0D0D0;
		line-height: 32px;
		padding: 0 10px 0 10px;
		margin: 20px 0 0 0;
	}

	#container {
		box-shadow: 0 0 8px #D0D0D0;
		width: 480px;
	}

	@media (max-width: 479px) {
		#container {
			width: 95%
		}
	}

	.form{
		padding: 15px;
	}

	.form .form-input{
		margin-bottom: 20px;
	}

	.form .form-input label{
		color: #232222;
		font-weight: bold;
		font-size: 14px;
		display: block;
		padding-bottom: 8px;
	}

	.form .form-input input{
		padding: 10px 15px;
		border: 2px solid #D88918;
		border-radius: 5px;
		outline: none;
	}

	.form .error{
		font-size: 13px;
		color: #C52323;
		font-weight: bold;
		padding-top: 5px;
	}

	.btn{
		padding: 8px 15px;
		background-color: #D88918;
		border: none;
		color: #fff;
		border-radius: 5px;
		cursor: pointer;
		transition: 0.3s;
		margin-bottom: 20px;
	}

	.btn:hover{
		background-color: #E59B31;
	}
	</style>
</head>
<body>

<div id="container">
	<h1>welcome <?php echo $user->user_name;?></h1>

	<form class="form" action="<?php echo base_url('payment');?>" method="post">

		<div class="form-input">
			<label>Amount</label>
			<input type="number" name="amount" placeholder="Enter payment amount">

			<?php echo form_error('amount', '<div class="error">', '</div>'); ?>
		</div>

		<button class="btn">Submit</button>

		<div class="error"><?php if(isset($error)){echo $error;}?></div>

		<a href="<?php echo base_url('payment/verify');?>">Verify Payment</a>

	</form>

	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds | <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></p>
</div>

</body>
</html>
