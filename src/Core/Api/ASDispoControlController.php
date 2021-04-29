<?php

declare(strict_types=1);

namespace ASDispositionControl\Core\Api;

use ASDispositionControl\Core\Content\DispoControlData\DispoControlDataEntity;
use ASMailService\Core\MailServiceHelper;
use Shopware\Core\Checkout\Order\Aggregate\OrderLineItem\OrderLineItemEntity;
use Shopware\Core\Checkout\Order\OrderEntity;
use Shopware\Core\Content\Product\ProductEntity;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\EntitySearchResult;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Shopware\Core\Framework\Routing\Annotation\RouteScope;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Shopware\Core\System\SystemConfig\SystemConfigService;

/**
 * @RouteScope(scopes={"api"})
 */
class ASDispoControlController extends AbstractController
{
    /** @var SystemConfigService $systemConfigService */
    private $systemConfigService;
    /** @var MailServiceHelper $mailServiceHelper */
    private $mailServiceHelper;
    /** @var string $senderName */
    private $senderName;
    public function __construct(
        SystemConfigService $systemConfigService,
        MailServiceHelper $mailServiceHelper
    ) {
        $this->systemConfigService = $systemConfigService;
        $this->mailServiceHelper = $mailServiceHelper;
        $this->senderName = 'Disposition Controle';
    }

    /**
     * @Route("/api/v{version}/_action/as-disposition-control/dummyRoute", name="api.custom.as_disposition_control.dummyRoute", methods={"POST"})
     * @param Context $context;
     * @return Response
     */
    public function dummyRoute(Context $context): ?Response
    {

        return new Response('', Response::HTTP_NO_CONTENT);
    }

    /**
     * @Route("/api/v{version}/_action/as-disposition-control/checkThresholds", name="api.custom.as_disposition_control.checkThresholds", methods={"POST"})
     * @param Context $context;
     * @return Response
     */
    public function checkThresholds(Context $context): ?Response
    {
        $sendMessageAdmin = false;
        $sendMessageEscalation = false;
        $adminSubject = 'Meldebestand unterschritten: ';
        $adminMessage = 'Der Meldebestand für<br><br>';
        $escalationSubject = 'ESKALATION: Sicherheitsbestand unterschritten: ';
        $escalationMessage = 'Der Sicherheitsbestand für<br><br>';
        $dataEntries = $this->getAllEntitiesOfRepository($this->get('as_dispo_control_data.repository'), $context);
        /** @var DispoControlDataEntity $dataEntry */
        foreach ($dataEntries as $dataEntry) {
            if ($dataEntry->getNotificationsActivated()) {
                $availableStock = $dataEntry->getStockAvailable();
                $notificationThreshold = $dataEntry->getNotificationThreshold();
                $absoluteMinimum = $dataEntry->getMinimumThreshold();
                $incoming = $dataEntry->getIncoming();
                if ($notificationThreshold > ($availableStock + $incoming)) {
                    $sendMessageAdmin = true;
                    //notification to administrators
                    $adminSubject .= "{$dataEntry->getProductNumber()}, ";
                    $adminMessage .= "{$dataEntry->getProductNumber()}, ";
                }
                if ($absoluteMinimum > ($availableStock)) {
                    $sendMessageEscalation = true;
                    //escalation
                    $escalationSubject .= "{$dataEntry->getProductNumber()}, ";
                    $escalationMessage .= "{$dataEntry->getProductNumber()} wurde unterschritten. Nachbestellung dringend!<br>Derzeit verfügbar: {$availableStock}<br>Offene Bestellungen: {$incoming}<br><br>";
                }
            }
        }
        if ($sendMessageAdmin) {
            $adminMessage = rtrim($adminMessage, ', ');
            $adminMessage .= '<br><br>wurde unterschritten.<br>Bitte nachbestellen.';
            $recipientList = $this->systemConfigService->get('ASDispositionControl.config.notificationRecipients');
            $recipientData = explode(';', $recipientList);
            $this->sendNotification(rtrim($adminSubject, ', '), $adminMessage, $recipientData);
        }
        if ($sendMessageEscalation) {
            $recipientList = $this->systemConfigService->get('ASDispositionControl.config.notificationRecipientsEscalated');
            $recipientData = explode(';', $recipientList);
            $this->sendNotification(rtrim($escalationSubject, ', '), $escalationMessage, $recipientData);
        }

        return new Response('', Response::HTTP_NO_CONTENT);
    }

    /* Sends an eMail to every entry in the plugin configuration inside the administration frontend */
    private function sendNotification(string $errorSubject, string $message, $recipientData)
    {
        $notificationSalesChannel = $this->systemConfigService->get('ASDispositionControl.config.fallbackSaleschannelNotification');
        $recipients = null;
        for ($i = 0; $i < count($recipientData); $i += 2) {
            $recipientName = $recipientData[$i];
            $recipientAddress = $recipientData[$i + 1];

            $mailCheck = explode('@', $recipientAddress);
            if (count($mailCheck) != 2) {
                continue;
            }
            $recipients[$recipientAddress] = $recipientName;
        }
        $this->mailServiceHelper->sendMyMail($recipients, $notificationSalesChannel, $this->senderName, $errorSubject, $message, $message, ['']);
    }

    /**
     * @Route("/api/v{version}/_action/as-disposition-control/updateDispoControlData", name="api.custom.as_disposition_control.updateDispoControlData", methods={"POST"})
     * @param Context $context;
     * @return Response
     */
    public function updateDispoControlData(Context $context): ?Response
    {
        /** @var EntityRepositoryInterface $asDispoDataRepository */
        $asDispoDataRepository = $this->get('as_dispo_control_data.repository');
        /** @var EntityRepositoryInterface $productRepository */
        $productRepository = $this->get('product.repository');


        $productSearchResult = $productRepository->search(new Criteria(), $context);

        $data = null;
        /** @var ProductEntity $productEntity */
        foreach ($productSearchResult as $productEntity) {
            $productId = $productEntity->getId();
            $productName = $productEntity->getName();
            $productNumber = $productEntity->getProductNumber();
            $criteria = new Criteria();
            $criteria->addFilter(new EqualsFilter('productId', $productId));

            $dispoDataSearchResult = $asDispoDataRepository->search($criteria, $context);
            if (count($dispoDataSearchResult) === 0) {
                $commissioned = 0;
                $availableStock = $this->calculateAvailableStock($productNumber, $context, $commissioned);
                // product has no equivalent entry in the dispo data table
                $data[] = ['notificationsActivated' => true, 'productId' => $productId, 'productName' => $productName, 'productNumber' => $productNumber, 'stock' => $productEntity->getStock(), 'commissioned' => $commissioned, 'stockAvailable' => $availableStock, 'incoming' => 0, 'minimumThreshold' => 0, 'notificationThreshold' => 0];
            } else {
                $entity = $dispoDataSearchResult->first();
                $commissioned = 0;
                $availableStock = $this->calculateAvailableStock($productNumber, $context, $commissioned);
                // update the entity
                $data[] = ['id' => $entity->getId(), 'productName' => $productName, 'productNumber' => $productNumber, 'stock' => $productEntity->getStock(), 'commissioned' => $commissioned, 'stockAvailable' => $availableStock];
            }
        }

        if ($data != null) {
            $asDispoDataRepository->upsert($data, $context);
        }

        return new Response('', Response::HTTP_NO_CONTENT);
    }

    private function calculateAvailableStock($articleNumber, $context, int &$commissioned): int
    {
        /** @var EntityRepositoryInterface $orderLineItemRepository */
        $productsRepository = $this->container->get('product.repository');                  // get products repository
        $criteria = new Criteria();                                                         // create new $criteria
        $criteria->addFilter(new EqualsFilter('productNumber', $articleNumber));            // add filter for product we are currently looking for stock / available stock
        /** @var ProductEntity */
        $product = $productsRepository->search($criteria, $context)->first();               // get the product entity with all the infos
        $productStock = $product->getStock();                                               // get the current stock, we will substract line item entries from this one and return the value at the end
        /** @var EntityRepositoryInterface $orderLineItemRepository */
        $orderLineItemRepository = $this->container->get('order_line_item.repository');
        /** @var EntityRepositoryInterface $orderRepository */
        $orderRepository = $this->container->get('order.repository');
        $criteria = new Criteria();

        /** @var EntitySearchResult $orders */
        $orders = $orderRepository->search($criteria, $context);

        /** @var OrderEntity $order */
        foreach ($orders as $order)                                                          // iterate through all orders
        {
            $orderState = $order->getStateMachineState()->getTechnicalName();
            if ($orderState == 'completed' || $orderState == 'cancelled')                   // skip order if it is not relevant for the available stock
                continue;

            $orderID = $order->getId();
            $criteria = new Criteria();
            $criteria->addFilter(new EqualsFilter('orderId', $orderID));

            $lineItems = $orderLineItemRepository->search($criteria, $context);             // get all line item entries for this order
            /** @var OrderLineItemEntity $lineItem */
            foreach ($lineItems as $lineItem)                                                // iterate through all line items of this order
            {
                if ($lineItem->getIdentifier() == 'INTERNAL_DISCOUNT')
                    continue;

                $lineItemProductID = $lineItem->getProductId();
                if ($product->getId() == $lineItemProductID)                                 // if looked at product id is the same as the line item product id
                {
                    $productStock -= $lineItem->getQuantity();                              // substract quantity of line item from stock to get available stock
                    $commissioned += $lineItem->getQuantity();
                }
            }
        }
        return $productStock;
    }

    public function deleteDispoControlEntry(string $productID, Context $context): ?Response
    {
        /** @var EntityRepositoryInterface $asDispoDataRepository */
        $asDispoDataRepository = $this->get('as_dispo_control_data.repository');

        $criteria = new Criteria();
        $criteria->addFilter(new EqualsFilter('productId', $productID));

        $searchResult = $asDispoDataRepository->search($criteria, $context);
        if (count($searchResult) > 0) {
            $entity = $searchResult->first();
            $asDispoDataRepository->delete([
                ['id' => $entity->getId()],
            ], $context);
        }

        return new Response('', Response::HTTP_NO_CONTENT);
    }

    public function upsertDispoControlEntry(string $productId, Context $context): ?Response
    {

        /** @var EntityRepositoryInterface $asDispoDataRepository */
        $productRepository = $this->get('product.repository');
        /** @var EntityRepositoryInterface $asDispoDataRepository */
        $asDispoDataRepository = $this->get('as_dispo_control_data.repository');

        $criteria = new Criteria();
        $criteria->addFilter(new EqualsFilter('productId', $productId));

        $searchResultDispo = $asDispoDataRepository->search($criteria, $context);

        $criteria = new Criteria();
        $criteria->addFilter(new EqualsFilter('id', $productId));

        /** @var EntitySearchResult $searchResult */
        $searchResult = $productRepository->search($criteria, $context);
        /** @var ProductEntity $product */
        $product = $searchResult->first();

        $productNumber = $product->getProductNumber();
        $productName = $product->getName();
        $commissioned = 0;
        $availableStock = $this->calculateAvailableStock($productNumber, $context, $commissioned);

        if (count($searchResultDispo) > 0) { // update existing entity
            $data[] = [
                'id' => $searchResultDispo->first()->getId(),
                'notificationsActivated' => true,
                'productId' => $productId,
                'productName' => $productName,
                'productNumber' => $productNumber,
                'stock' => $product->getStock(),
                'commissioned' => $commissioned,
                'stockAvailable' => $availableStock,
                'incoming' => 0, 'minimumThreshold' => 0,
                'notificationThreshold' => 0
            ];
        } else { // create new entity
            $data[] = [
                'notificationsActivated' => true,
                'productId' => $productId,
                'productName' => $productName,
                'productNumber' => $productNumber,
                'stock' => $product->getStock(),
                'commissioned' => $commissioned,
                'stockAvailable' => $availableStock,
                'incoming' => 0, 'minimumThreshold' => 0,
                'notificationThreshold' => 0
            ];
        }

        $asDispoDataRepository->upsert($data, $context);

        return new Response('', Response::HTTP_NO_CONTENT);
    }



    public function getAllEntitiesOfRepository(EntityRepositoryInterface $repository, Context $context): ?EntitySearchResult
    {
        /** @var Criteria $criteria */
        $criteria = new Criteria();
        /** @var EntitySearchResult $result */
        $result = $repository->search($criteria, $context);

        return $result;
    }
    public function getFilteredEntitiesOfRepository(EntityRepositoryInterface $repository, string $fieldName, $fieldValue, Context $context): ?EntitySearchResult
    {
        /** @var Criteria $criteria */
        $criteria = new Criteria();
        $criteria->addFilter(new EqualsFilter($fieldName, $fieldValue));
        /** @var EntitySearchResult $result */
        $result = $repository->search($criteria, $context);

        return $result;
    }
    public function entityExistsInRepositoryCk(EntityRepositoryInterface $repository, string $fieldName, $fieldValue, Context $context): bool
    {
        $criteria = new Criteria();

        $criteria->addFilter(new EqualsFilter($fieldName, $fieldValue));

        /** @var EntitySearchResult $searchResult */
        $searchResult = $repository->search($criteria, $context);

        return count($searchResult) != 0 ? true : false;
    }
}
