<?php

namespace thefx\pages\components;

/**
 * http://www.getinfo.ru/article610.html
 *
 * Class NestedTreeHelper
 * @package app\shop\helpers
 */
class NestedTreeHelper
{
//    /**
//     * Array to hierarchy array
//     * @param array $elements
//     * @param $depth
//     * @return array
//     */
//    public static function createPagesTree(array $elements, $depth)
//    {
//        $branch = array();
//
//        foreach ($elements as $element) {
//            if ($element['depth'] > $depth) {
//                $children = static::createPagesTree($elements, $element['depth']);
//                if ($children) {
//                    $element['children'] = $children;
//                }
//            }
//            $branch[] = (object) array_filter([
//                'text' => $element['Title'],
//                'SectionId' => $element['SectionId'],
//                'state' => (object) ['opened' => false],
//                'children' => $element['children']
//            ]);
//        }
//
//        return $branch;
//    }
//
//    /**
//     * Array to hierarchy array
//     * @param $category
//     * @param int $left
//     * @param null $right
//     * @return array
//     */
//    public static function createCategoryTree($category, $left = 0, $right = null)
//    {
//        $tree = array();
//        foreach ($category as $cat => $range) {
//            if ($range['lft'] == $left + 1 && (is_null($right) || $range['rgt'] < $right)) {
//                $tree[] = (object)[
//                    'text' => $range['Title'],
//                    'section_id' => $range['SectionId'],
//                    'image_id' => $range['ImageId'],
//                    'state' => (object)['opened' => false],
//                    'children' => static::createCategoryTree($category, $range['lft'], $range['rgt'])
//                ];
//                $left = $range['rgt'];
//            }
//        }
//        return $tree;
//    }
//
//    public static function createSectionsTree($items, $left = 0, $right = null)
//    {
//        $tree = array();
//
//        /* @var $items Sections[] */
//        foreach ($items as $item) {
//            if ($item->lft == $left + 1 && (is_null($right) || $item->rgt < $right)) {
//
//                $children = static::createSectionsTree($items, $item->lft, $item->rgt);
//
////                foreach ($item->goods as $good) {
////
////                    $children[] = (object)array_filter([
////                        'text' => $good->Title,
//////                        'alias' => $app['alias'],
////                        'id' => $good->GoodId + 100000,
////                        'orig_id' => $good->GoodId,
////                        'depth' => $item->depth + 1,
////                        'state' => (object)['opened' => false],
////                        'type' => 'good',
////                        'children' => array()
////                    ]);
////                }
//
//                $qty = count($item->goods) ? " (прод: ".count($item->goods).")" : null;
//
//                $tree[] = (object)array_filter([
//                    'text' => $item->Title . $qty,
////                    'alias' => $item->Alias,
//                    'section_id' => $item->SectionId,
//                    'depth' => $item->depth,
//                    'state' => (object)['opened' => false],
//                    'children' => $children
//                ]);
//                $left = $item->rgt;
//            }
//        }
//        return $tree;
//    }
//
//    public static function createCategoryTree2($category, $left = 0, $right = null, $depth = -1)
//    {
//        $tree = array();
//        foreach ($category as $cat => $range) {
//            if ($range['lft'] > $left && $range['depth'] == $depth + 1 && (is_null($right) || $range['rgt'] < $right)) {
//                $tree[] = (object)[
//                    'id' => $range['SectionId'],
//                    'text' => $range['Title'],
//                    'section_id' => $range['SectionId'],
//                    'depth' => $range['depth'],
//                    'image_id' => $range['ImageId'],
//                    'state' => (object)['opened' => false],
//                    'children' => static::createCategoryTree2($category, $range['lft'], $range['rgt'], $range['depth'])
//                ];
//                $left = $range['rgt'];
//            }
//        }
//        return $tree;
//    }

    ##################

    public static function createPagesTree($items, $left = 0, $right = null)
    {
        $tree = array();
        foreach ($items as $cat => $range) {
            if ((int)$range['lft'] === $left + 1 && ($right === null || $range['rgt'] < $right)) {
                $tree[] = (object)array_filter([
                    'text' => $range['title'],
                    'alias' => $range['path'],
                    'id' => $range['id'],
                    'depth' => $range['depth'],
                    'public' => $range['public'],
//                    'state' => (object)['opened' => false],
                    'children' => static::createPagesTree($items, $range['lft'], $range['rgt'])
                ]);
                $left = $range['rgt'];
            }
        }
        return $tree;
    }

//    /*
//     * With path
//     */
//    public static function createPagesTree2($items, $left = 0, $right = null, $parentPath = '/')
//    {
//        $tree = array();
//        foreach ($items as $cat => $range) {
//            if ($parentPath == '/root/') $parentPath = '/';
//            if ($range['lft'] == $left + 1 && (is_null($right) || $range['rgt'] < $right)) {
//                $path = $parentPath . $range['Alias'] . '/';
//                $tree[] = (object)array_filter([
//                    'text' => $range['Name'],
//                    'alias' => $range['Alias'],
//                    'path' => $path,
//                    'id' => $range['PageId'],
//                    'depth' => $range['depth'],
//                    'public' => $range['Visible'],
//                    'horizontal' => $range['Horizontal'],
////                    'state' => (object)['opened' => false],
//                    'children' => static::createPagesTree2($items, $range['lft'], $range['rgt'], $path)
//                ]);
//                $left = $range['rgt'];
//            }
//        }
//        return $tree;
//    }
//
//    ##################
//
//    /*
//     * Дерево решений
//     */
//    public static function createAppsTree($items, $left = 0, $right = null)
//    {
//        $tree = array();
//
//        /* @var $items Applications2[] */
//        foreach ($items as $item) {
//            if ($item->lft == $left + 1 && (is_null($right) || $item->rgt < $right)) {
//
//                $children = static::createAppsTree($items, $item->lft, $item->rgt);
//
//                foreach ($item->apps as $app) {
//
//                    $children[] = (object)array_filter([
//                        'text' => $app->name,
//                        'alias' => $app->alias,
//                        'id' => $app->app_id + 100000,
//                        'orig_id' => $app->app_id,
//                        'depth' => $item->depth + 1,
////                        'state' => (object)['opened' => false],
//                        'type' => 'app',
//                        'children' => array()
//                    ]);
//                }
//
//                $qty = count($item->apps) ? " (".count($item->apps).")" : null;
//
//                $tree[] = (object)array_filter([
//                    'text' => $item->Name . $qty,
//                    'alias' => $item->Alias,
//                    'id' => $item->PageId,
//                    'depth' => $item->depth,
////                    'state' => (object)['opened' => false],
//                    'children' => $children
//                ]);
//                $left = $item->rgt;
//            }
//        }
//        return $tree;
//    }
//
//    ##################
//
//    /**
//     * Create nested sets tree from array with children
//     * @param array $array
//     * @param array $new_array
//     * @param int $level
//     * @param int $left
//     * @return array
//     */
//    public static function createNestedArray(array $array, array &$new_array = array(), $level = -1, &$left = 1)
//    {
//        $level++;
//
//        foreach ($array as $item) {
//            $new_array[$item->id]['item_id'] = $item->id;
//            $new_array[$item->id]['depth'] = $level;
//            $new_array[$item->id]['left'] = $left;
//            $left++;
//
//            if (isset($item->children)) {
//                static::createNestedArray($item->children, $new_array, $level, $left);
//            }
//
//            $new_array[$item->id]['right'] = $left;
//            $left++;
//        }
//
//        return $new_array;
//    }
}