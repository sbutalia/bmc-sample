$(document).ready(function(){
/*
	new OffCanvasMenuController({
		$menu: $('#left-menu'),
		$menuToggle: $('#left-menu-toggle'),
		menuExpandedClass: 'show-left-menu',
		position: 'left'
	});

	new OffCanvasMenuController({
		$menu: $('#right-menu'),
		$menuToggle: $('#right-menu-toggle'),
		menuExpandedClass: 'show-right-menu',
		position: 'right'
	});


	$('#activityTable').stacktable({myClass:'stacktable small-only'});

	$(".toggleFields").on("click", function(){
		$("#fields").toggle();
		$(this).find(".caret").toggleClass("caret-up");
	});

	$(".closeLeft.closeMenu").on("click", function(){
		$("body").removeClass("show-left-menu");
	});
	$(".closeRight.closeMenu").on("click", function(){
		$("body").removeClass("show-right-menu");
	});

	$("#fieldInfoTable .viewMore").on("click", function(event){
		event.preventDefault();
		var $txt = $(this).prev().text();
		$("#moreInfoModal p.noteInfo").text($txt);
		$("#moreInfoModal").toggle();
	});

	// Switch on bootstrap-datepicker  plugin for non-info modal dialogs
	startDatepickers();

	$("#infoWaterModal .form-control").attr("readonly", true);
	$("#infoFertilizerModal .form-control").attr("readonly", true);
	$("#infoHarvestModal .form-control").attr("readonly", true);
	$("#infoPlantModal .form-control").attr("readonly", true);

	/*
	$('#editFieldModal .modal-dialog .form-control.date').keyup(function(event) {
		var value = $( this ).val();
		var $correctValue = value;
		if(value="") {

		}
		else {
			var date_regex = /^[a-zA-Z]{3}\s/\d{2},\s/\d{4}$/ ;
    		$correctValue = date_regex.test(value);
		}
		$(this).val( $correctValue );
	});*/
/*
	$( document.body ).on( 'click', '.dropdown-menu li', function( event ) {

	var $target = $( event.currentTarget );

	$target.closest( '.btn-group' )
	  .find( '[data-bind="label"]' ).text( $target.text() )
	     .end()
	  .children( '.dropdown-toggle' ).dropdown( 'toggle' );

	return false;

	});*/

	$( document.body ).on( 'click', '.dropdown-menu li', function( event ) {

	var $target = $( event.currentTarget );

	$target.closest( '.btn-group' )
	  .find( '[data-bind="label"]' ).html( $target.html() )
	     .end()
	  .children( '.dropdown-toggle' ).dropdown( 'toggle' );

	return false;

	});

	//tablesorter plugin
	 $("#activityTable").tablesorter();

});
	
function glDatePicker() {
	//$('#infoWaterModal .modal-dialog .form-control.date').glDatePicker();
}


function startDatepickers() {
	$('#editFieldModal .modal-dialog .form-control.date').datepicker({
		format: "M dd, yyyy",
		minViewMode: 0, 
		autoclose: true, 
		forceParse: true
	});
	$('#editFieldEmptyModal .modal-dialog .form-control.date').datepicker({
		format: "M dd, yyyy",
		minViewMode: 0, 
		autoclose: true, 
		forceParse: true
	});
	$('#editPlantModal .modal-dialog .form-control.date').datepicker({
		format: "M dd, yyyy",
		minViewMode: 0, 
		autoclose: true, 
		forceParse: true
	});
	$('#editHarvestModal .modal-dialog .form-control.date').datepicker({
		format: "M dd, yyyy",
		minViewMode: 0, 
		autoclose: true, 
		forceParse: true
	});
	$('#editPlantModal .modal-dialog .form-control.date').datepicker({
		format: "M dd, yyyy",
		minViewMode: 0, 
		autoclose: true, 
		forceParse: true
	});
	/*$('#infoPlantModal .modal-dialog .form-control.date').datepicker({
		format: "M dd, yyyy",
		minViewMode: 0, 
		autoclose: true, 
		forceParse: true
	});*/
	$('#editFertilizerModal .modal-dialog .form-control.date').datepicker({
		format: "M dd, yyyy",
		minViewMode: 0, 
		autoclose: true, 
		forceParse: true
	});
	/*$('#infoFertilizerModal .modal-dialog .form-control.date').datepicker({
		format: "M dd, yyyy",
		minViewMode: 0, 
		autoclose: true, 
		forceParse: true
	});*/
	$('#editHarvestModal .modal-dialog .form-control.date').datepicker({
		format: "M dd, yyyy",
		minViewMode: 0, 
		autoclose: true, 
		forceParse: true
	});
	/*$('#infoHarvestModal .modal-dialog .form-control.date').datepicker({
		format: "M dd, yyyy",
		minViewMode: 0, 
		autoclose: true, 
		forceParse: true
	});*/
	
	$('#editWaterModal .modal-dialog .form-control.date').datepicker({
		format: "M dd, yyyy",
		minViewMode: 0, 
		autoclose: true, 
		forceParse: true
	});
	/*$('#infoWaterModal .modal-dialog .form-control.date').datepicker({
		format: "M dd, yyyy",
		minViewMode: 0, 
		autoclose: true
	});*/
	$('#addActivitySpecModal .modal-dialog .form-control.date').datepicker({
		format: "M dd, yyyy",
		minViewMode: 0, 
		autoclose: true, 
		forceParse: true
	});
	
	/*$('#dateZebra').Zebra_DatePicker({
	    format: 'M d, Y'
	});*/
}
