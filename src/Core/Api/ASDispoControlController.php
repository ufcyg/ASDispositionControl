<?php declare(strict_types=1);

namespace ASDispositionControl\Core\Api;

use ASDispositionControl\Core\Utilities\MailServiceHelper;
use Shopware\Core\Content\Product\ProductEntity;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
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
    
    public function __construct(SystemConfigService $systemConfigService,
                                MailServiceHelper $mailServiceHelper)
    {
        $this->systemConfigService = $systemConfigService;
        $this->mailServiceHelper = $mailServiceHelper;
    }

    /**
     * @Route("/api/v{version}/_action/as-disposition-control/dummyRoute", name="api.custom.as_disposition_control.dummyRoute", methods={"POST"})
     * @param Context $context;
     * @return Response
     */
    public function dummyRoute(Context $context): ?Response
    {
        // $salesChannel = $this->systemConfigService->get('ASDispositionControl.config.fallbackSaleschannelNotification');
        // $notification = "Hello from [$salesChannel]<br><br>This is a test.<br>Henlo";
        // $this->mailServiceHelper->sendMyMail('iifsanalyzer@gmail.com', 'Melle Mellowski', $salesChannel,'TestSubject', $notification, 'TestSenderName');
        /** @var EntityRepositoryInterface $asDispoDataRepository */
        $asDispoDataRepository = $this->get('as_dispo_control_data.repository');
        
        $data = [
            ['productId' => 'asdwx123', 'outgoing' => 1, 'incoming' => 123, 'minimumThreshold' => 33, 'notificationThreshold' => 44],
        ];
        
        $asDispoDataRepository->create($data,$context);
        
        return new Response('',Response::HTTP_NO_CONTENT);
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


        $productSearchResult = $productRepository->search(new Criteria(),$context);

        $data = null;
        /** @var ProductEntity $productEntity */
        foreach($productSearchResult as $productEntity)
        {
            $productId = $productEntity->getId();
            $productName = $productEntity->getName();
            $productNumber = $productEntity->getProductNumber();
            $criteria = new Criteria();
            $criteria->addFilter(new EqualsFilter('productId',$productId));

            $dispoDataSearchResult = $asDispoDataRepository->search($criteria,$context);
            if(count($dispoDataSearchResult) === 0)
            {
                // product has no equivalent entry in the dispo data table
                $data[] = ['productId' => $productId, 'productName' => $productName, 'productNumber' => $productNumber, 'stock' => $productEntity->getStock(), 'outgoing' => 0, 'stockAvailable' => $productEntity->getAvailableStock() != null ? $productEntity->getAvailableStock() : $productEntity->getStock(), 'incoming' => 0, 'minimumThreshold' => 0, 'notificationThreshold' => 0];
            }
            else
            {
                $entity = $dispoDataSearchResult->first();
                // update the entity
                $updateData[] = ['id' => $entity->getId(), 'productName' => $productName, 'productNumber' => $productNumber, 'stock' => $productEntity->getStock(), 'stockAvailable' => $productEntity->getAvailableStock() != null ? $productEntity->getAvailableStock() : $productEntity->getStock()];
                $asDispoDataRepository->update($updateData, $context);
            }            
        }

        if($data != null)
        {
            $asDispoDataRepository->create($data,$context);
        }

        return new Response('',Response::HTTP_NO_CONTENT);
    }

    public function deleteDispoControlEntry(string $productID, Context $context): ?Response
    {
        /** @var EntityRepositoryInterface $asDispoDataRepository */
        $asDispoDataRepository = $this->get('as_dispo_control_data.repository');

        $criteria = new Criteria();
        $criteria->addFilter(new EqualsFilter('productId', $productID));

        $searchResult = $asDispoDataRepository->search($criteria,$context);
        if(count($searchResult) > 0)
        {
            $entity = $searchResult->first();
            $asDispoDataRepository->delete([
                ['id' => $entity->getId()],
            ],$context);
        }

        return new Response('',Response::HTTP_NO_CONTENT);
    }
}