<?php $__env->startSection('title', 'Contact Us'); ?>
<?php $__env->startSection('extra-css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/algolia.css')); ?>">
<script type="text/javascript" src="<?php echo asset('js/jquery-3.3.1.min.js'); ?>"></script>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="container containerProducts">

	<?php if(session()->has('success_message')): ?>
	<div class="alert alert-success containerAlerts">
		<?php echo e(session()->get('success_message')); ?>

	</div>
	<?php endif; ?>

	<div class="row">
		<div class="col-md-8">
			<h2 class="titlecontact">Contact Us</h2>
			<form action="<?php echo e(route('EmailContact')); ?>" method="post" accept-charset="utf-8">
				<?php echo e(csrf_field()); ?>

				<div class="row">
					<div class="col-md-4 col-sm-12">
						<input class="contactinput" placeholder="Full Name*" type="text" name="nombre" required>
					</div>
					<div class="col-md-4 col-sm-12">
						<input class="contactinput" placeholder="Phone*" type="tel" name="telefono" required>
					</div>
					<div class="col-md-4 col-sm-12">
						<input class="contactinput" placeholder="E-mail*" type="email" name="email" required>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4 col-sm-12">
						<select class="formselcontact" name="producto" required>
							<option value="">Subject*</option>
							<option value="Existing order" class="optfield">Existing order</option>
							<option value="Quotation" class="optfield">Quotation</option>
							<option value="Custom Apparel" class="optfield">Custom Apparel</option>
							<option value="Marketing Products" class="optfield">Marketing Products</option>
							<option value="My Account" class="optfield">My Account</option>
							<option value="Email Marketing" class="optfield">Email Marketing</option>
							<option value="Other" class="optfield">Other</option>
						</select>
					</div>
					<div class="col-md-4 col-sm-12">
						<input class="contactinput" placeholder="Company Name" type="text" name="compania" >
					</div>
				</div>
				<textarea placeholder="Message*" id="text" class="form-control" rows="2" name="comentario" required></textarea>
				<div class="g-recaptcha" data-sitekey="6LfVdEAUAAAAAGU-ey1nXYoKztntr9v0lxI0Sli8"></div>
				<button type="submit" class="botonsubmit " value="Submit">
					SEND MESSAGE
				</button>
			</form>
		</div>
		<div class="col-md-4 fondocontacto" >
			<h5 id="title2contact">Contact Info</h5>
			<li class="list-contac"><i class="fa fa-phone " aria-hidden="true"></i><a href= "tel:(201)3050404">&nbsp;(201) 305 0404</a></li>
			<li class="list-contac"><i class="fa fa-envelope " aria-hidden="true"></i> <a href="mailto:contacto@tienda.printinglab.com">info@printinglab.com</a> </li><br><br>
			<li class="list-contac"><i class="fa fa-location-arrow" aria-hidden="true"></i>609 55th Street,<br>West New York, NJ 07093</li>
			<li class="list-contac"><i class="fa fa-location-arrow" aria-hidden="true"></i> Medellín, Colombia</li><br><br>
			<li class="list-contac"><i class="fa fa-user" aria-hidden="true"></i> Customer Service Hours<br>Monday - Friday / 9:00a.m. - 7:00p.m. </li>
		</div>
	</div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script src='https://www.google.com/recaptcha/api.js'></script>
<script>
$('.botonsubmit').click(function(){
	 var $captcha = $('#recaptcha'),
      response = grecaptcha.getResponse();

	if (response.length === 0) {
		$.confirm({
			title: 'Alert!',
			content: 'Please confirm you are not a robot',
			draggable: false,
			buttons: {
				confirm: function () {
				},
			}
		})
		return false;
	}else{

	    	if ($.trim($('#text').val()).length < 1) {
		$.confirm({
			title: 'Alert!',
			content: 'The field is empty, please fill it.',
			draggable: false,
			buttons: {
				confirm: function () {
				},
			}
		})
		return false;
	}else{
		return true;
	}

	}
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>