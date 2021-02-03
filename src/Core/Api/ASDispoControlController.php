<?php declare(strict_types=1);

namespace SynlabOrderInterface\Core\Api;

use Shopware\Core\Framework\Context;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Shopware\Core\Framework\Routing\Annotation\RouteScope;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Shopware\Core\System\SystemConfig\SystemConfigService;

/**
 * @RouteScope(scopes={"api"})
 */
class OrderInterfaceController extends AbstractController
{
    /** @var SystemConfigService $systemConfigService */
    private $systemConfigService;
    
    public function __construct(SystemConfigService $systemConfigService)
    {
        $this->systemConfigService = $systemConfigService;
    }

    /**
     * @Route("/api/v{version}/_action/as-disposition-control/dummyRoute", name="api.custom.as_disposition_control.dummyRoute", methods={"POST"})
     * @param Context $context;
     * @return Response
     */
    public function dummyRoute(Context $context): ?Response
    {
        return new Response('',Response::HTTP_NO_CONTENT);
    }
}