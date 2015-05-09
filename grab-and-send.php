<?php

// First, retrieve the remote source using file_get_contents()
$str = file_get_contents('http://www.example.com/');    

$my_field_val  = 'my_field_value';
$fields_i_want = array('audien', 'unifor');
$field_vals    = array();
$field_string  = '';


// Use DOM to parse the values you want from the form
$dom = new DOMDocument;
$dom->loadHTML($str);

// Get all the input field nodes
$inputs = $dom->getElementsByTagName('input');

// Iterate over the input fields and save the values we want to an array
foreach ($inputs as $input) {
  $name = $input->getAttribute('name');
  if (in_array($name, $fields_i_want)) {
    $val = $input->getAttribute('value');
    $field_vals[$name] = $val;
  }
}

// append the field value we set ourselves to the list
$field_vals['my_field'] = $my_field_val;

foreach ($field_vals as $key => $val) {
  $field_vals[$key] = urlencode($val)
}

// url-ify the data for the POST
foreach($fields as $key=>$value) {
  $fields_string .= $key.'='.$value.'&';
}
rtrim($fields_string, '&');

// open connection
$ch = curl_init();

// POST the data to the form submission url
$submit_url = 'http://www.submitform.com';

// set the url, number of POST vars, POST data
curl_setopt($ch, CURLOPT_URL, $submit_url);
curl_setopt($ch, CURLOPT_POST, count($fields));
curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);

// execute post (returns TRUE on success or FALSE on failure)
$result = curl_exec($ch);

// close connection
curl_close($ch);
