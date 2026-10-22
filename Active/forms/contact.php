<?php
header('Content-Type: text/plain; charset=utf-8');

function respond($message, $status)
{
  http_response_code($status);
  echo $message;
  exit;
}

function posted_string($key)
{
  $value = isset($_POST[$key]) ? $_POST[$key] : '';
  return is_string($value) ? trim($value) : '';
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  respond('Submit the enquiry using the contact form.', 405);
}

$recipient = getenv('CONTACT_EMAIL');
if ($recipient === false || filter_var(trim($recipient), FILTER_VALIDATE_EMAIL) === false) {
  respond('The enquiry form is not configured yet. Please contact the site administrator.', 503);
}
$recipient = trim($recipient);

$name = posted_string('name');
$email = filter_var(posted_string('email'), FILTER_VALIDATE_EMAIL);
$subject = posted_string('subject');
$message = posted_string('message');

if ($name === '' || strlen($name) > 200 || $email === false || $subject === '' || strlen($subject) > 200 || $message === '' || strlen($message) > 5000) {
  respond('Please provide a valid name, email, order request and message.', 400);
}

$body = "Name: " . $name . "\n";
$body .= "Email: " . $email . "\n";
$body .= "Request: " . $subject . "\n\n";
$body .= $message . "\n";
$headers = "From: " . $recipient . "\r\n";
$headers .= "Reply-To: " . $email . "\r\n";

if (!mail($recipient, 'Banana supply enquiry', $body, $headers)) {
  respond('We could not send your enquiry. Please try again later.', 500);
}

echo 'OK';
