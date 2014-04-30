'use strict';

describe('when user did not login faceboock, install page test', function() {
    
	it('should load facebook', function() {
	    var base_url = '/#/p/apps/instagram';
		browser().navigateTo(base_url);
		sleep(3);
	});

	it('after click install page button, should go to install page', function() {;
		element('#appInstallButton').click();
		sleep(3);
	});

	it('should show facebook login button', function() {
		expect(element('.facebookConnect').css("display")).toBe("block"); 
		expect(element('.install-me').css("display")).toBe("none"); 
	});

});

describe('pricing page test', function() {
	
	it('should load facebook', function() {
	    var base_url = '/#/p/apps/instagram';
		browser().navigateTo(base_url);
		sleep(3);
	});

	it('after click install page button, should go to install page', function() {;
		element('#appInstallButton').click();
		sleep(3);
	});
	
	it('after click facebook page, If state is not paid,  should go to pricing page and diplay selected page and app', function() {
		select('selectedItem').option('723993830963637');
		element('.btn-ipg-install-app').click();
		expect(element('.message-list').html()).toEqual('Please <a href="/#/p/pricing">click here</a> to signup the page.');
		element('.message-list a').click();
        expect(element('.dropdown:eq(0)').css("display")).toBe("block"); 
		expect(element('.dropdown:eq(1)').css("display")).toBe("none"); 
	});

	it('If click reset section button, should show facebook page list', function() {
		element('.reset-section').click();
		expect(element('.dropdown:eq(0)').css("display")).toBe("none"); 
		expect(element('.dropdown:eq(1)').css("display")).toBe("block"); 
	});

	it('after click select button, should go to purchase page', function() {
			// click credit card option
			select('selectedPage').option('723993830963637');
			input('planCode').select('1');
			element('.pricing-lockdown a:eq(0)').click();
			expect(element('#payment-progress li:first-child').attr('class')).toEqual('selected');
			expect(element('.the-form:eq(0) .the-form-line-breaks:eq(1)').css("display")).toBe("block"); 
			expect(element('.referral-code-context').css("display")).toBe("block"); 
			expect(element('.digital-signature-context').css("display")).toBe("none"); 
		});

		it('after empty input in firstname filed and click review order button, should show error message', function() {
			input('account.last_name').enter('Sliva');
			input('account.last_name').enter('Dima');
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
			input('credit_card_verification_value').enter('123');
			element('.btn-review-order').click();
			expect(element('#payment-progress li:nth-child(1)').attr('class')).toEqual('selected');
		});

/*
		it('after click submit button should go to confirm page', function() {
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