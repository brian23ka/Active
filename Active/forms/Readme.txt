Contact form setup
==================

Set the CONTACT_EMAIL environment variable on the PHP hosting server to the
company email address that should receive banana supply enquiries. PHP mail
delivery must also be configured by the host. The form reports a configuration
error until both are available.

The contact handler validates the form fields and sends enquiries using PHP's
mail() function. It does not depend on the BootstrapMade PHP Email Form library.
