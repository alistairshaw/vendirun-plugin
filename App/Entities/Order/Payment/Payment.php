<?php namespace AlistairShaw\Vendirun\App\Entities\Order\Payment;

class Payment {

    /**
     * @var string
     */
    private $id;

    /**
     * @var int
     */
    private $amount;

    /**
     * @var string
     */
    private $paymentDate;

    /**
     * @var string
     */
    private $paymentType;

    /**
     * @var string
     */
    private $transactionData;

    /**
     * Payment constructor.
     * @param int $amount
     * @param string $paymentDate
     * @param string $paymentType
     * @param string $transactionData
     * @param null $id
     */
    public function __construct($amount, $paymentDate, $paymentType = '', $transactionData = '', $id = null)
    {
        $this->amount = $amount;
        $this->paymentDate = $paymentDate;
        $this->paymentType = $paymentType;
        $this->transactionData = $transactionData;
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return array
     */
    public function getArray()
    {
        return [
            'amount' => $this->amount,
            'paymentDate' => $this->paymentDate,
            'transactionData' => $this->transactionData,
            'paymentType' => $this->displayPaymentType()
        ];
    }

    /**
     * @return string
     */
    public function displayPaymentType() {
        switch ($this->paymentType)
        {
            case 'stripe':
                return 'Credit Card';
            case 'paypal':
                return 'PayPal';
            default:
                return ucwords($this->paymentType);
        }
    }

    /**
     * @return int
     */
    public function getAmount()
    {
        return $this->amount;
    }

}