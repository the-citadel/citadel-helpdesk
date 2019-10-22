<?php

add_action( 'wp_ajax_button_click', 'user_clicked' );
function user_clicked() {

	$id = $_POST['id'];
	$column = $_POST['column'];
	$value = $_POST['value'];
	$successMessage = 'Ticket [' . $id . '] has been updated';

	if ($column == 'status') {
		//wp_set_object_terms( $id, array($value), 'ticket_categories' );
		echo 'The ' . $column . ' for ' . $successMessage . ' to ' . $value . '!';
	} else {
		echo $successMessage . '!';
	}

}