<?php
/**
 * To load javascript
 */
?>

<script type="text/javascript">
StrandsRecommenderConfig = {

	trackWidgetsHomepage: function(evt){
		if (this.value == 0) {
			$('recommender_widgets-homepage').select('tr#row_recommender_widgets-homepage_block')[0].show();
			if ($('recommender_widgets-homepage').select('input#recommender_widgets-homepage_block')[0].value != '')
				$('recommender_widgets-homepage').select('tr#row_recommender_widgets-homepage_position')[0].show();
			$('recommender_widgets-homepage').select('tr#row_recommender_widgets-homepage_file')[0].hide();
			$('recommender_widgets-homepage').select('tr#row_recommender_widgets-homepage_cms')[0].hide();
		} else if (this.value == 1) {
			$('recommender_widgets-homepage').select('tr#row_recommender_widgets-homepage_file')[0].show();
			$('recommender_widgets-homepage').select('tr#row_recommender_widgets-homepage_block')[0].hide();
			$('recommender_widgets-homepage').select('tr#row_recommender_widgets-homepage_position')[0].hide();
			$('recommender_widgets-homepage').select('tr#row_recommender_widgets-homepage_cms')[0].hide();
		} else if (this.value == 2) {
			$('recommender_widgets-homepage').select('tr#row_recommender_widgets-homepage_cms')[0].show();
			$('recommender_widgets-homepage').select('tr#row_recommender_widgets-homepage_block')[0].hide();
			$('recommender_widgets-homepage').select('tr#row_recommender_widgets-homepage_position')[0].hide();
			$('recommender_widgets-homepage').select('tr#row_recommender_widgets-homepage_file')[0].hide();
		}
	},

	trackWidgetsProduct: function(evt){
		if (this.value == 0) {
			$('recommender_widgets-product').select('tr#row_recommender_widgets-product_block')[0].show();
			if ($('recommender_widgets-product').select('input#recommender_widgets-product_block')[0].value != '')
				$('recommender_widgets-product').select('tr#row_recommender_widgets-product_position')[0].show();
			$('recommender_widgets-product').select('tr#row_recommender_widgets-product_file')[0].hide();
			$('recommender_widgets-product').select('tr#row_recommender_widgets-product_cms')[0].hide();
		} else if (this.value == 1) {
			$('recommender_widgets-product').select('tr#row_recommender_widgets-product_file')[0].show();
			$('recommender_widgets-product').select('tr#row_recommender_widgets-product_block')[0].hide();
			$('recommender_widgets-product').select('tr#row_recommender_widgets-product_position')[0].hide();
			$('recommender_widgets-product').select('tr#row_recommender_widgets-product_cms')[0].hide();
		} else if (this.value == 2) {
			$('recommender_widgets-product').select('tr#row_recommender_widgets-product_cms')[0].show();
			$('recommender_widgets-product').select('tr#row_recommender_widgets-product_block')[0].hide();
			$('recommender_widgets-product').select('tr#row_recommender_widgets-product_position')[0].hide();
			$('recommender_widgets-product').select('tr#row_recommender_widgets-product_file')[0].hide();
		}
	},

	trackWidgetsCategory: function(evt){
		if (this.value == 0) {
			$('recommender_widgets-category').select('tr#row_recommender_widgets-category_block')[0].show();
			if ($('recommender_widgets-category').select('input#recommender_widgets-category_block')[0].value != '')
				$('recommender_widgets-category').select('tr#row_recommender_widgets-category_position')[0].show();
			$('recommender_widgets-category').select('tr#row_recommender_widgets-category_file')[0].hide();
			$('recommender_widgets-category').select('tr#row_recommender_widgets-category_cms')[0].hide();
		} else if (this.value == 1) {
			$('recommender_widgets-category').select('tr#row_recommender_widgets-category_file')[0].show();
			$('recommender_widgets-category').select('tr#row_recommender_widgets-category_block')[0].hide();
			$('recommender_widgets-category').select('tr#row_recommender_widgets-category_position')[0].hide();
			$('recommender_widgets-category').select('tr#row_recommender_widgets-category_cms')[0].hide();
		} else if (this.value == 2) {
			$('recommender_widgets-category').select('tr#row_recommender_widgets-category_cms')[0].show();
			$('recommender_widgets-category').select('tr#row_recommender_widgets-category_block')[0].hide();
			$('recommender_widgets-category').select('tr#row_recommender_widgets-category_position')[0].hide();
			$('recommender_widgets-category').select('tr#row_recommender_widgets-category_file')[0].hide();
		}
	},

	trackWidgetsCart: function(evt){
		if (this.value == 0) {
			$('recommender_widgets-cart').select('tr#row_recommender_widgets-cart_block')[0].show();
			if ($('recommender_widgets-cart').select('input#recommender_widgets-cart_block')[0].value != '')
				$('recommender_widgets-cart').select('tr#row_recommender_widgets-cart_position')[0].show();
			$('recommender_widgets-cart').select('tr#row_recommender_widgets-cart_file')[0].hide();
			$('recommender_widgets-cart').select('tr#row_recommender_widgets-cart_cms')[0].hide();
		} else if (this.value == 1) {
			$('recommender_widgets-cart').select('tr#row_recommender_widgets-cart_file')[0].show();
			$('recommender_widgets-cart').select('tr#row_recommender_widgets-cart_block')[0].hide();
			$('recommender_widgets-cart').select('tr#row_recommender_widgets-cart_position')[0].hide();
			$('recommender_widgets-cart').select('tr#row_recommender_widgets-cart_cms')[0].hide();
		} else if (this.value == 2) {
			$('recommender_widgets-cart').select('tr#row_recommender_widgets-cart_cms')[0].show();
			$('recommender_widgets-cart').select('tr#row_recommender_widgets-cart_block')[0].hide();
			$('recommender_widgets-cart').select('tr#row_recommender_widgets-cart_position')[0].hide();
			$('recommender_widgets-cart').select('tr#row_recommender_widgets-cart_file')[0].hide();
		}
	},

	trackWidgetsCheckout: function(evt){
		if (this.value == 0) {
			$('recommender_widgets-checkout').select('tr#row_recommender_widgets-checkout_block')[0].show();
			if ($('recommender_widgets-checkout').select('input#recommender_widgets-checkout_block')[0].value != '')
				$('recommender_widgets-checkout').select('tr#row_recommender_widgets-checkout_position')[0].show();
			$('recommender_widgets-checkout').select('tr#row_recommender_widgets-checkout_file')[0].hide();
			$('recommender_widgets-checkout').select('tr#row_recommender_widgets-checkout_cms')[0].hide();
		} else if (this.value == 1) {
			$('recommender_widgets-checkout').select('tr#row_recommender_widgets-checkout_file')[0].show();
			$('recommender_widgets-checkout').select('tr#row_recommender_widgets-checkout_block')[0].hide();
			$('recommender_widgets-checkout').select('tr#row_recommender_widgets-checkout_position')[0].hide();
			$('recommender_widgets-checkout').select('tr#row_recommender_widgets-checkout_cms')[0].hide();
		} else if (this.value == 2) {
			$('recommender_widgets-checkout').select('tr#row_recommender_widgets-checkout_cms')[0].show();
			$('recommender_widgets-checkout').select('tr#row_recommender_widgets-checkout_block')[0].hide();
			$('recommender_widgets-checkout').select('tr#row_recommender_widgets-checkout_position')[0].hide();
			$('recommender_widgets-checkout').select('tr#row_recommender_widgets-checkout_file')[0].hide();
		}
	},




	trackCatalogSelection: function(evt){
		if (this.value == 1) {
			$(document.body).select('.entry-edit-head').each(function(e){
				var cats = $(e).select('a')[0].id;
				if (cats.startsWith('recommender_cron-')) {
					$(e).show();
					$(cats.replace('-head','')).show();
				} else if(cats.startsWith('recommender_manual-')) {
					$(e).hide();
					if($(cats.replace('-head','')).visible())
						$(cats.replace('-head','')).hide();
				}
				$('recommender_catalog').select('tr#row_recommender_catalog_cron_explanation')[0].show();
				$('recommender_catalog').select('tr#row_recommender_catalog_feed_explanation')[0].hide();
				$('recommender_catalog').select('tr#row_recommender_catalog_manual_explanation')[0].hide();

				if ($('recommender_catalog').select('tr#row_recommender_catalog_cron_feasible').length)
					$('recommender_catalog').select('tr#row_recommender_catalog_cron_feasible')[0].show();
				if ($('recommender_catalog').select('tr#row_recommender_catalog_feed_feasible').length)
					$('recommender_catalog').select('tr#row_recommender_catalog_feed_feasible')[0].hide();
			});
		} else if(this.value == 0) {
			$(document.body).select('.entry-edit-head').each(function(e){
				var cats = $(e).select('a')[0].id;
				if (cats.startsWith('recommender_cron-')) {
					$(e).hide();
					if($(cats.replace('-head','')).visible())
						$(cats.replace('-head','')).hide();
					
				} else if(cats.startsWith('recommender_manual-')) {
					$(e).hide();
					if($(cats.replace('-head','')).visible())
						$(cats.replace('-head','')).hide();
				}
				$('recommender_catalog').select('tr#row_recommender_catalog_feed_explanation')[0].show();
				$('recommender_catalog').select('tr#row_recommender_catalog_cron_explanation')[0].hide();
				$('recommender_catalog').select('tr#row_recommender_catalog_manual_explanation')[0].hide();

				if ($('recommender_catalog').select('tr#row_recommender_catalog_cron_feasible').length)
					$('recommender_catalog').select('tr#row_recommender_catalog_cron_feasible')[0].hide();
				if ($('recommender_catalog').select('tr#row_recommender_catalog_feed_feasible').length)
					$('recommender_catalog').select('tr#row_recommender_catalog_feed_feasible')[0].show();			
			});
		} else if(this.value == 2) {
			$(document.body).select('.entry-edit-head').each(function(e){
				var cats = $(e).select('a')[0].id;
				if (cats.startsWith('recommender_manual-')) {
					$(e).show();
					$(cats.replace('-head','')).show();
				} else if(cats.startsWith('recommender_cron-')) {
					$(e).hide();
					if($(cats.replace('-head','')).visible())
						$(cats.replace('-head','')).hide();
				}
				$('recommender_catalog').select('tr#row_recommender_catalog_manual_explanation')[0].show();
				$('recommender_catalog').select('tr#row_recommender_catalog_cron_explanation')[0].hide();
				$('recommender_catalog').select('tr#row_recommender_catalog_feed_explanation')[0].hide();

				if ($('recommender_catalog').select('tr#row_recommender_catalog_cron_feasible').length)
					$('recommender_catalog').select('tr#row_recommender_catalog_cron_feasible')[0].hide();
				if ($('recommender_catalog').select('tr#row_recommender_catalog_feed_feasible').length)
					$('recommender_catalog').select('tr#row_recommender_catalog_feed_feasible')[0].hide();				
			});
		}
	},

	
	startCatalogSelection: function() {
		var currentlySelected = $(document.body).select('select#recommender_catalog_select').first().value;
		if (currentlySelected == 1) {
			$(document.body).select('.entry-edit-head').each(function(e){
				var cats = $(e).select('a')[0].id;
				if (cats.startsWith('recommender_cron-')) {
					$(e).show();
					$(cats.replace('-head','')).show();
				} else if(cats.startsWith('recommender_manual-')) {
					$(e).hide();
					if($(cats.replace('-head','')).visible())
						$(cats.replace('-head','')).hide();
				}
				$('recommender_catalog').select('tr#row_recommender_catalog_cron_explanation')[0].show();
				$('recommender_catalog').select('tr#row_recommender_catalog_feed_explanation')[0].hide();
				$('recommender_catalog').select('tr#row_recommender_catalog_manual_explanation')[0].hide();

				if ($('recommender_catalog').select('tr#row_recommender_catalog_cron_feasible').length)
					$('recommender_catalog').select('tr#row_recommender_catalog_cron_feasible')[0].show();
				if ($('recommender_catalog').select('tr#row_recommender_catalog_feed_feasible').length)
					$('recommender_catalog').select('tr#row_recommender_catalog_feed_feasible')[0].hide();				
			});
		} else if (currentlySelected == 0) {
			$(document.body).select('.entry-edit-head').each(function(e){
				var cats = $(e).select('a')[0].id;
				if (cats.startsWith('recommender_cron-')) {
					$(e).hide();
					if($(cats.replace('-head','')).visible())
						$(cats.replace('-head','')).hide();
					
				} else if(cats.startsWith('recommender_manual-')) {
					$(e).hide();
					if($(cats.replace('-head','')).visible())
						$(cats.replace('-head','')).hide();
				}
				$('recommender_catalog').select('tr#row_recommender_catalog_feed_explanation')[0].show();
				$('recommender_catalog').select('tr#row_recommender_catalog_cron_explanation')[0].hide();
				$('recommender_catalog').select('tr#row_recommender_catalog_manual_explanation')[0].hide();

				if ($('recommender_catalog').select('tr#row_recommender_catalog_cron_feasible').length)
					$('recommender_catalog').select('tr#row_recommender_catalog_cron_feasible')[0].hide();
				if ($('recommender_catalog').select('tr#row_recommender_catalog_feed_feasible').length)
					$('recommender_catalog').select('tr#row_recommender_catalog_feed_feasible')[0].show();
			});
		} else if (currentlySelected == 2) {
			$(document.body).select('.entry-edit-head').each(function(e){
				var cats = $(e).select('a')[0].id;
				if (cats.startsWith('recommender_manual-')) {
					$(e).show();
					$(cats.replace('-head','')).show();
				} else if(cats.startsWith('recommender_cron-')) {
					$(e).hide();
					if($(cats.replace('-head','')).visible())
						$(cats.replace('-head','')).hide();
				}
				$('recommender_catalog').select('tr#row_recommender_catalog_manual_explanation')[0].show();
				$('recommender_catalog').select('tr#row_recommender_catalog_cron_explanation')[0].hide();
				$('recommender_catalog').select('tr#row_recommender_catalog_feed_explanation')[0].hide();

				if ($('recommender_catalog').select('tr#row_recommender_catalog_cron_feasible').length)
					$('recommender_catalog').select('tr#row_recommender_catalog_cron_feasible')[0].hide();
				if ($('recommender_catalog').select('tr#row_recommender_catalog_feed_feasible').length)
					$('recommender_catalog').select('tr#row_recommender_catalog_feed_feasible')[0].hide();
			});
		}
	},

	trackLoginChange: function() {
		if (this.id == 'recommender_cron_strands_login') {
			this.value=this.value.trim();
			$('recommender_manual').select('input#recommender_manual_strands_login')[0].value = this.value;
		} else if (this.id == 'recommender_manual_strands_login') {
			this.value=this.value.trim();
			$('recommender_cron').select('input#recommender_cron_strands_login')[0].value = this.value;
		}
	},

	trackPasswordChange: function() {
		if (this.id == 'recommender_cron_strands_password') {
			$('recommender_manual').select('input#recommender_manual_strands_password')[0].value = this.value;
		} else if (this.id == 'recommender_manual_strands_password') {
			$('recommender_cron').select('input#recommender_cron_strands_password')[0].value = this.value;
		}
	},


	trackActiveIndividualWidget: function() {
		if (this.id == 'recommender_widgets-homepage_block') {
			if (this.value == '')
				$('recommender_widgets-homepage').select('tr#row_recommender_widgets-homepage_position')[0].hide();
			else
				$('recommender_widgets-homepage').select('tr#row_recommender_widgets-homepage_position')[0].show();	
		} else if (this.id == 'recommender_widgets-product_block') {
			if (this.value == '')
				$('recommender_widgets-product').select('tr#row_recommender_widgets-product_position')[0].hide();
			else
				$('recommender_widgets-product').select('tr#row_recommender_widgets-product_position')[0].show();	
		} else if (this.id == 'recommender_widgets-category_block') {
			if (this.value == '')
				$('recommender_widgets-category').select('tr#row_recommender_widgets-category_position')[0].hide();
			else
				$('recommender_widgets-category').select('tr#row_recommender_widgets-category_position')[0].show();	
		} else if (this.id == 'recommender_widgets-cart_block') {
			if (this.value == '')
				$('recommender_widgets-cart').select('tr#row_recommender_widgets-cart_position')[0].hide();
			else
				$('recommender_widgets-cart').select('tr#row_recommender_widgets-cart_position')[0].show();	
		} else if (this.id == 'recommender_widgets-checkout_block') {
			if (this.value == '')
				$('recommender_widgets-checkout').select('tr#row_recommender_widgets-checkout_position')[0].hide();
			else
				$('recommender_widgets-checkout').select('tr#row_recommender_widgets-checkout_position')[0].show();	
		}
	},

	trackApiidInput: function() {
		this.value=this.value.trim();
	},
	
	trackCustomertokenInput: function() {
		this.value=this.value.trim();
	},

	startActiveIndividualHomepage: function() {
		if ($('recommender_widgets-homepage').select('select#recommender_widgets-homepage_active')[0].value == '0') {
			if ($('recommender_widgets-homepage').select('input#recommender_widgets-homepage_block')[0].value == '')
				$('recommender_widgets-homepage').select('tr#row_recommender_widgets-homepage_position')[0].hide();
			else
				$('recommender_widgets-homepage').select('tr#row_recommender_widgets-homepage_position')[0].show();
			$('recommender_widgets-homepage').select('tr#row_recommender_widgets-homepage_file')[0].hide();
			$('recommender_widgets-homepage').select('tr#row_recommender_widgets-homepage_cms')[0].hide();			
		} else if ($('recommender_widgets-homepage').select('select#recommender_widgets-homepage_active')[0].value == '1') {
			$('recommender_widgets-homepage').select('tr#row_recommender_widgets-homepage_block')[0].hide();
			$('recommender_widgets-homepage').select('tr#row_recommender_widgets-homepage_position')[0].hide();
			$('recommender_widgets-homepage').select('tr#row_recommender_widgets-homepage_file')[0].show();
			$('recommender_widgets-homepage').select('tr#row_recommender_widgets-homepage_cms')[0].hide();
		} else if ($('recommender_widgets-homepage').select('select#recommender_widgets-homepage_active')[0].value == '2') {
			$('recommender_widgets-homepage').select('tr#row_recommender_widgets-homepage_block')[0].hide();
			$('recommender_widgets-homepage').select('tr#row_recommender_widgets-homepage_position')[0].hide();
			$('recommender_widgets-homepage').select('tr#row_recommender_widgets-homepage_file')[0].hide();
			$('recommender_widgets-homepage').select('tr#row_recommender_widgets-homepage_cms')[0].show();
		}
	},

	startActiveIndividualProduct: function() {
		if ($('recommender_widgets-product').select('select#recommender_widgets-product_active')[0].value == '0') {
			if ($('recommender_widgets-product').select('input#recommender_widgets-product_block')[0].value == '')
				$('recommender_widgets-product').select('tr#row_recommender_widgets-product_position')[0].hide();
			else
				$('recommender_widgets-product').select('tr#row_recommender_widgets-product_position')[0].show();
			$('recommender_widgets-product').select('tr#row_recommender_widgets-product_file')[0].hide();
			$('recommender_widgets-product').select('tr#row_recommender_widgets-product_cms')[0].hide();			
		} else if ($('recommender_widgets-product').select('select#recommender_widgets-product_active')[0].value == '1') {
			$('recommender_widgets-product').select('tr#row_recommender_widgets-product_block')[0].hide();
			$('recommender_widgets-product').select('tr#row_recommender_widgets-product_position')[0].hide();
			$('recommender_widgets-product').select('tr#row_recommender_widgets-product_file')[0].show();
			$('recommender_widgets-product').select('tr#row_recommender_widgets-product_cms')[0].hide();
		} else if ($('recommender_widgets-product').select('select#recommender_widgets-product_active')[0].value == '2') {
			$('recommender_widgets-product').select('tr#row_recommender_widgets-product_block')[0].hide();
			$('recommender_widgets-product').select('tr#row_recommender_widgets-product_position')[0].hide();
			$('recommender_widgets-product').select('tr#row_recommender_widgets-product_file')[0].hide();
			$('recommender_widgets-product').select('tr#row_recommender_widgets-product_cms')[0].show();
		}		
	},

	startActiveIndividualCategory: function() {
		if ($('recommender_widgets-category').select('select#recommender_widgets-category_active')[0].value == '0') {
			if ($('recommender_widgets-category').select('input#recommender_widgets-category_block')[0].value == '')
				$('recommender_widgets-category').select('tr#row_recommender_widgets-category_position')[0].hide();
			else
				$('recommender_widgets-category').select('tr#row_recommender_widgets-category_position')[0].show();
			$('recommender_widgets-category').select('tr#row_recommender_widgets-category_file')[0].hide();
			$('recommender_widgets-category').select('tr#row_recommender_widgets-category_cms')[0].hide();			
		} else if ($('recommender_widgets-category').select('select#recommender_widgets-category_active')[0].value == '1') {
			$('recommender_widgets-category').select('tr#row_recommender_widgets-category_block')[0].hide();
			$('recommender_widgets-category').select('tr#row_recommender_widgets-category_position')[0].hide();
			$('recommender_widgets-category').select('tr#row_recommender_widgets-category_file')[0].show();
			$('recommender_widgets-category').select('tr#row_recommender_widgets-category_cms')[0].hide();
		} else if ($('recommender_widgets-category').select('select#recommender_widgets-category_active')[0].value == '2') {
			$('recommender_widgets-category').select('tr#row_recommender_widgets-category_block')[0].hide();
			$('recommender_widgets-category').select('tr#row_recommender_widgets-category_position')[0].hide();
			$('recommender_widgets-category').select('tr#row_recommender_widgets-category_file')[0].hide();
			$('recommender_widgets-category').select('tr#row_recommender_widgets-category_cms')[0].show();
		}
	},

	startActiveIndividualCart: function() {
		if ($('recommender_widgets-cart').select('select#recommender_widgets-cart_active')[0].value == '0') {
			if ($('recommender_widgets-cart').select('input#recommender_widgets-cart_block')[0].value == '')
				$('recommender_widgets-cart').select('tr#row_recommender_widgets-cart_position')[0].hide();
			else
				$('recommender_widgets-cart').select('tr#row_recommender_widgets-cart_position')[0].show();
			$('recommender_widgets-cart').select('tr#row_recommender_widgets-cart_file')[0].hide();
			$('recommender_widgets-cart').select('tr#row_recommender_widgets-cart_cms')[0].hide();			
		} else if ($('recommender_widgets-cart').select('select#recommender_widgets-cart_active')[0].value == '1') {
			$('recommender_widgets-cart').select('tr#row_recommender_widgets-cart_block')[0].hide();
			$('recommender_widgets-cart').select('tr#row_recommender_widgets-cart_position')[0].hide();
			$('recommender_widgets-cart').select('tr#row_recommender_widgets-cart_file')[0].show();
			$('recommender_widgets-cart').select('tr#row_recommender_widgets-cart_cms')[0].hide();
		} else if ($('recommender_widgets-cart').select('select#recommender_widgets-cart_active')[0].value == '2') {
			$('recommender_widgets-cart').select('tr#row_recommender_widgets-cart_block')[0].hide();
			$('recommender_widgets-cart').select('tr#row_recommender_widgets-cart_position')[0].hide();
			$('recommender_widgets-cart').select('tr#row_recommender_widgets-cart_file')[0].hide();
			$('recommender_widgets-cart').select('tr#row_recommender_widgets-cart_cms')[0].show();
		}
	},

	startActiveIndividualCheckout: function() {
		if ($('recommender_widgets-checkout').select('select#recommender_widgets-checkout_active')[0].value == '0') {
			if ($('recommender_widgets-checkout').select('input#recommender_widgets-checkout_block')[0].value == '')
				$('recommender_widgets-checkout').select('tr#row_recommender_widgets-checkout_position')[0].hide();
			else
				$('recommender_widgets-checkout').select('tr#row_recommender_widgets-checkout_position')[0].show();
			$('recommender_widgets-checkout').select('tr#row_recommender_widgets-checkout_file')[0].hide();
			$('recommender_widgets-checkout').select('tr#row_recommender_widgets-checkout_cms')[0].hide();			
		} else if ($('recommender_widgets-checkout').select('select#recommender_widgets-checkout_active')[0].value == '1') {
			$('recommender_widgets-checkout').select('tr#row_recommender_widgets-checkout_block')[0].hide();
			$('recommender_widgets-checkout').select('tr#row_recommender_widgets-checkout_position')[0].hide();
			$('recommender_widgets-checkout').select('tr#row_recommender_widgets-checkout_file')[0].show();
			$('recommender_widgets-checkout').select('tr#row_recommender_widgets-checkout_cms')[0].hide();
		} else if ($('recommender_widgets-checkout').select('select#recommender_widgets-checkout_active')[0].value == '2') {
			$('recommender_widgets-checkout').select('tr#row_recommender_widgets-checkout_block')[0].hide();
			$('recommender_widgets-checkout').select('tr#row_recommender_widgets-checkout_position')[0].hide();
			$('recommender_widgets-checkout').select('tr#row_recommender_widgets-checkout_file')[0].hide();
			$('recommender_widgets-checkout').select('tr#row_recommender_widgets-checkout_cms')[0].show();
		}
	},


	trackUploadButton: function(url) {
		var login = $('recommender_manual').select('input#recommender_manual_strands_login')[0].value;
		var pass = $('recommender_manual').select('input#recommender_manual_strands_password')[0].value;

		var oldForm = document.getElementById('uploadForm');
		if (oldForm != null) {
			oldForm.login.value = login;
			oldForm.password.value = pass;
			var uploadVarienForm = new varienForm('uploadForm');
		} else {
			var uploadForm = document.createElement('form');
			uploadForm.id = 'uploadForm';
			uploadForm.method = "post";
			uploadForm.action = url;
			uploadForm.target = "_blank";
			document.body.appendChild(uploadForm);
			var loginInput = document.createElement('input');
			uploadForm.appendChild(loginInput);
			loginInput.name = 'login';
			loginInput.type = 'hidden';
			loginInput.value = login;
			var passInput = document.createElement('input');
			passInput.name = 'password';
			passInput.type = 'hidden';
			passInput.value = pass;
			var formKey = document.createElement('input');
			formKey.name = 'form_key';
			formKey.type = 'hidden';
			formKey.value = '<?php echo Mage::getSingleton('core/session')->getFormKey() ?>';
	
			
			uploadForm.appendChild(passInput);
			uploadForm.appendChild(formKey);
	
			var uploadVarienForm = new varienForm('uploadForm');
		}
		uploadVarienForm.submit();				
	}


}

Event.observe(window, 'load', function() {


	StrandsRecommenderConfig.startCatalogSelection();

	StrandsRecommenderConfig.startActiveIndividualHomepage();
	StrandsRecommenderConfig.startActiveIndividualProduct();
	StrandsRecommenderConfig.startActiveIndividualCategory();
	StrandsRecommenderConfig.startActiveIndividualCart();
	StrandsRecommenderConfig.startActiveIndividualCheckout();

	
	Element.observe('recommender_widgets-homepage_active', 'change', StrandsRecommenderConfig.trackWidgetsHomepage);
	Element.observe('recommender_widgets-product_active', 'change', StrandsRecommenderConfig.trackWidgetsProduct);
	Element.observe('recommender_widgets-category_active', 'change', StrandsRecommenderConfig.trackWidgetsCategory);
	Element.observe('recommender_widgets-cart_active', 'change', StrandsRecommenderConfig.trackWidgetsCart);
	Element.observe('recommender_widgets-checkout_active', 'change', StrandsRecommenderConfig.trackWidgetsCheckout);

	Element.observe('recommender_catalog_select', 'change', StrandsRecommenderConfig.trackCatalogSelection);

	Element.observe('recommender_cron_strands_login', 'change', StrandsRecommenderConfig.trackLoginChange);
	Element.observe('recommender_manual_strands_login', 'change', StrandsRecommenderConfig.trackLoginChange);
	Element.observe('recommender_cron_strands_password', 'change', StrandsRecommenderConfig.trackPasswordChange);
	Element.observe('recommender_manual_strands_password', 'change', StrandsRecommenderConfig.trackPasswordChange);

	Element.observe('recommender_widgets-homepage_block', 'change', StrandsRecommenderConfig.trackActiveIndividualWidget);
	Element.observe('recommender_widgets-product_block', 'change', StrandsRecommenderConfig.trackActiveIndividualWidget);
	Element.observe('recommender_widgets-category_block', 'change', StrandsRecommenderConfig.trackActiveIndividualWidget);
	Element.observe('recommender_widgets-cart_block', 'change', StrandsRecommenderConfig.trackActiveIndividualWidget);
	Element.observe('recommender_widgets-checkout_block', 'change', StrandsRecommenderConfig.trackActiveIndividualWidget);

	Element.observe('recommender_account_strands_api_id', 'change', StrandsRecommenderConfig.trackApiidInput);
	Element.observe('recommender_account_strands_customer_token', 'change', StrandsRecommenderConfig.trackCustomertokenInput);

});
</script>