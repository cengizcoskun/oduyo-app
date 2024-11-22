<?php

namespace App\Http\Controllers;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Omnipay\Gvp\Gateway as gvpGateway;
use App\Helpers\Purchase as purchaseHelper;
use App\Helpers\Purchase3D as purchase3DHelper;

class PaymentController extends Controller
{
    public gvpGateway $gvpGateway;

    public purchaseHelper $purchaseHelper;

    public purchase3DHelper $purchase3DHelper;

    public function __construct(gvpGateway $gvpGateway, purchaseHelper $purchaseHelper, purchase3DHelper $purchase3DHelper)
    {
        $this->gvpGateway = new $gvpGateway();
        $this->purchaseHelper = $purchaseHelper;
        $this->purchase3DHelper = $purchase3DHelper;
    }

    public function processPayment(Request $request): mixed
    {
        try {
            $threeDRequestData = [];

            if ($request->threeD_secure) {
                $params = $this->purchase3DHelper->getPurchase3dParams($request);
                $response = $this->gvpGateway->purchase($params)->send();
                // $threeDRequestData = $response->getRedirectData();

               return $response->redirect();
            } else {
                $params = $this->purchaseHelper->getPurchaseParams($request);
                $response = $this->gvpGateway->purchase($params)->send();
            }


            $result = [
                'status' => $response->isSuccessful() ?: 0,
                'redirect' => $response->isRedirect() ?: 0,
                'redirectUrl' => $response->getRedirectUrl(),
                'errorCode' => $response->getCode(),
                'message' => $response->getMessage(),
                'threeDRequestData' => !$response->isRedirect() ? 0 : $threeDRequestData,
                'requestParams' => $response->getServiceRequestParams(),
                'response' => $response->getData()
            ];

            return response()->json($result);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        } catch (GuzzleException $e) {
            return response()->json(['error Guzzle' => $e->getMessage()], 500);
        }
    }



}
