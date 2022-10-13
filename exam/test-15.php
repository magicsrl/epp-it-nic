<?php
require_once __DIR__ . '/../vendor/autoload.php';

use digitall\Epp;
use Symfony\Component\Yaml\Yaml;

$cfg = Yaml::parseFile(__DIR__ . '/../exam.yaml');
$dryrun = $cfg['dryrun'];

$epp_a = new Epp('epp-a', $cfg['servers']['exam-a'], $dryrun);
$epp_b = new Epp('epp-b', $cfg['servers']['exam-b'], $dryrun);

$domain_test = $cfg["sampledomains"]['test'];
$domain_test['authInfo'] = 'newwwtest-it';

echo 'Test 15 - Request to change the Registrar of a domain name:';
$return = $epp_b->domainTransfer($domain_test, 'request');
if (!$dryrun && $return['status']['code'] != 2304) die('FAILED');
echo "OK-";

$return = $epp_a->domainUpdate(
    [
        'name' => 'test.it',
        'rem' => ['status' => "clientTransferProhibited"]
    ]
);
if (!$dryrun && $return['status']['code'] != 1000) die('FAILED');
echo "OK\n";

unset($epp_a);
unset($epp_b);