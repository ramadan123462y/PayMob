
***
# **Integration With PayMob**
***
#دي documentaion علشان request, response [ApiFlow](https://docs.paymob.com/docs/accept-standard-redirect)

***

Maked By Ramdan Mohamed
***



# 1-First Login Or Register
[Paymob Login](https://accept.paymob.com/portal2/en/login)
# 2-Step Auth Used Api key
يستخدم باننا لما نبعت اي طلب للسيرفيv زي (Username Password) الحصول على مفتاح الواجهة البرمجية (API key): بعد تسجيل الدخول، يمكنك الحصول على مفتاح الواجهة البرمجية من خلال الرابط المرفق: [Api key](https://accept.paymob.com/portal2/en/settings).from [Api key](https://accept.paymob.com/portal2/en/settings) **Setting tab**



***

`

    `
    public function Auth_Paymob()
    {
        $response =  Http::withHeader('content-type', 'application/json')->post(
            'https://accept.paymob.com/api/auth/tokens',
            [
                "api_key" => env('paymob_api_key')
            ]
        );
        $this->token = $response['token'];

        return $this;
    }


# 3-Step Register Order 
 بنستخدم الطلب دا علشان نقوله اعمل تسجيل لل الاوردر دا بس متدفعوش لان الاوردر ممكن يكون ليه اكتر عمليه دفع وكمان علشان يعرض عمليات Transections



***

`

    `
       public function Register_Order(array $data_order)
    {
        $data = [

            "auth_token" => $this->token,
        ];
        $all_data =  array_merge($data, $data_order);
        $response2 = Http::asJson()->withHeaders([
            'Content-Type' => 'application/json'
        ])->post('https://accept.paymob.com/api/ecommerce/orders', $all_data);



        $this->order_id = $response2['id'];

        return  $this;
    }

# 4-Step Get_Payment_key
الطلب دا كل الهدف منه انو بديله id_order  الي اتعمله registeration وكمان  token  الي جه من الخطوه دي Get_Payment_key() بيرجعلي token  من خلاله بدفع 



***

`

    `
      public function Get_Payment_key($data_to_pay)
    {

        $data = [
            "auth_token" => $this->token,
            "order_id" => $this->order_id
        ];

        $all_data =  array_merge($data, $data_to_pay);

        $response3 = Http::asJson()->withHeaders([
            'Content-Type' => 'application/json'
        ])->post('https://accept.paymob.com/api/acceptance/payment_keys', $all_data);
        $this->Payment_Key_Request = $response3['token'];
        return $this;
    }


# 5-Step Url_Card_toIftame_ToPay


redirect To Pay In iFrame

***

`

    `
      public function Url_Card_toIftame_ToPay($id_iframes)
    {


        return "https://accept.paymob.com/api/acceptance/iframes/$id_iframes?payment_token=$this->Payment_Key_Request";
    }


# 6-StepRollBack

الخطوه دي ليها جانبين 
1-عباره عن route  من نوع get  انا بعمله عندي في السيستم وبسجله في paymob   بعد ما يتم الدفع بيروح عليه بالحاله وبيانات الاوردر وبكدا تكت عمليه الدفع 


***
[Transaction response callback](https://accept.paymob.com/portal2/en/PaymentIntegrations)

# 7-WebHoke
زي الي الي فوق بس دا علشان لو النت فصل 
1-عباره عن route  من نوع Post انا بعمله عندي في السيستم وبسجله في paymob   بعد ما يتم الدفع بيروح عليه بالحاله وبيانات الاوردر وبكدا تكت عمليه الدفع  عباره عن events  بيبعتها paymob عندي علشان في السييستم انا بكون مورفرله route api  علشان يخش عندي بعد ما يتم الدفع بيروح عليه بالحاله وبيانات الاوردر وبكدا تكت عمليه الدفع 
[Transaction processed callback](https://accept.paymob.com/portal2/en/PaymentIntegrations)

***
