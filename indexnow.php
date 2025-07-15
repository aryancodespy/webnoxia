<?php
$data = [
  "host": "www.webnoxia.com",
  "key": "61faf15d6992465ab87b8cf507aa3d3f",
  "keyLocation": "https://www.webnoxia.com/61faf15d6992465ab87b8cf507aa3d3f.txt",
  "urlList": [
      "https://www.webnoxia.com/about",
      "https://www.webnoxia.com/service",
      "https://www.webnoxia.com/project",
      "https://www.webnoxia.com/contact",
      "https://www.webnoxia.com/team"
    ]
];

$options = [
    'http' => [
        'header'  => "Content-type: application/json\r\n",
        'method'  => 'POST',
        'content' => json_encode($data),
    ]
];

$context  = stream_context_create($options);
$result = file_get_contents('https://api.indexnow.org/IndexNow', false, $context);
echo $result;
?>
