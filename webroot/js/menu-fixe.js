// Execution de cette fonction lorsque le DOM sera enti�rement charg� 
			
			
			
	$(document).ready(function() {
		showRight.onclick = function() {
				classie.toggle( this, 'active' );
				classie.toggle( menu_connexion, 'cbp-spmenu-open' );
				disableOther( 'showRight' );
			};
			
			
	}); 