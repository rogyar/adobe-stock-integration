<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Magento\AdobeStockAssetApi\Api\Data;

use Magento\AdobeStockAssetApi\Api\Data\CategoryExtensionInterface;

/**
 * Interface CategoryInterface
 * @api
 */
interface CategoryInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{
    const ID = 'id';
    const NAME = 'name';

    /**
     * Get the id
     *
     * @return int|null
     */
    public function getId() : ?int;

    /**
     * Set the id
     *
     * @param int $value
     * @return void
     */
    public function setId($value): void;

    /**
     * Get the category name
     *
     * @return string
     */
    public function getName(): ?string;

    /**
     * Set the category name
     *
     * @param string $value
     * @return void
     */
    public function setName(string $value): void;

    /**
     * Retrieve existing extension attributes object or create a new one.
     *
     * @return \Magento\AdobeStockAssetApi\Api\Data\CategoryExtensionInterface
     */
    public function getExtensionAttributes(): CategoryExtensionInterface;

    /**
     * Set extension attributes
     *
     * @param \Magento\AdobeStockAssetApi\Api\Data\CategoryExtensionInterface $extensionAttributes
     * @return void
     */
    public function setExtensionAttributes(CategoryExtensionInterface $extensionAttributes): void;
}
