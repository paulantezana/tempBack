<?php
class HomeController
{

    public function Exec()
    {


//$privateKey = <<<EOD
//-----BEGIN RSA PRIVATE KEY-----
//MIICXAIBAAKBgQC8kGa1pSjbSYZVebtTRBLxBz5H4i2p/llLCrEeQhta5kaQu/Rn
//vuER4W8oDH3+3iuIYW4VQAzyqFpwuzjkDI+17t5t0tyazyZ8JXw+KgXTxldMPEL9
//5+qVhgXvwtihXC1c5oGbRlEDvDF6Sa53rcFVsYJ4ehde/zUxo6UvS7UrBQIDAQAB
//AoGAb/MXV46XxCFRxNuB8LyAtmLDgi/xRnTAlMHjSACddwkyKem8//8eZtw9fzxz
//bWZ/1/doQOuHBGYZU8aDzzj59FZ78dyzNFoF91hbvZKkg+6wGyd/LrGVEB+Xre0J
//Nil0GReM2AHDNZUYRv+HYJPIOrB0CRczLQsgFJ8K6aAD6F0CQQDzbpjYdx10qgK1
//cP59UHiHjPZYC0loEsk7s+hUmT3QHerAQJMZWC11Qrn2N+ybwwNblDKv+s5qgMQ5
//5tNoQ9IfAkEAxkyffU6ythpg/H0Ixe1I2rd0GbF05biIzO/i77Det3n4YsJVlDck
//ZkcvY3SK2iRIL4c9yY6hlIhs+K9wXTtGWwJBAO9Dskl48mO7woPR9uD22jDpNSwe
//k90OMepTjzSvlhjbfuPN1IdhqvSJTDychRwn1kIJ7LQZgQ8fVz9OCFZ/6qMCQGOb
//qaGwHmUK6xzpUbbacnYrIM6nLSkXgOAwv7XXCojvY614ILTK3iXiLBOxPu5Eu13k
//eUz9sHyD6vkgZzjtxXECQAkp4Xerf5TGfQXGXhxIX52yH+N2LtujCdkQZjXAsGdm
//B2zNzvrlgRmgBrklMTrMYgm1NPcW+bRLGcwgW2PTvNM=
//-----END RSA PRIVATE KEY-----
//EOD;
//
//$publicKey = <<<EOD
//-----BEGIN PUBLIC KEY-----
//MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQC8kGa1pSjbSYZVebtTRBLxBz5H
//4i2p/llLCrEeQhta5kaQu/RnvuER4W8oDH3+3iuIYW4VQAzyqFpwuzjkDI+17t5t
//0tyazyZ8JXw+KgXTxldMPEL95+qVhgXvwtihXC1c5oGbRlEDvDF6Sa53rcFVsYJ4
//ehde/zUxo6UvS7UrBQIDAQAB
//-----END PUBLIC KEY-----
//EOD;
//
//        $data = 'Datos a encriptar';

        $binary_signature = "";

        // At least with PHP 5.2.2 / OpenSSL 0.9.8b (Fedora 7)
        // there seems to be no need to call openssl_get_privatekey or similar.
        // Just pass the key as defined above
//        openssl_sign($data, $binary_signature, $privateKey, OPENSSL_ALGO_SHA1);
//
//        // Check signature
//        $ok = openssl_verify($data, $binary_signature, $publicKey, OPENSSL_ALGO_SHA1);
//        echo "check #1: ";
//        if ($ok == 1) {
//            echo "signature ok (as it should be)\n";
//        } elseif ($ok == 0) {
//            echo "bad (there's something wrong)\n";
//        } else {
//            echo "ugly, error checking signature\n";
//        }
//        var_dump($binary_signature);
//
//        $ok = openssl_verify('tampered'.$data, $binary_signature, $publicKey, OPENSSL_ALGO_SHA1);
//        echo "check #2: ";
//        if ($ok == 1) {
//            echo "ERROR: Data has been tampered, but signature is still valid! Argh!\n";
//        } elseif ($ok == 0) {
//            echo "bad signature (as it should be, since data has beent tampered)\n";
//        } else {
//            echo "ugly, error checking signature\n";
//        }
//        var_dump($binary_signature);


//        function urlB64Encode($input)
//        {
//            return str_replace('=', '', strtr(base64_encode($input), '+/', '-_'));
//        }
//
//        $header = [
//            'alg' => 'SHA512'
//        ];
//        $payload = [
//            'businessId' => 1,
//            'localId' => 2,
//        ];
//
//        $segments[] = urlB64Encode(json_encode($header));
//        $segments[] = urlB64Encode(json_encode($payload));
//        $signing_input = implode('.',$segments);
//
//        $signature = '';
//        openssl_sign($signing_input,$signature, $privateKey, $header['alg']);
//        $dataSign[] = urlB64Encode($signature);
//
//
//        var_dump(implode('.', $dataSign));

        $content = requireToVar(VIEW_PATH."User/Home.php", []);
        require_once(VIEW_PATH."User/Layout/main.php");
    }
}
