<?php namespace AlistairShaw\Vendirun\App\Lib\PaymentGateway;

use AlistairShaw\Vendirun\App\Entities\Order\Order;
use AlistairShaw\Vendirun\App\Entities\Order\OrderRepository;
use AlistairShaw\Vendirun\App\Lib\ClientHelper;
use AlistairShaw\Vendirun\App\Entities\Order\Payment\Payment as VendirunPayment;
use AlistairShaw\Vendirun\App\Lib\CountryHelper;
use Mockery\CountValidator\Exception;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\ShippingAddress;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;

class PaypalPaymentGateway extends AbstractPaymentGateway implements PaymentGateway {

    /**
     * @var ApiContext
     */
    private $apiContext;

    /**
     * @var string
     */
    private $returnUrl;

    /**
     * @var string
     */
    private $cancelUrl;

    public function __construct(Order $order, OrderRepository $orderRepository)
    {
        parent::__construct($order, $orderRepository);
        $this->setApiContext();
    }

    /**
     * @return mixed
     */
    public function takePayment()
    {
        $payer = new Payer();
        $payer->setPaymentMethod("paypal");

        $transaction = $this->buildTransaction();

        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl($this->returnUrl)
            ->setCancelUrl($this->cancelUrl);

        $payment = new Payment();
        $payment->setIntent("sale")
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions(array($transaction));

        $payment->create($this->apiContext);

        $link = $payment->getApprovalLink();
        return $link;
    }

    /**
     * @param array $params
     * @return bool
     */
    public function confirmPayment($params = [])
    {
        $payment = Payment::get($params['paymentId'], $this->apiContext);

        $execution = new PaymentExecution();
        $execution->setPayerId($params['PayerID']);

        $transaction = $this->buildTransaction();

        try
        {
            $execution->addTransaction($transaction);
            $payment->execute($execution, $this->apiContext);
            $payment = Payment::get($params['paymentId'], $this->apiContext);
        }
        catch (\Exception $e)
        {
            dd($e);
        }

        $vendirunPayment = new VendirunPayment($this->order->getTotalPrice(), date("Y-m-d"), 'paypal', json_encode($payment));
        $this->order->addPayment($vendirunPayment);

        return $this->orderRepository->save($this->order);
    }

    /**
     * @return Transaction
     */
    private function buildTransaction()
    {
        $clientInfo = ClientHelper::getClientInfo();
        $priceIncludesTax = $clientInfo->business_settings->tax->price_includes_tax;

        $paypalItems = [];
        $subTotal = 0;

        foreach ($this->order->getUniqueItems() as $item)
        {
            $subTotal += $item->price;

            // This doesn't work when price includes tax, because you can't split the price properly
            if (!$priceIncludesTax)
            {
                $newItem = new Item();
                $newItem->setName($item->productName)
                    ->setCurrency($clientInfo->currency->currency_iso)
                    ->setQuantity($item->quantity)
                    ->setSku($item->sku)
                    ->setPrice($item->unitPrice / 100);

                $paypalItems[] = $newItem;
            }
        }

        $shippingBeforeTax = $this->order->getShipping() / 100;
        $tax = $this->order->getTax() / 100;
        $subTotal = $subTotal / 100;
        $total = $this->order->getTotalPrice() / 100;

        $orderShippingAddress = $this->order->getShippingAddress()->getArray();
        $shippingAddress = new ShippingAddress();

        $shippingAddress->setCity($orderShippingAddress['city']);
        $shippingAddress->setCountryCode(CountryHelper::getCountryCode($orderShippingAddress['countryId']));
        $shippingAddress->setPostalCode($orderShippingAddress['postcode']);
        $shippingAddress->setLine1($orderShippingAddress['address1']);
        $shippingAddress->setState($orderShippingAddress['state']);
        $shippingAddress->setRecipientName($this->order->getCustomer()->fullName());

        $itemList = new ItemList();
        if (!$priceIncludesTax) $itemList->setItems($paypalItems);
        $itemList->setShippingAddress($shippingAddress);

        $details = new Details();
        $details->setShipping($shippingBeforeTax)
            ->setTax($tax)
            ->setSubtotal($subTotal);

        $amount = new Amount();
        $amount->setCurrency($clientInfo->currency->currency_iso)
            ->setTotal($total)
            ->setDetails($details);

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($itemList)
            ->setDescription("Order from " . $clientInfo->name)
            ->setInvoiceNumber($this->order->getId());

        return $transaction;
    }

    /**
     * @param $returnUrl
     * @param $cancelUrl
     */
    public function setUrls($returnUrl, $cancelUrl)
    {
        $this->returnUrl = $returnUrl;
        $this->cancelUrl = $cancelUrl;
    }

    /**
     * @param $fileLocation
     */
    public function setPaypalLog($fileLocation)
    {
        $this->apiContext->setConfig(
            [
                'log.LogEnabled' => true,
                'log.FileName' => $fileLocation
            ]
        );
    }

    private function setApiContext()
    {
        $settings = ClientHelper::getPaymentGatewayInfo('paypal');

        $this->apiContext = new ApiContext(
            new OAuthTokenCredential(
                $settings->client_id,     // ClientID
                $settings->secret      // ClientSecret
            )
        );

        $this->apiContext->setConfig(
            [
                'mode' => $settings->sandbox_mode ? 'sandbox' : 'live',
                'log.FileName' => './storage/logs/paypal.log',
                'log.LogLevel' => $settings->sandbox_mode ? 'DEBUG' : 'INFO', // PLEASE USE `INFO` LEVEL FOR LOGGING IN LIVE ENVIRONMENTS
                'cache.enabled' => true
            ]
        );
    }
}