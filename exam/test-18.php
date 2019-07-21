<?php
require_once __DIR__ . '/../vendor/autoload.php';

use digitall\Epp;
use Symfony\Component\Yaml\Yaml;

$cfg = Yaml::parseFile(__DIR__ . '/../exam.yaml');

$epp_a = new Epp("epp-a", $cfg["servers"]["exam-a"]);
$epp_b = new Epp("epp-b", $cfg["servers"]["exam-b"]);

$domain_test = $cfg["sampledomains"]['test'];
$domain_test['authInfo'] = 'newwwtest-it';


echo 'Test 18 - Modification of the AuthInfo code of a domain name:';

$return = $epp_b->domainUpdate(
    [
        'name' => 'test.it',
        'chg' => [
            'authInfo' => 'BB-29-IT'
        ]
    ]
);
if ($return['status']['code'] != 1000) die('FAILED');
echo "OK\n";

unset($epp_a);
unset($epp_b);