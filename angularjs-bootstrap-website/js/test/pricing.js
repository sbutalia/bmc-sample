'use strict';

describe('when user did not login faceboock, pricing page test', function() {
    
	it('should load facebook', function() {
	    var base_url = '/#/p/pricing';
		browser().navigateTo(base_url);
		sleep(3);
	});

	it('when user click facebook page, should show modal', function() {
	    element('.pagesDropdown').click();
		sleep(1)
		expect(element('#fbLoginModal').css("display")).toBe("block"); 
	});

});

describe('when user did not login faceboock, pricing page test', function() {
	
	describe('when user click credit card option', function() {

		it('should load facebook', function() {
			var base_url = '/#/p/pricing';
			browser().navigateTo(base_url);
			sleep(3);
		});

		it('should load facebook pages', function() {;
			expect(repeater('.pagesDropdown option').count()).toEqual(10);
		});
		
		it('after click facebook page, If state is paid,  should show go to link', function() {
			select('selectedPage').option('345234972289010');
			expect(element('.pricing-lockdown a').attr('class')).toEqual('not-active');
			expect(element('.message-list').html()).toEqual('You are all setup for this page. Please <a href="/#/p/apps/overview">select an application</a> to install.');
		});

		it('after click facebook page, If state is not paid, should be active select button', function() {
			select('selectedPage').option('723993830963637');
			expect(element('.pricing-lockdown a').attr('class')).toEqual('');
		});

		it('after click select button, should go to purchase page', function() {
			// click credit card option
			input('planCode').select('1');
			element('.pricing-lockdown a:eq(0)').click();
			expect(element('#payment-progress li:first-child').attr('class')).toEqual('selected');
			expect(element('.the-form:eq(0) .the-form-line-breaks:eq(1)').css("display")).toBe("block"); 
			expect(element('.referral-code-context').css("display")).toBe("block"); 
			expect(element('.digital-signature-context').css("display")).toBe("none"); 
		});

		it('after empty input in firstname filed and click review order button, should show error message', function() {
			input('account.last_name').enter('Sliva');
			input('account.email').enter('ggg@gmail.com');
			input('billing_info.phone').enter('418 56 2517');
			input('account.company_name').enter('peace');
			input('billing_info.address1').enter('address1');
			input('billing_info_address2').enter('address2');
			input('billing_info.city').enter('Kremenchuk');
			input('billing_info.state').enter('');
			select('billing_info.country').option('AF');
			input('billing_info.zip').enter('39600');
			select('credit_card_month').option('2');
			select('credit_card_year').option('2014');
			input('credit_card_number').enter('4111-1111-1111-1111');
			input('credit_card_verification_value').enter('2356');
			element('.btn-review-order').click();
			expect(element('.missing-items .error:first-child').text()).toEqual('Missing Firstname');
		});

		it('after input all billing info and click review order button, should go to place order page', function() {
			input('account.first_name').enter('Dima');
			element('.btn-review-order').click();
			expect(element('#payment-progress li:nth-child(2)').attr('class')).toEqual('selected');
		});

		it('Payment method shoud be "4111-1111-1111-1111 Expires: 3 2014" in order page ', function() {
			expect(element('.the-form:eq(1) .the-form-line-breaks:eq(1)').css("display")).toBe("block"); 
			expect(element('.the-form:eq(1) .the-form-line-breaks:eq(2)').css("display")).toBe("none"); 
			expect(element('.the-form:eq(1) .the-form-line-breaks:eq(1) span:eq(0)').text()).toEqual('4111-1111-1111-1111');
		});

		it('when did not click agree term and click review order button, should show error message', function() {
			element('.btn-submit-order').click();
			expect(element('.the-form:eq(1) .errors-list').text()).toEqual('Please agree to North Social Terms of Service.');
		});

		it('after click agree term and click review order button, If verification value of credit card is wrong, should go to billing page and show error message', function() {
			input('agree_term').check()
			element('.btn-submit-order').click();
			expect(element('#payment-progress li:nth-child(1)').attr('class')).toEqual('selected');
			expect(element('.error-list').text()).toEqual('Verification value must be three digits.');
		});
/*
		it('If verification value of credit card is true, should go to confirm page', function() {
			input('credit_card_verification_value').enter('123');
			element('.btn-review-order').click();
			element('.btn-submit-order').click();
			expect(element('#payment-progress li:nth-child(3)').attr('class')).toEqual('selected');
			expect(element('.credit-btn-block').css("display")).toBe("block"); 
			expect(element('.invoice-btn-block').css("display")).toBe("none"); 
		});

		it('after click review edit fan page button, should go to facebook page', function() {
			element('.credit-btn-block .btn-ns').click();
		});

		*/
	});

	describe('when user click invoice option', function() {

		it('should load facebook', function() {
			var base_url = '/#/p/pricing';
			browser().navigateTo(base_url);
			sleep(3);
		});

		it('should load facebook pages', function() {;
			expect(repeater('.pagesDropdown option').count()).toEqual(10);
		});
		
		it('after click facebook page, If state is paid,  should show go to link', function() {
			select('selectedPage').option('345234972289010');
			expect(element('.pricing-lockdown a').attr('class')).toEqual('not-active');
			expect(element('.message-list').html()).toEqual('You are all setup for this page. Please <a href="/#/p/apps/overview">select an application</a> to install.');
		});

		it('after click facebook page, If state is not paid, should be active select button', function() {
			select('selectedPage').option('723993830963637');
			expect(element('.pricing-lockdown a').attr('class')).toEqual('');
		});

		it('after click select button, should go to purchase page', function() {
			// click credit card option
			input('planCode').select('2');
			element('.pricing-lockdown a:eq(0)').click();
			expect(element('#payment-progress li:first-child').attr('class')).toEqual('selected');
			expect(element('.the-form:eq(0) .the-form-line-breaks:eq(1)').css("display")).toBe("none"); 
			expect(element('.referral-code-context').css("display")).toBe("none"); 
			expect(element('.digital-signature-context').css("display")).toBe("block"); 
		});

		it('after empty input in firstname filed and click review order button, should show error message', function() {
			input('account.last_name').enter('Sliva');
			input('account.email').enter('ggg@gmail.com');
			input('billing_info.phone').enter('41856662517');
			input('account.company_name').enter('peace');
			input('billing_info.address1').enter('address1');
			input('billing_info_address2').enter('address2');
			input('billing_info.city').enter('Kremenchuk');
			input('billing_info.state').enter('');
			select('billing_info.country').option('AF');
			input('billing_info.zip').enter('39600');
			input('account.digital_signature').enter('39600');
			element('.btn-review-order').click();
			expect(element('.missing-items .error:first-child').text()).toEqual('Missing Firstname');
		});

		it('after input all billing info and click review order button, should go to place order page', function() {
			input('account.first_name').enter('Dima');
			element('.btn-review-order').click();
			expect(element('#payment-progress li:nth-child(2)').attr('class')).toEqual('selected');
		});

		it('Payment method shoud be "4111-1111-1111-1111 Expires: 3 2014" in order page ', function() {
			expect(element('.the-form:eq(1) .the-form-line-breaks:eq(1)').css("display")).toBe("none"); 
			expect(element('.the-form:eq(1) .the-form-line-breaks:eq(2)').css("display")).toBe("block"); 
			expect(element('.the-form:eq(1) .the-form-line-breaks:eq(2) span:eq(0)').text()).toEqual('Invoice');
		});

		it('when did not click agree term and click review order button, should show error message', function() {
			element('.btn-submit-order').click();
			expect(element('.the-form:eq(1) .errors-list').text()).toEqual('Please agree to North Social Terms of Service.');
		});

		it('after click agree term and click review order button, If verification value of credit card is wrong, should go to billing page and show error message', function() {
			input('agree_term').check()
			element('.btn-submit-order').click();
			expect(element('#payment-progress li:nth-child(3)').attr('class')).toEqual('selected');
			expect(element('.credit-btn-block').css("display")).toBe("none"); 
			expect(element('.invoice-btn-block').css("display")).toBe("block"); 
		});

		it('when click print receipt', function() {
			element('.invoice-btn-block .btn-ns').click();
		});

		
	});
});
