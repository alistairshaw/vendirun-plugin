<?php namespace AlistairShaw\Vendirun\App\Entities\Order\Shipment;

use AlistairShaw\Vendirun\App\Entities\Order\Order;
use AlistairShaw\Vendirun\App\ValueObjects\DateWindow;
use AlistairShaw\Vendirun\App\ValueObjects\TimeWindow;

class ShipmentFactory {

    /**
     * @param $shipment
     * @param Order $order
     * @return Shipment
     */
    public function fromApi($shipment, Order $order)
    {
        $deliveryWindowDate = DateWindow::make($shipment->expected_delivery_date_start, $shipment->expected_delivery_date_end);
        $deliveryWindowTime = TimeWindow::make($shipment->expected_delivery_time_start, $shipment->expected_delivery_time_end);

        $vrShipment = new Shipment(
            $shipment->shipped_at,
            $shipment->shipping_company,
            $deliveryWindowDate,
            $deliveryWindowTime,
            $shipment->tracking_number,
            $shipment->tracking_url
        );

        foreach ($shipment->shipment_items as $shipmentItem)
        {
            $item = $order->getItemById($shipmentItem->order_item_id);
            $vrShipment->addItem($item, $shipmentItem->quantity);
        }

        return $vrShipment;
    }

}