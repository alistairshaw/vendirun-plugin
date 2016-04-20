<?php namespace AlistairShaw\Vendirun\App\Lib\PaymentGateway;

use AlistairShaw\Vendirun\App\Entities\Cart\Cart;
use AlistairShaw\Vendirun\App\Entities\Cart\CartItem\CartItem;
use AlistairShaw\Vendirun\App\Entities\Cart\CartRepository;
use AlistairShaw\Vendirun\App\Entities\Order\Order;
use AlistairShaw\Vendirun\App\Entities\Order\Payment\PaymentRepository;
use AlistairShaw\Vendirun\App\Lib\ClientHelper;
use AlistairShaw\Vendirun\App\Entities\Order\Payment\Payment as VendirunPayment;
use AlistairShaw\Vendirun\App\Lib\CountryHelper;
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

    /**
     * PaypalPaymentGateway constructor.
     * @param Order             $order
     * @param Cart              $cart
     * @param CartRepository    $cartRepository
     * @param PaymentRepository $paymentRepository
     */
    public function __construct(Order $order, Cart $cart = null, CartRepository $cartRepository = null, PaymentRepository $paymentRepository = null)
    {
        parent::__construct($order, $cart, $cartRepository, $paymentRepository);
        $this->setApiContext();
    }

    /**
     * @return mixed
     */
    public function takePayment()
    {
        $payer = new Payer();
        $payer->setPaymentMethod("paypal");

        $clientInfo = ClientHelper::getClientInfo();

        $paypalItems = [];
        foreach ($this->cart->getItems() as $item)
        {
            /* @var $item CartItem */
            $itemTotalBeforeTax = $item->totalBeforeTax() / 100;

            $newItem = new Item();
            $newItem->setName($item->getProduct()->product_name)
                ->setCurrency($clientInfo->currency->currency_iso)
                ->setQuantity($item->getQuantity())
                ->setSku($item->getProduct()->product_sku . $item->getProductVariation()->variation_sku)
                ->setPrice($itemTotalBeforeTax);
        }

        $shippingBeforeTax = $this->cart->shippingBeforeTax() / 100;
        $tax = $this->cart->tax() / 100;
        $subTotal = $this->cart->totalBeforeTax() / 100;
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
        $itemList->setItems($paypalItems);
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

        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl($this->returnUrl)
            ->setCancelUrl($this->cancelUrl);

        $payment = new Payment();
        $payment->setIntent("sale")
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions(array($transaction));

        $payment->create($this->apiContext);

        return $payment->getApprovalLink();
    }

    /**
     * @param array $params
     * @return bool
     */
    public function confirmPayment($params = [])
    {
        $clientInfo = ClientHelper::getClientInfo();

        $total = $this->order->getTotalPrice() / 100;

        $payment = Payment::get($params['paymentId'], $this->apiContext);

        $execution = new PaymentExecution();
        $execution->setPayerId($params['PayerID']);

        $transaction = new Transaction();
        $amount = new Amount();
        $details = new Details();

        $amount->setCurrency($clientInfo->currency->currency_iso);
        $amount->setTotal($total);
        $amount->setDetails($details);
        $transaction->setAmount($amount);

        $execution->addTransaction($transaction);

        $payment->execute($execution, $this->apiContext);

        $payment = Payment::get($params['paymentId'], $this->apiContext);

        $vendirunPayment = new VendirunPayment($this->order, $this->order->getTotalPrice(), date("Y-m-d"), 'paypal', json_encode($payment));
        return $this->paymentRepository->save($vendirunPayment);
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
                'log.LogEnabled' => false
            ]
        );
    }
}