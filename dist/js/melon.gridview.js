/**
 * 
 */
(function ($) {
	$.fn.melongrid = function (method) {
		if (methods[method]) {
			return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
		} else if (typeof method === 'object' || !method) {
				return methods.init.apply(this, arguments);
		} else {
			$.error('Method ' + method + ' does not exist in jQuery.yiiGridView');
			return false;
		}
	};
	
	var methods = {
		init: function(){
			
		}
	};
})(window.jQuery);