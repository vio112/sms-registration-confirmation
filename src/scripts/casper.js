var casper = require('casper').create({
	verbose: true,
  	logLevel: 'error',
  	pageSettings: {
    	loadImages: false,
    	loadPlugins: false,
    	userAgent: 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.2 Safari/537.36'
  	},
  	waitTimeout: 30000
});
var message = casper.cli.get(0);

casper.start('https://im.chikka.com/');

casper.then(function(){
	this.echo('1. filling up the form.');
	this.fillSelectors("form[class='com-si-form']",{
	    'input.inp-txt-mn' : '9392076605',
	    'input.inp-txt-pwd' : 'Delosreyes!1'
	}, true);
});

casper.waitForSelector('body.page-signed-in', function() {
	this.echo('2. Entered DashBoard');
});

casper.waitForSelector('#recipient-toolbar:not([style*="display: none"])', function(){
	if (this.visible('#recipient-toolbar')) {
	    this.echo("3. Add recipient textarea is visible.");
	} else {
	    this.echo("3. Add recipient textarea is NOT visible.");
	}
});

casper.waitForSelector('#comp-msg-lnk-id', function() {
	if (this.visible('#comp-msg-lnk-id')) {
	    this.echo("4. compose message logo is visible.");
	} else {
	    this.echo("4. compose message logo is NOT visible.");
	}
	this.click('#comp-msg-lnk-id');
});

casper.waitForSelector('#compose-message-toolbar', function() {
	this.echo('5. Adding recipient number and message..');
	this.sendKeys('#search-recipients-txt', '09392076605');
	this.sendKeys('#inp-textarea-id', 'Your Confirmation code is: ' + message );
});

casper.waitForSelector('div.psu-btn.psu-btn-pri.psu-btn-sub', function(){
	this.click('#compose-msg-submit-btn');
	this.echo('6. Message submitted!');
});

// casper.then(function(){
// 	this.echo('wait for a sec...');
// 	this.wait(1000, function(){
// 	this.capture('chikka.jpg');
// 	this.echo('sceenshot done!');
// 	});
// });

casper.run();