<?php declare(strict_types=1);

namespace HeyFrame\Core\Content\Cms\SalesChannel\Struct;

use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\Framework\Struct\Struct;

#[Package('discovery')]
class HtmlStruct extends Struct
{
    protected ?string $content = null;

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function getApiAlias(): string
    {
        return 'cms_html';
    }
}
