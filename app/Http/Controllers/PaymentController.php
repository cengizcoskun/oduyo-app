<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Omnipay\Gvp\Gateway as gvpGateway;
use App\Helpers\Payment as paymentHelper;

class PaymentController extends Controller
{
    public gvpGateway $gvpGateway;

    public paymentHelper $paymentHelper;

    public function __construct(gvpGateway $gvpGateway, paymentHelper $paymentHelper)
    {
        $this->gvpGateway = new $gvpGateway();
        $this->paymentHelper = $paymentHelper;
    }

    public function processPayment(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $params = $this->paymentHelper->getCaptureParams($request);
            $response = $this->gvpGateway->capture($params)->send();

            $result = [
                'status' => $response->isSuccessful() ?: 0,
                'redirect' => $response->isRedirect() ?: 0,
                'message' => $response->getMessage(),
                'requestParams' => $response->getServiceRequestParams(),
                'response' => $response->getData()
            ];

            return response()->json($result);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

}
