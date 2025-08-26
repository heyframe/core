<?php declare(strict_types=1);

namespace HeyFrame\Core\Content\Cms\DataAbstractionLayer\FieldSerializer;

use HeyFrame\Core\Content\Cms\DataResolver\FieldConfig;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\Field;
use HeyFrame\Core\Framework\DataAbstractionLayer\FieldSerializer\JsonFieldSerializer;
use HeyFrame\Core\Framework\Log\Package;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\NotBlank;

#[Package('discovery')]
class SlotConfigFieldSerializer extends JsonFieldSerializer
{
    protected function getConstraints(Field $field): array
    {
        return [
            new All(
                constraints: new Collection(
                    fields: [
                        'source' => [
                            new Choice(
                                choices: [
                                    FieldConfig::SOURCE_STATIC,
                                    FieldConfig::SOURCE_MAPPED,
                                    FieldConfig::SOURCE_PRODUCT_STREAM,
                                    FieldConfig::SOURCE_DEFAULT,
                                ]
                            ),
                            new NotBlank(),
                        ],
                        'value' => [],
                    ],
                    allowExtraFields: false,
                    allowMissingFields: false
                ),
            ),
        ];
    }
}
