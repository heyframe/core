<?php declare(strict_types=1);

namespace HeyFrame\Core\Checkout\Customer\SalesChannel;

use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\SalesChannel\SalesChannelContext;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

#[Package('checkout')]
abstract class AbstractDownloadRoute
{
    abstract public function getDecorated(): AbstractDownloadRoute;

    abstract public function load(Request $request, SalesChannelContext $context): Response;
}
