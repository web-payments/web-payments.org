<?php

class SpecialContact extends SpecialPage {
	function __construct() {
		parent::__construct( 'SpecialContact' );
	}
 
		function execute( $par ) {
		$request = $this->getRequest();
		$output = $this->getOutput();
		$this->setHeaders();
		$output->setPageTitle("BootStrapSkin Contact Page");

		$param = $request->getText( 'param' );
		
		$output = $this->getOutput();
                $output->addModuleScripts( 'ext.BootStrapSkinContact' );
		$output->addModuleStyles( 'ext.BootStrapSkinContact' );
 
		$wikitext = '';
		$output->addWikiText( $wikitext );
		$output->addHTML('

                <script type="text/javascript" src="./extensions/BootStrapSkinContact/modules/ext.validate.js"></script>
                <form action="./extensions/BootStrapSkinContact/contacts-process.php" method="post" id="contact-form" class="bootstrap">				
				 <fieldset>					
					 <div class="row">
						 <section class="col col-6">
							 <label class="label">Name</label>
							 <label class="input">
								 <i class="icon-append fa fa-user"></i>
								 <input type="text" name="name" id="name">
							 </label>
						 </section>
						 <section class="col col-6">
							 <label class="label">E-mail</label>
							 <label class="input">
 								<i class="icon-append fa fa-envelope-o"></i>
 								<input type="email" name="email" id="email">
 							</label>
						 </section>
					 </div>
					
					 <section>
						 <label class="label">Subject</label>
						 <label class="input">
							 <i class="icon-append fa fa-tag"></i>
							 <input type="text" name="subject" id="subject">
						</label>
					 </section>
					
					 <section>
						 <label class="label">Message</label>
 						<label class="textarea">
							 <i class="icon-append fa fa-comment"></i>
							 <textarea rows="4" name="message" id="message"></textarea>
						</label>
					</section>
				</fieldset>
				
				<footer>
					<button type="submit" class="button">Send message</button>
				</footer>
			</form>			
		</div>
		
		<script type="text/javascript">
			$(function()
			{
				// Validation
				$("#contact-form").validate(
				{					
					// Rules for form validation
					rules:
					{
						name:
						{
							required: true
						},
						email:
						{
							required: true,
							email: true
						},
						message:
						{
							required: true,
							minlength: 10
						},
					},					

				});
			});			
		</script>');
	}
};