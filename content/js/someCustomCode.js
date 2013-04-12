
$(function() {
	var Module = function($el) {
		var that = this;

		this.$el = $el;

		console.log($el);

		this.$el.find('h4').on('click', function() {
			that.save();
		});
	}

	Module.prototype.save = function() {
		var that = this;
		$.ajax({
			url: '/index.php/test/api'
		}).done(function() {
			that.$el.trigger('saveSuccess');
		}).fail(function() {
			that.$el.trigger('saveFail');
		});
	}

	var $el = $('article')

	var mod = new Module($el);

	$el.on('saveSuccess', function() {
		console.log('save Succeeded!');
	})
	$el.on('saveFail', function() {
		console.log('save Failed!');
	});
});