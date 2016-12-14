/*
 *
 *
 */

function makePostRequest() {
	// jQuery's .post method (below) is implemented using three parameters
	// URL - the URL to send the request
	// data - additional data to send with the request. Should be a dictionary of key-value pairs. The keys will be used by PHP to extract values
	// function - function to run upon completion
	var quantity_id = event.target.id;

	console.log("quantity_id is: " + quantity_id);
	console.log("newingredient_fk is: " + $(`#${event.target.id} option:selected`).val());

 $.post($(`#quantity${quantity_id}Form`).attr("action"),
        {'quantity_id': quantity_id, 'newingredient_fk': $(`#${quantity_id} option:selected`).val()},
        function(result){
        	$(`#row${quantity_id}`).html(result);
        });
};