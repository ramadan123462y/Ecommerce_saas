<?php

namespace Database\Seeders;

use App\Models\Myfatoorahmethodes;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MufatoorahmethodsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $paymentMethods = [
            [
                "PaymentMethodId" => 7,
                "PaymentMethodAr" => "البطاقات المدينة  قطر",
                "PaymentMethodEn" => "QPay",
                "ImageUrl" => "https://demo.myfatoorah.com/imgs/payment-methods/np.png",
            ],
            [
                "PaymentMethodId" => 6,
                "PaymentMethodAr" => "مدى",
                "PaymentMethodEn" => "MADA",
                "ImageUrl" => "https://demo.myfatoorah.com/imgs/payment-methods/md.png",
            ],
            [
                "PaymentMethodId" => 11,
                "PaymentMethodAr" => "أبل الدفع",
                "PaymentMethodEn" => "Apple Pay",
                "ImageUrl" => "https://demo.myfatoorah.com/imgs/payment-methods/ap.png",
            ],
            [
                "PaymentMethodId" => 2,
                "PaymentMethodAr" => "فيزا / ماستر",
                "PaymentMethodEn" => "VISA/MASTER",
                "ImageUrl" => "https://demo.myfatoorah.com/imgs/payment-methods/vm.png",
            ],
            [
                "PaymentMethodId" => 14,
                "PaymentMethodAr" => "STC Pay",
                "PaymentMethodEn" => "STC Pay",
                "ImageUrl" => "https://demo.myfatoorah.com/imgs/payment-methods/stc.png",
            ],
            [
                "PaymentMethodId" => 8,
                "PaymentMethodAr" => "كروت الدفع المدنية (الإمارات)",
                "PaymentMethodEn" => "UAE Debit Cards",
                "ImageUrl" => "https://demo.myfatoorah.com/imgs/payment-methods/uaecc.png",
            ],
            [
                "PaymentMethodId" => 9,
                "PaymentMethodAr" => "Visa/Master Direct 3DS Flow",
                "PaymentMethodEn" => "Visa/Master Direct 3DS Flow",
                "ImageUrl" => "https://demo.myfatoorah.com/imgs/payment-methods/vm.png",
            ],
            [
                "PaymentMethodId" => 20,
                "PaymentMethodAr" => "Visa/Master Direct",
                "PaymentMethodEn" => "Visa/Master Direct",
                "ImageUrl" => "https://demo.myfatoorah.com/imgs/payment-methods/vm.png",
            ],
            [
                "PaymentMethodId" => 3,
                "PaymentMethodAr" => "اميكس",
                "PaymentMethodEn" => "AMEX",
                "ImageUrl" => "https://demo.myfatoorah.com/imgs/payment-methods/ae.png",
            ],
            [
                "PaymentMethodId" => 25,
                "PaymentMethodAr" => "أبل باي (مدي)",
                "PaymentMethodEn" => "Apple Pay (Mada)",
                "ImageUrl" => "https://demo.myfatoorah.com/imgs/payment-methods/ap.png",
            ],
            [
                "PaymentMethodId" => 32,
                "PaymentMethodAr" => "جوجل للدفع",
                "PaymentMethodEn" => "GooglePay",
                "ImageUrl" => "https://demo.myfatoorah.com/imgs/payment-methods/gp.png",
            ],
            [
                "PaymentMethodId" => 5,
                "PaymentMethodAr" => "بنفت",
                "PaymentMethodEn" => "Benefit",
                "ImageUrl" => "https://demo.myfatoorah.com/imgs/payment-methods/b.png",
            ],
            [
                "PaymentMethodId" => 1,
                "PaymentMethodAr" => "كي نت",
                "PaymentMethodEn" => "KNET",
                "ImageUrl" => "https://demo.myfatoorah.com/imgs/payment-methods/kn.png",
            ]
        ];

        foreach ($paymentMethods as $method) {
            Myfatoorahmethodes::create([

                'PaymentMethodId' => $method['PaymentMethodId'],
                'PaymentMethodAr' => $method['PaymentMethodAr'],
                'PaymentMethodEn' => $method['PaymentMethodEn'],
                'ImageUrl' => $method['ImageUrl'],

            ]);
        }
    }
}
