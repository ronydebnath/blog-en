jQuery('body').on('click','.penci-recipe-print',function(){
	var printWindow = window.open('', '', 'height=800,width=800');
	var printCSS = jQuery(this).data('print');
	var divContents = jQuery(this).parent().parent().parent().html() +
						"<script>" +
						"window.onload = function() {" +
						"     window.print();" +
						"};" +
						"<" + "/script>";
	var srcCSS = '<link href=\"' + printCSS + '\" rel=\"stylesheet\" type=\"text/css\" media=\"print\">';
	setTimeout(function() {
		printWindow.document.write( srcCSS + divContents);
		printWindow.document.close();
	}, 250);
	return false;
});