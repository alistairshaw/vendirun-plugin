<?php namespace AlistairShaw\Vendirun\App\Entities\Order\Shipment;

use AlistairShaw\Vendirun\App\Entities\Order\OrderItem\OrderItem;
use AlistairShaw\Vendirun\App\ValueObjects\DateWindow;
use AlistairShaw\Vendirun\App\ValueObjects\TimeWindow;

class Shipment {

    /**
     * @var string
     */
    private $shippedDate;

    /**
     * @var string
     */
    private $shippingCompany;

    /**
     * @var DateWindow
     */
    private $deliveryWindowDate;

    /**
     * @var TimeWindow
     */
    private $deliveryWindowTime;

    /**
     * @var string
     */
    private $trackingNumber;

    /**
     * @var string
     */
    private $trackingUrl;

    /**
     * Array of OrderItems
     * @var array
     */
    private $items;

    /**
     * Shipment constructor.
     * @param $shippedDate
     * @param string $shippingCompany
     * @param DateWindow|null $deliveryWindowDate
     * @param TimeWindow|null $deliveryWindowTime
     * @param string $trackingNumber
     * @param string $trackingUrl
     */
    public function __construct($shippedDate, $shippingCompany = '', DateWindow $deliveryWindowDate = null, TimeWindow $deliveryWindowTime = null, $trackingNumber = '', $trackingUrl = '')
    {
        $this->shippedDate = $shippedDate;
        $this->shippingCompany = $shippingCompany;
        $this->deliveryWindowDate = $deliveryWindowDate;
        $this->deliveryWindowTime = $deliveryWindowTime;
        $this->trackingNumber = $trackingNumber;
        $this->trackingUrl = $trackingUrl;
        $this->items = [];
    }

    /**
     * @param OrderItem $item
     */
    public function addItem(OrderItem $item)
    {
        $this->items[] = $item;
    }

    /**
     * @return array
     */
    public function display()
    {
        return [
            'shippedDate' => $this->shippedDate,
            'shippingCompany' => $this->shippingCompany,
            'deliveryWindowDate' => (string)$this->deliveryWindowDate,
            'deliveryWindowTime' => (string)$this->deliveryWindowTime,
            'trackingNumber' => $this->trackingNumber,
            'trackingUrl' => $this->trackingUrl,
            'itemCount' => count($this->items)
        ];
    }
}