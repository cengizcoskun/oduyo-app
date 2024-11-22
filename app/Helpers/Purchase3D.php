<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use Omnipay\Common\CreditCard;
use App\Models\Settings;

class Purchase3D
{
    public $settings;

    public Request $request;

    public function __construct(Settings $settings, Request $request)
    {
        $this->settings = Settings::find(1);
        $this->request = $request;
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function getPurchase3dParams(): array
    {
        $params = $this->getDefaultPurchaseParams();
        $params['paymentMethod'] = '3d';

        return $this->provideMergedParams($params);
    }

    /**
     * @param array $params
     * @return array
     */
    private function provideMergedParams(array $params): array
    {
        $params = array_merge($params, $this->getDefaultOptions());
        return $params;
    }

    /**
     * @return array
     */
    private function getDefaultOptions(): array
    {
        return [
            'testMode' => true,
            'terminalId' => $this->settings->terminal_id,
            'merchantId' => $this->settings->merchant_id,
            'password' => $this->settings->provision_password
        ];
    }

    /**
     * @return array
     * @throws \Exception
     */
    protected function getDefaultPurchaseParams(): array
    {
        $params = [
            'card' => $this->getCardInfo(),
            'orderId' => random_int(99999, 9999999),
            'amount' => $this->request->totalAmount,
            'currency' => 'TRY',
            'returnUrl' => 'http://localhost/payment/success',
            'cancelUrl' => 'http://localhost/payment/error',
            'installment' => '',
            'paymentMethod' => '',
            'clientIp' => 'xxx',
            'secureKey' => '12345678'
        ];

        return $params;
    }

    /**
     * @return CreditCard
     * @throws \Exception
     */
    private function getCardInfo(): \Omnipay\Common\CreditCard
    {
        $fullName = $this->splitFullName($this->request->full_name);
        $firstName = $fullName[0];
        $lastName = $fullName[1];

        $cardInfo = $this->getValidCard();
        $cardInfo['firstName'] = $firstName;
        $cardInfo['lastName'] = $lastName;
        $cardInfo['number'] = $this->request->cc_no;
        $cardInfo['expiryMonth'] = $this->request->cc_month;
        $cardInfo['expiryYear'] = $this->request->cc_year;
        $cardInfo['cvv'] = $this->request->cc_cvc;;
        $card = new CreditCard($cardInfo);
        $card->setEmail('y.cengiz.coskun@gmail.com');
        $card->setFirstName($firstName);
        $card->setLastName($lastName);

        return $card;
    }

    /**
     * @return array
     * @throws \Exception
     */
    private function getValidCard(): array
    {
        return [
            'billingAddress1' => 'Atasehir',
            'billingAddress2' => '',
            'billingCity' => 'Istanbul',
            'billingPostcode' => '34000',
            'billingState' => '',
            'billingCountry' => 'TR',
            'billingPhone' => '(538) 896-1435',
            'shippingAddress1' => 'Atasehir',
            'shippingAddress2' => '',
            'shippingCity' => 'Istanbul',
            'shippingPostcode' => '34000',
            'shippingState' => '',
            'shippingCountry' => 'TR',
            'shippingPhone' => '(538) 896-1435',
        ];
    }

    public function splitFullName($fullName): array
    {
        $name = trim($fullName);
        $lastName = (!str_contains($name, ' ')) ? '' : preg_replace('#.*\s([\w-]*)$#', '$1', $fullName);
        $firstName = trim( preg_replace('#'.preg_quote($lastName,'#').'#', '', $fullName ) );
        return array($firstName, $lastName);
    }
}
