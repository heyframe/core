<?php declare(strict_types=1);

namespace HeyFrame\Core\Content\Sitemap\Service;

use League\Flysystem\FilesystemOperator;
use HeyFrame\Core\Content\Sitemap\Struct\Sitemap;
use HeyFrame\Core\System\SalesChannel\Aggregate\SalesChannelDomain\SalesChannelDomainCollection;
use HeyFrame\Core\System\SalesChannel\SalesChannelContext;
use Symfony\Component\Asset\Package;

#[\HeyFrame\Core\Framework\Log\Package('discovery')]
class SitemapLister implements SitemapListerInterface
{
    /**
     * @internal
     */
    public function __construct(
        private readonly FilesystemOperator $filesystem,
        private readonly Package $package
    ) {
    }

    /**
     * {@inheritdoc}
     */
    public function getSitemaps(SalesChannelContext $salesChannelContext): array
    {
        $files = $this->filesystem->listContents('sitemap/salesChannel-' . $salesChannelContext->getSalesChannelId() . '-' . $salesChannelContext->getLanguageId());

        $sitemaps = [];

        /** @var SalesChannelDomainCollection $domains */
        $domains = $salesChannelContext->getSalesChannel()->getDomains();

        foreach ($files as $file) {
            if ($file->isDir()) {
                continue;
            }

            $filename = basename($file->path());

            $exploded = explode('-', $filename);

            if (isset($exploded[1]) && $domains->has($exploded[1])) {
                $domain = $domains->get($exploded[1]);

                $sitemaps[] = new Sitemap($domain->getUrl() . '/' . $file->path(), 0, new \DateTime('@' . ($file->lastModified() ?? time())));

                continue;
            }

            $sitemaps[] = new Sitemap($this->package->getUrl($file->path()), 0, new \DateTime('@' . ($file->lastModified() ?? time())));
        }

        return $sitemaps;
    }
}
