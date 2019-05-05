<?php

namespace App\Utils;

use JonnyW\PhantomJs\Client as PhantomClient;
use JonnyW\PhantomJs\DependencyInjection\ServiceContainer;
use Goutte\Client;

class Facebook {

    private static $reg_url = "https://www.facebook.com/reg/";

    public static function createAccountByPhantomJs(){


        $location = '/Users/alesey/1ALL/GRAND/my-project/assets/phantom/facebook/registration/';

        $serviceContainer = ServiceContainer::getInstance();

        $procedureLoader = $serviceContainer->get('procedure_loader_factory')
            ->createProcedureLoader($location);

        $client = PhantomClient::getInstance();
        $client->getProcedureCompiler()->disableCache();
        $client->getEngine()->setPath('/Users/alesey/bin/phantomjs');
        //$client->setProcedure('my_procedure');
        $client->getProcedureLoader()->addLoader($procedureLoader);

        $request  = $client->getMessageFactory()->createRequest();
        $response = $client->getMessageFactory()->createResponse();

        $request->setMethod('GET');
        $request->setUrl(self::$reg_url);
        $request->setDelay("1");
        $request->setViewportSize(1280,800);


        $client->send($request, $response);



        var_dump($response);

    }

    public static function createAccount(){
        $client = new Client();
        $client->setHeader('User-Agent',
            "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.87 Safari/537.36");
        $crawler = $client->request('GET', self::$reg_url);


        $form = $crawler->filter('#reg')->form();
        foreach ($form as $domElement) {
            var_dump($domElement->nodeName);
        }

        $req_array = [
            'firstname' =>  "Aleksey",
            'lastname' => 'Stavotin',
            'reg_passwd__' => 'Stavotin123456',
            'reg_email__' => '+79111538097',
            'sex' => '2',
            "birthday_day" => "10",
            "birthday_month" => "01",
            "birthday_year" => "1993",
        ];

        $form->setValues($req_array);

        $values = $form->getValues();

        $crawler = $client->submit($form);

        var_dump($crawler->html());


     /*   $crawler = $client->submit($form, [
                'firstname' =>  "Aleksey",
                'lastname' => 'Stavotin',
                'reg_passwd__' => 'Stavotin123456',
                'reg_email__' => '+79111538097',
                'sex' => '2',
                "birthday_day" => "10",
                "birthday_month" => "01",
                "birthday_year" => "1993",
            ]
        );
     */
       // $crawler->filter('.flash-error')->each(function ($node) {
         //   print $node->text()."\n";
       // });
    }
}


/*
 * Request URL: https://www.facebook.com/ajax/register.php?dpr=1
Request Method: POST
Status Code: 200
Remote Address: 31.13.72.36:443
Referrer Policy: origin-when-cross-origin
access-control-allow-credentials: true
access-control-allow-methods: OPTIONS
access-control-allow-origin: https://www.facebook.com
access-control-expose-headers: X-FB-Debug, X-Loader-Length
cache-control: private, no-cache, no-store, must-revalidate
content-encoding: br
content-security-policy: default-src * data: blob:;script-src *.facebook.com *.fbcdn.net *.facebook.net *.google-analytics.com *.virtualearth.net *.google.com 127.0.0.1:* *.spotilocal.com:* 'unsafe-inline' 'unsafe-eval' *.atlassolutions.com blob: data: 'self';style-src data: blob: 'unsafe-inline' *;connect-src *.facebook.com facebook.com *.fbcdn.net *.facebook.net *.spotilocal.com:* wss://*.facebook.com:* https://fb.scanandcleanlocal.com:* *.atlassolutions.com attachment.fbsbx.com ws://localhost:* blob: *.cdninstagram.com 'self' chrome-extension://boadgeojelhgndaghljhdicfkmllpafd chrome-extension://dliochdbjfkdbacpmhlcpmleaejidimm;
content-type: application/x-javascript; charset=utf-8
date: Tue, 06 Nov 2018 18:56:21 GMT
expect-ct: max-age=86400, report-uri="http://reports.fb.com/expectct/"
expires: Sat, 01 Jan 2000 00:00:00 GMT
pragma: no-cache
set-cookie: xs=5%3AmUIm8cEJgc3o5A%3A2%3A1541530580%3A-1%3A-1; expires=Mon, 04-Feb-2019 18:56:20 GMT; Max-Age=7775999; path=/; domain=.facebook.com; secure; httponly
set-cookie: pl=n; expires=Mon, 04-Feb-2019 18:56:20 GMT; Max-Age=7775999; path=/; domain=.facebook.com; secure; httponly
set-cookie: reg_fb_ref=deleted; expires=Thu, 01-Jan-1970 00:00:01 GMT; Max-Age=-1541530580; path=/; domain=.facebook.com; httponly
set-cookie: reg_fb_gate=deleted; expires=Thu, 01-Jan-1970 00:00:01 GMT; Max-Age=-1541530580; path=/; domain=.facebook.com; httponly
set-cookie: c_user=100029876568881; expires=Mon, 04-Feb-2019 18:56:20 GMT; Max-Age=7775999; path=/; domain=.facebook.com; secure
set-cookie: fr=0rGqZP8Vf0XL4fKZR.AWURp3LzImL1nl5JsuQr4eN3u_A.BXyISD.rz.AAA.0.0.Bb4ePU.AWU9GPZ2; expires=Mon, 04-Feb-2019 18:56:20 GMT; Max-Age=7775999; path=/; domain=.facebook.com; secure; httponly
set-cookie: locale=ru_RU; expires=Tue, 13-Nov-2018 18:56:20 GMT; Max-Age=604799; path=/; domain=.facebook.com; secure
set-cookie: sb=_UTkVyaO0v0BpUhlHnsQaJ81; expires=Thu, 05-Nov-2020 18:56:20 GMT; Max-Age=63071999; path=/; domain=.facebook.com; secure; httponly
status: 200
strict-transport-security: max-age=15552000; preload
vary: Origin
vary: Accept-Encoding
x-content-type-options: nosniff
x-fb-debug: N1p00gw7vZBAT29t1rgvw+bIrjqjBVaMmt8wG7DKg8ZuOKEf9SDUC1NTdGed/ltv1ee0vsedZjcnt9U+qZmcZQ==
x-frame-options: DENY
x-xss-protection: 0
:authority: www.facebook.com
:method: POST
:path: /ajax/register.php?dpr=1
:scheme: https
accept:
accept-encoding: gzip, deflate, br
accept-language: ru-RU,ru;q=0.9,en-US;q=0.8,en;q=0.7
cache-control: no-cache
content-length: 1690
content-type: application/x-www-form-urlencoded
cookie: datr=80TkV4KubtZkq6xc65v3t3y-; sb=_UTkVyaO0v0BpUhlHnsQaJ81; ; locale=ru_RU; reg_fb_gate=https%3A%2F%2Fwww.facebook.com%2F%3Fstype%3Dlo%26jlou%3DAfc16XhjYrpgjZAGmfWfzHgNrHpr_PLBmgLim1uUz16EPwB-fRnh7yjklGCNczIBnsEjmxGueX3b-DasUX98jjH4gCgLkenpdL4CMSMo0QpNlA%26smuh%3D17505%26lh%3DAc_S_FtMbxczf8cF; m_pixel_ratio=1; fr=0rGqZP8Vf0XL4fKZR.AWXQlMo5VkHf5JnvsMOAH8N7IWQ.BXyISD.rz.AAA.0.0.Bb4eKs.AWXTouXG; wd=1440x359; reg_fb_ref=https%3A%2F%2Fwww.facebook.com%2Freg%2F
origin: https://www.facebook.com
pragma: no-cache
referer: https://www.facebook.com/reg/
user-agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.87 Safari/537.36
dpr: 1
lsd: AVodNfWx
firstname: Aleks
lastname: Testog
reg_email__: +79111538097
reg_email_confirmation__:
reg_second_contactpoint__:
reg_passwd__: Salamandra55555
birthday_day: 6
birthday_month: 6
birthday_year: 1993
sex: 2
referrer:
asked_to_login: 0
terms: on
ns: 0
ri: b885b730-a4cb-60fa-80a0-f17a99fef669
action_dialog_shown:
invid:
a:
oi:
locale: ru_RU
app_bundle:
app_data:
reg_data:
app_id:
fbpage_id:
reg_oid:
reg_instance: 80TkV4KubtZkq6xc65v3t3y-
openid_token:
uo_ip:
key:
re:
mid:
fid:
reg_dropoff_id:
reg_dropoff_code:
contactpoint_label: email_or_phone
ignore: reg_second_contactpoint__|captcha|reg_email_confirmation__
captcha_persist_data: AZm6Vc8dHpYtvJuv0cCAKm6JzrOC4_yrospMcIPZDRqLz6Ui0iEycOX0JPnF9_xnnijSAArRQlIWbpuogCrfIMdNZFCaqtrFX1ycYfI28u_6w7UiX8fQAtV_y83V8ShSHOdwWyxsthT4zh6hboj64koTKznc-2w_JR93E-O8kO4FdSMAZGXw20eK2SrjKUhbQodC6wcgzzoY8Is05FZkX5bu4kavaEJIpTESyEC2tWXUhKpb05jJPBYqjalzq2qt5ePeLjeUSgnzgxU3n5ylxNSzNLgj-GCn9ZnWnb8EAvFsErSWQ2yHhiF61_DNDDZiFixvv0Fjx5yHqSxIgr8F0J0QVlkvyOwvU4lqRoCqxvrXyJjYSOOPllBP5YOpYCcjVbg
captcha_response:
skstamp: eyJyb3VuZHMiOjUsInNlZWQiOiJmNmEyNDE2MTg2YjNlYjJkOTY2ODAyY2ZlNzBhOGY3NSIsInNlZWQyIjoiMzc2NTUyMGQyYjBjNjM0ZjgyZjc0MjQ3ZGM2NjU3ZGYiLCJoYXNoIjoiOWE1MzczMjc1Mzg1Y2Y2YWE3MTZjYTQ5YzA4YzU1MmQiLCJoYXNoMiI6ImM1NDJiMGI5YzU0MzEyODBiZDBmNTlhYjAzNzhmOTEwIiwidGltZV90YWtlbiI6MjIyNjk5LCJzdXJmYWNlIjoicmVnaXN0cmF0aW9uIn0=
    __user: 0
__a: 1
__dyn: 7AzHJ4zamaUCUx2u6Xolg9obHGiWGeye4m-C11xG3F6wAxu13wFG2K48jyR88xK5WAAzoOuVWxeUW2y4GDg4idxK4ohyVeE8UnyogKcx2785aayrwQx66E4G27xZ0WxSUlU4-2Z5wlU4qu4rG7pE9GBy8pxO12wRyU4KdyU4e4e6efxu8CwKwCzUyh1GicwKghxm3edBzUOEiK6o-6UG6EO1pGFUaUvxucz9XAy8aEaoB6yXwPz8-XwKwDxK68mwBgK
__req: x
__be: -1
__pc: PHASED:DEFAULT
__rev: 4504449
 *
 * */