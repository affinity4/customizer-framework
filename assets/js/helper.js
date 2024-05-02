(function($) {

	/**
	* Restrics input for the set of matched elements to the given
	* inputFilter function.
	*
	* @since 1.0.0
	*/
	$.fn.inputFilter = function( inputFilter ) {
		return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function() {
			if( inputFilter( this.value ) ) {
				this.oldValue = this.value;
				this.oldSelectionStart = this.selectionStart;
				this.oldSelectionEnd = this.selectionEnd;
			}else if( this.hasOwnProperty( "oldValue" ) ) {
				this.value = this.oldValue;
				this.setSelectionRange( this.oldSelectionStart, this.oldSelectionEnd );
			}else{
				this.value = "";
			}
		});
	};
}(jQuery));