<?php
/**
 * Ecomteck
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Ecomteck.com license that is
 * available through the world-wide-web at this URL:
 * https://www.ecomteck.com/LICENSE.txt
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Ecomteck
 * @package     Ecomteck_BlogGraphQl
 * @copyright   Copyright (c) Ecomteck (https://www.ecomteck.com/)
 * @license     https://www.ecomteck.com/LICENSE.txt
 */
declare(strict_types=1);

namespace Ecomteck\BlogGraphQl\Model\Resolver\DataProvider;

use Magefan\Blog\Api\CategoryRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Widget\Model\Template\FilterEmulate;

/**
 * Class Category
 * @package Ecomteck\BlogGraphQl\Model\Resolver\DataProvider
 */
class Category
{
    /**
     * @var FilterEmulate
     */
    private $widgetFilter;

    /**
     * @var CategoryRepositoryInterface
     */
    private $categoryRepository;

    /**
     * Category constructor.
     * @param CategoryRepositoryInterface $categoryRepository
     * @param FilterEmulate $widgetFilter
     */
    public function __construct(
        CategoryRepositoryInterface $categoryRepository,
        FilterEmulate $widgetFilter
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->widgetFilter = $widgetFilter;
    }

    /**
     * @param int $categoryId
     * @return array
     * @throws NoSuchEntityException
     */
    public function getData(int $categoryId): array
    {
        $category = $this->categoryRepository->getById($categoryId);

        if (false === $category->isActive()) {
            throw new NoSuchEntityException();
        }

        $renderedContent = $this->widgetFilter->filter($category->getData('content'));

        $categoryData = [
            'url_key' => $category->getIdentifier(),
            'title' => $category->getTitle(),
            'meta_title' => $category->getMetaTitle(),
            'meta_keywords' => $category->getMetaKeywords(),
            'meta_description' => $category->getMetaDescription(),
            'content_heading' => $category->getData('content_heading'),
            'content' => $renderedContent,
            'path' => $category->getPath(),
            'position' => $category->getData('position'),
            'posts_sort_by' => $category->getData('posts_sort_by'),
            'include_in_menu' => $category->getData('include_in_menu'),
            'is_active' => $category-> isActive(),
            'display_mode' => $category->getData('display_mode'),
            'page_layout' => $category->getData('page_layout'),
            'layout_update_xml' => $category->getData('layout_update_xml'),
            'custom_theme' => $category->getData('custom_theme'),
            'custom_layout' => $category->getData('custom_layout'),
            'custom_layout_update_xml' => $category->getData('custom_layout_update_xml'),
            'custom_theme_from' => $category->getData('custom_theme_from'),
            'custom_theme_to' => $category->getData('custom_theme_to'),
        ];
        return $categoryData;
    }
}
