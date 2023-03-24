;(function() {
	'use strict';
	window.throttleResize = function(fn) {
		var scheduled = false, lastEvent;
		addEventListener('resize', function(event) {
			lastEvent = event;
			if (!scheduled) {
				scheduled = true;
				setTimeout(function() {
					scheduled = false;
					fn();
				}, 500);
			}
		});
	};
}());
