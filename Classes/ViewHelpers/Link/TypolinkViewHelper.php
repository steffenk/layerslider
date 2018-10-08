<?php
namespace MINAV\Layerslider\ViewHelpers\Link;

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
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\VersionNumberUtility;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use TYPO3\CMS\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\CMS\Fluid\Core\ViewHelper\Facets\CompilableInterface;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\Service\TypoLinkCodecService;

/**
 * A ViewHelper to create links from fields supported by the link wizard
 *
 * == Example ==
 *
 * {link} contains "19 _blank - "testtitle with whitespace" &X=y"
 *
 * <code title="minimal usage">
 * <f:link.typolink parameter="{link}">
 * Linktext
 * </f:link.typolink>
 * <output>
 * <a href="index.php?id=19&X=y" title="testtitle with whitespace" target="_blank">
 * Linktext
 * </a>
 * </output>
 * </code>
 *
 * <code title="Full parameter usage">
 * <f:link.typolink parameter="{link}" target="_blank" class="ico-class" title="some title" additionalParams="&u=b" additionalAttributes="{type:'button'}">
 * Linktext
 * </f:link.typolink>
 * </code>
 * <output>
 * <a href="index.php?id=19&X=y&u=b" title="some title" target="_blank" class="ico-class" type="button">
 * Linktext
 * </a>
 * </output>
 *
 */
class TypolinkViewHelper extends AbstractViewHelper implements CompilableInterface
{


    /**
     * @var bool
     */
    protected $escapeOutput = false;

    /**
     * Render
     *
     * @param string $parameter stdWrap.typolink style parameter string
     * @param string $target
     * @param string $class
     * @param string $title
     * @param string $additionalParams
     * @param array $additionalAttributes
     *
     * @return string
     */
    public function render(
        $parameter,
        $target = '',
        $class = '',
        $title = '',
        $additionalParams = '',
        $additionalAttributes = array()
    ) {

        if (VersionNumberUtility::convertVersionNumberToInteger(TYPO3_version) >= 8006000){
            return $this->renderStaticV86(
                array(
                    'parameter' => $parameter,
                    'target' => $target,
                    'class' => $class,
                    'title' => $title,
                    'additionalParams' => $additionalParams,
                    'additionalAttributes' => $additionalAttributes
                ),
                $this->buildRenderChildrenClosure(),
                $this->renderingContext
            );
        } else {
            return static::renderStatic(
                array(
                    'parameter' => $parameter,
                    'target' => $target,
                    'class' => $class,
                    'title' => $title,
                    'additionalParams' => $additionalParams,
                    'additionalAttributes' => $additionalAttributes
                ),
                $this->buildRenderChildrenClosure(),

                $this->renderingContext
            );
        }
    }

    /**
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     * @return mixed|string
     * @throws \InvalidArgumentException
     * @throws \UnexpectedValueException
     */
    static public function renderStatic(
        array $arguments,
        \Closure $renderChildrenClosure,
        RenderingContextInterface $renderingContext
    ) {
        $parameter = $arguments['parameter'];
        $target = $arguments['target'];
        $class = $arguments['class'];
        $title = $arguments['title'];
        $additionalParams = $arguments['additionalParams'];
        $additionalAttributes = $arguments['additionalAttributes'];

        // Merge the $parameter with other arguments
        $typolinkParameter = self::createTypolinkParameterArrayFromArguments($parameter, $target, $class, $title,
            $additionalParams);

        // array(param1 -> value1, param2 -> value2) --> "param1=value1 param2=>value2" for typolink.ATagParams
        $extraAttributes = array();
        foreach ($additionalAttributes as $attributeName => $attributeValue) {
            $extraAttributes[] = $attributeName . '="' . htmlspecialchars($attributeValue) . '"';
        }
        $aTagParams = implode(' ', $extraAttributes);

        // If no link has to be rendered, the inner content will be returned as such
        $content = $renderChildrenClosure();

        if ($parameter) {
            /** @var ContentObjectRenderer $contentObject */
            $contentObject = GeneralUtility::makeInstance('TYPO3\\CMS\\Frontend\\ContentObject\\ContentObjectRenderer');
            $contentObject->start(array(), '');
            $content = $contentObject->stdWrap(
                $content,
                array(
                    'typolink.' => array(
                        'parameter' => implode(' ', $typolinkParameter),
                        'ATagParams' => $aTagParams,
                    )
                )
            );
        }

        return $content;
    }

    /**
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     * @return mixed|string
     * @throws \InvalidArgumentException
     * @throws \UnexpectedValueException
     */
    static public function renderStaticV86(
        array $arguments,
        \Closure $renderChildrenClosure,
        RenderingContextInterface $renderingContext
    ) {
        $parameter = $arguments['parameter'];
        $target = $arguments['target'];
        $class = $arguments['class'];
        $title = $arguments['title'];
        $additionalParams = $arguments['additionalParams'];
        $additionalAttributes = $arguments['additionalAttributes'];
        $useCacheHash = $arguments['useCacheHash'];

        // Merge the $parameter with other arguments
        $typolinkParameter = self::createTypolinkParameterArrayFromArgumentsV86($parameter, $target, $class, $title, $additionalParams);

        // array(param1 -> value1, param2 -> value2) --> param1="value1" param2="value2" for typolink.ATagParams
        $extraAttributes = [];
        foreach ($additionalAttributes as $attributeName => $attributeValue) {
            $extraAttributes[] = $attributeName . '="' . htmlspecialchars($attributeValue) . '"';
        }
        $aTagParams = implode(' ', $extraAttributes);

        // If no link has to be rendered, the inner content will be returned as such
        $content = (string)$renderChildrenClosure();

        if ($parameter) {
            /** @var ContentObjectRenderer $contentObject */
            $contentObject = GeneralUtility::makeInstance(ContentObjectRenderer::class);
            $contentObject->start([], '');
            $content = $contentObject->stdWrap(
                $content,
                [
                    'typolink.' => [
                        'parameter' => $typolinkParameter,
                        'ATagParams' => $aTagParams,
                        'useCacheHash' => $useCacheHash,
                    ]
                ]
            );
        }

        return $content;
    }


    /**
     * Transforms ViewHelper arguments to typo3link.parameters.typoscript option as array.
     *
     * @param string $parameter Example: 19 _blank - "testtitle with whitespace" &X=y
     * @param string $target
     * @param string $class
     * @param string $title
     * @param string $additionalParams
     *
     * @return array Final merged typolink.parameter as array to be imploded with empty string later
     */
    static protected function createTypolinkParameterArrayFromArguments(
        $parameter,
        $target = '',
        $class = '',
        $title = '',
        $additionalParams = ''
    ) {
        // Explode $parameter by whitespace and remove any " around resulting array values
        $parameterArray = GeneralUtility::unQuoteFilenames($parameter, true);

        if (empty($parameterArray)) {
            return array();
        }

        // Extend to 4 elements
        $typolinkConfiguration = array_pad($parameterArray, 4, '-');

        // Override target if given in target argument
        if ($target) {
            $typolinkConfiguration[1] = $target;
        }

        // Combine classes if given in both "parameter" string and "class" argument
        if ($class) {
            $typolinkConfiguration[2] = $typolinkConfiguration[2] !== '-' ? $typolinkConfiguration[2] . ' ' : '';
            $typolinkConfiguration[2] .= $class;
        }

        // Override title if given in title argument
        if ($title) {
            $typolinkConfiguration[3] = $title;
        }

        // Combine additionalParams
        if ($additionalParams) {
            $typolinkConfiguration[4] .= $additionalParams;
        }

        // Unset unused parameters again from the end, wrap all given values with "
        $reverseSortedParameters = array_reverse($typolinkConfiguration, true);
        $aValueWasSet = false;
        foreach ($reverseSortedParameters as $position => $value) {
            if ($value === '-' && !$aValueWasSet) {
                unset($typolinkConfiguration[$position]);
            } else {
                $aValueWasSet = true;
                if ($value !== '-') {
                    $typolinkConfiguration[$position] = '"' . $value . '"';
                }
            }
        }

        return $typolinkConfiguration;
    }

    /**
     * Transforms ViewHelper arguments to typo3link.parameters.typoscript option as array.
     *
     * @param string $parameter Example: 19 _blank - "testtitle \"with whitespace\"" &X=y
     * @param string $target
     * @param string $class
     * @param string $title
     * @param string $additionalParams
     *
     * @return string The final TypoLink string
     */
    protected static function createTypolinkParameterArrayFromArgumentsV86($parameter, $target = '', $class = '', $title = '', $additionalParams = '')
    {
        $typoLinkCodec = GeneralUtility::makeInstance(TypoLinkCodecService::class);
        $typolinkConfiguration = $typoLinkCodec->decode($parameter);
        if (empty($typolinkConfiguration)) {
            return $typolinkConfiguration;
        }

        // Override target if given in target argument
        if ($target) {
            $typolinkConfiguration['target'] = $target;
        }

        // Combine classes if given in both "parameter" string and "class" argument
        if ($class) {
            $classes = explode(' ', trim($typolinkConfiguration['class']) . ' ' . trim($class));
            $typolinkConfiguration['class'] = implode(' ', array_unique(array_filter($classes)));
        }

        // Override title if given in title argument
        if ($title) {
            $typolinkConfiguration['title'] = $title;
        }

        // Combine additionalParams
        if ($additionalParams) {
            $typolinkConfiguration['additionalParams'] .= $additionalParams;
        }

        return $typoLinkCodec->encode($typolinkConfiguration);
    }


}
