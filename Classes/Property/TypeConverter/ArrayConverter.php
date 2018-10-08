<?php
namespace MINAV\Layerslider\Property\TypeConverter;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2017 Manfred Rutschmann <manfred@rutschmann.biz>, Rutschmann.BIZ
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/
use TYPO3\CMS\Extbase\Property\PropertyMappingConfigurationInterface;
use TYPO3\CMS\Extbase\Property\TypeConverter\AbstractTypeConverter;

/**
 * Converter which transforms arrays to arrays.
 *
 * @api
 */
class ArrayConverter extends AbstractTypeConverter
{

    /**
     * @var array<string>
     */
    protected $sourceTypes = array('array', 'string');

    /**
     * @var string
     */
    protected $targetType = 'string';

    /**
     * @var integer
     */
    protected $priority = 35;

    /**
     * We can only convert empty strings to array or array to array.
     *
     * @param mixed $source
     * @param string $targetType
     * @return boolean
     */
    public function canConvertFrom($source, $targetType)
    {
        return is_array($source);
    }

    /**
     * Convert from $source to $targetType, a noop if the source is an array.
     * If it is an empty string it will be converted to an empty array.
     *
     * @param string|array $source
     * @param string $targetType
     * @param array $convertedChildProperties
     * @param \TYPO3\CMS\Extbase\Property\PropertyMappingConfigurationInterface $configuration
     * @return array
     * @api
     */
    public function convertFrom(
        $source,
        $targetType,
        array $convertedChildProperties = array(),
        PropertyMappingConfigurationInterface $configuration = null
    ) {
        if (is_array($source)) {
            return json_encode($source);
        }

        return $source;
    }
}
