<?php namespace AlistairShaw\Vendirun\App\Lib\PaymentGateway;

use AlistairShaw\Vendirun\App\Entities\Order\Payment\Payment;
use AlistairShaw\Vendirun\App\Lib\ClientHelper;
use AlistairShaw\Vendirun\App\Lib\PaymentGateway\Exceptions\CardDeclinedException;
use AlistairShaw\Vendirun\App\Lib\PaymentGateway\Exceptions\UnknownErrorException;
use Stripe\Charge;
use Stripe\Error\Card;
use Stripe\Stripe;

class StripePaymentGateway extends AbstractPaymentGateway implements PaymentGateway {

    /**
     * @var string
     */
    private $stripeToken;

    /**
     * @return mixed
     * @throws CardDeclinedException
     * @throws UnknownErrorException
     */
    public function takePayment()
    {
        $settings = ClientHelper::getPaymentGatewayInfo('stripe');
        $clientInfo = ClientHelper::getClientInfo();
        Stripe::setApiKey($settings->sandbox_mode ? $settings->test_secret : $settings->secret);

        // Create the charge on Stripe's servers - this will charge the user's card
        try
        {
            $charge = Charge::create(array(
                "amount" => $this->order->getTotalPrice(),
                "currency" => $clientInfo->currency->currency_iso,
                "source" => $this->stripeToken,
                "description" => $clientInfo->name,
                "metadata" => [
                    "order_id" => $this->order->getId()
                ]
            ));

            $payment = new Payment($this->order->getTotalPrice(), date("Y-m-d"), 'stripe', $charge->getLastResponse()->body);
            $this->order->addPayment($payment);
            $this->orderRepository->save($this->order);
        }
        catch (Card $e)
        {
            throw new CardDeclinedException();
        }
        catch (\Exception $e)
        {
            throw new UnknownErrorException($e->getMessage());
        }
    }

    /**
     * @param $token
     */
    public function setStripeToken($token)
    {
        $this->stripeToken = $token;
    }
}