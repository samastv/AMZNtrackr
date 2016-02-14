<!DOCTYPE HTML>

<html>
  <head>
    <title>Track</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!--[if lte IE 8]><script src="assets/js/html5shiv.js"></script><![endif]-->
    <link rel="stylesheet" href="assets/css/main.css" />
    <!--[if lte IE 9]><link rel="stylesheet" href="assets/css/ie9.css" /><![endif]-->
    <!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->
    <noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
    <link rel="shortcut icon" type="image/x-icon" href="Logo.png" />

  </head>
  <body>

    <!-- Scripts -->
      <!--[if lte IE 8]><script src="assets/js/respond.min.js"></script><![endif]-->
      <script>

        if ('addEventListener' in window) {
          window.addEventListener('load', function() { document.body.className = document.body.className.replace(/\bis-loading\b/, ''); });
          document.body.className += (navigator.userAgent.match(/(MSIE|rv:11\.0)/) ? ' is-ie' : '');
        }

      </script>

<?php
  // Your AWS Access Key ID, as taken from the AWS Your Account page
  $aws_access_key_id = "AKIAI2WAASHANPIJSOZA";

  // Your AWS Secret Key corresponding to the above ID, as taken from the AWS Your Account page
  $aws_secret_key = "gg72F2caTJWTU5OQ+TwqYHZSiSpOKKcTLNBgqp9s";

  // The region you are interested in
  $endpoint = "webservices.amazon.com";

  $uri = "/onca/xml";

  $params = array(
      "Service" => "AWSECommerceService",
      "Operation" => "ItemSearch",
      "AWSAccessKeyId" => "AKIAI2WAASHANPIJSOZA",
      "AssociateTag" => "baarha-20",
      "SearchIndex" => "All",
      "Keywords" => $_POST["product"],
      "ResponseGroup" => "Images,ItemAttributes,Offers"
  );

  // Set current timestamp if not set
  if (!isset($params["Timestamp"])) {
      $params["Timestamp"] = gmdate('Y-m-d\TH:i:s\Z');
  }

  // Sort the parameters by key
  ksort($params);

  $pairs = array();

  foreach ($params as $key => $value) {
      array_push($pairs, rawurlencode($key)."=".rawurlencode($value));
  }

  // Generate the canonical query
  $canonical_query_string = join("&", $pairs);

  // Generate the string to be signed
  $string_to_sign = "GET\n".$endpoint."\n".$uri."\n".$canonical_query_string;

  // Generate the signature required by the Product Advertising API
  $signature = base64_encode(hash_hmac("sha256", $string_to_sign, $aws_secret_key, true));

  // Generate the signed URL
  $request_url = 'http://'.$endpoint.$uri.'?'.$canonical_query_string.'&Signature='.rawurlencode($signature);

  // echo "Signed URL: \"".$request_url."\"";
  //header('Content-type: text/xml');
  $file = simplexml_load_file($request_url );
  // print($file->Items->Item->ItemLinks->ItemLink->URL);
  $price=($file->Items->Item->ItemAttributes->ListPrice->FormattedPrice);
  // print($price);
  $image=($file->Items->Item->LargeImage->URL);
  // print($image);
  $name=($file->Items->Item->ItemAttributes->Title);
  // print($name);
?>

<!-- Wrapper -->
      <div id="wrapper">

        <!-- Main -->
          <section id="track">
            <header>
              <h1>Choosing your Product</h1>
              <?php echo "<p>The product you have chosen is ".$name.".</p>";?>
            </header>
          </section>

        <!-- Footer -->
          <footer id="footer">
            <ul class="credits">
              <li>Samast Varma, Varad Nevasekar, Saurav Chhatrapati</li>
            </ul>
          </footer>

      </div>
  </body>
</html>