<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\AdobeMediaGallery\Model\Keyword\Command;

use Magento\AdobeMediaGalleryApi\Api\Data\KeywordInterface;
use Magento\AdobeMediaGalleryApi\Model\Keyword\Command\SaveAssetKeywordsInterface;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\Exception\CouldNotSaveException;

/**
 * Class SaveAssetKeywords
 */
class SaveAssetKeywords implements SaveAssetKeywordsInterface
{
    private const TABLE_KEYWORD = 'media_gallery_keyword';
    private const ID = 'id';
    private const KEYWORD = 'keyword';

    /**
     * @var ResourceConnection
     */
    private $resourceConnection;

    /**
     * SaveAssetKeywords constructor.
     *
     * @param ResourceConnection $resourceConnection
     */
    public function __construct(
        ResourceConnection $resourceConnection
    ) {
        $this->resourceConnection = $resourceConnection;
    }

    /**
     * Save asset keywords.
     *
     * @param KeywordInterface[] $keywords
     *
     * @return int[]
     * @throws CouldNotSaveException
     */
    public function execute(array $keywords): array
    {
        try {
            $data = [];
            /** @var KeywordInterface $keyword */
            foreach ($keywords as $keyword) {
                $data[] = $keyword->getKeyword();
            }

            /** @var \Magento\Framework\DB\Adapter\Pdo\Mysql $connection */
            $connection = $this->resourceConnection->getConnection();
            $connection->insertArray(
                self::TABLE_KEYWORD,
                [self::KEYWORD],
                $data,
                AdapterInterface::INSERT_IGNORE
            );

            return $this->getKeywordIds($data);
        } catch (\Exception $exception) {
            $message = __('An error occurred during save asset keyword: %1', $exception->getMessage());
            throw new CouldNotSaveException($message, $exception);
        }
    }

    /**
     * Select keywords by names
     *
     * @param string[] $keywords
     *
     * @return int[]
     */
    private function getKeywordIds(array $keywords): array
    {
        $connection = $this->resourceConnection->getConnection();
        $select = $connection->select()
            ->from(['k' => $this->resourceConnection->getTableName(self::TABLE_KEYWORD)])
            ->columns(self::ID)
            ->where('k.' . self::KEYWORD . ' in (?)', $keywords);

        return $connection->fetchCol($select);
    }
}